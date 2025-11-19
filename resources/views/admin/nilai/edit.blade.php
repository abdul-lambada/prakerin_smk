@extends('layouts.app')

@section('title', 'Edit Nilai PKL')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Nilai PKL</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.nilai.update', $nilai) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Penempatan (Siswa - Tempat)</label>
                <select name="kd_tempat" class="form-control @error('kd_tempat') is-invalid @enderror" required>
                    <option value="">-- Pilih Penempatan --</option>
                    @foreach($tempats as $t)
                        <option value="{{ $t->kd_tempat }}" {{ old('kd_tempat', $nilai->kd_tempat) == $t->kd_tempat ? 'selected' : '' }}>
                            {{ $t->kd_tempat }} - {{ optional($t->siswa)->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
                @error('kd_tempat')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Nilai (0-100)</label>
                <input type="number" name="nilai" value="{{ old('nilai', $nilai->nilai) }}" class="form-control @error('nilai') is-invalid @enderror" min="0" max="100" required>
                @error('nilai')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" value="{{ old('keterangan', $nilai->keterangan) }}" class="form-control @error('keterangan') is-invalid @enderror">
                @error('keterangan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('admin.nilai.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
