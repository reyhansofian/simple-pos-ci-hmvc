-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2014 at 03:03 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `2014060162_dbpenjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `kartu_stok`
--

CREATE TABLE IF NOT EXISTS `kartu_stok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_barang` int(11) NOT NULL,
  `qty_masuk` int(11) NOT NULL,
  `qty_keluar` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_id_barang` (`id_barang`),
  KEY `FK_id_pegawai` (`id_pegawai`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `tmbarang`
--

CREATE TABLE IF NOT EXISTS `tmbarang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `id_jnsbarang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_id_jnsbarang` (`id_jnsbarang`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tmjnsbarang`
--

CREATE TABLE IF NOT EXISTS `tmjnsbarang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `tmpegawai`
--

CREATE TABLE IF NOT EXISTS `tmpegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_pegawai` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabel master pegawai' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tmpegawai`
--

INSERT INTO `tmpegawai` (`id`, `no_pegawai`, `nama`, `password`, `role`) VALUES
(1, 'admin', 'Administrator', '0c7540eb7e65b553ec1ba6b20de79608', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `ttdjual`
--

CREATE TABLE IF NOT EXISTS `ttdjual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tthtransaksi` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tth_transaksi` (`id_tthtransaksi`),
  KEY `FK_id_barang` (`id_barang`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Table detail transaksi' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `tthjual`
--

CREATE TABLE IF NOT EXISTS `tthjual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `no_nota` varchar(20) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_id_pegawai` (`id_pegawai`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabel header transaksi' AUTO_INCREMENT=14 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kartu_stok`
--
ALTER TABLE `kartu_stok`
  ADD CONSTRAINT `kartu_stok_ibfk_5` FOREIGN KEY (`id_barang`) REFERENCES `tmbarang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kartu_stok_ibfk_6` FOREIGN KEY (`id_pegawai`) REFERENCES `tmpegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tmbarang`
--
ALTER TABLE `tmbarang`
  ADD CONSTRAINT `tmbarang_ibfk_3` FOREIGN KEY (`id_jnsbarang`) REFERENCES `tmjnsbarang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ttdjual`
--
ALTER TABLE `ttdjual`
  ADD CONSTRAINT `ttdjual_ibfk_1` FOREIGN KEY (`id_tthtransaksi`) REFERENCES `tthjual` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ttdjual_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `tmbarang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tthjual`
--
ALTER TABLE `tthjual`
  ADD CONSTRAINT `tthjual_ibfk_3` FOREIGN KEY (`id_pegawai`) REFERENCES `tmpegawai` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
