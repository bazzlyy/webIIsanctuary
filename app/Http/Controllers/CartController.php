<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // ======================
    // 🛒 CART PAGE
    // ======================
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // ======================
    // ➕ ADD TO CART
    // ======================
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'size' => 'required'
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);
        $key = $product->id . '-' . $request->size;

        if (isset($cart[$key])) {
            $cart[$key]['qty']++;
        } else {
            $cart[$key] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'size' => $request->size,
                'qty' => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect('/cart')->with('success', 'Produk ditambahkan!');
    }

    // ======================
    // ➕ QTY (+)
    // ======================
    public function increase($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {

            $item = $cart[$key];

            $size = ProductSize::where('product_id', $item['id'])
                ->where('size', $item['size'])
                ->first();

            if ($size && $item['qty'] < $size->stock) {
                $cart[$key]['qty']++;
            } else {
                return back()->with('error', 'Stok tidak cukup!');
            }
        }

        session()->put('cart', $cart);
        return back();
    }

    // ======================
    // ➖ QTY (-)
    // ======================
    public function decrease($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key]) && $cart[$key]['qty'] > 1) {
            $cart[$key]['qty']--;
        }

        session()->put('cart', $cart);
        return back();
    }

    // ======================
    // ❌ REMOVE
    // ======================
    public function remove($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
        }

        session()->put('cart', $cart);
        return back();
    }

    // ======================
    // 🧾 CHECKOUT PAGE
    // ======================
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Cart kosong!');
        }

        if ($request->has('selected')) {

            $selectedKeys = $request->selected;
            $cart = array_intersect_key($cart, array_flip($selectedKeys));

            if (empty($cart)) {
                return redirect('/cart')->with('error', 'Pilih produk dulu!');
            }

            session()->put('checkout_cart', $cart);

        } else {
            session()->put('checkout_cart', $cart);
        }

        return view('cart.checkout', compact('cart'));
    }

    // ======================
    // 💳 PROCESS CHECKOUT (FIXED 🔥)
    // ======================
    public function processCheckout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        $cart = session()->get('checkout_cart', []);

        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Cart kosong!');
        }

        DB::beginTransaction();

        try {

            // 🔥 VALIDASI STOK
            foreach ($cart as $item) {

                $size = ProductSize::where('product_id', $item['id'])
                    ->where('size', $item['size'])
                    ->lockForUpdate()
                    ->first();

                if (!$size) {
                    throw new \Exception('Size tidak ditemukan');
                }

                if ($item['qty'] > $size->stock) {
                    throw new \Exception('Stok tidak cukup untuk ' . $item['name']);
                }
            }

            // 🔥 TOTAL
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['qty'];
            }

            // 🔥 CREATE ORDER
            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'total' => $total,
                'status' => 'pending'
            ]);

            // 🔥 CREATE ITEMS + KURANGI STOK
            foreach ($cart as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $item['name'],
                    'size' => $item['size'],
                    'qty' => $item['qty'],
                    'price' => $item['price']
                ]);

                $size = ProductSize::where('product_id', $item['id'])
                    ->where('size', $item['size'])
                    ->first();

                $size->stock -= $item['qty'];
                $size->save();
            }

            DB::commit();

            session()->forget('cart');
            session()->forget('checkout_cart');

            return redirect('/my-orders')->with('success', 'Pesanan berhasil!');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect('/cart')->with('error', $e->getMessage());
        }
    }
}