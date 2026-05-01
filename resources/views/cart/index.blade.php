@extends('layouts.shop')

@section('content')

<style>
.cart-container {
    display: flex;
    gap: 30px;
}

.cart-left {
    flex: 2;
}

.cart-right {
    flex: 1;
}

.cart-item {
    display: flex;
    align-items: center;
    gap: 15px;
    background: white;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.cart-item img {
    width: 80px;
    border-radius: 10px;
}

.cart-info {
    flex: 1;
}

.cart-price {
    font-weight: bold;
}

.qty-btn {
    padding:5px 10px;
    border-radius:6px;
    text-decoration:none;
}

.minus { background:#e5e7eb; }
.plus { background:#111827; color:white; }

.delete-btn {
    background:red;
    color:white;
    padding:6px 10px;
    border-radius:8px;
    text-decoration:none;
}

.summary {
    background:white;
    padding:20px;
    border-radius:12px;
    height:fit-content;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}
</style>

<h2 style="margin-bottom:20px;">Keranjang Belanja</h2>

@if(empty($cart))
    <p>Cart kosong 😢</p>
@else

<form action="/checkout" method="GET">

<div class="cart-container">

    <!-- 🔥 LEFT -->
    <div class="cart-left">

        @foreach($cart as $key => $item)

            <div class="cart-item">

                <!-- ✅ CHECKBOX -->
                <input 
                    type="checkbox" 
                    class="check-item"
                    data-price="{{ $item['price'] * $item['qty'] }}"
                    name="selected[]" 
                    value="{{ $key }}"
                >

                <!-- IMAGE -->
                <img src="{{ asset('storage/'.$item['image']) }}">

                <!-- INFO -->
                <div class="cart-info">
                    <h4>{{ $item['name'] }}</h4>
                    <p>Size: <b>{{ $item['size'] }}</b></p>
                    <p>Rp {{ number_format($item['price']) }}</p>
                </div>

                <!-- QTY -->
                <div>
                    <a href="/cart/decrease/{{ $key }}" class="qty-btn minus">-</a>
                    <span>{{ $item['qty'] }}</span>
                    <a href="/cart/increase/{{ $key }}" class="qty-btn plus">+</a>
                </div>

                <!-- SUBTOTAL -->
                <div class="cart-price">
                    Rp {{ number_format($item['price'] * $item['qty']) }}
                </div>

                <!-- DELETE -->
                <a href="/cart/remove/{{ $key }}" class="delete-btn">
                    Hapus
                </a>

            </div>

        @endforeach

    </div>

    <!-- 🔥 RIGHT -->
    <div class="cart-right">

        <div class="summary">

            <h3>Ringkasan</h3>

            <p>Total:</p>

            <h2 id="totalHarga">Rp 0</h2>

            <button style="
                width:100%;
                background:#111827;
                color:white;
                padding:12px;
                border-radius:10px;
                margin-top:15px;
            ">
                Checkout Selected
            </button>

        </div>

    </div>

</div>

</form>

@endif


<script>
function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString();
}

function hitungTotal() {
    let total = 0;

    document.querySelectorAll('.check-item:checked').forEach(el => {
        total += parseInt(el.dataset.price);
    });

    document.getElementById('totalHarga').innerText = formatRupiah(total);
}

document.querySelectorAll('.check-item').forEach(el => {
    el.addEventListener('change', hitungTotal);
});
</script>

@endsection