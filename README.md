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

---
*Dikembangkan untuk efisiensi birokrasi dan administrasi kepegawaian.*
