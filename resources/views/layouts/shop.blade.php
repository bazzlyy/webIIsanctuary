<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sanctuary Shop</title>

    @vite('resources/css/app.css')

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Inter&display=swap" rel="stylesheet">
</head>

<body class="bg-white text-gray-900">

<!-- 🔥 BLOCK ADMIN -->
@auth
    @if(auth()->user()->role === 'admin')
        <script>window.location = "/products";</script>
    @endif
@endauth

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur border-b">

    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <a href="/shop" class="text-lg font-semibold tracking-widest">
            SANCTUARY
        </a>

        <div class="flex items-center gap-6 text-sm">

            <!-- 🔥 PUBLIC -->
            <a href="/shop" class="hover:text-gray-500">Shop</a>

            @auth

                @if(auth()->user()->role === 'customer')

                    <a href="/cart" class="hover:text-gray-500">Cart</a>
                    <a href="/my-orders" class="hover:text-gray-500">Orders</a>

                @endif

                <span class="text-gray-500">
                    {{ auth()->user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="hover:text-red-500">
                        Logout
                    </button>
                </form>

            @else

                <a href="/login" class="hover:text-gray-500">Login</a>

            @endauth

        </div>

    </div>

</nav>


<!-- CONTENT -->
<main class="pt-24">

    <div class="max-w-7xl mx-auto px-6">
        @yield('content')
    </div>

</main>

</body>
</html>