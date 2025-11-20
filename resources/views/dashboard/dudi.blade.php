@extends('layouts.app')

@section('title', 'Dashboard DUDI')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard DUDI</h1>
<p class="mb-3">
    Selamat datang di portal penilaian DU/DI
    @if($industri)
        untuk <strong>{{ $industri->nama_industri }}</strong>.
    @else
        . Hubungkan akun DUDI ini dengan data Industri di menu Admin &gt; Data Industri.
    @endif
</p>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Siswa PKL</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_siswa_pkl }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sudah Dinilai DU/DI</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_nilai_du_di }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belum Dinilai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_belum_dinilai }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <a href="{{ route('dudi.chat.index') }}" class="text-decoration-none">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pesan Pembimbing Belum Dibaca</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unread_chat_pembimbing }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

@endsection
