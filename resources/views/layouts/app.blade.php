<!DOCTYPE html>
<html>
<head>
    <title>Sanctuary Admin</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f3f4f6;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #111827, #1f2937);
            color: white;
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            border-radius: 8px;
            color: #9ca3af;
            text-decoration: none;
            margin-bottom: 8px;
        }

        .sidebar a:hover {
            background: #374151;
            color: white;
        }

        /* CONTENT */
        .content {
            margin-left: 240px;
            padding: 30px;
        }

        .topbar {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
        }

        .logout-btn {
            background: #ef4444;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
        }
        .topbar input:focus {
    border: 1px solid #6366f1;
}

.topbar div {
    transition: 0.2s;
}

.topbar div:hover {
    transform: scale(1.05);
}

        .dropdown-box {
    display: none;
    position: absolute;
    right: 0;
    top: 40px;
    width: 200px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    z-index: 999;
}

.dropdown-box a,
.dropdown-box button {
    display: block;
    width: 100%;
    padding: 10px;
    border: none;
    background: none;
    text-align: left;
    cursor: pointer;
}

.dropdown-box a:hover,
.dropdown-box button:hover {
    background: #f3f4f6;
}

.card-hover {
    transition: 0.3s;
    cursor: pointer;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
    </style>
</head>

<body>

@auth
    @if(auth()->user()->role === 'admin')

    <!-- SIDEBAR (HANYA ADMIN) -->
    <div class="sidebar">

        <div>
            <h2>SANCTUARY</h2>

            <a href="/products">Dashboard</a>
            <a href="{{ route('products.create') }}">Add Product</a>
            <a href="/orders">Orders</a>
            <a href="{{ route('profile.edit') }}" class="menu-item">
    Edit Profile
</a>
        </div>

        <div>
            <div style="text-align:center;">
                <p>{{ auth()->user()->nickname ?? auth()->user()->name }}</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn">Logout</button>
            </form>
        </div>

    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="topbar">

    {{-- LEFT --}}
    <div style="display:flex; align-items:center; gap:15px;">
        
        <div style="font-size:20px; cursor:pointer;">☰</div>

        <form action="/products" method="GET" style="position:relative;">
            <input 
                type="text" 
                name="search"
                placeholder="Search..." 
                value="{{ request('search') }}"
                style="
                    padding:8px 15px 8px 35px;
                    border-radius:20px;
                    border:1px solid #ddd;
                    width:250px;
                "
            >
            <span style="position:absolute; left:10px; top:7px;">🔍</span>
        </form>

    </div>

    {{-- RIGHT --}}
    <div style="display:flex; align-items:center; gap:20px;">

        {{-- NOTIF --}}
        <div onclick="toggleNotif()" style="position:relative; cursor:pointer;">
            🔔
            <span id="notifCount">{{ $pendingOrders ?? 0 }}</span>

            <div id="notifDropdown" class="dropdown-box">
                @forelse($latestOrders ?? [] as $order)
                    <div style="padding:10px;">
                        Order #{{ $order->id }}<br>
                        <small>{{ $order->status }}</small>
                    </div>
                @empty
                    <div style="padding:10px;">No orders</div>
                @endforelse
            </div>
        </div>

        {{-- SETTINGS --}}
        <a href="/settings" style="text-decoration:none;">⚙️</a>

        {{-- PROFILE --}}
        <div onclick="toggleProfile()" style="position:relative; cursor:pointer;">
            <div style="display:flex; align-items:center; gap:10px;">
                <img src="https://i.pravatar.cc/40" style="width:35px; border-radius:50%;">
                <div>
                    <div>{{ auth()->user()->name }}</div>
                    <small style="color:gray;">Admin</small>
                </div>
            </div>

            <div id="profileDropdown" class="dropdown-box">
                <a href="{{ route('profile.edit') }}">Edit Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>

    </div>

</div>

        @yield('content')

    </div>

    @else

        <!-- 🔥 USER BUKAN ADMIN → REDIRECT -->
        <script>window.location = "/shop";</script>

    @endif

@else

    <!-- 🔥 BELUM LOGIN → REDIRECT LOGIN -->
    <script>window.location = "/login";</script>

@endauth





<script>
function loadNotif() {
    fetch('/notifications')
        .then(res => res.json())
        .then(data => {

            // update badge
            document.getElementById('notifCount').innerText = data.count;

            // update dropdown
            let html = '';

            if (data.orders.length === 0) {
                html = '<div style="padding:10px;">No orders</div>';
            } else {
                data.orders.forEach(order => {
                    html += `
                        <div style="padding:10px; border-bottom:1px solid #eee;">
                            Order #${order.id}<br>
                            <small>${order.status}</small>
                        </div>
                    `;
                });
            }

            document.getElementById('notifDropdown').innerHTML = html;
        });
}

// 🔥 jalan tiap 5 detik
setInterval(loadNotif, 5000);

// 🔥 load pertama
loadNotif();
</script>

<script>
function toggleNotif() {
    let el = document.getElementById('notifDropdown');
    el.style.display = el.style.display === 'block' ? 'none' : 'block';
}

function toggleProfile() {
    let el = document.getElementById('profileDropdown');
    el.style.display = el.style.display === 'block' ? 'none' : 'block';
}
</script>

<!-- 🔥 CHART.JS HARUS DI LUAR -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</script>

</body>
</html>