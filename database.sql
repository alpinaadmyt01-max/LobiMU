CREATE DATABASE IF NOT EXISTS buku_tamu;
USE buku_tamu;

CREATE TABLE IF NOT EXISTS pengguna (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role ENUM('admin', 'resepsionis') DEFAULT 'resepsionis',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tamu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    instansi VARCHAR(100) NOT NULL,
    tujuan VARCHAR(100) NOT NULL,
    keperluan TEXT NOT NULL,
    jenis_kunjungan ENUM('Bertamu', 'Titip Barang') DEFAULT 'Bertamu',
    jenis_titipan VARCHAR(100) NULL,
    keterangan_titipan TEXT NULL,
    waktu_masuk DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    waktu_keluar DATETIME NULL,
    status ENUM('berkunjung', 'selesai') DEFAULT 'berkunjung'
);

-- Default admin user: admin / admin123
INSERT INTO pengguna (username, password, nama_lengkap, role) VALUES 
('admin', '$2y$10$e.w2pI/.pB//YdJjXkX61u2D2p./rV8G.Y9BqjD.yU/I1qjR3D6bK', 'Administrator Ma''soem', 'admin');

-- Contoh Data Tamu dari BJB
INSERT INTO tamu (nama_lengkap, instansi, tujuan, keperluan, status) VALUES 
('Asep Sudrajat', 'Bank BJB Cabang Jatinangor', 'Bagian Keuangan', 'Pembahasan kerjasama pembayaran SPP mahasiswa', 'berkunjung');
