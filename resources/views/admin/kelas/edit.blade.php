@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Kelas</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.kelas.update', $kelas) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Jurusan</label>
                <select name="kd_jurusan" class="form-control @error('kd_jurusan') is-invalid @enderror" required>
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->kd_jurusan }}" {{ old('kd_jurusan', $kelas->kd_jurusan) == $j->kd_jurusan ? 'selected' : '' }}>
                            {{ $j->nama }}
                        </option>
                    @endforeach
                </select>
                @error('kd_jurusan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Nama Kelas</label>
                <input type="text" name="nama" value="{{ old('nama', $kelas->nama) }}" class="form-control @error('nama') is-invalid @enderror" required>
                @error('nama')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
