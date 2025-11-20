<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sistem Informasi Prakerin SMK

Aplikasi ini adalah **Sistem Informasi Praktik Kerja Lapangan (Prakerin)** untuk SMK, dibangun dengan Laravel. Portal ini digunakan oleh:

- **Siswa** – mengajukan / melihat tempat Prakerin, mengisi absensi harian, jurnal, mengunggah laporan, dan melihat bimbingan.
- **Pembimbing Sekolah** – memantau absensi & jurnal, melakukan monitoring lapangan Prakerin, mengelola bimbingan, nilai, dan laporan.
- **Mitra Industri (DUDI)** – melihat siswa Prakerin di industrinya dan mengisi penilaian.
- **Admin** – mengelola data master (siswa, pembimbing, industri, kelas/jurusan, user), penempatan Prakerin, laporan, monitoring, dan pengaturan aplikasi.

Istilah utama yang digunakan di aplikasi adalah **Prakerin** (Praktik Kerja Lapangan).

---

## Fitur Utama

- **Manajemen Data**
  - Data siswa, pembimbing, user, jurusan, kelas.
  - Data industri mitra dan penempatan Prakerin (tabel `Tempat`).

- **Portal Siswa**
  - Lihat tempat Prakerin.
  - Isi absensi harian dan jurnal kegiatan.
  - Unggah laporan Prakerin.
  - Ruang bimbingan dengan pembimbing.

- **Portal Pembimbing**
  - Monitoring harian (absensi & jurnal) siswa bimbingan.
  - **Monitoring Lapangan Prakerin** (kunjungan ke industri).
  - Bimbingan & penilaian siswa.

- **Portal DUDI**
  - Daftar siswa Prakerin di industri.
  - Input nilai DU/DI.
  - Chat dengan pembimbing sekolah.

- **Portal Publik**
  - Beranda dengan ringkasan Prakerin.
  - Daftar industri Prakerin.
  - Info & pengumuman Prakerin.

---

## Instalasi & Menjalankan Aplikasi

1. **Clone repositori & install dependency**

   ```bash
   composer install
   # opsional, jika ingin mengelola asset frontend manual:
   # npm install && npm run dev
   ```

2. **Konfigurasi environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Lalu sesuaikan koneksi database di `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

3. **Migrasi database (& seeding jika ada)**

   ```bash
   php artisan migrate
   # php artisan db:seed    # jika disediakan seeder
   ```

4. **Link storage** (untuk upload foto/lampiran)

   ```bash
   php artisan storage:link
   ```

5. **Jalankan aplikasi**

   ```bash
   php artisan serve
   ```

   Di lingkungan **Laragon**, project ini diasumsikan berada di `c:/laragon/www/prakerin_smk` dan bisa diakses via virtual host Laragon.

---

## Struktur Folder Penting

Hanya ringkasan direktori yang paling sering disentuh saat pengembangan:

- `app/Models`
  - Model utama: `Siswa`, `Pembimbing`, `Industri`, `Tempat`, `Absensi`, `Jurnal`, `Laporan`, `Monitoring`, `Bimbingan`, `Nilai`, `Setting`, `Info`.

- `app/Http/Controllers`
  - `DashboardController` – logika dashboard per role.
  - `PublicController` – halaman publik (beranda, info, industri, kontak).
  - `Siswa*Controller` – fitur siswa (tempat, absensi, jurnal, laporan, bimbingan, info).
  - `Pembimbing*Controller` – fitur pembimbing (monitoring harian, monitoring lapangan Prakerin, bimbingan, nilai, laporan sidang, chat DUDI, info).
  - `Admin/*` – modul admin (data master, penempatan, laporan, nilai, sidang, absensi, jurnal, info, settings, monitoring).
  - `Dudi*Controller` – fitur DUDI (siswa, nilai, chat).

- `resources/views`
  - `layouts/app.blade.php` – layout area internal (admin/pembimbing/siswa/DUDI).
  - `layouts/public.blade.php` – layout halaman publik.
  - `public/` – halaman publik: beranda, info Prakerin, daftar industri Prakerin, detail industri, tentang, kontak.
  - `dashboard/` – tampilan dashboard untuk `admin`, `pembimbing`, `siswa`, `dudi`.
  - `siswa/`, `pembimbing/`, `admin/`, `dudi/` – view per role.

- `routes/web.php`
  - Definisi route utama, dipisah per role: publik, admin, pembimbing, siswa, DUDI.

---

## Lisensi

Aplikasi ini dibangun menggunakan framework **Laravel** yang dirilis di bawah lisensi [MIT](https://opensource.org/licenses/MIT).

Hak cipta isi dan data aplikasi mengikuti ketentuan yang berlaku di lingkungan sekolah masing-masing.
