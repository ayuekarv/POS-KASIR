-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2023 at 03:34 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos-kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode_barang` varchar(12) NOT NULL,
  `barcode` varchar(25) NOT NULL,
  `namaproduk` varchar(50) NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `hargaawal` int(11) NOT NULL,
  `hargajual` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `barcode`, `namaproduk`, `id_suplier`, `hargaawal`, `hargajual`, `stok`) VALUES
('BRG-001', '886896986090', 'Malkist', 1, 500, 1000, 65),
('BRG-002', '998976897097', 'Indomilk', 3, 4000, 5000, 53),
('BRG-003', '898979687908', 'Kacang Garuda', 10, 1500, 2000, 42),
('BRG-004', '0123456789101', 'Teh Pucuk 350 ml ', 11, 2800, 3000, 91);

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `kode_barang`, `qty`, `tanggal`) VALUES
(34, 'BRG-001', 4, '2023-07-13 16:31:17'),
(38, 'BRG-002', 10, '2023-07-13 16:40:45'),
(39, 'BRG-003', 20, '2023-07-13 16:40:51'),
(40, 'BRG-004', 24, '2023-08-03 09:43:44');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `idpelanggan` int(11) NOT NULL,
  `namapelanggan` varchar(30) NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`idpelanggan`, `namapelanggan`, `notelp`, `alamat`) VALUES
(22, 'Budi', '089612845246', ' Cianjur'),
(23, 'Aslam Ibrahim', '089767868690', 'Cibinong'),
(24, 'Ayu Eka', '089612845246', 'Cilodong'),
(25, 'Neni', '000000000000', 'Bogor');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `no_jual` varchar(20) NOT NULL,
  `tgl_jual` date NOT NULL,
  `idpelanggan` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jml_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`no_jual`, `tgl_jual`, `idpelanggan`, `total`, `keterangan`, `jml_bayar`, `kembalian`) VALUES
('PJ0001', '2023-07-13', 22, 5000, '', 10000, 5000),
('PJ0002', '2023-07-13', 23, 10000, '', 20000, 10000),
('PJ0003', '2023-07-13', 24, 4000, '', 5000, 1000),
('PJ0004', '2023-08-03', 22, 17000, '', 20000, 3000),
('PJ0005', '2023-08-03', 25, 15000, '', 20000, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id` int(11) NOT NULL,
  `no_jual` varchar(20) NOT NULL,
  `tgl_jual` date NOT NULL,
  `namaproduk` varchar(255) NOT NULL,
  `barcode` varchar(25) NOT NULL,
  `kode_barang` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL,
  `hargajual` int(11) NOT NULL,
  `jml_hrg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id`, `no_jual`, `tgl_jual`, `namaproduk`, `barcode`, `kode_barang`, `qty`, `hargajual`, `jml_hrg`) VALUES
(63, 'PJ0001', '2023-07-13', 'Malkist', '886896986090', 'BRG-001', 5, 1000, 5000),
(65, 'PJ0002', '2023-07-13', 'Indomilk', '998976897097', 'BRG-002', 2, 5000, 10000),
(68, 'PJ0003', '2023-07-13', 'Kacang Garuda', '898979687908', 'BRG-003', 2, 2000, 4000),
(74, 'PJ0004', '2023-08-03', 'Indomilk', '998976897097', 'BRG-002', 3, 5000, 15000),
(75, 'PJ0004', '2023-08-03', 'Malkist', '886896986090', 'BRG-001', 2, 1000, 2000),
(76, 'PJ0005', '2023-08-03', 'Teh Pucuk 350 ml ', '0123456789101', 'BRG-004', 5, 3000, 15000);

-- --------------------------------------------------------

--
-- Table structure for table `suplier`
--

CREATE TABLE `suplier` (
  `id_suplier` int(11) NOT NULL,
  `nama_suplier` varchar(255) NOT NULL,
  `telpon` varchar(15) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suplier`
--

INSERT INTO `suplier` (`id_suplier`, `nama_suplier`, `telpon`, `deskripsi`, `alamat`) VALUES
(1, 'PT Khong Guan', '089777564646', '  Distributor Malkist', 'Ciriung, Cibinong, Bogor'),
(3, 'PT Indofood Sukses Makmur Tbk', '0877745875969', '   Distributor Indomilk', 'Jakarta'),
(10, 'PT. Garudafood Putra Putri Jaya Tbk.', '085789989089', 'Distributor Kacang Garuda', 'Sumedang'),
(11, 'Toko Ceceng ', '0812123466789', 'Toko Sembako', 'Jalan Raya Bogor KM 39');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `email` varchar(25) NOT NULL,
  `namaadmin` varchar(25) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(20) NOT NULL,
  `notelp` varchar(13) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `email`, `namaadmin`, `username`, `password`, `notelp`, `level`) VALUES
(17, 'user@gmail.com', 'user', 'user', '12345678', '089978578585', 'user'),
(18, 'ayu286048@gmail.com', 'Ayu Eka Marviyanti', 'admin', 'lp3idepok', '089612845246', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`idpelanggan`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`no_jual`);

--
-- Indexes for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suplier`
--
ALTER TABLE `suplier`
  ADD PRIMARY KEY (`id_suplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `idpelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `suplier`
--
ALTER TABLE `suplier`
  MODIFY `id_suplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
