@extends('layouts.app')

@section('title', 'Tambah Penempatan PKL')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Penempatan PKL</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.tempat.store') }}">
            @csrf

            <div class="form-group">
                <label>Siswa</label>
                <select name="nis_siswa" class="form-control @error('nis_siswa') is-invalid @enderror" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas as $siswa)
                        <option value="{{ $siswa->nis_siswa }}" {{ old('nis_siswa') == $siswa->nis_siswa ? 'selected' : '' }}>
                            {{ $siswa->nis_siswa }} - {{ $siswa->nama_lengkap }} ({{ optional($siswa->kelas)->nama }})
                        </option>
                    @endforeach
                </select>
                @error('nis_siswa')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Pembimbing</label>
                <select name="kd_pembimbing" class="form-control @error('kd_pembimbing') is-invalid @enderror" required>
                    <option value="">-- Pilih Pembimbing --</option>
                    @foreach($pembimbings as $p)
                        <option value="{{ $p->kd_pembimbing }}" {{ old('kd_pembimbing') == $p->kd_pembimbing ? 'selected' : '' }}>
                            {{ optional($p->user)->name }} ({{ $p->wilayah }})
                        </option>
                    @endforeach
                </select>
                @error('kd_pembimbing')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Industri</label>
                <select name="kd_industri" class="form-control @error('kd_industri') is-invalid @enderror" required>
                    <option value="">-- Pilih Industri --</option>
                    @foreach($industris as $i)
                        <option value="{{ $i->kd_industri }}" {{ old('kd_industri') == $i->kd_industri ? 'selected' : '' }}>
                            {{ $i->nama_industri }} ({{ $i->wilayah }})
                        </option>
                    @endforeach
                </select>
                @error('kd_industri')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tanggal Mulai PKL</label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror" required>
                @error('tanggal')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Wilayah</label>
                <input type="text" name="wilayah" value="{{ old('wilayah') }}" class="form-control @error('wilayah') is-invalid @enderror" required>
                @error('wilayah')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tahun Ajaran</label>
                <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" class="form-control @error('tahun') is-invalid @enderror" required>
                @error('tahun')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Status</label>
                <input type="text" name="status" value="{{ old('status', 'Proses') }}" class="form-control @error('status') is-invalid @enderror" required>
                @error('status')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Surat (keterangan/no surat, opsional)</label>
                <input type="text" name="surat" value="{{ old('surat') }}" class="form-control @error('surat') is-invalid @enderror">
                @error('surat')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('admin.tempat.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
