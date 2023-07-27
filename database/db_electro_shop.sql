-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2023 at 10:42 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `tb_barang`
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
-- Table structure for table `tb_barang_keluar`
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
-- Table structure for table `tb_barang_masuk`
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
-- Table structure for table `tb_dtl_penjualan`
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
-- Table structure for table `tb_kategori_barang`
--

CREATE TABLE `tb_kategori_barang` (
  `id_kategori` varchar(15) NOT NULL,
  `nm_kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kategori_barang`
--

INSERT INTO `tb_kategori_barang` (`id_kategori`, `nm_kategori`) VALUES
('K00001', 'Aksesoris'),
('K00002', 'Monitor'),
('K00003', 'Chasing CPU');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan`
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
-- Dumping data for table `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`id_pelanggan`, `id_user`, `no_pelanggan`, `nm_pelanggan`, `alamat`, `tgl_register`) VALUES
('P2300001', 'U2300003', '08567543557', 'Pelanggan Pertama Kita', 'Kudus Desa di Kudus', '2020-11-18');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
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
-- Table structure for table `tb_penjualan`
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
-- Table structure for table `tb_unit_pengukuran`
--

CREATE TABLE `tb_unit_pengukuran` (
  `unit_pengukuran` varchar(10) NOT NULL,
  `deskripsi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` varchar(15) NOT NULL,
  `nm_pengguna` varchar(50) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `level` enum('PELANGGAN','KASIR','PEMILIK','SUPER USER') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nm_pengguna`, `username`, `password`, `level`) VALUES
('SU', 'Admin', 'admin', 'admin', 'SUPER USER'),
('U2300001', 'Kasir', 'kasir', '12345678', 'KASIR'),
('U2300002', 'Pemilik', 'pemilik', 'pemilik', 'PEMILIK'),
('U2300003', 'Pelanggan 1', 'pelanggan', 'pelanggan', 'PELANGGAN'),
('U2300004', 'Pelanggan 2', 'pelanggan2', 'pelanggan2', 'PELANGGAN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `tb_barang_keluar`
--
ALTER TABLE `tb_barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`);

--
-- Indexes for table `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`);

--
-- Indexes for table `tb_dtl_penjualan`
--
ALTER TABLE `tb_dtl_penjualan`
  ADD PRIMARY KEY (`id_dtl_penjualan`);

--
-- Indexes for table `tb_kategori_barang`
--
ALTER TABLE `tb_kategori_barang`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `tb_unit_pengukuran`
--
ALTER TABLE `tb_unit_pengukuran`
  ADD PRIMARY KEY (`unit_pengukuran`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
