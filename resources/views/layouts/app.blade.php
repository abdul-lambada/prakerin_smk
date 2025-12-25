<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @php
        $appName = \App\Models\Setting::get('app_name', 'PKL SMK');
        $appLogo = \App\Models\Setting::get('app_logo');
        $primaryColor = \App\Models\Setting::get('theme_color_primary', '#4e73df');
    @endphp
    <title>@yield('title', $appName)</title>

    @if ($appLogo)
        <link rel="icon" type="image/png" href="{{ asset($appLogo) }}">
    @endif

    <!-- Custom fonts and styles for this template-->
    <link href="{{ asset('sb-admin-2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary-color: {{ $primaryColor ?: '#4e73df' }};
        }

        .bg-gradient-primary {
            background-color: var(--primary-color) !important;
            background-image: none !important;
        }

        .btn-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .btn-outline-primary {
            color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        a {
            color: var(--primary-color);
        }

        a:hover {
            color: var(--primary-color);
        }
    </style>

    @stack('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @php
            $role = auth()->user()->role ?? null;
            $dashboardRouteName = match ($role) {
                'admin' => 'dashboard.admin',
                'pembimbing' => 'dashboard.pembimbing',
                'siswa' => 'dashboard.siswa',
                'dudi' => 'dashboard.dudi',
                default => 'dashboard.index',
            };
            $isDashboardActive = request()->routeIs($dashboardRouteName);
        @endphp
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            @php
                $appName = \App\Models\Setting::get('app_name', 'PKL SMK');
                $appShortName = \App\Models\Setting::get('app_short_name');
                $appLogo = \App\Models\Setting::get('app_logo');
                $brandText = $appShortName ?: $appName;
            @endphp
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ route('dashboard.index') }}">
                <div class="sidebar-brand-icon d-flex align-items-center justify-content-center">
                    @if ($appLogo)
                        <img src="{{ asset($appLogo) }}" alt="Logo"
                            style="height:24px; max-width:120px; object-fit:contain;">
                    @else
                        <i class="fas fa-laugh-wink"></i>
                    @endif
                </div>
                <div class="sidebar-brand-text mx-3">{{ $brandText }}</div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Menu umum -->
            <li class="nav-item {{ $isDashboardActive ? 'active' : '' }}">
                <a class="nav-link" href="{{ route($dashboardRouteName) }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Admin menu --}}
            @if ($role === 'admin')
                <hr class="sidebar-divider">
                <div class="sidebar-heading">Manajemen</div>

                <li class="nav-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.siswa.index') }}">
                        <i class="fas fa-users fa-fw"></i>
                        <span>Data Siswa</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.pembimbing.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.pembimbing.index') }}">
                        <i class="fas fa-chalkboard-teacher fa-fw"></i>
                        <span>Data Pembimbing</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.user.index') }}">
                        <i class="fas fa-user-tie fa-fw"></i>
                        <span>Data User</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog fa-fw"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.industri.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.industri.index') }}">
                        <i class="fas fa-industry fa-fw"></i>
                        <span>Data Industri</span>
                    </a>
                </li>
                <li
                    class="nav-item {{ request()->routeIs('admin.jurusan.*') || request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.jurusan.index') }}">
                        <i class="fas fa-school fa-fw"></i>
                        <span>Jurusan &amp; Kelas</span>
                    </a>
                </li>

                <hr class="sidebar-divider">
                <div class="sidebar-heading">PKL</div>

                <li class="nav-item {{ request()->routeIs('admin.tempat.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.tempat.index') }}">
                        <i class="fas fa-briefcase fa-fw"></i>
                        <span>Penempatan PKL</span>
                    </a>
                </li>
                <li
                    class="nav-item {{ request()->routeIs('admin.nilai.*') || request()->routeIs('admin.sidang.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.nilai.index') }}">
                        <i class="fas fa-clipboard-check fa-fw"></i>
                        <span>Nilai &amp; Sidang</span>
                    </a>
                </li>
                <li
                    class="nav-item {{ request()->routeIs('admin.laporan.*') || request()->routeIs('admin.jurnal.*') || request()->routeIs('admin.absensi.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                        <i class="fas fa-file-alt fa-fw"></i>
                        <span>Laporan Jurnal &amp; Absensi</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.monitoring.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.monitoring.index') }}">
                        <i class="fas fa-map-marked-alt fa-fw"></i>
                        <span>Monitoring Lapangan</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.info.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.info.index') }}">
                        <i class="fas fa-bullhorn fa-fw"></i>
                        <span>Info / Pengumuman</span>
                    </a>
                </li>
            @endif

            {{-- Pembimbing menu --}}
            @if ($role === 'pembimbing')
                <hr class="sidebar-divider">
                <div class="sidebar-heading">Pembimbing</div>

                <li class="nav-item {{ request()->routeIs('pembimbing.siswa-bimbingan.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pembimbing.siswa-bimbingan.index') }}">
                        <i class="fas fa-user-graduate fa-fw"></i>
                        <span>Siswa Bimbingan</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('pembimbing.monitoring.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pembimbing.monitoring.index') }}">
                        <i class="fas fa-book-open fa-fw"></i>
                        <span>Monitoring Harian &amp; Bimbingan Prakerin</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('pembimbing.monitoring-lapangan.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pembimbing.monitoring-lapangan.index') }}">
                        <i class="fas fa-map-marked-alt fa-fw"></i>
                        <span>Monitoring Lapangan Prakerin</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('pembimbing.laporan-sidang.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pembimbing.laporan-sidang.index') }}">
                        <i class="fas fa-file-alt fa-fw"></i>
                        <span>Laporan &amp; Sidang</span>
                    </a>
                </li>

                @php
                    $sidebarUnreadChatDudi = \App\Models\ChatDudiPembimbing::where('to_user_id', auth()->id())
                        ->where('is_read_pembimbing', false)
                        ->count();
                @endphp

                <li class="nav-item {{ request()->routeIs('pembimbing.chat-dudi.*') ? 'active' : '' }}">
                    <a class="nav-link d-flex justify-content-between align-items-center"
                        href="{{ route('pembimbing.chat-dudi.index') }}">
                        <span>
                            <i class="fas fa-comments fa-fw"></i>
                            <span>Chat DUDI</span>
                        </span>
                        @if ($sidebarUnreadChatDudi > 0)
                            <span class="badge badge-danger badge-pill">{{ $sidebarUnreadChatDudi }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('pembimbing.info.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pembimbing.info.index') }}">
                        <i class="fas fa-bullhorn fa-fw"></i>
                        <span>Info / Pengumuman</span>
                    </a>
                </li>
            @endif

            {{-- Siswa menu --}}
            @if ($role === 'siswa')
                <hr class="sidebar-divider">
                <div class="sidebar-heading">Siswa</div>

                <li class="nav-item {{ request()->routeIs('siswa.tempat.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('siswa.tempat.index') }}">
                        <i class="fas fa-briefcase fa-fw"></i>
                        <span>Tempat PKL</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('siswa.absensi.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('siswa.absensi.index') }}">
                        <i class="fas fa-clipboard-check fa-fw"></i>
                        <span>Absensi</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('siswa.jurnal.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('siswa.jurnal.index') }}">
                        <i class="fas fa-book fa-fw"></i>
                        <span>Jurnal Harian</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('siswa.bimbingan.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('siswa.bimbingan.index') }}">
                        <i class="fas fa-comments fa-fw"></i>
                        <span>Bimbingan</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('siswa.laporan.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('siswa.laporan.index') }}">
                        <i class="fas fa-file-alt fa-fw"></i>
                        <span>Laporan PKL</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('siswa.info.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('siswa.info.index') }}">
                        <i class="fas fa-bullhorn fa-fw"></i>
                        <span>Info / Pengumuman</span>
                    </a>
                </li>
            @endif

            {{-- DUDI menu --}}
            @if ($role === 'dudi')
                <hr class="sidebar-divider">
                <div class="sidebar-heading">DUDI</div>

                <li class="nav-item {{ request()->routeIs('dashboard.dudi') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.dudi') }}">
                        <i class="fas fa-clipboard-check fa-fw"></i>
                        <span>Dashboard DUDI</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('dudi.siswa.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dudi.siswa.index') }}">
                        <i class="fas fa-user-graduate fa-fw"></i>
                        <span>Siswa PKL</span>
                    </a>
                </li>

                @php
                    $sidebarUnreadChatPembimbing = \App\Models\ChatDudiPembimbing::where('to_user_id', auth()->id())
                        ->where('is_read_dudi', false)
                        ->count();
                @endphp

                <li class="nav-item {{ request()->routeIs('dudi.chat.*') ? 'active' : '' }}">
                    <a class="nav-link d-flex justify-content-between align-items-center"
                        href="{{ route('dudi.chat.index') }}">
                        <span>
                            <i class="fas fa-comments fa-fw"></i>
                            <span>Chat Pembimbing</span>
                        </span>
                        @if ($sidebarUnreadChatPembimbing > 0)
                            <span class="badge badge-danger badge-pill">{{ $sidebarUnreadChatPembimbing }}</span>
                        @endif
                    </a>
                </li>
            @endif

            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ auth()->user()->name ?? (auth()->user()->username ?? 'User') }}
                                </span>
                                @if (auth()->user()->foto)
                                    <img src="{{ asset('storage/' . auth()->user()->foto) }}"
                                        class="img-profile rounded-circle"
                                        style="height: 32px; width: 32px; object-fit: cover;">
                                @else
                                    <i class="fas fa-user-circle fa-lg text-gray-400"></i>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @php
                        $appName = \App\Models\Setting::get('app_name', 'PKL SMK');
                        $appShortName = \App\Models\Setting::get('app_short_name', 'PKL SMK');
                        $appLogo = \App\Models\Setting::get('app_logo');
                        $schoolName = \App\Models\Setting::get('school_name');
                        $maintenanceMode = \App\Models\Setting::get('maintenance_mode', '0') === '1';
                        $maintenanceMessage = \App\Models\Setting::get('maintenance_message');
                        $dashboardInfoBanner = \App\Models\Setting::get('dashboard_info_banner');
                    @endphp
                    @if ($maintenanceMode && $maintenanceMessage)
                        <div class="alert alert-warning mb-3">
                            {!! nl2br(e($maintenanceMessage)) !!}
                        </div>
                    @endif

                    @if ($dashboardInfoBanner)
                        <div class="alert alert-info mb-3">
                            {!! nl2br(e($dashboardInfoBanner)) !!}
                        </div>
                    @endif

                    @hasSection('breadcrumb')
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb bg-white px-0 mb-0">
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                    @endif

                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>
                            &copy; {{ $schoolName ?: $appName }} {{ date('Y') }}
                        </span>
                        <span class="d-block small text-muted mt-1">
                            Powered by <a href="https://syntaxtrust.akarsekawan.my.id/" target="_blank"
                                rel="noopener">SyntaxTrust</a>
                        </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <script src="{{ asset('sb-admin-2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/js/sb-admin-2.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('status'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: @json(session('status')),
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: @json(session('error')),
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan',
                html: @json(implode('<br>', $errors->all())),
            });
        @endif
    </script>

    @stack('scripts')
</body>

</html>
