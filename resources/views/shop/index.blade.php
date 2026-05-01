@extends('layouts.shop')

@section('content')

<!-- 🔥 HERO PREMIUM -->
<div class="relative h-[60vh] md:h-[70vh] w-full">

    <img src="/images/hero.jpg"
         class="w-full h-full object-cover">

    <!-- overlay -->
    <div class="absolute inset-0 bg-black/30 flex flex-col justify-center items-center text-white text-center">

        <p class="tracking-widest text-xs md:text-sm mb-2">
            NEW COLLECTION 2026
        </p>

        <h1 class="text-3xl md:text-5xl font-serif italic mb-4">
            Sanctuary Drop
        </h1>

        <a href="#products"
           class="bg-white text-black px-5 py-2 rounded-full text-sm hover:bg-gray-200 transition">
            SHOP NOW
        </a>

    </div>

</div>


<h2 class="text-center text-sm tracking-[3px] mb-10 text-gray-600">
    FEATURED PRODUCTS
</h2>

<!-- 🔥 PRODUCT SECTION -->
<div id="products" class="py-16">

    <h2 class="text-center text-lg tracking-widest mb-10">
        SHOP THE COLLECTION
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($products as $product)

        <div class="group relative cursor-pointer">

            <!-- IMAGE -->
            <div class="overflow-hidden">
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="w-full aspect-[3/4] object-cover transition duration-300 group-hover:scale-105">
            </div>

            <!-- INFO -->
            <div class="mt-3 text-center">
                <h3 class="text-sm font-medium">
                    {{ $product->name }}
                </h3>

                <p class="text-sm text-gray-500">
                    Rp {{ number_format($product->price) }}
                </p>
            </div>

            <!-- CLICK AREA -->
            <button onclick='openModal(@json($product))'
                class="absolute inset-0 z-10">
            </button>

        </div>

        @endforeach

    </div>

</div>

    


<!-- 🔥 BANNER / CAMPAIGN -->
<div class="relative h-[70vh] my-20">

    <img src="/images/banner.jpg"
         class="w-full h-full object-cover">

    <div class="absolute inset-0 bg-black/40 flex flex-col justify-center items-center text-white text-center">

        <p class="text-sm mb-2">SANCTUARY EDIT</p>

        <h2 class="text-4xl md:text-5xl font-light mb-4">
            Street Culture 2026
        </h2>

        <a href="#"
           class="border px-6 py-2 rounded-full hover:bg-white hover:text-black transition">
            EXPLORE
        </a>

    </div>



<!-- 🔥 MODAL (UPGRADED UI) -->
<div id="productModal" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4">

    <div id="modalContent"
     class="bg-white w-[90%] max-w-3xl rounded-2xl p-5 relative flex flex-col md:flex-row gap-4 scale-95 opacity-0 transition duration-300">

        <span onclick="closeModal()" class="absolute right-4 top-3 cursor-pointer text-xl">✖</span>

        <div class="relative w-full md:w-[45%]">

    <img id="modalImage" class="w-full h-[350px] object-cover rounded-lg">

    <!-- tombol kiri -->
    <button onclick="prevImage()" 
        class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/70 px-2 rounded">
        ‹
    </button>

    <!-- tombol kanan -->
    <button onclick="nextImage()" 
        class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/70 px-2 rounded">
        ›
    </button>

</div>

        <div class="flex-1 text-sm">

            <h2 id="modalName" class="text-xl font-semibold"></h2>

            <p id="modalPrice" class="font-bold mt-2"></p>

            <h4 class="mt-4 mb-2">Pilih Size</h4>
            <div id="modalSizes" class="flex flex-wrap gap-2"></div>

            <h4 class="mt-4 mb-2">Qty</h4>
            <input type="number" id="modalQty" value="1" min="1"
                class="border rounded px-3 py-2 w-20">

            <button onclick="addToCart()"
    class="mt-6 w-full bg-black text-white py-3 rounded-full hover:bg-gray-800 transition">
    Add to Cart
</button>

            <div id="toast"
     class="fixed bottom-6 right-6 bg-black text-white px-6 py-3 rounded-full opacity-0 transition">
</div>

            

        </div>

    </div>

</div>


<script>
let selectedSize = null;
let currentProduct = null;

let images = [];
let currentIndex = 0;

function openModal(product) {
    currentProduct = product;

    const modal = document.getElementById('productModal');
    const content = document.getElementById('modalContent');

    modal.classList.remove('hidden');

    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);

    images = [product.image];
    currentIndex = 0;
    updateImage();

    document.getElementById('modalName').innerText = product.name;
    document.getElementById('modalPrice').innerText = 'Rp ' + Number(product.price).toLocaleString();

    renderSizes(product);
}

function closeModal() {
    const modal = document.getElementById('productModal');
    const content = document.getElementById('modalContent');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

function renderSizes(product) {
    let sizesHtml = '';

    product.sizes.forEach(size => {
        let disabled = size.stock <= 0;

        sizesHtml += `
            <span onclick="${disabled ? '' : `selectSize(this, '${size.size}')`}"
                class="px-4 py-2 border rounded-full
                ${disabled ? 'opacity-30 cursor-not-allowed' : 'cursor-pointer hover:bg-black hover:text-white'}">
                ${size.size}
            </span>
        `;
    });

    document.getElementById('modalSizes').innerHTML = sizesHtml;
}

function selectSize(el, size) {
    selectedSize = size;

    document.querySelectorAll('#modalSizes span').forEach(e => {
        e.classList.remove('bg-black', 'text-white');
    });

    el.classList.add('bg-black', 'text-white');
}

function updateImage() {
    document.getElementById('modalImage').src = '/storage/' + images[currentIndex];
}

function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    updateImage();
}

function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateImage();
}

function addToCart() {
    if (!selectedSize) {
        showToast('Pilih size dulu!');
        return;
    }

    let qty = document.getElementById('modalQty').value;

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: currentProduct.id,
            size: selectedSize,
            qty: qty
        })
    }).then(() => {
        showToast('Berhasil ditambahkan ke cart 🛒');
        closeModal();
    });
}

function showToast(message) {
    const toast = document.getElementById('toast');

    toast.innerText = message;
    toast.classList.remove('opacity-0');

    setTimeout(() => {
        toast.classList.add('opacity-0');
    }, 2000);
}
</script>
@endsection