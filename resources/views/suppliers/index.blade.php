@extends('layouts.app')

@section('title', 'Maison & Pemasok')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1 font-serif text-dark">Luxury Maisons & Distributor</h4>
        <p class="text-muted small mb-0">Manajemen rumah mode (Maison) dan distributor penyedia sepatu heels.</p>
    </div>
    @if(Auth::user()->role === 'admin')
        <div>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 shadow-sm px-3">
                <i class="bi bi-plus-lg"></i> Tambah Maison Baru
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
                    <th>Nama Maison / Distributor</th>
                    <th>Kontak Perwakilan</th>
                    <th>No. Telepon</th>
                    <th>Alamat / Kota Asal</th>
                    <th class="text-center">Koleksi Terkait</th>
                    @if(Auth::user()->role === 'admin')
                        <th class="text-end" style="width: 80px;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $s)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $s->name }}</div>
                        </td>
                        <td>{{ $s->contact_person ?: '-' }}</td>
                        <td><span class="font-monospace small text-dark">{{ $s->phone ?: '-' }}</span></td>
                        <td class="small text-muted text-truncate" style="max-width: 260px;">
                            {{ $s->address ?: '-' }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-2 py-1">{{ $s->products_count }} Model</span>
                        </td>
                        @if(Auth::user()->role === 'admin')
                            <td class="text-end">
                                <a href="{{ route('suppliers.edit', $s) }}" class="btn btn-light btn-sm border text-dark" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Belum ada data pemasok atau maison.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
