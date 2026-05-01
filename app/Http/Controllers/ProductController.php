<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // ======================
    // INDEX (FIXED 🔥)
    // ======================
    public function index(Request $request)
    {

            $query = Product::with('sizes');

if ($request->search) {
    $query->where('name', 'like', '%' . $request->search . '%');
}

$products = $query->get();

        $products = Product::with('sizes')->get();

        // 🔥 LOW STOCK
        $lowStock = DB::table('product_sizes')
            ->where('stock', '<', 5)
            ->count();

        return view('products.index', [
            'products' => $products,

            // STATS
            'totalProducts' => Product::count(),
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status','pending')->count(),
            'completedOrders' => Order::where('status','completed')->count(),
            'cancelledOrders' => Order::where('status','cancelled')->count(),

            'totalRevenue' => Order::sum('total'),
            'totalUsers' => User::count(),

            'recentOrders' => Order::latest()->take(5)->get(),

            'totalStock' => DB::table('product_sizes')->sum('stock'),

            // 🔥 TAMBAHAN
            'lowStock' => $lowStock,

            // 🔥 CHART
            'monthlyOrders' => [
                Order::whereMonth('created_at',1)->count(),
                Order::whereMonth('created_at',2)->count(),
                Order::whereMonth('created_at',3)->count(),
                Order::whereMonth('created_at',4)->count(),
                Order::whereMonth('created_at',5)->count(),
                Order::whereMonth('created_at',6)->count(),
            ]
        ]);
    }

    // ======================
    // CREATE
    // ======================
    public function create()
    {
        return view('products.create');
    }

    // ======================
    // STORE
    // ======================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        foreach ($request->input('sizes', []) as $size => $stock) {
            if ($stock != null) {
                $product->sizes()->create([
                    'size' => $size,
                    'stock' => $stock
                ]);
            }
        }

        return redirect('/products')->with('success', 'Produk berhasil ditambahkan!');
    }

    // ======================
    // SHOW
    // ======================
    public function show($id)
    {
        $product = Product::with('sizes')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    // ======================
    // EDIT
    // ======================
    public function edit($id)
    {
        $product = Product::with('sizes')->findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // ======================
    // UPDATE
    // ======================
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'description' => 'required',
            'sizes' => 'required|array',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        $product->sizes()->delete();

        foreach ($request->input('sizes', []) as $size => $stock) {
            if ($stock != null) {
                $product->sizes()->create([
                    'size' => $size,
                    'stock' => $stock
                ]);
            }
        }

        return redirect('/products')->with('success', 'Produk berhasil diupdate!');
    }

    // ======================
    // DELETE
    // ======================
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        $product->sizes()->delete();
        $product->delete();

        return redirect('/products')->with('success', 'Produk berhasil dihapus!');
    }
}