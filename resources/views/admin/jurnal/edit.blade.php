@extends('layouts.app')

@section('title', 'Edit Jurnal PKL')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Jurnal PKL</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.jurnal.update', $jurnal) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Siswa</label>
                <select name="nis_siswa" class="form-control @error('nis_siswa') is-invalid @enderror" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas as $s)
                        <option value="{{ $s->nis_siswa }}" {{ old('nis_siswa', $jurnal->nis_siswa) == $s->nis_siswa ? 'selected' : '' }}>
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
                        <option value="{{ $t->kd_tempat }}" {{ old('kd_tempat', $jurnal->kd_tempat) == $t->kd_tempat ? 'selected' : '' }}>
                            {{ $t->kd_tempat }}
                        </option>
                    @endforeach
                </select>
                @error('kd_tempat')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', optional($jurnal->tanggal)->format('Y-m-d')) }}" class="form-control @error('tanggal') is-invalid @enderror" required>
                @error('tanggal')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Jam Mulai</label>
                <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $jurnal->jam_mulai) }}" class="form-control @error('jam_mulai') is-invalid @enderror" required>
                @error('jam_mulai')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Jam Selesai</label>
                <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jurnal->jam_selesai) }}" class="form-control @error('jam_selesai') is-invalid @enderror">
                @error('jam_selesai')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Kegiatan</label>
                <input type="text" name="kegiatan" value="{{ old('kegiatan', $jurnal->kegiatan) }}" class="form-control @error('kegiatan') is-invalid @enderror" required>
                @error('kegiatan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $jurnal->deskripsi) }}</textarea>
                @error('deskripsi')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('admin.jurnal.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
