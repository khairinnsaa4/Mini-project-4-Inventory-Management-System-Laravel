@extends('layouts.app')

@section('title', 'Kasir Penjualan (OUT)')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1 font-serif text-dark">Kasir Penjualan Butik (OUT)</h4>
                <p class="text-muted small mb-0">Catat transaksi penjualan heels kepada pelanggan VIP butik.</p>
            </div>
            <a href="{{ route('stock.history') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-journal-text me-1"></i> Riwayat Kasir
            </a>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('stock.storeOut') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Pilih Model Heels <span class="text-danger">*</span></label>
                    <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required autofocus>
                        <option value="">-- Pilih Model Heels Tersedia --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ (string)old('product_id', $selectedProductId) === (string)$p->id ? 'selected' : '' }}>
                                [{{ $p->sku }}] {{ $p->name }} (Tersedia: {{ $p->stock }} psg) - Rp {{ number_format($p->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Jumlah Terjual (Pasang) <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" min="1" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}" placeholder="1" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Catatan Transaksi / No. Faktur VIP</label>
                    <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes', 'Penjualan Butik - Faktur #MAI-' . date('md') . rand(10, 99)) }}" placeholder="Contoh: Penjualan VIP Suite - Faktur #MAI-8801">
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm px-3">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4">
                        <i class="bi bi-bag-check me-1"></i> Konfirmasi Penjualan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
