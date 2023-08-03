-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Agu 2023 pada 17.18
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
('B2300001', 'K00004', 'Mouse', 50000, 'PCS', 0.5, 35, 'Logitech', 'mouse.png', 'Mouse Logitech Wireless'),
('B2300002', 'K00002', 'Monitor IPS LED Full HD 22\"', 8000000, 'EA', 3, 5, 'LG', '1690555956812.png', 'Layar IPS FHD 22\"(1920 x 1080)\r\nTeknologi Radeon FreeSync™\r\n3 Side Virtually Borderless Design\r\nOn Screen Control\r\nDual HDMI\r\nHemat Listrik Cerdas'),
('B2300003', 'K00001', 'Mousepad', 15000, 'EA', 0.5, 20, '-', '1690690381510.png', 'Mousepad Murah'),
('B2300004', 'K00006', 'Keyboard Logitect USB Kabel K120', 80000, 'EA', 1, 10, 'Logitect', '1690690618727.png', 'Keyboard Logitect USB Kabel K120');

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
('C2300001', 'J2300001', 'U2300003', '2023-08-03', 'Barang Pecah', 'Barang Pecah saat pengantaran', '1691048039584.png', 'OPEN');

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
(15, 'J2300001', 'B2300004', 2, 80000, 0, 160000);

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
('C2300001', '2023-08-03 21:36:42', 'Mantabs', 'ADMIN', 'SU');

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
  `tgl_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`id_pelanggan`, `id_user`, `no_pelanggan`, `nm_pelanggan`, `alamat`, `tgl_register`) VALUES
('GUEST', 'GUEST', NULL, 'Non Member', 'Non Member', '2020-01-01'),
('P2300001', 'U2300003', '08567543557', 'Pelanggan Pertama Kita', 'Kudus Desa di Kudus', '2020-11-18'),
('P2300002', 'U2300005', '08976378234', 'Pelanggan 3', 'Pati', '2023-08-01');

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
(7, 'J2300001', 'Test penerima', '209', '398', 'jne', 11000, '3-6', '11000', 'Test Alamat');

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
  `tot_biaya_barang` float DEFAULT NULL,
  `tot_akhir` float DEFAULT NULL,
  `status_penjualan` enum('DIKIRIM','SELESAI','DISIAPKAN','DITERIMA') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_penjualan`
--

INSERT INTO `tb_penjualan` (`id_penjualan`, `tgl_penjualan`, `id_pelanggan`, `tipe_penjualan`, `diskon`, `tot_biaya_barang`, `tot_akhir`, `status_penjualan`) VALUES
('J2300001', '2023-08-03 06:02:46', 'P2300001', 'ONLINE', 0, 8175000, 8186000, 'DITERIMA');

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
('EA', 'Each'),
('KG', 'Kilogram'),
('L', 'Liter'),
('PCS', 'Piece'),
('TON', 'Ton');

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
('U2300005', 'Pelanggan 3', 'pelanggan3', 'pelanggan3', 'PELANGGAN');

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
  MODIFY `id_dtl_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tb_pengiriman`
--
ALTER TABLE `tb_pengiriman`
  MODIFY `id_pengiriman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
