@extends('layouts.app')

@section('title', 'Edit Industri')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Industri</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.industri.update', $industri) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Industri</label>
                <input type="text" name="nama_industri" value="{{ old('nama_industri', $industri->nama_industri) }}" class="form-control @error('nama_industri') is-invalid @enderror" required>
                @error('nama_industri')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Bidang Kerja</label>
                <input type="text" name="bidang_kerja" value="{{ old('bidang_kerja', $industri->bidang_kerja) }}" class="form-control @error('bidang_kerja') is-invalid @enderror" required>
                @error('bidang_kerja')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" required>{{ old('deskripsi', $industri->deskripsi) }}</textarea>
                @error('deskripsi')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Alamat Industri</label>
                <textarea name="alamat_industri" class="form-control @error('alamat_industri') is-invalid @enderror" rows="2" required>{{ old('alamat_industri', $industri->alamat_industri) }}</textarea>
                @error('alamat_industri')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Wilayah</label>
                <input type="text" name="wilayah" value="{{ old('wilayah', $industri->wilayah) }}" class="form-control @error('wilayah') is-invalid @enderror" required>
                @error('wilayah')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $industri->telepon) }}" class="form-control @error('telepon') is-invalid @enderror" required>
                @error('telepon')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Kuota</label>
                <input type="number" name="kuota" value="{{ old('kuota', $industri->kuota) }}" class="form-control @error('kuota') is-invalid @enderror" required>
                @error('kuota')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Akun DUDI (opsional)</label>
                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                    <option value="">-- Tidak ada akun DUDI --</option>
                    @foreach($dudis as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $industri->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->username }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('admin.industri.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
