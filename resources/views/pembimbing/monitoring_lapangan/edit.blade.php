@extends('layouts.app')

@section('title', 'Edit Monitoring Lapangan')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Monitoring Lapangan</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('pembimbing.monitoring-lapangan.update', $monitoring) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Tempat PKL</label>
                <select name="kd_tempat" class="form-control @error('kd_tempat') is-invalid @enderror" required>
                    <option value="">-- Pilih Tempat --</option>
                    @foreach($tempats as $t)
                        <option value="{{ $t->kd_tempat }}" {{ old('kd_tempat', $monitoring->kd_tempat) == $t->kd_tempat ? 'selected' : '' }}>
                            {{ $t->kd_tempat }} - {{ optional($t->industri)->nama_industri ?? '-' }} ({{ optional($t->siswa)->nama_lengkap ?? 'Siswa' }})
                        </option>
                    @endforeach
                </select>
                @error('kd_tempat')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tanggal Monitoring</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', optional($monitoring->tanggal)->toDateString()) }}" class="form-control @error('tanggal') is-invalid @enderror" required>
                @error('tanggal')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="4">{{ old('catatan', $monitoring->catatan) }}</textarea>
                @error('catatan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Foto Dokumentasi (opsional)</label>
                @if($monitoring->foto)
                    <div class="mb-2">
                        <a href="{{ asset('storage/'.$monitoring->foto) }}" target="_blank">Lihat foto saat ini</a>
                    </div>
                @endif
                <input type="file" name="foto" class="form-control-file @error('foto') is-invalid @enderror">
                @error('foto')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('pembimbing.monitoring-lapangan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
