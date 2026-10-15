@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Detail Produk</h5>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                Kembali
            </a>
        </div>

        <div class="card p-4 mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="text-muted small">Kode SKU</label>
                    <div class="fs-5 fw-bold font-monospace text-primary">{{ $product->sku }}</div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Kategori</label>
                    <div><span class="badge text-bg-light border">{{ $product->category->name }}</span></div>
                </div>
                <div class="col-12">
                    <label class="text-muted small">Nama Produk</label>
                    <div class="fs-5 fw-bold text-dark">{{ $product->name }}</div>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small">Harga</label>
                    <div class="fs-5 fw-semibold text-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small">Stok Fisik</label>
                    <div class="fs-5 fw-bold {{ $product->isLowStock() ? 'text-danger' : 'text-dark' }}">{{ $product->stock }} unit</div>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small">Batas Minimum Stok</label>
                    <div class="fs-5 text-muted">{{ $product->minimum_stock }} unit</div>
                </div>
                <div class="col-12">
                    <label class="text-muted small">Pemasok / Supplier</label>
                    <div class="mt-1">
                        @forelse($product->suppliers as $s)
                            <span class="badge text-bg-light border me-1 p-2">{{ $s->name }}</span>
                        @empty
                            <span class="text-muted small">-</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="card-header">
                Riwayat Mutasi Produk Ini
            </div>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Tipe</th>
                            <th class="text-center">Qty</th>
                            <th>Keterangan</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($product->stockMovements as $sm)
                            <tr>
                                <td class="small text-muted font-monospace">{{ $sm->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge {{ $sm->type === 'IN' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border-0">
                                        {{ $sm->type }}
                                    </span>
                                </td>
                                <td class="text-center fw-semibold {{ $sm->type === 'IN' ? 'text-success' : 'text-danger' }}">
                                    {{ $sm->type === 'IN' ? '+' : '-' }}{{ $sm->quantity }}
                                </td>
                                <td class="small text-muted">{{ $sm->notes ?: '-' }}</td>
                                <td class="small text-muted">&#64;{{ $sm->user->username }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">Belum ada riwayat mutasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
