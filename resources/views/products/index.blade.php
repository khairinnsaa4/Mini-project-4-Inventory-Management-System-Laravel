@extends('layouts.app')

@section('title', 'Data Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Data Produk</h5>
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
        </a>
    @endif
</div>

<!-- Filter & Search Bar -->
<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('products.index') }}" class="row g-2 align-items-center">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau SKU..." value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="category_id" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ (string)request('category_id') === (string)$c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <div class="input-group input-group-sm">
                <select name="sort" class="form-select">
                    <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>Urut: Nama</option>
                    <option value="sku" {{ $sortBy === 'sku' ? 'selected' : '' }}>Urut: SKU</option>
                    <option value="price" {{ $sortBy === 'price' ? 'selected' : '' }}>Urut: Harga</option>
                    <option value="stock" {{ $sortBy === 'stock' ? 'selected' : '' }}>Urut: Stok</option>
                </select>
                <select name="order" class="form-select" style="max-width: 80px;">
                    <option value="asc" {{ $order === 'asc' ? 'selected' : '' }}>ASC</option>
                    <option value="desc" {{ $order === 'desc' ? 'selected' : '' }}>DESC</option>
                </select>
            </div>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm flex-fill">
                Filter
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </div>
    </form>
</div>

<!-- Tabel Data Produk -->
<div class="card overflow-hidden mb-3">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Kode SKU</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Supplier</th>
                    <th class="text-end">Harga</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Status</th>
                    <th class="text-end" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                        <td>
                            <span class="font-monospace text-dark" style="font-size: 0.8rem;">{{ $product->sku }}</span>
                        </td>
                        <td>
                            <div class="fw-medium text-dark">{{ $product->name }}</div>
                        </td>
                        <td>
                            <span class="badge text-bg-light border">{{ $product->category->name }}</span>
                        </td>
                        <td>
                            @if($product->suppliers->isNotEmpty())
                                <span class="small text-muted">{{ $product->suppliers->pluck('name')->join(', ') }}</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-end text-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="text-center fw-semibold {{ $product->stock <= $product->minimum_stock ? 'text-danger' : 'text-dark' }}">
                            {{ $product->stock }}
                        </td>
                        <td class="text-center">
                            @if($product->stock <= 0)
                                <span class="badge bg-danger-subtle text-danger">Habis</span>
                            @elseif($product->stock <= $product->minimum_stock)
                                <span class="badge bg-warning-subtle text-warning">Menipis</span>
                            @else
                                <span class="badge bg-success-subtle text-success">Aman</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('stock.in', ['product_id' => $product->id]) }}" class="btn btn-light border" title="Tambah Stok">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-light border" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light border text-danger" title="Hapus">
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
                            Tidak ditemukan produk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="card-footer bg-white py-2 px-3 border-top d-flex justify-content-between align-items-center">
            <small class="text-muted">Total {{ $products->total() }} produk</small>
            <div>
                {{ $products->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
