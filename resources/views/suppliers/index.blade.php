@extends('layouts.app')

@section('title', 'Maison & Distributor')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1 font-serif">Maison & Distributor Resmi</h5>
        <p class="text-muted small mb-0">Atelier mode dan mitra distribusi resmi Louboutin, Paciotti, Blahnik, Choo, dan Muaddi.</p>
    </div>
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Mitra Maison
        </a>
    @endif
</div>

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Maison / Distributor</th>
                    <th>Perwakilan Kontak</th>
                    <th>Hotline / Telepon</th>
                    <th>Atelier / Alamat</th>
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
                            <span class="fw-medium text-dark">{{ $s->name }}</span>
                        </td>
                        <td>{{ $s->contact_person ?: '-' }}</td>
                        <td><span class="font-monospace small text-dark">{{ $s->phone ?: '-' }}</span></td>
                        <td class="small text-muted text-truncate" style="max-width: 240px;">
                            {{ $s->address ?: '-' }}
                        </td>
                        <td class="text-center">
                            <span class="badge text-bg-light border">{{ $s->products_count }}</span>
                        </td>
                        @if(Auth::user()->role === 'admin')
                            <td class="text-end">
                                <a href="{{ route('suppliers.edit', $s) }}" class="btn btn-light btn-sm border" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data supplier.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
