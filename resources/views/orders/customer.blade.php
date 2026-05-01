@extends('layouts.shop')

@section('content')

<h2 style="margin-bottom:20px;">Pesanan Saya</h2>

<div style="display:flex; flex-direction:column; gap:15px;">

@foreach($orders as $order)
<div style="
    background:white;
    padding:15px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
">

    <p><strong>Order ID:</strong> #{{ $order->id }}</p>

    <p>Total:
        <strong>Rp {{ number_format($order->total) }}</strong>
    </p>

    <p>Status:
        <span style="
            padding:5px 10px;
            border-radius:10px;
            background:#111827;
            color:white;
        ">
            {{ $order->status }}
        </span>
    </p>

    <a href="/orders/{{ $order->id }}" style="
        display:inline-block;
        margin-top:10px;
        background:#111827;
        color:white;
        padding:8px 12px;
        border-radius:8px;
        text-decoration:none;
    ">
        Lihat Detail
    </a>

</div>
@endforeach

</div>

@endsection