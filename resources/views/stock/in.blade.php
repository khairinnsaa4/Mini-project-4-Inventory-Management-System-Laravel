@extends('layouts.app')

@section('title', 'Restock Koleksi Heels')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1 font-serif">Penerimaan Koleksi (Restock)</h5>
                <p class="text-muted small mb-0">Catat penambahan kuantitas heels dari pengiriman Maison atau importir resmi.</p>
            </div>
            <a href="{{ route('stock.history') }}" class="btn btn-outline-secondary btn-sm">
                Riwayat Ledger
            </a>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('stock.storeIn') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Model Heels <span class="text-danger">*</span></label>
                    <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required autofocus>
                        <option value="">-- Pilih Model Heels --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ (string)old('product_id', $selectedProductId) === (string)$p->id ? 'selected' : '' }}>
                                [{{ $p->sku }}] {{ $p->name }} (Stok Saat Ini: {{ $p->stock }} pairs)
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Restock (Pairs) <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" min="1" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" placeholder="Contoh: 5" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Keterangan / Referensi Pengiriman</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Nomor faktur invoice pengiriman dari Paris/Milan atelier atau keterangan kurir khusus...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-box-arrow-in-down me-1"></i> Simpan Restock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
