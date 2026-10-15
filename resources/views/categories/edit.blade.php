@extends('layouts.app')

@section('title', 'Edit Siluet')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 font-serif">Edit Kategori Siluet</h5>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm">
                Kembali
            </a>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('categories.update', $category) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Siluet / Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
