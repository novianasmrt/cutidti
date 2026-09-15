# Sistem Informasi Pengajuan Cuti (CUTDTI)

Aplikasi berbasis web untuk mengelola permohonan cuti pegawai secara digital dengan alur persetujuan berjenjang. Sistem ini dibangun menggunakan **CodeIgniter 3** (PHP) dan dilengkapi dengan fitur notifikasi email otomatis serta cetak surat cuti ber-TTE (Tanda Tangan Elektronik).

## 🚀 Fitur Utama

1. **Dashboard Statistik**  
   Menampilkan ringkasan data permohonan cuti (jumlah pegawai, status persetujuan, dll).
2. **Manajemen Pegawai & Role**  
   Pengelolaan data staff beserta hak akses jabatannya (Administrator, Admin SDM, Sekretaris Direktur, Direktur, dan Staff). Dilengkapi dengan fitur *Live Search* untuk pencarian instan.
3. **Alur Persetujuan (Approval Workflow)**  
   Proses persetujuan cuti yang berjenjang:
   - **Atasan Bidang** -> **Sekretaris Direktur** -> **Direktur** (Persetujuan Final)
4. **Notifikasi Email Otomatis**  
   Sistem akan secara otomatis mengirimkan email notifikasi ke:
   - *Approver* selanjutnya saat status cuti naik ke tahap berikutnya.
   - *Direktur* ketika dokumen telah disetujui penuh dan siap untuk dibubuhkan TTE.
   - *Pemohon (Pegawai)* setiap kali ada pembaruan status (Disetujui/Ditolak/dll).
5. **Cetak Surat & TTE**  
   Fasilitas mencetak surat cuti yang telah disetujui, dilengkapi dengan input nomor surat dan pembubuhan Tanda Tangan Elektronik (berupa *barcode* atau *QR code*).

## 🛠️ Teknologi yang Digunakan

*   **Framework PHP:** CodeIgniter 3
*   **Database:** MySQL / MariaDB
*   **Frontend:** HTML5, CSS3, Bootstrap 4, JavaScript, jQuery
*   **Mail Server:** SMTP (Gmail)

## 📋 Prasyarat Sistem

*   PHP versi 7.4 atau versi 8.x
*   MySQL / MariaDB
*   Web Server (Apache / Nginx / PHP Built-in Server)
*   Koneksi internet aktif (untuk mengirim email via SMTP)
*   **Ekstensi PHP Aktif:** `mysqli`, `openssl` (wajib untuk email SMTP)

## ⚙️ Cara Instalasi & Menjalankan (Localhost)

1. **Siapkan Database**
   * Buka phpMyAdmin (atau *database client* favorit Anda).
   * Buat database baru dengan nama `db_cuti`.
   * *Import* file `db_cuti.sql` yang ada di *root* folder proyek ini.

2. **Konfigurasi Database**
   * Pastikan konfigurasi di `application/config/database.php` sudah sesuai dengan *environment* lokal Anda (hostname, username, password, dan database).

3. **Konfigurasi Notifikasi Email**
   * Buka file `application/config/email.php`.
   * Ubah parameter `'smtp_user'` menjadi alamat email Gmail pengirim Anda.
   * *(Catatan: Pastikan Anda menggunakan App Password Gmail pada `'smtp_pass'`, bukan password akun reguler).*

4. **Jalankan Aplikasi**
   * **Via XAMPP / Laragon:** Pindahkan folder proyek ke `htdocs` atau `www`, lalu akses melalui browser di `http://localhost/CUTDTI/`.
   * **Via PHP Built-in Server:** Buka terminal/Command Prompt di folder proyek, jalankan:
     ```bash
     php -S localhost:8000
     ```
     Lalu buka browser dan akses `http://localhost:8000`.

## 🔐 Akun Default
Silakan masuk (login) menggunakan kredensial email/password pegawai yang telah terdaftar di database untuk mencoba alur persetujuan. Pastikan kolom email pada tabel *user* valid agar fitur notifikasi dapat diuji.

## 🚀 Panduan Deployment & Migrasi (Server UGM)

Bagi pengembang selanjutnya atau administrator yang bertugas memindahkan repositori ke server produksi (Universitas Gadjah Mada), harap perhatikan langkah-langkah berikut:

1. **Persiapan Server Produksi**
   * Pastikan server terinstall **PHP 7.4 - 8.x** dengan ekstensi wajib: `mysqli`, `openssl`, `gd`, dan `zip`.
   * Web Server (Apache/Nginx). Jika menggunakan Apache, pastikan modul `mod_rewrite` diaktifkan agar routing CodeIgniter berfungsi dengan baik (merujuk pada file `.htaccess`).
   * Buat *database* di server UGM dan *import* file struktur `db_cuti.sql`.

2. **Penyesuaian Konfigurasi (Environment)**
   * **Base URL:** Buka `application/config/config.php` dan ubah parameter `$config['base_url']` sesuai dengan domain/subdomain resmi yang dialokasikan (contoh: `https://[subdomain].ugm.ac.id/`).
   * **Database:** Buka `application/config/database.php` dan perbarui kredensial koneksi (`hostname`, `username`, `password`, `database`) sesuai dengan server *database* produksi.
   * **Email SMTP:** Buka `application/config/email.php`. Jika menggunakan SMTP UGM, sesuaikan `smtp_host`, `smtp_user`, `smtp_pass`, dan `smtp_crypto`. Jika menggunakan Google Workspace/Gmail, gunakan *App Password*.

3. **Keamanan & Hak Akses Folder (Permissions)**
   * Atur hak akses direktori agar server dapat menyimpan *file* (seperti dokumen PDF surat cuti, atau foto profil).
   * Biasanya folder *upload* atau penyimpanan sementara membutuhkan *permission* `755` atau `777` (tergantung konfigurasi *ownership* server).

## 📁 Struktur Direktori Penting (Untuk Pengembang)

*   `application/controllers/` - Berisi logika utama aplikasi (misalnya: `Cuti.php` untuk pengajuan, `Admin.php` untuk manajemen).
*   `application/models/` - Tempat query *database*. **Catatan:** Logika pemotongan sisa cuti secara berurutan (`cuti_n2`, `cuti_n1`, `cuti_n`) dilakukan pada `Cuti_model.php` dan `User_model.php`.
*   `application/views/` - Halaman *frontend* yang dibangun dengan integrasi Bootstrap.

---
*Dikembangkan untuk efisiensi birokrasi dan administrasi kepegawaian.*
