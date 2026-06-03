-- ==========================================
-- SUPABASE POSTGRESQL DATABASE SCHEMA
-- ==========================================

-- 1. TABLE: user_role
CREATE TABLE IF NOT EXISTS user_role (
    id_role SERIAL PRIMARY KEY,
    role VARCHAR(50) DEFAULT NULL
);

-- Insert Roles
INSERT INTO user_role (id_role, role) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Sekretaris Direktur'),
(4, 'Direktur'),
(5, 'Admin SDM')
ON CONFLICT (id_role) DO NOTHING;

-- 2. TABLE: user (Note: "user" is a reserved keyword, CodeIgniter automatically quotes it)
CREATE TABLE IF NOT EXISTS "user" (
    id_user SERIAL PRIMARY KEY,
    name VARCHAR(100) DEFAULT NULL,
    atasan_bidang VARCHAR(255) DEFAULT NULL,
    email VARCHAR(100) DEFAULT NULL,
    password VARCHAR(255) DEFAULT NULL,
    nip VARCHAR(50) DEFAULT NULL,
    jabatan VARCHAR(100) DEFAULT NULL,
    role_id INT DEFAULT NULL,
    is_active SMALLINT DEFAULT NULL,
    date_created INT DEFAULT NULL,
    no_telpon VARCHAR(20) DEFAULT NULL,
    tipe_pegawai VARCHAR(50) DEFAULT NULL,
    unit_kerja VARCHAR(100) DEFAULT NULL,
    pangkat VARCHAR(50) DEFAULT NULL,
    jenis_pegawai VARCHAR(20) DEFAULT NULL,
    kategori VARCHAR(50) DEFAULT NULL,
    sisa_cuti INT NOT NULL DEFAULT 0,
    sisa_cuti_2025 INT DEFAULT 0,
    image VARCHAR(255) DEFAULT NULL
);

-- Insert Default Admin (Password: admin123)
INSERT INTO "user" (name, email, password, role_id, is_active, date_created, sisa_cuti, image) VALUES
('Administrator', 'admin@ugm.ac.id', '$2y$10$tMh4f0c43jN3qL/v6Vd8feK3UqE0/6GZg5U/i/Y9tYQ4oU71F9l0q', 1, 1, 1717320000, 12, 'default.jpg')
ON CONFLICT (id_user) DO NOTHING;

-- 3. TABLE: cuti
CREATE TABLE IF NOT EXISTS cuti (
    id_cuti SERIAL PRIMARY KEY,
    id_user INT DEFAULT NULL,
    jenis_cuti VARCHAR(50) DEFAULT NULL,
    tgl_pengajuan DATE DEFAULT NULL,
    tanggal_mulai DATE DEFAULT NULL,
    tanggal_selesai DATE DEFAULT NULL,
    tanggal_masuk DATE DEFAULT NULL,
    jumlah_cuti INT DEFAULT NULL,
    keterangan TEXT DEFAULT NULL,
    alamat VARCHAR(255) DEFAULT NULL,
    status VARCHAR(50) DEFAULT 'Menunggu Atasan',
    atasan_bidang VARCHAR(255) DEFAULT NULL,
    ket_approval TEXT DEFAULT NULL,
    dokumen_pengajuan VARCHAR(255) DEFAULT NULL,
    dokumen_approved VARCHAR(255) DEFAULT NULL,
    lampiran VARCHAR(255) DEFAULT NULL,
    no_surat VARCHAR(255) DEFAULT NULL
);

-- 4. TABLE: hari_libur
CREATE TABLE IF NOT EXISTS hari_libur (
    id_libur SERIAL PRIMARY KEY,
    tanggal DATE NOT NULL,
    keterangan VARCHAR(255) NOT NULL
);
