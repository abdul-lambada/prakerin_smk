@extends('layouts.app')

@section('title', 'Edit Jurusan')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Jurusan</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.jurusan.update', $jurusan) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Jurusan</label>
                <input type="text" name="nama" value="{{ old('nama', $jurusan->nama) }}" class="form-control @error('nama') is-invalid @enderror" required>
                @error('nama')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
