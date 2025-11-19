@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Siswa</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.siswa.update', $siswa) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>NIS</label>
                <input type="number" class="form-control" value="{{ $siswa->nis_siswa }}" disabled>
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" class="form-control @error('nama_lengkap') is-invalid @enderror" required>
                @error('nama_lengkap')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <select name="kd_kelas" class="form-control @error('kd_kelas') is-invalid @enderror" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->kd_kelas }}" {{ old('kd_kelas', $siswa->kd_kelas) == $k->kd_kelas ? 'selected' : '' }}>
                            {{ $k->nama }} - {{ optional($k->jurusan)->nama }}
                        </option>
                    @endforeach
                </select>
                @error('kd_kelas')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Pembimbing</label>
                <select name="kd_pembimbing" class="form-control @error('kd_pembimbing') is-invalid @enderror" required>
                    <option value="">-- Pilih Pembimbing --</option>
                    @foreach($pembimbings as $p)
                        <option value="{{ $p->kd_pembimbing }}" {{ old('kd_pembimbing', $siswa->kd_pembimbing) == $p->kd_pembimbing ? 'selected' : '' }}>
                            {{ optional($p->user)->name }} ({{ $p->wilayah }})
                        </option>
                    @endforeach
                </select>
                @error('kd_pembimbing')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Telepon</label>
                <input type="text" name="telp" value="{{ old('telp', $siswa->telp) }}" class="form-control @error('telp') is-invalid @enderror" required>
                @error('telp')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
