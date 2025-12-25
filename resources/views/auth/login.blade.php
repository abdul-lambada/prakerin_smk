@extends('layouts.auth')

@section('title', 'Login - Sistem Informasi PKL')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-4 col-lg-5 col-md-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="p-5">
                    <div class="text-center mb-4">
                        @php
                            $appLogo = \App\Models\Setting::get('app_logo');
                            $schoolName = \App\Models\Setting::get('school_name', 'SMK');
                            $appName = \App\Models\Setting::get('app_name', 'Sistem Informasi PKL');
                        @endphp
                        @if ($appLogo)
                            <div class="mb-3">
                                <img src="{{ asset($appLogo) }}" alt="Logo" style="max-height:80px;">
                            </div>
                        @endif
                        <h1 class="h4 text-gray-900 mb-1 font-weight-bold">{{ $schoolName }}</h1>
                        <div class="text-muted mb-3">{{ $appName }}</div>
                        <hr>
                        <p class="mb-4">Silakan login dengan akun Anda</p>
                    </div>

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="form-group">
                            <label class="text-small font-weight-bold">Username</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username" required autofocus>
                            </div>
                            @error('username')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="text-small font-weight-bold">Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </button>
                    </form>

                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{ route('public.home') }}"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda</a>
                        <br>
                        <a class="small" href="{{ route('register.dudi') }}">Daftar akun DUDI baru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
