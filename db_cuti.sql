-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jun 2026 pada 06.49
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cuti`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti`
--

CREATE TABLE `cuti` (
  `id_cuti` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `jenis_cuti` varchar(50) DEFAULT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `jumlah_cuti` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `status` enum('Menunggu','Menunggu Atasan','Menunggu Sekdir','Disetujui','Ditolak') DEFAULT 'Menunggu Atasan',
  `atasan_bidang` varchar(255) DEFAULT NULL,
  `ket_approval` text DEFAULT NULL,
  `dokumen_pengajuan` varchar(255) DEFAULT NULL,
  `dokumen_approved` varchar(255) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cuti`
--

INSERT INTO `cuti` (`id_cuti`, `id_user`, `jenis_cuti`, `tgl_pengajuan`, `tanggal_mulai`, `tanggal_selesai`, `tanggal_masuk`, `jumlah_cuti`, `keterangan`, `alamat`, `status`, `atasan_bidang`, `ket_approval`, `dokumen_pengajuan`, `dokumen_approved`, `lampiran`) VALUES
(4, 1, 'Cuti Tahunan', '2026-04-22', '2026-04-23', '2026-04-23', '2026-04-24', 1, 'Acara Keluarga', 'Temanggung', 'Ditolak', NULL, NULL, NULL, NULL, NULL),
(6, 1, 'Cuti Tahunan', '2026-04-22', '2026-04-23', '2026-04-23', '2026-04-24', 1, 'Acara Keluarga', 'Temanggung', 'Ditolak', NULL, NULL, NULL, NULL, NULL),
(7, 1, 'Cuti Tahunan', '2026-04-22', '2026-04-28', '2026-04-29', '2026-04-30', 2, 'Acara Keluarga', 'Temanggung', '', NULL, NULL, NULL, NULL, NULL),
(8, 1, 'Cuti Sakit', '2026-04-22', '2026-04-22', '2026-04-22', '2026-04-23', 1, 'Acara Keluarga', 'Temanggung', '', NULL, NULL, NULL, NULL, '7858e32a906fda2ad7007568279159bf.jpg'),
(9, 1, 'Cuti Tahunan', '2026-04-23', '2026-04-24', '2026-04-27', '2026-04-28', 2, 'Acara Keluarga', 'Temanggung', 'Disetujui', NULL, NULL, NULL, NULL, 'ee2ede26d09e14df4676648a10b2ee9e.pdf'),
(10, 2, 'Cuti Tahunan', '2026-04-23', '2026-04-24', '2026-04-24', '2026-04-27', 1, 'Gladi Wisuda', 'Yogyakarta', 'Disetujui', NULL, NULL, NULL, NULL, '50d77a8602bb62fd7312ef2aa3cfd899.pdf'),
(11, 1, 'Cuti Sakit', '2026-04-27', '2026-04-27', '2026-04-27', '2026-04-28', 1, 'Demam Tinggi', 'Temanggung', 'Disetujui', NULL, NULL, NULL, NULL, '697ae57afbfdc488ed350e46e237b353.pdf'),
(12, 2, 'Cuti Tahunan', '2026-04-28', '2026-04-29', '2026-04-30', '2026-05-01', 2, 'Acara Keluarga', 'Temanggung', 'Ditolak', NULL, 'Sisa cuti di sistem 0', NULL, NULL, 'bb94fce247332b9c4fc5626ec9f6743a.pdf'),
(13, 2, 'Cuti Sakit', '2026-04-28', '2026-04-29', '2026-04-29', '2026-04-30', 1, 'Demam', 'Temanggung', '', NULL, NULL, NULL, NULL, 'da5a6a7028dcaa304322e9823c566afd.pdf'),
(14, 2, 'Cuti Tahunan', '2026-04-28', '2026-04-28', '2026-04-29', '2026-04-30', 2, 'Demam Tinggi', 'Yogyakarta', 'Disetujui', NULL, '', NULL, NULL, NULL),
(15, 2, 'Cuti Alasan Penting', '2026-04-30', '2026-04-30', '2026-04-30', '2026-05-01', 1, 'p', 'Yogyakarta', 'Disetujui', 'Dendy Bagus Sulistiyo., S.T., M.Kom', 'oke', NULL, NULL, NULL),
(16, 1, 'Cuti Sakit', '2026-05-05', '2026-05-06', '2026-05-06', '2026-05-07', 1, 'Demam Tinggi', 'Yogyakarta', 'Disetujui', 'Sekertaris Direktur', 'oke semoga cepat sembuh', NULL, NULL, NULL),
(17, 2, 'Cuti Alasan Penting', '2026-05-07', '2026-05-08', '2026-05-08', '2026-05-11', 1, 'acara keluarga', 'Mangir, Pandemulyo, Bulu, Temanggung Regency, Central Java, Indonesia', 'Ditolak', 'Dendy Bagus Sulistiyo., S.T., M.Kom', '', NULL, NULL, NULL),
(18, 2, 'Cuti Sakit', '2026-05-07', '2026-05-07', '2026-05-07', '2026-05-08', 1, 'acara keluarga', 'Mangir, Pandemulyo, Bulu, Temanggung Regency, Central Java, Indonesia', 'Ditolak', 'Dendy Bagus Sulistiyo., S.T., M.Kom', '', NULL, NULL, NULL),
(19, 2, 'Cuti Tahunan', '2026-05-07', '2026-05-11', '2026-05-11', '2026-05-12', 1, 'acara keluarga', 'Mangir, Pandemulyo, Bulu, Temanggung Regency, Central Java, Indonesia', 'Disetujui', 'Dendy Bagus Sulistiyo., S.T., M.Kom', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hari_libur`
--

CREATE TABLE `hari_libur` (
  `id_libur` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hari_libur`
--

INSERT INTO `hari_libur` (`id_libur`, `tanggal`, `keterangan`) VALUES
(1, '2025-12-25', 'Hari Raya Natal'),
(2, '2026-01-01', 'Tahun Baru Masehi'),
(3, '2026-02-14', 'Cuti Bersama Imlek'),
(4, '2026-05-14', 'Kenaikan Yesus Kristus'),
(5, '2026-05-27', 'Idhul Adha 1447 Hijriyah'),
(6, '2026-05-31', 'Hari Raya Waisyak 2570 BE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `atasan_bidang` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `no_telpon` varchar(20) DEFAULT NULL,
  `tipe_pegawai` varchar(50) DEFAULT NULL,
  `unit_kerja` varchar(100) DEFAULT NULL,
  `pangkat` varchar(50) DEFAULT NULL,
  `jenis_pegawai` varchar(20) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `sisa_cuti` int(11) NOT NULL,
  `sisa_cuti_2025` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `name`, `atasan_bidang`, `email`, `password`, `nip`, `jabatan`, `role_id`, `is_active`, `date_created`, `no_telpon`, `tipe_pegawai`, `unit_kerja`, `pangkat`, `jenis_pegawai`, `kategori`, `sisa_cuti`, `sisa_cuti_2025`, `image`) VALUES
(1, 'Admin SDM', NULL, 'admin@gmail.com', '$2y$10$2y.HyWp5YHvHY9BQNzkywue1GglDlGQTls/jL5L8c401RNEHJPZzq', '123456', 'Admin SDM', 5, 1, 1775540384, '08123456787', 'Pegawai Tetap', 'Direktorat Teknologi Informasi', 'IIIa', 'Tenaga Kependidikan', 'Tetap', 10, 0, 'profile_1776930643.jpeg'),
(2, 'Noviana Sami Ratri', NULL, 'novi@ugm.ac.id', '$2y$10$RzYdzJh.9GKXaObcHXsj0.uUOzDfGSSNdMANi89Ckrx5OJY71wQwu', '3323015811010002', '', 2, 1, 1775700130, '085877180502', 'Kontrak', 'Direktorat Teknologi Informasi', '', 'Tenaga Harian Lepas', 'Kontrak', 8, 0, 'profile_1776926468.jpg'),
(3, 'Dendy Bagus Sulistiyo., S.T., M.Kom', NULL, 'dendy@ugm.ac.id', '$2y$10$zhSpy8rzxtNibGGcjT1zie.PJIlJ8c4QGtriCyrOUUVDNO.yuAZM.', '3323015811010002', 'Ketua Tim Kerja Literasi Teknologi dan Manajemen Pengetahuan Direktorat Teknologi Informasi', 5, 1, 1777349226, '', '', '', '', '', '', 12, 0, 'default.jpg'),
(4, 'Akhmad Aminullah, S.T., M.T., Ph.D.', NULL, 'sekdir@ugm.ac.id', '$2y$10$iVKi0VfvUtaOIeAyxZc53Owmvu2ZhpIgdNCwfhEYkqicvzdOFKcDu', '197908152008121004', 'Sekertaris Direktorat Teknologi Informasi', 3, 1, 1777535791, '', '', '', '', '', '', 12, 0, 'default.jpg'),
(5, 'Direktur', NULL, 'direktur@ugm.ac.id', '$2y$10$U8FNXxST35NWRZvWdRY/3O6fDd.8G3K32bXLxJdfWWNxM5yrMC5EC', '123456', 'Direktur Direktorat Teknologi Informasi', 4, 1, 1777535872, '', '', '', '', '', '', 12, 0, 'default.jpg'),
(6, 'Agung Ariansyah, S.Kom., M.Cs.', NULL, 'arians@ugm.ac.id', '$2y$10$iYwUT0/SAzRyFx3W1DuVXuDFBb/aOmkFSZXKJdvEvB.RZyK81GUme', '197712202002121003', 'Kepala Subdirektorat Infrastruktur dan Keamanan Teknologi Informasi Direktorat Teknologi Informasi', 1, 1, 1780540599, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'default.jpg'),
(7, 'Hendranti Wisnu Saputro, S.T., M.Sc.', NULL, 'wisnusaputro@ugm.ac.id', '$2y$10$TQlTjpDcMWMQ0ATUdc0BzO4Udw4HqPK81CtbfLrhQ.Ee8b/b.aSNK', '210198209201105101', 'Kepala Subdirektorat Analisis Data dan Kolaborasi Sistem Informasi Direktorat Teknologi Informasi', 1, 1, 1780541104, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'default.jpg'),
(8, 'Wahyu Sejati, S.T.', NULL, 'wahyusejati@ugm.ac.id', '$2y$10$CKFi26Ocyz5hJxNtnWw4C.kVb8PFXGqHd1U4Vy7.cGx2waG0n1EO2', '210197601201704101', 'Kepala Subdirektorat Pengembangan dan Perawatan Sistem Informasi Direktorat Teknologi Informasi', 1, 1, 1780541172, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'default.jpg'),
(9, 'M. Zudha Ghofur, S.T., M.Cs.', NULL, 'zudha@ugm.ac.id', '$2y$10$O8ha7LGNetC9b9cgegeW0OCZ0xsBOmZFT9VqwF4NotLfobWJtKpNy', '197808072002121003', 'Kepala Subdirektorat Pelayanan dan Diseminasi Teknologi Informasi Direktorat Teknologi Informasi', 1, 1, 1780541298, NULL, NULL, NULL, NULL, NULL, NULL, 12, 0, 'default.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id_role`, `role`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Sekretaris Direktur'),
(4, 'Direktur'),
(5, 'Admin SDM');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_cuti`);

--
-- Indeks untuk tabel `hari_libur`
--
ALTER TABLE `hari_libur`
  ADD PRIMARY KEY (`id_libur`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id_cuti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `hari_libur`
--
ALTER TABLE `hari_libur`
  MODIFY `id_libur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
