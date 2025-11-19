@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Profil Akun</h6>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Foto Profil</label>
                        <input type="file" name="foto" class="form-control-file @error('foto') is-invalid @enderror">
                        @error('foto')
                            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        @if($user->foto)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$user->foto) }}" alt="Foto Profil" class="img-thumbnail" style="max-height: 120px;">
                            </div>
                        @endif
                    </div>

                    @if($user->role === 'pembimbing')
                        <div class="form-group">
                            <label>Wilayah Bimbingan</label>
                            <input type="text" name="wilayah" class="form-control @error('wilayah') is-invalid @enderror" value="{{ old('wilayah', optional($user->pembimbing)->wilayah) }}">
                            @error('wilayah')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    @elseif($user->role === 'siswa')
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="telp" class="form-control @error('telp') is-invalid @enderror" value="{{ old('telp', optional($user->siswa)->telp) }}">
                            @error('telp')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Profil</h6>
            </div>
            <div class="card-body">
                @if($user->role === 'admin')
                    <p>Admin mengelola data siswa, pembimbing, industri, dan info PKL.</p>
                @elseif($user->role === 'pembimbing')
                    <p><strong>Wilayah Bimbingan:</strong>
                        {{ optional($user->pembimbing)->wilayah ?? '-' }}
                    </p>
                    <p>Pembimbing bertanggung jawab terhadap siswa bimbingan dan penilaian PKL.</p>
                @elseif($user->role === 'siswa')
                    <p><strong>Nama Siswa:</strong> {{ optional($user->siswa)->nama_lengkap ?? $user->name }}</p>
                    <p><strong>Kelas:</strong>
                        {{ optional(optional($user->siswa)->kelas)->nama ?? '-' }}
                    </p>
                    <p><strong>Telepon:</strong>
                        {{ optional($user->siswa)->telp ?? '-' }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
