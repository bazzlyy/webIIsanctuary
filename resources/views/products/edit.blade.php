@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px;">Edit Produk</h2>

@if ($errors->any())
    <div style="
        background:#fee2e2;
        padding:10px;
        border-radius:8px;
        margin-bottom:15px;
        color:#b91c1c;
    ">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card" style="max-width:600px;">

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- 🔥 NAME -->
    <div style="margin-bottom:15px;">
        <label>Nama Produk</label><br>
        <input type="text" name="name" value="{{ $product->name }}"
            style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
    </div>

    <!-- 🔥 PRICE -->
    <div style="margin-bottom:15px;">
        <label>Harga</label><br>
        <input type="number" name="price" value="{{ $product->price }}"
            style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
    </div>

    <!-- 🔥 DESCRIPTION -->
    <div style="margin-bottom:15px;">
        <label>Deskripsi</label><br>
        <textarea name="description"
            style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">{{ $product->description }}</textarea>
    </div>

    <!-- 🔥 SIZE & STOCK -->
    <h3 style="margin-bottom:10px;">Size & Stock</h3>

    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px;">
        @foreach(['S','M','L','XL'] as $size)

            @php
                $existing = $product->sizes->where('size', $size)->first();
            @endphp

            <div style="
                background:#f3f4f6;
                padding:10px;
                border-radius:10px;
                text-align:center;
                width:80px;
            ">
                <label>{{ $size }}</label><br>

                <input type="number"
                    name="sizes[{{ $size }}]"
                    value="{{ $existing->stock ?? '' }}"
                    style="width:60px; padding:5px; border-radius:6px; border:1px solid #ccc;">
            </div>

        @endforeach
    </div>

    <!-- 🔥 IMAGE -->
    <div style="margin-bottom:15px;">
        <label>Gambar</label><br><br>

        <img src="{{ asset('storage/'.$product->image) }}"
             style="width:120px; border-radius:10px; margin-bottom:10px;"><br>

        <input type="file" name="image">
    </div>



    <!-- UPDATE BUTTON -->
    <button style="
        background:#111827;
        color:white;
        padding:12px 20px;
        border-radius:10px;
    ">
        Update Produk
    </button>

    <!-- 🔥 TOMBOL KEMBALI -->
    <a href="/products" style="
        background:#e5e7eb;
        color:black;
        padding:12px 20px;
        border-radius:10px;
        text-decoration:none;
        display:inline-block;
    ">
        Kembali
    </a>

</div>

</form>

</div>

@endsection