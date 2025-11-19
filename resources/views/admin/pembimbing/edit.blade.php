@extends('layouts.app')

@section('title', 'Edit Pembimbing')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Pembimbing</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.pembimbing.update', $pembimbing) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>User (Akun Pembimbing)</label>
                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $pembimbing->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->username }} - {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Jurusan</label>
                <select name="kd_jurusan" class="form-control @error('kd_jurusan') is-invalid @enderror" required>
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->kd_jurusan }}" {{ old('kd_jurusan', $pembimbing->kd_jurusan) == $j->kd_jurusan ? 'selected' : '' }}>
                            {{ $j->nama }}
                        </option>
                    @endforeach
                </select>
                @error('kd_jurusan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $pembimbing->nip) }}" class="form-control @error('nip') is-invalid @enderror" required>
                @error('nip')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pembimbing->nama_lengkap) }}" class="form-control @error('nama_lengkap') is-invalid @enderror" required>
                @error('nama_lengkap')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Wilayah</label>
                <input type="text" name="wilayah" value="{{ old('wilayah', $pembimbing->wilayah) }}" class="form-control @error('wilayah') is-invalid @enderror" required>
                @error('wilayah')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('admin.pembimbing.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
