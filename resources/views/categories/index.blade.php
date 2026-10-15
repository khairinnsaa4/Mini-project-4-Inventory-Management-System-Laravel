@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Kategori Produk</h5>
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </a>
    @endif
</div>

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th class="text-center">Jumlah Item</th>
                    <th class="text-center">Total Stok</th>
                    @if(Auth::user()->role === 'admin')
                        <th class="text-end" style="width: 100px;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            <span class="fw-medium text-dark">{{ $cat->name }}</span>
                        </td>
                        <td class="text-muted small">{{ $cat->description ?: '-' }}</td>
                        <td class="text-center">
                            <span class="badge text-bg-light border">{{ $cat->products_count }}</span>
                        </td>
                        <td class="text-center">{{ $cat->total_stock ?? 0 }}</td>
                        @if(Auth::user()->role === 'admin')
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('categories.edit', $cat) }}" class="btn btn-light border" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('categories.destroy', $cat) }}" class="d-inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light border text-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
