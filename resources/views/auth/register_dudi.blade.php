@extends('layouts.auth')

@section('title', 'Registrasi Mitra DUDI - Sistem Informasi PKL')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8">
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
                                    <img src="{{ asset($appLogo) }}" alt="Logo" style="max-height:70px;">
                                </div>
                            @endif
                            <h1 class="h4 text-gray-900 mb-1 font-weight-bold">Registrasi Mitra DUDI</h1>
                            <p class="text-muted small">Bergabunglah dengan program Prakerin {{ $schoolName }}</p>
                            <hr>
                        </div>

                        <form method="POST" action="{{ route('register.dudi.submit') }}">
                            @csrf

                            <div class="form-group">
                                <label class="text-small font-weight-bold">Nama Perusahaan / Industri</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Contoh: PT. Maju Bersama" required autofocus>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-small font-weight-bold">Username</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" name="username" value="{{ old('username') }}"
                                                class="form-control @error('username') is-invalid @enderror"
                                                placeholder="Username login" required>
                                        </div>
                                        @error('username')
                                            <span class="invalid-feedback d-block"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-small font-weight-bold">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Alamat email">
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback d-block"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="text-small font-weight-bold">Nama PIC / Kontak Person</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" name="identitas" value="{{ old('identitas') }}"
                                        class="form-control @error('identitas') is-invalid @enderror"
                                        placeholder="Nama penanggung jawab di industri">
                                </div>
                                @error('identitas')
                                    <span class="invalid-feedback d-block"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-small font-weight-bold">Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Minimal 6 karakter" required>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback d-block"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-small font-weight-bold">Konfirmasi</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                            </div>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Ulangi password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm mt-4">
                                <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                            </button>
                        </form>

                        <hr>
                        <div class="text-center">
                            <p class="small mb-2">Sudah memiliki akun kemitraan?</p>
                            <a class="btn btn-outline-primary btn-sm px-4 shadow-sm" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt mr-1"></i> Masuk di Sini
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-2">
                <a class="text-white small" href="{{ route('public.home') }}"><i class="fas fa-arrow-left mr-1"></i>
                    Kembali ke Beranda</a>
            </div>
        </div>
    </div>
@endsection
