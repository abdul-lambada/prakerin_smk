# SIPRAKERIN - Sistem Informasi Prakerin SMK

<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

**SIPRAKERIN** adalah platform manajemen Praktik Kerja Lapangan (Prakerin) terpadu yang dirancang khusus untuk memenuhi kebutuhan instansi sekolah menengah kejuruan (SMK). Aplikasi ini mengintegrasikan seluruh proses PKL, mulai dari penempatan hingga penilaian akhir, dalam satu ekosistem digital yang efisien.

---

## 🚀 Fitur Utama

Sistem ini menyediakan portal khusus untuk empat entitas utama dengan fitur yang dipersonalisasi:

### 👨‍🎓 Portal Siswa
*   **Logbook Digital:** Pengisian absensi harian dan jurnal kegiatan dengan fitur unggah foto bukti kegiatan.
*   **Ruang Bimbingan:** Konsultasi daring dengan pembimbing sekolah terkait progres PKL.
*   **Manajemen Laporan:** Unggah dokumen laporan akhir langsung ke sistem untuk di-review.
*   **Informasi Real-time:** Notifikasi pengumuman terbaru seputar pelaksanaan Prakerin.

### 👩‍🏫 Portal Pembimbing (Guru)
*   **Monitoring Terpusat:** Memantau absensi dan jurnal harian seluruh siswa bimbingan secara real-time.
*   **Monitoring Lapangan:** Pencatatan hasil kunjungan industri langsung dari perangkat mobile secara presisi.
*   **Integrasi Chat:** Komunikasi dua arah dengan pihak Industri (DUDI) untuk sinkronisasi kendala di lapangan.
*   **Evaluasi & Sidang:** Pengelolaan nilai sidang laporan siswa.

### 🏭 Portal Mitra Industri (DUDI)
*   **Manajemen Praktikan:** Melihat daftar siswa yang sedang melakukan Prakerin di industrinya.
*   **Penilaian Teknis:** Pengisian nilai kinerja industri sesuai dengan kompetensi keahlian.
*   **Saluran Komunikasi:** Hubungan langsung dengan pembimbing sekolah via fitur chat internal.

### ⚙️ Portal Administrator
*   **Master Data Management:** Pengelolaan data Siswa, Pembimbing, Industri, Jurusan, Kelas, dan User.
*   **Engine Penempatan:** Pengaturan distribusi siswa ke berbagai mitra industri.
*   **Konfigurasi Sistem:** Pengaturan profil sekolah, logo aplikasi, warna tema (white-labeling), dan maintenance mode.

---

## 🛠️ Arsitektur Teknologi

Aplikasi ini dibangun menggunakan teknologi mutakhir untuk memastikan performa dan keamanan optimal:

*   **Core:** [Laravel 12.0](https://laravel.com) (PHP 8.2+)
*   **UI Engine:** SB Admin 2 (Bootstrap) dengan kustomisasi CSS variabel untuk tema dinamis.
*   **Database:** MySQL / MariaDB.
*   **Library:** 
    *   `DOMPDF` untuk generator sertifikat/laporan.
    *   `PHPSpreadsheet` untuk ekspor-impor data Excel masal.
    *   `SweetAlert2` untuk interaksi user yang elegan.

---

## 💻 Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan project di lingkungan lokal:

1.  **Clone & Install Dependencies**
    ```bash
    git clone https://github.com/syntaxlink/prakerin_smk.git
    cd prakerin_smk
    composer install
    npm install && npm run build
    ```

2.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Sesuaikan nilai `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di file `.env`.*

3.  **Database Migration**
    ```bash
    php artisan migrate
    # php artisan db:seed # Opsional, jika menyediakan data awal
    ```

4.  **Storage Link**
    ```bash
    php artisan storage:link
    ```

5.  **Run Application**
    ```bash
    php artisan serve
    ```

---

## 📁 Struktur Penting

*   `app/Models`: Definisi relasi database (Siswa, Tempat, Industri, Jurnal, dsb).
*   `app/Http/Controllers`: Logika bisnis per role (Admin, Siswa, Pembimbing, Dudi).
*   `resources/views/auth/login.blade.php`: Gerbang login tunggal untuk semua role.
*   `routes/web.php`: Definisi alur navigasi dan proteksi middleware role.

---

## 📄 Lisensi
Sistem ini menggunakan framework Laravel yang berlisensi [MIT](https://opensource.org/licenses/MIT). Seluruh hak cipta konten dan data menyesuaikan kebijakan sekolah pengguna masing-masing.

---
<p align="center">
    <i>Powered by <a href="https://syntaxtrust.akarsekawan.my.id/" target="_blank">SyntaxTrust</a></i>
</p>
