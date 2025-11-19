@extends('layouts.app')

@section('title', 'Input Nilai PKL')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Input Nilai PKL</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nilai PKL untuk {{ optional($tempat->siswa)->nama_lengkap }}</h6>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Siswa</dt>
            <dd class="col-sm-9">{{ optional($tempat->siswa)->nama_lengkap }}</dd>

            <dt class="col-sm-3">Industri</dt>
            <dd class="col-sm-9">{{ optional($tempat->industri)->nama_industri }}</dd>

            <dt class="col-sm-3">Kode Tempat</dt>
            <dd class="col-sm-9">{{ $tempat->kd_tempat }}</dd>

            <dt class="col-sm-3">Tahun</dt>
            <dd class="col-sm-9">{{ $tempat->tahun }}</dd>
        </dl>

        <form method="POST" action="{{ route('pembimbing.nilai.save', $tempat) }}">
            @csrf

            <div class="form-group">
                <label>Nilai (0 - 100)</label>
                <input type="number" name="nilai" min="0" max="100" step="1"
                       value="{{ old('nilai', optional($tempat->nilai)->nilai) }}"
                       class="form-control @error('nilai') is-invalid @enderror" required>
                @error('nilai')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan"
                       value="{{ old('keterangan', optional($tempat->nilai)->keterangan) }}"
                       class="form-control @error('keterangan') is-invalid @enderror">
                @error('keterangan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('pembimbing.nilai.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Nilai</button>
        </form>
    </div>
</div>
@endsection
