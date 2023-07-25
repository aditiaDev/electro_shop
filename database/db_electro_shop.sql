-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Jul 2023 pada 22.09
-- Versi server: 10.4.10-MariaDB
-- Versi PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_electro_shop`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_barang` varchar(15) NOT NULL,
  `id_kategori` varchar(15) DEFAULT NULL,
  `nm_barang` varchar(150) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `unit_pengukuran` varchar(10) DEFAULT '',
  `foto_barang` text DEFAULT NULL,
  `ket_barang` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_keluar`
--

CREATE TABLE `tb_barang_keluar` (
  `id_barang_keluar` varchar(15) NOT NULL,
  `id_barang` varchar(15) DEFAULT NULL,
  `doc_tipe` varchar(30) DEFAULT NULL,
  `tgl_barang_keluar` date DEFAULT NULL,
  `ket_barang_keluar` varchar(255) DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `unit_pengukuran` varchar(10) DEFAULT NULL,
  `doc_referensi` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_masuk`
--

CREATE TABLE `tb_barang_masuk` (
  `id_barang_masuk` varchar(15) NOT NULL,
  `id_barang` varchar(15) DEFAULT NULL,
  `doc_tipe` varchar(30) DEFAULT NULL,
  `tgl_barang_masuk` datetime DEFAULT NULL,
  `ket_barang_masuk` varchar(255) DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `unit_pengukuran` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dtl_penjualan`
--

CREATE TABLE `tb_dtl_penjualan` (
  `id_dtl_penjualan` varchar(15) NOT NULL,
  `id_penjualan` varchar(15) DEFAULT NULL,
  `id_barang` varchar(15) DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `diskon` float NOT NULL,
  `subtotal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori_barang`
--

CREATE TABLE `tb_kategori_barang` (
  `id_kategori` varchar(15) NOT NULL,
  `nm_kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` varchar(15) NOT NULL DEFAULT '',
  `id_user` varchar(15) DEFAULT NULL,
  `no_pelanggan` varchar(13) DEFAULT NULL,
  `nm_pelanggan` varchar(30) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `tgl_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`id_pelanggan`, `id_user`, `no_pelanggan`, `nm_pelanggan`, `alamat`, `tgl_register`) VALUES
('P2300001', 'U2300003', '08567543557', 'Pelanggan Pertama Kita', 'Kudus Desa di Kudus', '2020-11-18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pembayaran` varchar(15) NOT NULL,
  `id_penjualan` varchar(15) DEFAULT NULL,
  `tgl_pembayaran` datetime DEFAULT NULL,
  `nominal` float DEFAULT NULL,
  `bukti_bayar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penjualan`
--

CREATE TABLE `tb_penjualan` (
  `id_penjualan` varchar(15) NOT NULL,
  `tgl_penjualan` datetime DEFAULT NULL,
  `id_pelanggan` varchar(15) DEFAULT NULL,
  `tipe_penjualan` enum('ONLINE','ONSITE') DEFAULT NULL,
  `jasa_pengiriman` varchar(100) DEFAULT NULL,
  `ongkir` float DEFAULT NULL,
  `diskon` float NOT NULL,
  `tot_biaya_barang` float DEFAULT NULL,
  `tot_akhir` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_unit_pengukuran`
--

CREATE TABLE `tb_unit_pengukuran` (
  `unit_pengukuran` varchar(10) NOT NULL,
  `deskripsi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` varchar(15) NOT NULL,
  `nm_pengguna` varchar(50) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `level` enum('PELANGGAN','KASIR','PEMILIK','SUPER USER') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nm_pengguna`, `username`, `password`, `level`) VALUES
('SU', 'Admin', 'admin', 'admin', 'SUPER USER'),
('U2300001', 'Kasir', 'kasir', 'kasir', 'KASIR'),
('U2300002', 'Pemilik', 'pemilik', 'pemilik', 'PEMILIK'),
('U2300003', 'Pelanggan 1', 'pelanggan', 'pelanggan', 'PELANGGAN');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `tb_barang_keluar`
--
ALTER TABLE `tb_barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`);

--
-- Indeks untuk tabel `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`);

--
-- Indeks untuk tabel `tb_dtl_penjualan`
--
ALTER TABLE `tb_dtl_penjualan`
  ADD PRIMARY KEY (`id_dtl_penjualan`);

--
-- Indeks untuk tabel `tb_kategori_barang`
--
ALTER TABLE `tb_kategori_barang`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indeks untuk tabel `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `tb_unit_pengukuran`
--
ALTER TABLE `tb_unit_pengukuran`
  ADD PRIMARY KEY (`unit_pengukuran`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
