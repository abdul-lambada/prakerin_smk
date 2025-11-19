@extends('layouts.app')

@section('title', 'Tambah Jurnal Harian')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Jurnal Harian</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('siswa.jurnal.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Tempat PKL</label>
                <select name="kd_tempat" class="form-control @error('kd_tempat') is-invalid @enderror" required>
                    <option value="">-- Pilih Tempat PKL --</option>
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
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" class="form-control @error('tanggal') is-invalid @enderror" required>
                @error('tanggal')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Jam Mulai</label>
                <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" class="form-control @error('jam_mulai') is-invalid @enderror" required>
                @error('jam_mulai')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Jam Selesai</label>
                <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" class="form-control @error('jam_selesai') is-invalid @enderror">
                @error('jam_selesai')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Kegiatan</label>
                <input type="text" name="kegiatan" value="{{ old('kegiatan') }}" class="form-control @error('kegiatan') is-invalid @enderror" required>
                @error('kegiatan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Deskripsi / Catatan</label>
                <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Foto Jurnal Kertas (wajib)</label>
                <input type="file" name="foto" accept="image/*" capture="environment" class="form-control-file @error('foto') is-invalid @enderror" required>
                <small class="form-text text-muted">Foto halaman jurnal kertas yang sudah ditandatangani pembimbing lapangan (DU/DI).</small>
                @error('foto')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('siswa.jurnal.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Jurnal</button>
        </form>
    </div>
</div>
@endsection
