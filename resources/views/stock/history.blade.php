@extends('layouts.app')

@section('title', 'Buku Besar Mutasi')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1 font-serif text-dark">Buku Besar Transaksi (Stock Ledger)</h4>
        <p class="text-muted small mb-0">Catatan kronologis penerimaan restock masuk (IN) dan penjualan butik keluar (OUT).</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('stock.in') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 shadow-sm px-3">
            <i class="bi bi-box-arrow-in-down"></i> Restock Butik (IN)
        </a>
        <a href="{{ route('stock.out') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 shadow-sm px-3">
            <i class="bi bi-bag-check"></i> Kasir Penjualan (OUT)
        </a>
    </div>
</div>

<!-- Filter Tipe Mutasi -->
<div class="card p-3 mb-4">
    <div class="d-flex flex-wrap align-items-center gap-2">
        <span class="small text-muted me-2 fw-semibold">Filter Catatan:</span>
        <a href="{{ route('stock.history') }}" class="btn btn-sm {{ empty($type) ? 'btn-dark' : 'btn-light border' }} px-3">
            Semua Transaksi
        </a>
        <a href="{{ route('stock.history', ['type' => 'IN']) }}" class="btn btn-sm {{ $type === 'IN' ? 'btn-success' : 'btn-light border' }} px-3">
            <i class="bi bi-arrow-down-left me-1"></i> Restock Masuk (IN)
        </a>
        <a href="{{ route('stock.history', ['type' => 'OUT']) }}" class="btn btn-sm {{ $type === 'OUT' ? 'btn-danger' : 'btn-light border' }} px-3">
            <i class="bi bi-bag-check me-1"></i> Penjualan Keluar (OUT)
        </a>
    </div>
</div>

<!-- Tabel Riwayat Mutasi -->
<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 45px;">No</th>
                    <th>Waktu Catat</th>
                    <th>Kode SKU</th>
                    <th>Model Heels</th>
                    <th class="text-center">Jenis Transaksi</th>
                    <th class="text-center">Kuantitas</th>
                    <th>Catatan Faktur / Konsinyasi</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $m)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration + ($movements->currentPage() - 1) * $movements->perPage() }}</td>
                        <td class="small text-muted font-monospace">
                            {{ $m->created_at->format('d M Y, H:i') }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border font-monospace" style="font-size: 0.75rem;">
                                {{ $m->product->sku ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $m->product->name ?? 'Produk Dihapus' }}</div>
                        </td>
                        <td class="text-center">
                            @if($m->type === 'IN')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                    <i class="bi bi-arrow-down-left me-1"></i> Restock (IN)
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                    <i class="bi bi-bag-check me-1"></i> Penjualan (OUT)
                                </span>
                            @endif
                        </td>
                        <td class="text-center fw-bold {{ ($m->type === 'IN') ? 'text-success' : 'text-danger' }}">
                            {{ ($m->type === 'IN' ? '+' : '-') . $m->quantity }} psg
                        </td>
                        <td class="small text-muted" style="max-width: 250px;">
                            {{ $m->notes ?: '-' }}
                        </td>
                        <td class="small text-dark fw-medium">
                            {{ $m->user->profile->full_name ?? '@' . $m->user->username }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">Belum ada riwayat transaksi mutasi yang tercatat.</td>
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
