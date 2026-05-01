<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sanctuary</title>

    @vite('resources/css/app.css')

    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 font-[Inter]">

<div class="min-h-screen flex items-center justify-center px-4">

    <!-- 🔥 CARD -->
    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-xl overflow-hidden flex">

        <!-- LEFT -->
        <div class="w-full md:w-1/2 p-8">

            <h2 class="text-2xl font-semibold mb-6">Account Login</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- EMAIL -->
                <div class="mb-3">
                    <input type="email" name="email" placeholder="Email Address"
                        class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                        required>
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <input type="password" name="password" placeholder="Password"
                        class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                        required>
                </div>

                <!-- REMEMBER -->
                <div class="flex items-center mb-4 text-sm">
                    <input type="checkbox" name="remember" class="mr-2">
                    <label>Keep me logged in</label>
                </div>

                <!-- ERROR -->
                @if($errors->any())
                    <div class="mb-3 text-red-500 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- BUTTON -->
                <button
                    class="w-full bg-black text-white py-2.5 rounded-lg hover:bg-gray-800 transition">
                    Log in
                </button>

                <!-- REGISTER -->
                <p class="text-center text-sm mt-4 text-gray-400">
    Account required? Contact admin.
</p>

            </form>

        </div>

        <!-- RIGHT IMAGE -->
        <div class="hidden md:block w-1/2 bg-gray-100">
            <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1"
                class="w-full h-full object-cover">
        </div>

    </div>

</div>

</body>
</html>