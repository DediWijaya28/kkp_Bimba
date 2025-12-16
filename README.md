# PPDB BIMBA AIUEO Unit Klender

Aplikasi Penerimaan Peserta Didik Baru (PPDB) berbasis web untuk BIMBA AIUEO Unit Klender. Aplikasi ini dirancang untuk mempermudah proses pendaftaran siswa baru, pengelolaan data siswa, manajemen kelas, serta penjadwalan trial gratis secara digital dan efisien.

## 🚀 Fitur Utama

### 👥 Halaman Publik (User)
*   **Landing Page Modern**: Informasi lengkap mengenai program (PDI, PDS, PBM), galeri kegiatan, dan testimoni.
*   **Registrasi Online (Wizard)**: Alur pendaftaran bertahap (Data Diri, Pilih Kelas, Pembayaran) yang user-friendly.
*   **Form Free Trial**: Pendaftaran trial gratis dengan pemilihan jadwal otomatis.
*   **User Dashboard**:
    *   Pantau status pendaftaran (Draft, Menunggu Pembayaran, Terverifikasi, Aktif).
    *   Informasi jadwal trial.
    *   Upload bukti pembayaran.
    *   Lanjut daftar (convert) dari akun Trial ke Pendaftaran Reguler.
*   **Sistem Pembayaran**: Upload bukti transfer manual dengan validasi admin.
*   **Fitur Lupa Password**: Reset password via email.

### 🛠 Panel Admin
*   **Dashboard Statistik**: Ringkasan jumlah siswa, pendaftaran baru, dan status trial.
*   **Manajemen Siswa**:
    *   Lihat detail biodata & orang tua.
    *   Verifikasi dokumen & pembayaran.
    *   Aktivasi akun siswa (Pemberian NIM).
    *   Bulk Delete data siswa.
*   **Manajemen Kelas**: Pengaturan kuota, jadwal, dan penetapan harga kelas.
*   **Manajemen Trial**: Atur jadwal trial, tandai kehadiran/selesai, dan follow-up.
*   **Laporan Pembayaran**: Verifikasi bukti transfer siswa.

## 💻 Teknologi yang Digunakan
*   **Backend**: Laravel 10 (PHP Framework)
*   **Frontend**: Blade Templates
*   **Styling**: Tailwind CSS (Modern Utility-First CSS)
*   **Interactivity**: Alpine.js (Lightweight JavaScript Framework)
*   **Database**: MySQL
*   **Icons**: Heroicons
*   **Font**: Comic Sans MS (Global custom font)

## ⚙️ Persyaratan Sistem
*   PHP >= 8.1
*   Composer
*   MySQL Database
*   Node.js & NPM (untuk compile aset)

## 📦 Instalasi
Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/DediWijaya28/kkp_Bimba.git
    cd kkp_Bimba
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment**
    *   Duplikasi file `.env.example` menjadi `.env`.
    *   Sesuaikan konfigurasi database di file `.env`.
    *   Generate Application Key:
    ```bash
    php artisan key:generate
    ```

4.  **Migrasi & Seeding Database**
    ```bash
    php artisan migrate --seed
    ```
    *(Gunakan `--seed` jika ingin membuat akun admin default)*

5.  **Jalankan Aplikasi**
    *   Jalankan server Laravel:
    ```bash
    php artisan serve
    ```
    *   Jalankan compiler aset (di terminal terpisah):
    ```bash
    npm run dev
    ```

6.  **Akses Aplikasi**
    Buka `http://127.0.0.1:8000` di browser Anda.

## 🔑 Akun Default (Seeder)
Jika Anda menjalanan seeder, gunakan akun berikut untuk login sebagai Admin:
*   **Email**: `admin@bimba.com`
*   **Password**: `password`

## 📝 Catatan Penting
*   Aplikasi ini menggunakan API eksternal (EMSIFA & Nominatim) untuk fitur autocomplete alamat, pastikan koneksi internet tersedia saat pengujian.
*   Fitur upload file memerlukan symlink storage. Jalankan `php artisan storage:link` jika gambar tidak muncul.

---
Dikembangkan oleh **Dedi Wijaya** untuk Tugas Akhir / Kerja Praktek.
