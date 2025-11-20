@extends('layouts.app')

@section('title', 'Upload Laporan Prakerin')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Upload Laporan Prakerin</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('siswa.laporan.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Tempat Prakerin</label>
                <select name="kd_tempat" class="form-control @error('kd_tempat') is-invalid @enderror" required>
                    <option value="">-- Pilih Tempat Prakerin --</option>
                    @foreach($tempats as $t)
                        <option value="{{ $t->kd_tempat }}" {{ old('kd_tempat') == $t->kd_tempat ? 'selected' : '' }}>
                            {{ $t->kd_tempat }} - {{ optional($t->industri)->nama_industri }}
                        </option>
                    @endforeach
                </select>
                @error('kd_tempat')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Judul Laporan</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-control @error('judul') is-invalid @enderror" required>
                @error('judul')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>File Laporan (PDF/DOC, max 4 MB)</label>
                <input type="file" name="file" class="form-control-file @error('file') is-invalid @enderror" required>
                @error('file')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('siswa.laporan.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</div>
@endsection
