@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Pengaturan Aplikasi</h1>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card mb-4">
        <div class="card-header">Identitas &amp; Tampilan Aplikasi</div>
        <div class="card-body">
            <div class="form-group">
                <label>Nama Aplikasi</label>
                <input type="text" name="app_name" value="{{ old('app_name', $settings['app_name']) }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Logo Aplikasi</label>
                @if(!empty($settings['app_logo']))
                    <div class="mb-2">
                        <img src="{{ asset($settings['app_logo']) }}" alt="Logo" style="height: 40px; object-fit: contain;">
                    </div>
                @endif
                <input type="file" name="app_logo" class="form-control-file @error('app_logo') is-invalid @enderror">
                @error('app_logo')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah logo. Format: JPG, PNG, SVG, max 2MB.</small>
            </div>
            <div class="form-group">
                <label>Nama Singkat / Singkatan</label>
                <input type="text" name="app_short_name" value="{{ old('app_short_name', $settings['app_short_name']) }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Nama Sekolah</label>
                <input type="text" name="school_name" value="{{ old('school_name', $settings['school_name']) }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Alamat Sekolah</label>
                <textarea name="school_address" class="form-control" rows="2">{{ old('school_address', $settings['school_address']) }}</textarea>
            </div>
            <div class="form-group">
                <label>Telepon Sekolah</label>
                <input type="text" name="school_phone" value="{{ old('school_phone', $settings['school_phone']) }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Email Sekolah</label>
                <input type="email" name="school_email" value="{{ old('school_email', $settings['school_email']) }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Warna Utama (Theme Primary)</label>
                <input type="text" name="theme_color_primary" value="{{ old('theme_color_primary', $settings['theme_color_primary']) }}" class="form-control" placeholder="#4e73df atau nama kelas warna">
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Pengaturan Tahun Ajaran / Periode PKL</div>
        <div class="card-body">
            <div class="form-group">
                <label>Tahun Ajaran Aktif</label>
                <input type="text" name="active_academic_year" value="{{ old('active_academic_year', $settings['active_academic_year']) }}" class="form-control" placeholder="2025/2026">
            </div>
            <div class="form-group">
                <label>Tahun PKL Aktif</label>
                <input type="text" name="active_pkl_year" value="{{ old('active_pkl_year', $settings['active_pkl_year']) }}" class="form-control">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Tanggal Mulai PKL (default)</label>
                    <input type="date" name="pkl_start_date" value="{{ old('pkl_start_date', $settings['pkl_start_date']) }}" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Tanggal Selesai PKL (default)</label>
                    <input type="date" name="pkl_end_date" value="{{ old('pkl_end_date', $settings['pkl_end_date']) }}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Minimal Persentase Kehadiran (%)</label>
                <input type="number" name="pkl_min_presence_percent" value="{{ old('pkl_min_presence_percent', $settings['pkl_min_presence_percent']) }}" class="form-control" min="0" max="100">
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Batasan &amp; Aturan Penilaian</div>
        <div class="card-body">
            <div class="form-group">
                <label>Nilai Minimal Lulus PKL</label>
                <input type="number" name="pkl_min_grade" value="{{ old('pkl_min_grade', $settings['pkl_min_grade']) }}" class="form-control" min="0" max="100">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Bobot Nilai DU/DI (%)</label>
                    <input type="number" name="pkl_weight_nilai_du_di" value="{{ old('pkl_weight_nilai_du_di', $settings['pkl_weight_nilai_du_di']) }}" class="form-control" min="0" max="100">
                </div>
                <div class="form-group col-md-6">
                    <label>Bobot Nilai Sekolah (%)</label>
                    <input type="number" name="pkl_weight_nilai_sekolah" value="{{ old('pkl_weight_nilai_sekolah', $settings['pkl_weight_nilai_sekolah']) }}" class="form-control" min="0" max="100">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Maksimal Siswa per Industri</label>
                    <input type="number" name="max_students_per_industri" value="{{ old('max_students_per_industri', $settings['max_students_per_industri']) }}" class="form-control" min="0">
                </div>
                <div class="form-group col-md-6">
                    <label>Maksimal Tempat PKL per Siswa</label>
                    <input type="number" name="max_pkl_places_per_student" value="{{ old('max_pkl_places_per_student', $settings['max_pkl_places_per_student']) }}" class="form-control" min="0">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Informasi Dashboard &amp; Maintenance</div>
        <div class="card-body">
            <div class="form-group">
                <label>Teks Pengumuman Umum di Dashboard</label>
                <textarea name="dashboard_info_banner" class="form-control" rows="3">{{ old('dashboard_info_banner', $settings['dashboard_info_banner']) }}</textarea>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="maintenance_mode" id="maintenance_mode" class="form-check-input" value="1" {{ old('maintenance_mode', $settings['maintenance_mode']) == '1' ? 'checked' : '' }}>
                <label for="maintenance_mode" class="form-check-label">Aktifkan Maintenance Mode</label>
            </div>
            <div class="form-group">
                <label>Pesan Maintenance</label>
                <textarea name="maintenance_message" class="form-control" rows="2">{{ old('maintenance_message', $settings['maintenance_message']) }}</textarea>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
</form>
@endsection
