<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Work Order | Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="layout">
        @include('partials.sidebar')
        <main class="content">
            <div class="topbar">
                <div>
                    <h1>Detail Work Order</h1>
                    <p>Ubah status dan lihat informasi lengkap work order.</p>
                </div>
            </div>
            <a href="/admin/orders" class="back-link">← Kembali ke Daftar Work Order</a>
            @if(session('status'))
                <div class="message">{{ session('status') }}</div>
            @endif
            <div class="card" id="details">
                <h2>{{ $order->wo_number }}</h2>
                <div class="details-grid">
                    <div>
                        <strong>Departemen</strong>
                        <p>{{ $order->department }}</p>
                    </div>
                    <div>
                        <strong>Jenis Masalah</strong>
                        <p>{{ $order->issue_type }}</p>
                    </div>
                    <div>
                        <strong>Lokasi</strong>
                        <p>{{ $order->location ?: 'Tidak ada lokasi' }}</p>
                    </div>
                    <div>
                        <strong>Status saat ini</strong>
                        <p><span class="status {{ strtolower(str_replace(' ', '-', $order->status)) }}">{{ $order->status }}</span></p>
                    </div>
                    <div>
                        <strong>Dibuat pada</strong>
                        <p>{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</p>
                    </div>
                </div>
                <div>
                    <strong>Deskripsi</strong>
                    <p>{{ $order->description ?: 'Tidak ada deskripsi tambahan.' }}</p>
                </div>
            </div>
            <div class="card">
                <h2>Ubah Status Work Order</h2>
                <form class="status-form" method="POST" action="/admin/order/{{ $order->id }}/update-status">
                    @csrf
                    <select name="status">
                        <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="On Progress" {{ $order->status === 'On Progress' ? 'selected' : '' }}>On Progress</option>
                        <option value="Completed" {{ $order->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit">Simpan Perubahan</button>
                </form>
            </div>
            @include('partials.footer')
        </main>
    </div>
</body>
</html>
