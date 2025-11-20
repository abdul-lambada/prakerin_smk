@extends('layouts.auth')

@section('title', 'Login DUDI / Industri')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-4 col-lg-5 col-md-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="p-5">
                    <div class="text-center mb-3">
                        @php
                            $appLogo = \App\Models\Setting::get('app_logo');
                            $schoolName = \App\Models\Setting::get('school_name', 'SMK');
                            $appName = \App\Models\Setting::get('app_name', 'Sistem Informasi PKL');
                        @endphp
                        @if ($appLogo)
                            <div class="mb-2">
                                <img src="{{ asset($appLogo) }}" alt="Logo" style="max-height:60px;">
                            </div>
                        @endif
                        <h1 class="h5 text-gray-900 mb-1">{{ $schoolName }}</h1>
                        <div class="small text-muted mb-2">{{ $appName }}</div>
                        <h2 class="h5 text-gray-900 mb-3">Login DUDI / Industri</h2>
                    </div>
                    <form method="POST" action="{{ route('login.dudi.submit') }}">
                        @csrf
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" required autofocus>
                            @error('username')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
