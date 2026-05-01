@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px;">Tambah Produk</h2>

{{-- ERROR --}}
@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="card" style="padding:20px; max-width:600px;">
    
    @csrf

    {{-- NAMA --}}
    <div style="margin-bottom:15px;">
        <label>Nama Produk</label><br>
        <input type="text" name="name" value="{{ old('name') }}" style="width:100%; padding:10px; border-radius:8px;">
    </div>

    {{-- HARGA --}}
    <div style="margin-bottom:15px;">
        <label>Harga</label><br>
        <input type="number" name="price" value="{{ old('price') }}" style="width:100%; padding:10px; border-radius:8px;">
    </div>

    {{-- DESKRIPSI --}}
    <div style="margin-bottom:15px;">
        <label>Deskripsi</label><br>
        <textarea name="description" style="width:100%; padding:10px; border-radius:8px;">{{ old('description') }}</textarea>
    </div>

    {{-- SIZE --}}
    <h3 style="margin-top:20px;">Size & Stock</h3>

    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px;">
        @foreach(['S','M','L','XL'] as $size)
            <div style="background:#f3f4f6; padding:10px; border-radius:10px; text-align:center;">
                <label style="font-weight:bold;">{{ $size }}</label><br>
                <input 
                    type="number" 
                    name="sizes[{{ $size }}]" 
                    value="{{ old('sizes.'.$size) }}" 
                    placeholder="Stock"
                    style="width:80px; padding:5px; border-radius:5px;"
                >
            </div>
        @endforeach
    </div>

    {{-- GAMBAR --}}
    <div style="margin-bottom:20px;">
        <label>Gambar Produk</label><br>
        <input type="file" name="image">
    </div>

    {{-- BUTTON --}}
    <button style="
        background:#111827;
        color:white;
        padding:12px 20px;
        border:none;
        border-radius:10px;
        cursor:pointer;
    ">
        Simpan Produk
    </button>

</form>

@endsection