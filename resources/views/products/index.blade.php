@extends('layouts.app')

@section('title', 'Koleksi Heels')

@section('content')
<!-- Header Halaman -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1 font-serif text-dark">Koleksi Designer Heels</h4>
        <p class="text-muted small mb-0">Katalog sepatu hak tinggi mewah (Haute Couture) Maison Sole Atelier.</p>
    </div>
    @if(Auth::user()->role === 'admin')
        <div>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 shadow-sm px-3">
                <i class="bi bi-plus-lg"></i> Tambah Koleksi Baru
            </a>
        </div>
    @endif
</div>

<!-- Filter & Pencarian Rapih -->
<div class="card p-3 mb-4">
    <form method="GET" action="{{ route('products.index') }}" class="row g-2 align-items-center">
        <div class="col-12 col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama heels atau SKU..." value="{{ request('search') }}">
            </div>
        </div>

        <div class="col-6 col-md-3">
            <select name="category_id" class="form-select form-select-sm">
                <option value="">Semua Siluet & Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ (string)request('category_id') === (string)$c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-6 col-md-3">
            <div class="input-group input-group-sm">
                <select name="sort" class="form-select">
                    <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>Urut: Nama</option>
                    <option value="sku" {{ $sortBy === 'sku' ? 'selected' : '' }}>Urut: SKU</option>
                    <option value="price" {{ $sortBy === 'price' ? 'selected' : '' }}>Urut: Harga</option>
                    <option value="stock" {{ $sortBy === 'stock' ? 'selected' : '' }}>Urut: Stok</option>
                </select>
                <select name="order" class="form-select" style="max-width: 80px;">
                    <option value="asc" {{ strtolower($order) === 'asc' ? 'selected' : '' }}>ASC</option>
                    <option value="desc" {{ strtolower($order) === 'desc' ? 'selected' : '' }}>DESC</option>
                </select>
            </div>
        </div>

        <div class="col-12 col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm flex-fill">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset Filter">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </div>
    </form>
</div>

<!-- Tabel Koleksi Heels -->
<div class="card overflow-hidden mb-3">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 45px;">No</th>
                    <th>Kode SKU</th>
                    <th>Model Heels</th>
                    <th>Siluet</th>
                    <th>Maison / Pemasok</th>
                    <th class="text-end">Harga Butik</th>
                    <th class="text-center">Sisa Stok</th>
                    <th class="text-center">Kondisi</th>
                    <th class="text-end" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                        <td>
                            <span class="badge bg-light text-dark border font-monospace" style="font-size: 0.75rem; letter-spacing: 0.3px;">
                                {{ $p->sku }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $p->name }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.74rem;">
                                {{ $p->category->name ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if($p->suppliers->isNotEmpty())
                                <span class="small text-muted">{{ $p->suppliers->pluck('name')->join(', ') }}</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-end fw-semibold text-dark">
                            Rp {{ number_format($p->price, 0, ',', '.') }}
                        </td>
                        <td class="text-center fw-bold {{ $p->stock <= $p->minimum_stock ? 'text-danger' : 'text-dark' }}">
                            {{ $p->stock }} <span class="fw-normal text-muted small">psg</span>
                        </td>
                        <td class="text-center">
                            @if($p->stock <= 0)
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Habis</span>
                            @elseif($p->stock <= $p->minimum_stock)
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Menipis</span>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Tersedia</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <!-- Aksi Kasir (Bisa dilakukan Admin & Staff) -->
                                <a href="{{ route('stock.out', ['product_id' => $p->id]) }}" class="btn btn-light border text-danger" title="Catat Penjualan (Kasir)">
                                    <i class="bi bi-bag-check"></i>
                                </a>
                                <a href="{{ route('stock.in', ['product_id' => $p->id]) }}" class="btn btn-light border text-success" title="Restock Butik">
                                    <i class="bi bi-box-arrow-in-down"></i>
                                </a>

                                @if(Auth::user()->role === 'admin')
                                    <!-- Aksi Khusus Admin: Edit & Hapus Master Data -->
                                    <a href="{{ route('products.edit', $p) }}" class="btn btn-light border text-dark" title="Edit Master Produk">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('products.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Hapus model heels ini dari inventaris?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light border text-danger" title="Hapus Koleksi">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                            Tidak ada koleksi heels yang sesuai dengan pencarian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div class="p-3 bg-white border-top d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <small class="text-muted">
            Menampilkan {{ $products->count() }} dari total {{ $products->total() }} koleksi (Halaman {{ $products->currentPage() }} dari {{ max(1, $products->lastPage()) }})
        </small>
        @if($products->hasPages())
            <div>
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
