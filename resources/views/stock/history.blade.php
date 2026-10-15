@extends('layouts.app')

@section('title', 'Riwayat Mutasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Riwayat Mutasi</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('stock.in') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Stok Masuk
        </a>
        <a href="{{ route('stock.out') }}" class="btn btn-outline-secondary btn-sm">
            Stok Keluar
        </a>
    </div>
</div>

<!-- Filter Tipe Mutasi -->
<div class="card p-3 mb-3">
    <div class="d-flex align-items-center gap-2">
        <span class="small text-muted me-1">Filter:</span>
        <a href="{{ route('stock.history') }}" class="btn btn-sm {{ empty($type) ? 'btn-secondary' : 'btn-light border' }}">
            Semua
        </a>
        <a href="{{ route('stock.history', ['type' => 'IN']) }}" class="btn btn-sm {{ $type === 'IN' ? 'btn-success' : 'btn-light border' }}">
            Masuk
        </a>
        <a href="{{ route('stock.history', ['type' => 'OUT']) }}" class="btn btn-sm {{ $type === 'OUT' ? 'btn-danger' : 'btn-light border' }}">
            Keluar
        </a>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Waktu</th>
                    <th>SKU</th>
                    <th>Produk</th>
                    <th class="text-center">Tipe</th>
                    <th class="text-center">Qty</th>
                    <th>Catatan</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $m)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration + ($movements->currentPage() - 1) * $movements->perPage() }}</td>
                        <td class="small text-muted font-monospace">
                            {{ $m->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td><span class="badge text-bg-light border font-monospace">{{ $m->product->sku }}</span></td>
                        <td class="fw-medium text-dark">{{ $m->product->name }}</td>
                        <td class="text-center">
                            <span class="badge {{ $m->type === 'IN' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border-0">
                                {{ $m->type }}
                            </span>
                        </td>
                        <td class="text-center fw-semibold {{ $m->type === 'IN' ? 'text-success' : 'text-danger' }}">
                            {{ $m->type === 'IN' ? '+' : '-' }}{{ $m->quantity }}
                        </td>
                        <td class="small text-muted">{{ $m->notes ?: '-' }}</td>
                        <td class="small text-muted">&#64;{{ $m->user->username }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada riwayat pergerakan stok.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($movements->hasPages())
        <div class="card-footer bg-white py-2 px-3 border-top d-flex justify-content-between align-items-center">
            <small class="text-muted">Total {{ $movements->total() }} transaksi</small>
            <div>
                {{ $movements->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
