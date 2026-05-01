@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px;">Detail Produk</h2>

<div style="
    display:flex;
    gap:30px;
    background:white;
    padding:25px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
">

    <!-- 🔥 IMAGE -->
    <div>
        <img src="{{ asset('storage/'.$product->image) }}" 
             style="width:300px; border-radius:12px;">
    </div>

    <!-- 🔥 INFO -->
    <div style="flex:1;">

        <h2 style="margin-bottom:10px;">{{ $product->name }}</h2>

        <p style="
            font-size:20px;
            font-weight:bold;
            margin-bottom:15px;
        ">
            Rp {{ number_format($product->price) }}
        </p>

        <p style="
            color:#6b7280;
            margin-bottom:20px;
        ">
            {{ $product->description }}
        </p>

        <!-- 🔥 SIZE -->
        <h4>Size & Stock</h4>

        <div style="margin-bottom:20px;">
            @foreach($product->sizes as $size)
                <span style="
                    display:inline-block;
                    background:#111827;
                    color:white;
                    padding:6px 12px;
                    margin:4px;
                    border-radius:20px;
                    font-size:13px;
                ">
                    {{ $size->size }} ({{ $size->stock }})
                </span>
            @endforeach
        </div>

        <!-- 🔥 BUTTON -->
        <div style="display:flex; gap:10px;">

            <a href="{{ route('products.edit', $product->id) }}" style="
                background:#f59e0b;
                color:white;
                padding:10px 16px;
                border-radius:10px;
                text-decoration:none;
            ">
                Edit
            </a>

            <a href="/products" style="
                background:#e5e7eb;
                padding:10px 16px;
                border-radius:10px;
                text-decoration:none;
                color:black;
            ">
                Kembali
            </a>

        </div>

    </div>

</div>

@endsection