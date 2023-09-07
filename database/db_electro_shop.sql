-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Agu 2023 pada 15.57
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
  `berat_barang` float NOT NULL,
  `stock` float NOT NULL,
  `merk` varchar(30) NOT NULL,
  `foto_barang` text DEFAULT NULL,
  `ket_barang` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_barang`
--

INSERT INTO `tb_barang` (`id_barang`, `id_kategori`, `nm_barang`, `harga`, `unit_pengukuran`, `berat_barang`, `stock`, `merk`, `foto_barang`, `ket_barang`) VALUES
('B2300001', 'K00004', 'Mouse', 50000, 'PCS', 0.5, 34, 'Logitech', 'mouse.png', 'Mouse Logitech Wireless'),
('B2300002', 'K00002', 'Monitor IPS LED Full HD 22\"', 8000000, 'EA', 3, 2, 'LG', '1690555956812.png', 'Layar IPS FHD 22\"(1920 x 1080)\r\nTeknologi Radeon FreeSync™\r\n3 Side Virtually Borderless Design\r\nOn Screen Control\r\nDual HDMI\r\nHemat Listrik Cerdas'),
('B2300003', 'K00001', 'Mousepad', 17000, 'EA', 0.5, 30, '-', '1690690381510.png', 'Mousepad Murah'),
('B2300004', 'K00006', 'Keyboard Logitect USB Kabel K120', 500000, 'EA', 1, 6, 'Logitech', '1690690618727.png', 'Keyboard Logitect USB Kabel K120');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_keluar`
--

CREATE TABLE `tb_barang_keluar` (
  `id_barang_keluar` varchar(15) NOT NULL,
  `id_barang` varchar(15) DEFAULT NULL,
  `doc_tipe` varchar(30) DEFAULT NULL,
  `tgl_barang_keluar` datetime DEFAULT NULL,
  `ket_barang_keluar` varchar(255) DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `unit_pengukuran` varchar(10) DEFAULT NULL,
  `doc_referensi` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_barang_keluar`
--

INSERT INTO `tb_barang_keluar` (`id_barang_keluar`, `id_barang`, `doc_tipe`, `tgl_barang_keluar`, `ket_barang_keluar`, `jumlah`, `harga`, `unit_pengukuran`, `doc_referensi`) VALUES
('K2300001', 'B2300003', 'PENJUALAN', '2023-08-08 20:00:00', 'a', 4, 15000, NULL, 'J2300005'),
('K2300002', 'B2300002', 'PENJUALAN', '2023-08-08 20:00:00', NULL, 1, 8000000, NULL, 'J2300005'),
('K2300003', 'B2300004', 'PENJUALAN', '2023-08-08 19:59:28', NULL, 2, 80000, NULL, 'J2300006'),
('K2300004', 'B2300004', 'PENJUALAN', '2023-08-09 21:19:24', NULL, 2, 80000, NULL, 'J2300007'),
('K2300005', 'B2300001', 'PENJUALAN', '2023-08-09 21:19:24', NULL, 1, 50000, NULL, 'J2300007'),
('K2300006', 'B2300002', 'PENJUALAN', '2023-08-09 21:19:24', NULL, 1, 8000000, NULL, 'J2300007'),
('K2300007', 'B2300004', 'PENJUALAN', '2023-08-13 15:17:26', NULL, 1, 500000, NULL, 'J2300011'),
('K2300008', 'B2300002', 'PENJUALAN', '2023-08-13 15:17:26', NULL, 1, 8000000, NULL, 'J2300011'),
('K2300009', 'B2300004', 'PENJUALAN', '2023-08-13 15:19:34', NULL, 1, 500000, NULL, 'J2300011'),
('K2300010', 'B2300002', 'PENJUALAN', '2023-08-13 15:19:34', NULL, 1, 8000000, NULL, 'J2300011');

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
  `unit_pengukuran` varchar(10) DEFAULT NULL,
  `doc_referensi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_barang_masuk`
--

INSERT INTO `tb_barang_masuk` (`id_barang_masuk`, `id_barang`, `doc_tipe`, `tgl_barang_masuk`, `ket_barang_masuk`, `jumlah`, `harga`, `unit_pengukuran`, `doc_referensi`) VALUES
('M2300001', 'B2300003', 'PEMBELIAN', '2023-08-08 20:49:42', 'Pembelian dari Ungu', 10, 17000, NULL, NULL),
('M2300002', 'B2300004', 'PEMBELIAN', '2023-08-09 21:23:28', 'Test', 2, 500000, NULL, 'INV-010102023');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_complaint`
--

CREATE TABLE `tb_complaint` (
  `id_complaint` varchar(15) NOT NULL,
  `id_penjualan` varchar(15) NOT NULL,
  `id_user` varchar(15) NOT NULL,
  `tgl_complaint` date NOT NULL,
  `judul_complaint` varchar(40) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_complaint`
--

INSERT INTO `tb_complaint` (`id_complaint`, `id_penjualan`, `id_user`, `tgl_complaint`, `judul_complaint`, `deskripsi`, `foto`, `status`) VALUES
('C2300001', 'J2300001', 'U2300003', '2023-08-03', 'Barang Pecah', 'Barang Pecah saat pengantaran2', '1691048039584.png', 'OPEN'),
('C2300002', 'J2300002', 'U2300003', '2023-07-03', 'Barang Pecah', 'Barang Pecah saat pengantaran', '1691048039584.png', 'OPEN'),
('C2300003', 'J2300003', 'U2300003', '2023-08-03', 'Barang Basah', 'Barang Pecah saat pengantaran', '1691048039584.png', 'OPEN'),
('C2300004', 'J2300004', 'U2300003', '2023-06-03', 'Barang Beda', 'Barang Pecah saat pengantaran', '1691048039584.png', 'OPEN'),
('C2300005', 'J2300005', 'U2300003', '2023-08-05', 'Barang Pecah', 'Barang Pecah saat pengantaran', '1691048039584.png', 'CLOSED');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dtl_penjualan`
--

CREATE TABLE `tb_dtl_penjualan` (
  `id_dtl_penjualan` int(11) NOT NULL,
  `id_penjualan` varchar(15) DEFAULT NULL,
  `id_barang` varchar(15) DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `diskon` float NOT NULL,
  `subtotal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_dtl_penjualan`
--

INSERT INTO `tb_dtl_penjualan` (`id_dtl_penjualan`, `id_penjualan`, `id_barang`, `jumlah`, `harga`, `diskon`, `subtotal`) VALUES
(13, 'J2300001', 'B2300002', 1, 8000000, 0, 8000000),
(14, 'J2300001', 'B2300003', 1, 15000, 0, 15000),
(15, 'J2300001', 'B2300004', 2, 80000, 0, 160000),
(16, 'J2300002', 'B2300004', 2, 80000, 0, 160000),
(17, 'J2300002', 'B2300002', 1, 8000000, 10000, 7990000),
(18, 'J2300002', 'B2300001', 1, 50000, 0, 50000),
(19, 'J2300003', 'B2300004', 1, 80000, 0, 80000),
(20, 'J2300003', 'B2300001', 1, 50000, 0, 50000),
(21, 'J2300004', 'B2300004', 1, 80000, 0, 80000),
(22, 'J2300004', 'B2300003', 1, 15000, 0, 15000),
(23, 'J2300005', 'B2300003', 4, 15000, 0, 60000),
(24, 'J2300005', 'B2300002', 1, 8000000, 0, 8000000),
(25, 'J2300006', 'B2300004', 2, 80000, 10000, 150000),
(26, 'J2300007', 'B2300004', 2, 80000, 5000, 155000),
(27, 'J2300007', 'B2300001', 1, 50000, 0, 50000),
(28, 'J2300007', 'B2300002', 1, 8000000, 0, 8000000),
(29, 'J2300008', 'B2300001', 1, 50000, 0, 50000),
(30, 'J2300008', 'B2300003', 1, 17000, 0, 17000),
(31, 'J2300009', 'B2300001', 1, 50000, 0, 50000),
(32, 'J2300009', 'B2300004', 1, 500000, 0, 500000),
(33, 'J2300010', 'B2300001', 1, 50000, 0, 50000),
(36, 'J2300011', 'B2300004', 1, 500000, 0, 500000),
(37, 'J2300011', 'B2300002', 1, 8000000, 0, 8000000),
(38, 'J2300012', 'B2300002', 1, 8000000, 0, 8000000),
(39, 'J2300012', 'B2300004', 1, 500000, 0, 500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jawab_complaint`
--

CREATE TABLE `tb_jawab_complaint` (
  `id_complaint` varchar(15) DEFAULT NULL,
  `tgl_jawab` datetime DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `oleh` enum('ADMIN','PELANGGAN') DEFAULT NULL,
  `id_user` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_jawab_complaint`
--

INSERT INTO `tb_jawab_complaint` (`id_complaint`, `tgl_jawab`, `deskripsi`, `oleh`, `id_user`) VALUES
('C2300001', '2023-08-03 17:57:36', 'Ada yang bisa kami bantu?', 'ADMIN', 'U2300001'),
('C2300001', '2023-08-03 18:00:36', 'Saya ingin komplain perihal barang saya yg rusak waktu pengiriman', 'PELANGGAN', 'U2300003'),
('C2300001', '2023-08-03 19:37:10', 'Oke', 'PELANGGAN', 'U2300003'),
('C2300001', '2023-08-03 21:36:42', 'Mantabs', 'ADMIN', 'SU'),
('C2300006', '2023-08-09 21:33:20', 'Test', 'ADMIN', 'SU'),
('C2300006', '2023-08-09 21:34:19', 'Ada yg bisa kami bantu?', 'ADMIN', 'SU'),
('C2300006', '2023-08-09 21:35:08', 'Barang saya basah, saya minta diganti', 'PELANGGAN', 'U2300003'),
('C2300006', '2023-08-09 21:40:18', 'test lagi', 'PELANGGAN', 'U2300003'),
('C2300006', '2023-08-09 21:40:48', 'sadad', 'PELANGGAN', 'U2300003'),
('C2300005', '2023-08-09 21:41:03', 'asda', 'PELANGGAN', 'U2300003'),
('C2300004', '2023-08-09 21:42:26', 'dsfdsf', 'PELANGGAN', 'U2300003');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori_barang`
--

CREATE TABLE `tb_kategori_barang` (
  `id_kategori` varchar(15) NOT NULL,
  `nm_kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_kategori_barang`
--

INSERT INTO `tb_kategori_barang` (`id_kategori`, `nm_kategori`) VALUES
('K00001', 'Aksesoris'),
('K00002', 'Monitor'),
('K00003', 'Chasing CPU'),
('K00004', 'Mouse'),
('K00005', 'Lain-lain'),
('K00006', 'Keyboard');

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
  `tgl_register` date DEFAULT NULL,
  `jml_point` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`id_pelanggan`, `id_user`, `no_pelanggan`, `nm_pelanggan`, `alamat`, `tgl_register`, `jml_point`) VALUES
('GUEST', 'GUEST', NULL, 'Non Member', 'Non Member', '2020-01-01', 0),
('P2300001', 'U2300003', '08567543557', 'Pelanggan Pertama Kita', 'Kudus Desa di Kudus', '2020-11-18', 139310),
('P2300002', 'U2300005', '08976378234', 'Pelanggan 3', 'Pati', '2023-08-01', 0),
('P2300003', 'U2300006', '0897788824', 'PELANGGAN1', 'KUDUS', '2023-08-09', 0),
('P2300004', 'U2300007', '08956677886', 'PELANGGAN4', 'PATI', '2023-08-09', 0);

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
-- Struktur dari tabel `tb_pengiriman`
--

CREATE TABLE `tb_pengiriman` (
  `id_pengiriman` int(11) NOT NULL,
  `id_penjualan` varchar(15) NOT NULL,
  `nm_penerima` varchar(50) NOT NULL,
  `kota_asal` varchar(50) DEFAULT NULL,
  `kota_tujuan` varchar(50) DEFAULT NULL,
  `kurir` varchar(25) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `estimasi` varchar(50) DEFAULT NULL,
  `layanan` varchar(50) DEFAULT NULL,
  `alamat_penerima` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pengiriman`
--

INSERT INTO `tb_pengiriman` (`id_pengiriman`, `id_penjualan`, `nm_penerima`, `kota_asal`, `kota_tujuan`, `kurir`, `harga`, `estimasi`, `layanan`, `alamat_penerima`) VALUES
(7, 'J2300001', 'Test penerima', '209', '398', 'jne', 11000, '3-6', '11000', 'Test Alamat'),
(8, 'J2300008', 'Saya', '398', '209', 'jne', 10000, '3-6', '10000', 'DS. test Rt1/3'),
(9, 'J2300009', 'Saya yg Nerima', '344', '80', 'tiki', 10000, '5', '10000', 'DS. Test RT 1 RW 3'),
(10, 'J2300010', 'Saya yg Nerima', '344', '41', 'jne', 13000, '3-6', '13000', 'fcgfdgfdg'),
(11, 'J2300012', 'Test penerima', '344', '209', 'jne', 11000, '3-6', '11000', 'DS. Kaliwungu Kec. kaliwungu Kudus');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penjualan`
--

CREATE TABLE `tb_penjualan` (
  `id_penjualan` varchar(15) NOT NULL,
  `tgl_penjualan` datetime DEFAULT NULL,
  `id_pelanggan` varchar(15) DEFAULT NULL,
  `tipe_penjualan` enum('ONLINE','ONSITE') DEFAULT NULL,
  `diskon` float NOT NULL,
  `point_pengurangan` int(11) DEFAULT NULL,
  `tot_biaya_barang` float DEFAULT NULL,
  `tot_akhir` float DEFAULT NULL,
  `bukti_bayar` varchar(500) NOT NULL,
  `status_penjualan` enum('DIKIRIM','SELESAI','DISIAPKAN','DITERIMA','MENUNGGU PEMBAYARAN','') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_penjualan`
--

INSERT INTO `tb_penjualan` (`id_penjualan`, `tgl_penjualan`, `id_pelanggan`, `tipe_penjualan`, `diskon`, `point_pengurangan`, `tot_biaya_barang`, `tot_akhir`, `bukti_bayar`, `status_penjualan`) VALUES
('J2300001', '2023-08-03 06:02:46', 'P2300001', 'ONLINE', 0, NULL, 8175000, 8186000, '', 'DISIAPKAN'),
('J2300002', '2023-08-05 05:42:43', 'GUEST', 'ONSITE', 0, NULL, 8200000, 8200000, '', 'SELESAI'),
('J2300003', '2023-08-07 19:53:52', 'GUEST', 'ONSITE', 0, NULL, 130000, 130000, '', 'SELESAI'),
('J2300004', '2023-08-07 19:59:51', 'GUEST', 'ONSITE', 0, NULL, 95000, 95000, '', 'SELESAI'),
('J2300005', '2023-08-08 19:53:14', 'GUEST', 'ONSITE', 0, NULL, 8060000, 8060000, '', 'SELESAI'),
('J2300006', '2023-08-08 19:59:28', 'GUEST', 'ONSITE', 0, NULL, 150000, 150000, '', 'SELESAI'),
('J2300007', '2023-08-09 21:19:24', 'GUEST', 'ONSITE', 5, NULL, 8205000, 7794750, '', 'SELESAI'),
('J2300009', '2023-08-11 20:59:37', 'P2300001', 'ONLINE', 0, NULL, 550000, 560000, '1691764082755.png', 'DITERIMA'),
('J2300010', '2023-08-11 21:56:03', 'P2300001', 'ONLINE', 0, NULL, 50000, 63000, '', 'MENUNGGU PEMBAYARAN'),
('J2300011', '2023-08-13 15:19:34', 'P2300001', 'ONSITE', 0, 40000, 8500000, 8460000, '', 'SELESAI'),
('J2300012', '2023-08-13 18:57:31', 'P2300001', 'ONLINE', 0, 40000, 8500000, 8471000, '', 'MENUNGGU PEMBAYARAN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sys_point`
--

CREATE TABLE `tb_sys_point` (
  `id` int(11) NOT NULL,
  `potongan_point` float DEFAULT NULL,
  `min_point` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_sys_point`
--

INSERT INTO `tb_sys_point` (`id`, `potongan_point`, `min_point`) VALUES
(2, 1, 50000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_temp_chart`
--

CREATE TABLE `tb_temp_chart` (
  `id_barang` varchar(15) NOT NULL,
  `id_user` varchar(15) NOT NULL,
  `qty` float NOT NULL,
  `harga` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_unit_pengukuran`
--

CREATE TABLE `tb_unit_pengukuran` (
  `unit_pengukuran` varchar(10) NOT NULL,
  `deskripsi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_unit_pengukuran`
--

INSERT INTO `tb_unit_pengukuran` (`unit_pengukuran`, `deskripsi`) VALUES
('KG', 'Kilogram'),
('PCS', 'Piece');

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
('U2300001', 'Kasir', 'kasir', '12345678', 'KASIR'),
('U2300002', 'Pemilik', 'pemilik', 'pemilik', 'PEMILIK'),
('U2300003', 'Pelanggan 1', 'pelanggan', 'pelanggan', 'PELANGGAN'),
('U2300004', 'Pelanggan 2', 'pelanggan2', 'pelanggan2', 'PELANGGAN'),
('U2300005', 'Pelanggan 3', 'pelanggan3', 'pelanggan3', 'PELANGGAN'),
('U2300006', 'PELANGGAN1', 'PELANGGAN1', 'PELANGGAN1', 'PELANGGAN'),
('U2300007', 'PELANGGAN4', 'PELANGGAN4', 'PELANGGAN4', 'PELANGGAN');

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
-- Indeks untuk tabel `tb_complaint`
--
ALTER TABLE `tb_complaint`
  ADD PRIMARY KEY (`id_complaint`);

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
-- Indeks untuk tabel `tb_pengiriman`
--
ALTER TABLE `tb_pengiriman`
  ADD PRIMARY KEY (`id_pengiriman`);

--
-- Indeks untuk tabel `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `tb_sys_point`
--
ALTER TABLE `tb_sys_point`
  ADD PRIMARY KEY (`id`);

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

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_dtl_penjualan`
--
ALTER TABLE `tb_dtl_penjualan`
  MODIFY `id_dtl_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `tb_pengiriman`
--
ALTER TABLE `tb_pengiriman`
  MODIFY `id_pengiriman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tb_sys_point`
--
ALTER TABLE `tb_sys_point`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
