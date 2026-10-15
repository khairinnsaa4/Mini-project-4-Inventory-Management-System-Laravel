@extends('layouts.app')

@section('title', 'Tambah Mitra Maison')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 font-serif">Tambah Mitra Maison / Distributor</h5>
            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary btn-sm">
                Kembali
            </a>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('suppliers.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Maison / Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Cesare Paciotti S.p.A." required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Perwakilan Kontak (Client Liaison)</label>
                    <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}" placeholder="Contoh: Marco Bellini">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Telepon / Hotline</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+39 0733 890123">
                </div>
                <div class="mb-3">
                    <label class="form-label">Atelier / Alamat Resmi</label>
                    <textarea name="address" class="form-control" rows="3" placeholder="Contoh: Via Monte Napoleone 8, Milan, Italy">{{ old('address') }}</textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
