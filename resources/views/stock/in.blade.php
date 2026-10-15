@extends('layouts.app')

@section('title', 'Restock Butik (IN)')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1 font-serif text-dark">Restock Koleksi Butik (IN)</h4>
                <p class="text-muted small mb-0">Catat penerimaan pengiriman sepatu heels dari Maison / Atelier.</p>
            </div>
            <a href="{{ route('stock.history') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-journal-text me-1"></i> Buku Besar
            </a>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('stock.storeIn') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Pilih Model Heels <span class="text-danger">*</span></label>
                    <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required autofocus>
                        <option value="">-- Pilih Model Heels --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ (string)old('product_id', $selectedProductId) === (string)$p->id ? 'selected' : '' }}>
                                [{{ $p->sku }}] {{ $p->name }} (Sisa: {{ $p->stock }} psg)
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Jumlah Pasang Masuk <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" min="1" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" placeholder="Contoh: 10" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Catatan / No. Invoice Pengiriman</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Contoh: Pengiriman batch konsinyasi langsung dari Paris Atelier...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm px-3">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4">
                        <i class="bi bi-box-arrow-in-down me-1"></i> Simpan Restock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
