<!DOCTYPE html>
<html lang="id" x-data="{ mobileMenu: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? ($settings['app_name'] ?? 'Prakerin SMK') }}</title>

    @if (!empty($settings['app_logo']))
        <link rel="icon" type="image/png" href="{{ asset($settings['app_logo']) }}">
    @else
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Ccircle cx='16' cy='16' r='16' fill='%232563eb'/%3E%3Ctext x='16' y='21' text-anchor='middle' font-size='14' fill='white' font-family='Arial'%3EPR%3C/text%3E%3C/svg%3E">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '{{ $settings['theme_color_primary'] ?? '#2563eb' }}',
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">
    <header class="bg-white shadow-sm sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('public.home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white border border-primary/20 flex items-center justify-center overflow-hidden">
                        @if (!empty($settings['app_logo']))
                            <img src="{{ asset($settings['app_logo']) }}" alt="Logo" class="max-w-full max-h-full object-contain">
                        @else
                            <span class="text-primary font-bold text-sm">PR</span>
                        @endif
                    </div>
                    <div>
                        <div class="text-sm font-semibold uppercase tracking-wide text-primary">{{ $settings['school_name'] ?? 'SMK' }}</div>
                        <div class="text-xs text-slate-500">{{ $settings['app_name'] ?? 'Sistem Informasi Prakerin' }}</div>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('public.home') }}" class="hover:text-primary {{ request()->routeIs('public.home') ? 'text-primary' : 'text-slate-700' }}">Beranda</a>
                    <a href="{{ route('public.industri') }}" class="hover:text-primary {{ request()->routeIs('public.industri') ? 'text-primary' : 'text-slate-700' }}">Industri Prakerin</a>
                    <a href="{{ route('public.info') }}" class="hover:text-primary {{ request()->routeIs('public.info') ? 'text-primary' : 'text-slate-700' }}">Info Prakerin</a>
                    <a href="{{ route('public.about') }}" class="hover:text-primary {{ request()->routeIs('public.about') ? 'text-primary' : 'text-slate-700' }}">Tentang Prakerin</a>
                    <a href="{{ route('public.contact') }}" class="hover:text-primary {{ request()->routeIs('public.contact') ? 'text-primary' : 'text-slate-700' }}">Kontak</a>

                    <div class="h-5 w-px bg-slate-200"></div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <span>Login</span>
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg border border-slate-100 py-1 text-xs">
                            <a href="{{ route('login.siswa') }}" class="block px-3 py-1.5 hover:bg-slate-50">Siswa</a>
                            <a href="{{ route('register.dudi') }}" class="block px-3 py-1.5 hover:bg-slate-50">DUDI</a>
                        </div>
                    </div>
                </nav>

                <button class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-slate-700 hover:bg-slate-100" @click="mobileMenu = !mobileMenu">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="md:hidden" x-show="mobileMenu" x-cloak>
            <div class="px-4 pb-3 space-y-1 text-sm font-medium bg-white border-t border-slate-100">
                <a href="{{ route('public.home') }}" class="block py-2 {{ request()->routeIs('public.home') ? 'text-primary' : 'text-slate-700' }}">Beranda</a>
                <a href="{{ route('public.industri') }}" class="block py-2 {{ request()->routeIs('public.industri') ? 'text-primary' : 'text-slate-700' }}">Industri Prakerin</a>
                <a href="{{ route('public.info') }}" class="block py-2 {{ request()->routeIs('public.info') ? 'text-primary' : 'text-slate-700' }}">Info Prakerin</a>
                <a href="{{ route('public.about') }}" class="block py-2 {{ request()->routeIs('public.about') ? 'text-primary' : 'text-slate-700' }}">Tentang Prakerin</a>
                <a href="{{ route('public.contact') }}" class="block py-2 {{ request()->routeIs('public.contact') ? 'text-primary' : 'text-slate-700' }}">Kontak</a>

                <div class="border-t border-slate-100 pt-2 mt-2">
                    <div class="text-xs uppercase tracking-wide text-slate-400 mb-1">Login</div>
                    <a href="{{ route('login.siswa') }}" class="block py-1.5 text-xs text-slate-700">Siswa</a>
                    <a href="{{ route('register.dudi') }}" class="block py-1.5 text-xs text-slate-700">DUDI</a>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white mt-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
            <div>
                &copy; {{ date('Y') }} {{ $settings['school_name'] ?? 'SMK' }} - Sistem Informasi Prakerin.
            </div>
            <div class="flex items-center gap-3">
                <span>{{ $settings['school_city'] ?? '' }}</span>
            </div>
        </div>
    </footer>
</body>
</html>
