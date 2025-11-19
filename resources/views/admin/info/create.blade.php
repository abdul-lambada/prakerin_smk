@extends('layouts.app')

@section('title', 'Tambah Info')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Info / Pengumuman</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.info.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-control @error('judul') is-invalid @enderror" required>
                @error('judul')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="form-control @error('tanggal') is-invalid @enderror" required>
                @error('tanggal')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Kategori (opsional)</label>
                <input type="text" name="kategori" value="{{ old('kategori') }}" class="form-control @error('kategori') is-invalid @enderror">
                @error('kategori')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Isi</label>
                <textarea name="isi" rows="4" class="form-control @error('isi') is-invalid @enderror" required>{{ old('isi') }}</textarea>
                @error('isi')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Lampiran (opsional, max 2 MB)</label>
                <input type="file" name="file" class="form-control-file @error('file') is-invalid @enderror">
                @error('file')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('admin.info.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
