@extends('layouts.app')

@section('title', 'Penjualan & Kasir VIP')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1 font-serif">Pencatatan Penjualan (VIP Checkout)</h5>
                <p class="text-muted small mb-0">Catat transaksi penjualan langsung kepada klien butik atau pengeluaran koleksi display.</p>
            </div>
            <a href="{{ route('stock.history') }}" class="btn btn-outline-secondary btn-sm">
                Riwayat Ledger
            </a>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('stock.storeOut') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Koleksi Heels <span class="text-danger">*</span></label>
                    <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required autofocus>
                        <option value="">-- Pilih Model Heels --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ (string)old('product_id', $selectedProductId) === (string)$p->id ? 'selected' : '' }}>
                                [{{ $p->sku }}] {{ $p->name }} (Tersedia: {{ $p->stock }} pairs | Rp {{ number_format($p->price, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Terjual (Pairs) <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" min="1" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}" placeholder="1" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Keterangan / Nomor Invoice VIP</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Nomor faktur butik, nama klien VIP, atau keperluan pameran/trunk show...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-bag-check me-1"></i> Konfirmasi Penjualan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
