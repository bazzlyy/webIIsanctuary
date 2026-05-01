@extends('layouts.app')

@section('content')

<div style="max-width:1200px; margin:auto;">

<style>

/* 🔥 CARD HOVER GLOBAL */
.card-hover {
    transition: 0.3s;
    cursor: pointer;
}
.card-hover:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
}

/* 🔥 DASHBOARD GRID */
.stat-grid-modern {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.stat-box {
    padding: 20px;
    border-radius: 18px;
    color: white;
    font-weight: 500;
    position: relative;
    overflow: hidden;
}

.stat-box h2 {
    font-size: 28px;
    margin-top: 10px;
}

/* ICON */
.stat-icon {
    position:absolute;
    right:20px;
    top:20px;
    font-size:40px;
    opacity:0.2;
}

/* COLORS */
.bg-blue { background: linear-gradient(135deg, #4f46e5, #3b82f6); }
.bg-red { background: linear-gradient(135deg, #ef4444, #dc2626); }
.bg-green { background: linear-gradient(135deg, #10b981, #059669); }
.bg-purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.bg-orange { background: linear-gradient(135deg, #f59e0b, #d97706); }
.bg-teal { background: linear-gradient(135deg, #14b8a6, #0d9488); }
.bg-pink { background: linear-gradient(135deg, #ec4899, #db2777); }
.bg-yellow { background: linear-gradient(135deg, #facc15, #eab308); }

/* TABLE */
.table-box {
    background: white;
    padding: 20px;
    border-radius: 16px;
    margin-top: 20px;
}

/* STATUS BADGE */
.status {
    padding:5px 10px;
    border-radius:8px;
    color:white;
    font-size:12px;
}
.pending { background:#f59e0b; }
.completed { background:#10b981; }
.cancelled { background:#ef4444; }

/* PRODUCT CARD */
.product-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.product-card {
    background: white;
    border-radius: 16px;
    width: 230px;
    padding: 15px;
}

.product-card img {
    width: 100%;
    border-radius: 10px;
    margin-bottom: 10px;
}

.size-badge {
    display:inline-block;
    background:#e5e7eb;
    padding:5px 10px;
    margin:2px;
    border-radius:20px;
    font-size:12px;
}

.btn {
    padding: 8px;
    border-radius: 8px;
    font-size: 13px;
    border: none;
    cursor: pointer;
}

.btn-edit { background: #f59e0b; color: white; }
.btn-delete { background: #ef4444; color: white; }
.btn-detail { background: #6b7280; color: white; }

</style>

<h2 style="margin-bottom:20px;">Dashboard</h2>

<!-- 🔥 STATS -->
<div class="stat-grid-modern">

    <div class="stat-box bg-blue card-hover">
        Total Produk
        <h2>{{ $totalProducts }}</h2>
        <div class="stat-icon">📦</div>
    </div>

    <div class="stat-box bg-red card-hover">
        Pending Orders
        <h2>{{ $pendingOrders }}</h2>
        <div class="stat-icon">⏳</div>
    </div>

    <div class="stat-box bg-green card-hover">
        Completed Orders
        <h2>{{ $completedOrders }}</h2>
        <div class="stat-icon">✅</div>
    </div>

    <div class="stat-box bg-purple card-hover">
        Revenue
        <h2>Rp {{ number_format($totalRevenue) }}</h2>
        <div class="stat-icon">💰</div>
    </div>

    <div class="stat-box bg-orange card-hover">
        Total Orders
        <h2>{{ $totalOrders }}</h2>
        <div class="stat-icon">🛒</div>
    </div>

    <div class="stat-box bg-teal card-hover">
        Customers
        <h2>{{ $totalUsers }}</h2>
        <div class="stat-icon">👤</div>
    </div>

    <div class="stat-box bg-pink card-hover">
        Cancelled
        <h2>{{ $cancelledOrders }}</h2>
        <div class="stat-icon">❌</div>
    </div>

    <div class="stat-box bg-yellow card-hover">
        Total Stock
        <h2>{{ $totalStock }}</h2>
        <div class="stat-icon">📊</div>
    </div>

</div>



<!-- 🔥 CHART -->
<div style="background:white; padding:20px; border-radius:12px;">
    <h4>Sales Overview</h4>

    {{-- 🔥 DEBUG DATA (sementara, nanti hapus) --}}

    <canvas id="salesChart"></canvas>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const ctx = document.getElementById('salesChart');

    if (!ctx) return;

    // 🔥 fallback biar gak kosong
    let data = @json($monthlyOrders ?? []);

    // kalau kosong → kasih dummy biar kelihatan
    if (!data || data.length === 0 || data.every(v => v == 0)) {
        data = [5, 10, 7, 12, 8, 15];
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun'],
            datasets: [{
                label: 'Orders',
                data: data,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.2)',
                tension: 0.4,
                fill: true,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            }
        }
    });

});
</script>

<!-- 🔥 RECENT ORDERS -->
<div class="table-box">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h3>Recent Orders</h3>
        <a href="/orders" style="font-size:13px; color:#6366f1;">View All</a>
    </div>

    <table style="width:100%; margin-top:15px; border-collapse:collapse;">
        <thead>
            <tr style="text-align:left; color:#6b7280; font-size:13px;">
                <th style="padding:10px;">ID</th>
                <th style="padding:10px;">Customer</th>
                <th style="padding:10px;">Total</th>
                <th style="padding:10px;">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($recentOrders as $order)
            <tr style="border-top:1px solid #eee;">
                <td style="padding:10px;">#{{ $order->id }}</td>
                <td style="padding:10px;">{{ $order->name }}</td>
                <td style="padding:10px;">Rp {{ number_format($order->total) }}</td>
                <td style="padding:10px;">
                    <span style="
                        padding:5px 12px;
                        border-radius:20px;
                        font-size:12px;
                        background:
                        {{ $order->status == 'completed' ? '#10b981' :
                           ($order->status == 'pending' ? '#f59e0b' : '#ef4444') }};
                        color:white;
                    ">
                        {{ $order->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding:20px; text-align:center; color:gray;">
                    No orders found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- 🔥 PRODUCT -->
<div class="product-grid">

@foreach($products as $product)

    <div class="product-card card-hover">

        <img src="{{ asset('storage/'.$product->image) }}">

        <h4>{{ $product->name }}</h4>
        <p>Rp {{ number_format($product->price) }}</p>

        <div>
            @foreach($product->sizes as $size)
                <span class="size-badge">
                    {{ $size->size }} ({{ $size->stock }})
                </span>
            @endforeach
        </div>

        <div style="display:flex; gap:5px; margin-top:10px;">
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-detail">Detail</a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit">Edit</a>
        </div>

        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-delete" style="width:100%; margin-top:5px;">Hapus</button>
        </form>

    </div>

@endforeach

</div>

</div>

@endsection