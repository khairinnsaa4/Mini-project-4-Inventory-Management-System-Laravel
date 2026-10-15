@extends('layouts.app')

@section('title', 'Edit Mitra Maison')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 font-serif">Edit Mitra Maison / Distributor</h5>
            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary btn-sm">
                Kembali
            </a>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Maison / Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $supplier->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact Person</label>
                    <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $supplier->contact_person) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address', $supplier->address) }}</textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
