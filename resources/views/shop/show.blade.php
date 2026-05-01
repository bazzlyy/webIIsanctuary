@extends('layouts.shop')

@section('content')

<style>
.container {
    display: flex;
    gap: 40px;
    max-width: 900px;
    margin: auto;
}

img {
    width: 350px;
    border-radius: 12px;
}

.info {
    flex: 1;
}

.price {
    font-size: 22px;
    font-weight: bold;
    margin: 10px 0;
}

.sizes button {
    padding: 10px 15px;
    margin: 5px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    background: #e5e7eb;
    transition: 0.2s;
}

.sizes button:hover {
    background: black;
    color: white;
}

.disabled {
    background: #ccc;
    cursor: not-allowed;
}

.btn {
    margin-top: 15px;
    background: black;
    color: white;
    padding: 12px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
}
</style>

<div class="container">

    <!-- IMAGE -->
    <img src="{{ asset('storage/'.$product->image) }}">

    <!-- INFO -->
    <div class="info">

        <h2>{{ $product->name }}</h2>

        <div class="price">
            Rp {{ number_format($product->price) }}
        </div>

        <p>{{ $product->description }}</p>

        <h4>Pilih Size:</h4>

        <!-- SIZE BUTTON VIEW -->
        <div class="sizes">
            @foreach($product->sizes as $size)
                <button 
                    class="{{ $size->stock == 0 ? 'disabled' : '' }}"
                    {{ $size->stock == 0 ? 'disabled' : '' }}
                >
                    {{ $size->size }} ({{ $size->stock }})
                </button>
            @endforeach
        </div>

        <!-- FORM ADD TO CART -->
        <form action="/cart/add" method="POST">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <p><strong>Pilih Size:</strong></p>

            @foreach($product->sizes as $size)
                @if($size->stock > 0)
                    <label>
                        <input type="radio" name="size" value="{{ $size->size }}">
                        {{ $size->size }} ({{ $size->stock }})
                    </label><br>
                @endif
            @endforeach

            <button class="btn">
                Tambah ke Keranjang
            </button>
        </form>

    </div>

</div>

@endsection