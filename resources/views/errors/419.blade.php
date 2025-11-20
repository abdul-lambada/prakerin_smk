<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sesi Kedaluwarsa - {{ config('app.name', 'Prakerin SMK') }}</title>

    @if(auth()->check())
        {{-- Backend: gunakan SB Admin 2 --}}
        <link href="{{ asset('sb-admin-2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    @else
        {{-- Public: gunakan Tailwind + Alpine --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endif
</head>
<body class="@if(auth()->check()) bg-gradient-primary @else bg-slate-50 @endif min-h-screen">
@if(auth()->check())
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="text-center text-white">
            <div class="error mx-auto" data-text="419">419</div>
            <p class="lead text-white-50 mb-4">Sesi Anda telah kedaluwarsa.</p>
            <p class="text-white-50 mb-4">Silakan muat ulang halaman dan login kembali jika diperlukan.</p>
            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm mr-2"><i class="fas fa-redo mr-1"></i> Muat Ulang</a>
            <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm"
               onclick="event.preventDefault(); document.getElementById('logout-form-error-419').submit();">
                <i class="fas fa-sign-out-alt mr-1"></i> Login Ulang
            </a>
            <form id="logout-form-error-419" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <script src="{{ asset('sb-admin-2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/js/sb-admin-2.min.js') }}"></script>
@else
    <div class="min-h-screen flex flex-col items-center justify-center px-4 text-center"
         x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)" x-show="show"
         x-transition.opacity.duration.300ms x-transition.transform.origin-top.duration.300ms>
        <div class="text-primary text-sm font-semibold tracking-widest mb-2">ERROR 419</div>
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 mb-3">Sesi Anda telah kedaluwarsa</h1>
        <p class="text-sm text-slate-600 max-w-md mb-6">
            Muat ulang halaman ini lalu kirim ulang formulir jika masih diperlukan.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3 text-xs">
            <button type="button" onclick="window.location.reload();"
                    class="inline-flex items-center px-4 py-2 rounded-full border border-slate-200 text-slate-700 hover:bg-slate-50">
                Muat Ulang
            </button>
            <a href="{{ route('public.home') }}" class="inline-flex items-center px-4 py-2 rounded-full bg-primary text-white font-semibold shadow-sm hover:bg-primary/90">
                Ke Beranda
            </a>
        </div>
    </div>
@endif
</body>
</html>
