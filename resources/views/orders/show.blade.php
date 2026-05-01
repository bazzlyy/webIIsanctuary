@extends('layouts.shop')

@section('content')

<h2 style="margin-bottom:20px;">Detail Order</h2>

<!-- 🔥 CUSTOMER INFO -->
<div style="
    background:white;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
">
    <p><strong>Nama:</strong> {{ $order->name }}</p>
    <p><strong>Alamat:</strong> {{ $order->address }}</p>
    <p><strong>Phone:</strong> {{ $order->phone }}</p>
</div>

@php
    $steps = ['pending', 'diproses', 'dikirim', 'selesai'];
    $currentIndex = array_search($order->status, $steps);
@endphp

<div style="
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin:30px 0;
">

@foreach($steps as $index => $step)
    <div style="text-align:center; flex:1; position:relative;">

        <!-- LINE -->
        @if($index != 0)
        <div style="
            position:absolute;
            top:12px;
            left:-50%;
            width:100%;
            height:4px;
            background: {{ $index <= $currentIndex ? '#22c55e' : '#e5e7eb' }};
            z-index:0;
        "></div>
        @endif

        <!-- CIRCLE -->
        <div style="
            width:25px;
            height:25px;
            margin:auto;
            border-radius:50%;
            background: {{ $index <= $currentIndex ? '#22c55e' : '#e5e7eb' }};
            z-index:1;
            position:relative;
        "></div>

        <!-- LABEL -->
        <p style="
            margin-top:8px;
            font-size:12px;
            color: {{ $index <= $currentIndex ? '#111827' : '#9ca3af' }};
        ">
            {{ ucfirst($step) }}
        </p>

    </div>
@endforeach

</div>

<!-- 🔥 STATUS -->
<div style="margin-bottom:20px;">
    <strong>Status:</strong>

    <span style="
        padding:6px 12px;
        border-radius:20px;
        color:white;
        font-size:12px;
        background:
        {{ $order->status == 'pending' ? '#facc15' : '' }}
        {{ $order->status == 'diproses' ? '#3b82f6' : '' }}
        {{ $order->status == 'dikirim' ? '#8b5cf6' : '' }}
        {{ $order->status == 'selesai' ? '#22c55e' : '' }};
    ">
        {{ $order->status }}
    </span>
</div>

<!-- 🔥 PRODUK -->
<div style="
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
">

    <h3 style="margin-bottom:15px;">Produk Dibeli</h3>

    <table style="width:100%; border-collapse:collapse;">

        <thead>
            <tr style="background:#f3f4f6;">
                <th style="padding:10px;">Produk</th>
                <th>Size</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
        @foreach($order->items as $item)
            <tr style="text-align:center; border-bottom:1px solid #eee;">
                <td style="padding:10px;">{{ $item->product->name ?? '-' }}</td>
                <td>{{ $item->size }}</td>
                <td>{{ $item->qty }}</td>
                <td>Rp {{ number_format($item->price) }}</td>
                <td>Rp {{ number_format($item->price * $item->qty) }}</td>
            </tr>
        @endforeach
        </tbody>

    </table>

    <!-- 🔥 TOTAL -->
    <div style="
        text-align:right;
        margin-top:20px;
        font-size:18px;
        font-weight:bold;
    ">
        Total: Rp {{ number_format($order->total) }}
    </div>

</div>

<!-- 🔥 BUTTON -->
<div style="margin-top:20px;">
    <a href="/orders" style="
        background:#e5e7eb;
        padding:10px 15px;
        border-radius:8px;
        text-decoration:none;
        color:black;
    ">
        ← Kembali
    </a>
</div>

@endsection