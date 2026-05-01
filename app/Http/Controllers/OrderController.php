<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * 📦 List semua order (admin)
     */
    public function index()
    {
        $orders = Order::latest()->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * 📄 Detail order (admin & customer)
     */
    public function show($id)
{
    $order = Order::with('items')->findOrFail($id);

    // 🔥 CEK PEMILIK
    if ($order->user_id && $order->user_id !== auth()->id()) {
        abort(403);
    }

    return view('orders.show', compact('order'));
}

    /**
     * 👤 Customer lihat semua order
     */
    public function myOrders()
{
    $orders = Order::where('user_id', auth()->id())
                ->latest()
                ->get();

    return view('orders.customer', compact('orders'));
}

    /**
     * 🔄 Update status order (admin)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'status' => $request->status
        ]);

        return redirect('/orders')->with('success', 'Status berhasil diupdate!');
    }
}