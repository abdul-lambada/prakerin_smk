<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Custom fonts and styles for this template-->
    <link href="{{ asset('sb-admin-2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @php($role = auth()->user()->role ?? null)
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">PKL <sup>SMK</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Menu umum -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.index') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @if($role === 'admin')
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
                <li class="nav-item {{ request()->routeIs('admin.industri.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.industri.index') }}">
                        <i class="fas fa-industry fa-fw"></i>
                        <span>Data Industri</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.jurusan.*') || request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
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
                <li class="nav-item {{ request()->routeIs('admin.nilai.*') || request()->routeIs('admin.sidang.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.nilai.index') }}">
                        <i class="fas fa-clipboard-check fa-fw"></i>
                        <span>Nilai &amp; Sidang</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.laporan.*') || request()->routeIs('admin.jurnal.*') || request()->routeIs('admin.absensi.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                        <i class="fas fa-file-alt fa-fw"></i>
                        <span>Laporan Jurnal &amp; Absensi</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.info.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.info.index') }}">
                        <i class="fas fa-bullhorn fa-fw"></i>
                        <span>Info / Pengumuman</span>
                    </a>
                </li>
            @elseif($role === 'pembimbing')
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
                        <span>Monitoring &amp; Bimbingan</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('pembimbing.laporan-sidang.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pembimbing.laporan-sidang.index') }}">
                        <i class="fas fa-file-alt fa-fw"></i>
                        <span>Laporan &amp; Sidang</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('pembimbing.info.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pembimbing.info.index') }}">
                        <i class="fas fa-bullhorn fa-fw"></i>
                        <span>Info / Pengumuman</span>
                    </a>
                </li>
            @elseif($role === 'siswa')
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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ auth()->user()->name ?? auth()->user()->username ?? 'User' }}
                                </span>
                                @if(auth()->user()->foto)
                                    <img src="{{ asset('storage/'.auth()->user()->foto) }}" class="img-profile rounded-circle" style="height: 32px; width: 32px; object-fit: cover;">
                                @else
                                    <i class="fas fa-user-circle fa-lg text-gray-400"></i>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; PKL SMK {{ date('Y') }}</span>
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
    <script src="{{ asset('sb-admin-2/js/sb-admin-2.min.js') }}"></script>

    @stack('scripts')
</body>
</html>
