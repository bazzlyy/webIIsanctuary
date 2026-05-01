@extends('layouts.shop')

@section('content')

<style>
.wrapper {
    max-width: 900px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

h2 {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

input, textarea {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ddd;
}

button {
    width: 100%;
    padding: 15px;
    background: black;
    color: white;
    border-radius: 12px;
    margin-top: 20px;
}

.summary {
    margin-top: 30px;
    padding: 20px;
    background: #f3f4f6;
    border-radius: 12px;
}
</style>

<div class="wrapper">

    <h2>Checkout</h2>

    <form action="/checkout" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="address" required></textarea>
        </div>

        <div class="form-group">
            <label>No HP</label>
            <input type="text" name="phone" required>
        </div>

        <div class="summary">
            <h4>Ringkasan Belanja</h4>

            @php $total = 0; @endphp

            @foreach($cart as $item)
                <p>
                    {{ $item['name'] }} ({{ $item['size'] }}) x{{ $item['qty'] }}
                </p>
                @php $total += $item['price'] * $item['qty']; @endphp
            @endforeach

            <hr>

            <strong>Total: Rp {{ number_format($total) }}</strong>
        </div>

        <button>Checkout Sekarang</button>

    </form>

</div>

@endsection