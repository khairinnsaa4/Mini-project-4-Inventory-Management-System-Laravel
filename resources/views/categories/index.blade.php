@extends('layouts.app')

@section('title', 'Kategori Siluet')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1 font-serif text-dark">Kategori Siluet Heels</h4>
        <p class="text-muted small mb-0">Klasifikasi tipe desain sepatu hak tinggi untuk pengorganisasian katalog atelier.</p>
    </div>
    @if(Auth::user()->role === 'admin')
        <div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 shadow-sm px-3">
                <i class="bi bi-plus-lg"></i> Tambah Kategori Siluet
            </a>
        </div>
    @endif
</div>

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Siluet / Kategori</th>
                    <th>Deskripsi Karakteristik</th>
                    <th class="text-center">Varian Model</th>
                    <th class="text-center">Total Pasang</th>
                    @if(Auth::user()->role === 'admin')
                        <th class="text-end" style="width: 100px;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration }}</td>
                        <td class="fw-semibold text-dark">{{ $cat->name }}</td>
                        <td class="text-muted small" style="max-width: 320px;">{{ $cat->description ?: '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-2 py-1">{{ $cat->products_count }} Model</span>
                        </td>
                        <td class="text-center fw-semibold text-dark">{{ $cat->total_stock ?? 0 }} psg</td>
                        @if(Auth::user()->role === 'admin')
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('categories.edit', $cat) }}" class="btn btn-light border text-dark" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('categories.destroy', $cat) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus siluet kategori ini?')">
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
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada kategori yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
