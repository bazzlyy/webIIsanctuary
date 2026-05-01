@extends('layouts.app')

@section('content')

<style>
.wrapper {
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    text-align: left;
    padding: 12px;
    font-size: 13px;
    color: #6b7280;
}

td {
    padding: 14px 12px;
    border-top: 1px solid #f1f5f9;
}

tr:hover {
    background: #f9fafb;
}

/* STATUS */
.badge {
    padding: 6px 12px;
    border-radius: 20px;
    color: white;
    font-size: 12px;
}

.pending { background:#facc15; }
.process { background:#3b82f6; }
.shipped { background:#8b5cf6; }
.done { background:#22c55e; }

/* BUTTON */
.btn {
    padding: 6px 10px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
}

.btn-save {
    background:#111827;
    color:white;
}

.btn-save:hover {
    background:#374151;
}

.btn-detail {
    background:#e5e7eb;
    text-decoration:none;
    font-size:13px;
}

/* SELECT */
select {
    padding: 6px;
    border-radius: 8px;
    border: 1px solid #ddd;
}
</style>

<h2 style="margin-bottom:20px;">Orders</h2>

<div class="wrapper">

<table>

    <thead>
        <tr>
            <th>Customer</th>
            <th>Alamat</th>
            <th>Phone</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
    @foreach($orders as $order)

        <tr>

            <td>
                <strong>{{ $order->name }}</strong><br>
                <small style="color:#9ca3af;">
                    {{ $order->created_at->format('d M Y H:i') }}
                </small>
            </td>

            <td>{{ $order->address }}</td>
            <td>{{ $order->phone }}</td>

            <td>
                <strong>Rp {{ number_format($order->total) }}</strong>
            </td>

            <!-- STATUS -->
            <td>
                <span class="badge
                    {{ $order->status == 'pending' ? 'pending' : '' }}
                    {{ $order->status == 'diproses' ? 'process' : '' }}
                    {{ $order->status == 'dikirim' ? 'shipped' : '' }}
                    {{ $order->status == 'selesai' ? 'done' : '' }}
                ">
                    {{ $order->status }}
                </span>
            </td>

            <!-- ACTION -->
            <td>

                <!-- 🔥 FIX DI SINI: HAPUS @method('PUT') -->
                <form action="/orders/{{ $order->id }}/status" method="POST" style="display:flex; gap:5px;">
    @csrf
    @method('PUT') <!-- WAJIB ADA -->

    <select name="status">
        <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
        <option value="diproses" {{ $order->status=='diproses'?'selected':'' }}>Diproses</option>
        <option value="dikirim" {{ $order->status=='dikirim'?'selected':'' }}>Dikirim</option>
        <option value="selesai" {{ $order->status=='selesai'?'selected':'' }}>Selesai</option>
    </select>

    <button class="btn btn-save">✔</button>
</form>

                <a href="/orders/{{ $order->id }}" class="btn btn-detail">
                    Detail
                </a>

            </td>

        </tr>

    @endforeach
    </tbody>

</table>

</div>

@endsection