@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Dashboard</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('stock.in') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Stok Masuk
        </a>
        <a href="{{ route('stock.out') }}" class="btn btn-outline-secondary btn-sm">
            Stok Keluar
        </a>
    </div>
</div>

<!-- 4 Kartu Metrik -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-medium text-uppercase">Total Produk</span>
                <i class="bi bi-box text-primary"></i>
            </div>
            <div class="fs-4 fw-bold text-dark">{{ number_format($total_produk) }}</div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-medium text-uppercase">Nilai Aset</span>
                <i class="bi bi-wallet2 text-success"></i>
            </div>
            <div class="fs-4 fw-bold text-dark">Rp {{ number_format($total_nilai, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-medium text-uppercase">Stok Menipis</span>
                <i class="bi bi-exclamation-triangle text-warning"></i>
            </div>
            <div class="fs-4 fw-bold {{ $total_low_stock > 0 ? 'text-warning' : 'text-dark' }}">
                {{ number_format($total_low_stock) }}
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-medium text-uppercase">Total Mutasi</span>
                <i class="bi bi-arrow-left-right text-secondary"></i>
            </div>
            <div class="fs-4 fw-bold text-dark d-flex gap-3">
                <span class="text-success small fw-semibold">+{{ number_format($total_in) }}</span>
                <span class="text-danger small fw-semibold">-{{ number_format($total_out) }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Kolom Kiri: Peringatan Stok Menipis -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Stok Perlu Perhatian</span>
                <span class="badge text-bg-light border">{{ $low_stock_products->count() }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th class="text-center">Sisa</th>
                            <th class="text-center">Min</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($low_stock_products as $prod)
                            <tr>
                                <td>
                                    <div class="fw-medium text-dark">{{ $prod->name }}</div>
                                    <span class="text-muted small font-monospace">{{ $prod->sku }}</span>
                                </td>
                                <td><span class="badge text-bg-light border">{{ $prod->category->name }}</span></td>
                                <td class="text-center">
                                    <span class="badge bg-danger-subtle text-danger border-0 fw-semibold">
                                        {{ $prod->stock }}
                                    </span>
                                </td>
                                <td class="text-center text-muted small">{{ $prod->minimum_stock }}</td>
                                <td class="text-end">
                                    <a href="{{ route('stock.in', ['product_id' => $prod->id]) }}" class="btn btn-light btn-sm border py-0 px-2" style="font-size: 0.8rem;">
                                        Restock
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">
                                    Semua stok dalam kondisi aman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Mutasi Terakhir -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Aktivitas Mutasi Terkini</span>
                <a href="{{ route('stock.history') }}" class="small text-decoration-none">
                    Semua &rarr;
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Produk</th>
                            <th>Tipe</th>
                            <th class="text-center">Qty</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_movements as $m)
                            <tr>
                                <td class="small text-muted font-monospace">
                                    {{ $m->created_at->format('d/m H:i') }}
                                </td>
                                <td>
                                    <div class="fw-medium text-dark text-truncate" style="max-width: 160px;">{{ $m->product->name }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $m->type === 'IN' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border-0">
                                        {{ $m->type }}
                                    </span>
                                </td>
                                <td class="text-center fw-semibold {{ $m->type === 'IN' ? 'text-success' : 'text-danger' }}">
                                    {{ $m->type === 'IN' ? '+' : '-' }}{{ $m->quantity }}
                                </td>
                                <td class="small text-muted">@{{ $m->user->username }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
