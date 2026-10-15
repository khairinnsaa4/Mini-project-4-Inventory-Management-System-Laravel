@extends('layouts.app')

@section('title', 'Tambah Koleksi Heels')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1 font-serif">Registrasi Koleksi Heels Baru</h5>
                <p class="text-muted small mb-0">Tambahkan koleksi haute couture ke dalam inventaris Maison Sole.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                Kembali
            </a>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('products.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode SKU <span class="text-danger">*</span></label>
                        <input type="text" name="sku" class="form-control font-monospace @error('sku') is-invalid @enderror" value="{{ old('sku') }}" placeholder="Contoh: LOUB-SO-KATE-120" required autofocus>
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kategori Siluet <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori Siluet</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ (string)old('category_id') === (string)$c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Nama Model & Spesifikasi Heels <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Christian Louboutin So Kate 120 Patent Rouge" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Harga Butik (Rp) <span class="text-danger">*</span></label>
                        <input type="number" step="100" min="0" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="15000000" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Stok Awal (Pairs)</label>
                        <input type="number" min="0" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Batas Minimum Stok</label>
                        <input type="number" min="0" name="minimum_stock" class="form-control @error('minimum_stock') is-invalid @enderror" value="{{ old('minimum_stock', 3) }}" required>
                        @error('minimum_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Maison & Distributor Resmi</label>
                        <div class="p-3 bg-light rounded-2 border">
                            <div class="row g-2">
                                @forelse($suppliers as $s)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="suppliers[]" value="{{ $s->id }}" id="sup_{{ $s->id }}"
                                                {{ is_array(old('suppliers')) && in_array($s->id, old('suppliers')) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="sup_{{ $s->id }}">
                                                {{ $s->name }}
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-muted small">Belum ada data supplier.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
