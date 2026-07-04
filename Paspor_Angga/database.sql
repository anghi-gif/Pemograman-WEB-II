-- Database: db_paspor
CREATE DATABASE IF NOT EXISTS db_paspor CHARACTER SET utf8 COLLATE utf8_general_ci;
USE db_paspor;

-- Tabel Pendaftaran
CREATE TABLE IF NOT EXISTS pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_daftar VARCHAR(20) NOT NULL UNIQUE,
    nama_pemohon VARCHAR(100) NOT NULL,
    tanggal_daftar DATE NOT NULL,
    hari VARCHAR(20) NOT NULL,
    jam TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Daftar Ulang
CREATE TABLE IF NOT EXISTS daftar_ulang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_daftar VARCHAR(20) NOT NULL,
    nama_pemohon VARCHAR(100) NOT NULL,
    keperluan VARCHAR(100) NOT NULL,
    hari_harus_datang VARCHAR(20) NOT NULL,
    tgl_harus_datang DATE NOT NULL,
    hari_datang VARCHAR(20) NOT NULL,
    tgl_datang DATE NOT NULL,
    ktp ENUM('Ada','Tidak') NOT NULL DEFAULT 'Tidak',
    kk ENUM('Ada','Tidak') NOT NULL DEFAULT 'Tidak',
    ijazah_akte ENUM('Ada','Tidak') NOT NULL DEFAULT 'Tidak',
    keterangan VARCHAR(10) NOT NULL DEFAULT 'tidak',
    no_antrian INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Pengurusan
CREATE TABLE IF NOT EXISTS pengurusan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_antrian INT NOT NULL,
    no_daftar VARCHAR(20) NOT NULL,
    nama_pemohon VARCHAR(100) NOT NULL,
    berkas VARCHAR(20) NOT NULL DEFAULT 'tidak lengkap',
    status VARCHAR(20) NOT NULL DEFAULT 'ditolak',
    keterangan VARCHAR(20) NOT NULL DEFAULT 'tidak',
    pembayaran DECIMAL(10,0) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
