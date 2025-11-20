@extends('layouts.app')

@section('title', 'Nilai DU/DI Siswa PKL')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Nilai DU/DI Siswa PKL</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <dl class="row mb-3">
            <dt class="col-sm-3">Industri</dt>
            <dd class="col-sm-9">{{ optional($industri)->nama_industri }}</dd>

            <dt class="col-sm-3">Siswa</dt>
            <dd class="col-sm-9">{{ optional($tempat->siswa)->nama_lengkap }} ({{ optional($tempat->siswa)->nis_siswa }})</dd>

            <dt class="col-sm-3">Tempat PKL</dt>
            <dd class="col-sm-9">{{ $tempat->kd_tempat }}</dd>
        </dl>

        <form method="POST" action="{{ route('dudi.nilai.update', $tempat) }}">
            @csrf

            <div class="form-group">
                <label>Nilai DU/DI (0 - 100)</label>
                <input type="number" name="nilai_du_di" step="0.01" min="0" max="100"
                       value="{{ old('nilai_du_di', optional($nilai)->nilai_du_di) }}"
                       class="form-control @error('nilai_du_di') is-invalid @enderror" required>
                @error('nilai_du_di')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Keterangan (opsional)</label>
                <input type="text" name="keterangan" maxlength="100"
                       value="{{ old('keterangan', optional($nilai)->keterangan) }}"
                       class="form-control @error('keterangan') is-invalid @enderror">
                @error('keterangan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('dudi.siswa.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Nilai</button>
        </form>
    </div>
</div>
@endsection
