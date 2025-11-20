@extends('layouts.app')

@section('title', 'Isi Absensi Prakerin')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Isi Absensi Prakerin</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('siswa.absensi.store') }}" enctype="multipart/form-data">
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
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" class="form-control @error('tanggal') is-invalid @enderror" required>
                @error('tanggal')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Jam Masuk</label>
                <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}" class="form-control @error('jam_masuk') is-invalid @enderror" required>
                @error('jam_masuk')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Jam Keluar</label>
                <input type="time" name="jam_keluar" value="{{ old('jam_keluar') }}" class="form-control @error('jam_keluar') is-invalid @enderror">
                @error('jam_keluar')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="hadir" {{ old('status', 'hadir') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="alpha" {{ old('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                </select>
                @error('status')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" value="{{ old('keterangan') }}" class="form-control @error('keterangan') is-invalid @enderror">
                @error('keterangan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" accept="image/*" capture="user" class="form-control-file @error('foto') is-invalid @enderror">
                <small class="form-text text-muted">Foto wajib untuk status Hadir, Izin, dan Sakit (selfie atau bukti). Untuk status Alpha, foto bersifat opsional.</small>
                @error('foto')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('siswa.absensi.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Absensi</button>
        </form>
    </div>
</div>
@endsection
