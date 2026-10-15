@extends('layouts.app')

@section('title', 'Barang Keluar')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Barang Keluar</h5>
            <a href="{{ route('stock.history') }}" class="btn btn-outline-secondary btn-sm">
                Riwayat
            </a>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('stock.storeOut') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Produk <span class="text-danger">*</span></label>
                    <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required autofocus>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ (string)old('product_id', $selectedProductId) === (string)$p->id ? 'selected' : '' }}>
                                [{{ $p->sku }}] {{ $p->name }} (Tersedia: {{ $p->stock }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Keluar (Qty) <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" min="1" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" placeholder="0" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Tujuan / Keperluan</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Keterangan pengeluaran barang...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-danger px-4">
                        Keluarkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
