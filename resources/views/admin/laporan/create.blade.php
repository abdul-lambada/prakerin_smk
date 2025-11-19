@extends('layouts.app')

@section('title', 'Tambah Laporan PKL')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Laporan PKL</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.laporan.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Siswa</label>
                <select name="nis_siswa" class="form-control @error('nis_siswa') is-invalid @enderror" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas as $s)
                        <option value="{{ $s->nis_siswa }}" {{ old('nis_siswa') == $s->nis_siswa ? 'selected' : '' }}>
                            {{ $s->nis_siswa }} - {{ $s->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
                @error('nis_siswa')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tempat</label>
                <select name="kd_tempat" class="form-control @error('kd_tempat') is-invalid @enderror" required>
                    <option value="">-- Pilih Tempat --</option>
                    @foreach($tempats as $t)
                        <option value="{{ $t->kd_tempat }}" {{ old('kd_tempat') == $t->kd_tempat ? 'selected' : '' }}>
                            {{ $t->kd_tempat }}
                        </option>
                    @endforeach
                </select>
                @error('kd_tempat')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Industri</label>
                <select name="kd_industri" class="form-control @error('kd_industri') is-invalid @enderror" required>
                    <option value="">-- Pilih Industri --</option>
                    @foreach($industris as $i)
                        <option value="{{ $i->kd_industri }}" {{ old('kd_industri') == $i->kd_industri ? 'selected' : '' }}>
                            {{ $i->nama_industri }}
                        </option>
                    @endforeach
                </select>
                @error('kd_industri')
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

            <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
