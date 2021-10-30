-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.38-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for dbsedia
DROP DATABASE IF EXISTS `dbsedia`;
CREATE DATABASE IF NOT EXISTS `dbsedia` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `dbsedia`;

-- Dumping structure for table dbsedia.d_persediaan
DROP TABLE IF EXISTS `d_persediaan`;
CREATE TABLE IF NOT EXISTS `d_persediaan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kd_barang` varchar(12) DEFAULT NULL,
  `hrg_satuan` decimal(8,0) DEFAULT NULL,
  `kuantitas` decimal(6,0) DEFAULT NULL,
  `jtrn` enum('m','k') DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `aktif` enum('y','n') DEFAULT 'y',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table dbsedia.d_persediaan: ~6 rows (approximately)
DELETE FROM `d_persediaan`;
/*!40000 ALTER TABLE `d_persediaan` DISABLE KEYS */;
INSERT INTO `d_persediaan` (`id`, `kd_barang`, `hrg_satuan`, `kuantitas`, `jtrn`, `keterangan`, `aktif`, `created_at`) VALUES
	(1, 'BRG01', 260000, 23, 'm', 'foo', 'y', '2020-09-25 21:47:27'),
	(2, 'BRG02', 450000, 42, 'm', 'foo bar', 'y', '2020-09-25 21:47:32'),
	(3, 'BRG03', 98000, 100, 'm', 'lorem ipsum dolor sit amet', 'y', '2020-09-25 21:51:14'),
	(4, 'BRG01', 260000, 3, 'k', 'pembelian pertama', 'y', '2020-09-25 22:00:55'),
	(5, 'BRG04', 324000, 1200, 'm', 'bla bla bla', 'y', '2020-10-24 14:50:11'),
	(6, 'BRG04', 324000, 34, 'k', 'pembelian oleh CV Maju', 'y', '2020-10-24 14:51:17');
/*!40000 ALTER TABLE `d_persediaan` ENABLE KEYS */;

-- Dumping structure for table dbsedia.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table dbsedia.migrations: ~0 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table dbsedia.r_barang
DROP TABLE IF EXISTS `r_barang`;
CREATE TABLE IF NOT EXISTS `r_barang` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `kd_barang` varchar(12) DEFAULT NULL,
  `nm_barang` varchar(100) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `ukuran` varchar(255) DEFAULT NULL,
  `berat` varchar(255) DEFAULT NULL,
  `nm_file_skema` varchar(255) DEFAULT NULL,
  `nm_file_gambar` varchar(255) DEFAULT NULL,
  `aktif` enum('y','n') DEFAULT 'y',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`kd_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table dbsedia.r_barang: ~4 rows (approximately)
DELETE FROM `r_barang`;
/*!40000 ALTER TABLE `r_barang` DISABLE KEYS */;
INSERT INTO `r_barang` (`id`, `kd_barang`, `nm_barang`, `deskripsi`, `ukuran`, `berat`, `nm_file_skema`, `nm_file_gambar`, `aktif`, `created_at`) VALUES
	(1, 'BRG01', 'Barang nomor satu', 'Barang nomor satu lorem ipsum dolor sit amet', '34 cm x 22 cm x 44 cm', '2 kg', '', '', 'y', '2020-09-25 21:13:44'),
	(2, 'BRG02', 'Barang nomor DUA', 'Barang nomor DUA lorem ipsum', '20cm x 60cm x 10cm', '2,5 kg', '', '', 'y', '2020-09-25 21:14:36'),
	(3, 'BRG03', 'Barang nomor 03', 'Barang nomor 03 foo bar baz lorem ipsum', '50cm x 10cm x 10cm', '1kg', '', '', 'y', '2020-09-25 21:49:32'),
	(4, 'BRG04', 'Barang Nomor Empat', 'Barang Nomor Empat dari sekian banyak barang', '32cm x 25cm x 20cm ', '260 gram', '', '', 'y', '2020-10-24 14:49:33'),
	(12, 'BRG05', 'Barang nomor lima', 'Barang nomor lima lorem ipsum dolor', '32cm x 25cm x 20cm', '260 gram', 'BRG05_skema.jpg', 'BRG05_gambar.jpg', 'y', '2020-11-03 20:50:32');
/*!40000 ALTER TABLE `r_barang` ENABLE KEYS */;

-- Dumping structure for table dbsedia.r_lokasi
DROP TABLE IF EXISTS `r_lokasi`;
CREATE TABLE IF NOT EXISTS `r_lokasi` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `nm_lokasi` varchar(100) DEFAULT NULL,
  `ket_lokasi` varchar(255) DEFAULT NULL,
  `aktif` enum('y','n') DEFAULT 'y',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table dbsedia.r_lokasi: ~2 rows (approximately)
DELETE FROM `r_lokasi`;
/*!40000 ALTER TABLE `r_lokasi` DISABLE KEYS */;
INSERT INTO `r_lokasi` (`id`, `nm_lokasi`, `ket_lokasi`, `aktif`, `created_at`) VALUES
	(1, 'Rak 1', NULL, 'y', '2020-09-25 21:11:33'),
	(2, 'Rak 2', NULL, 'y', '2020-09-25 21:11:37'),
	(3, 'Rak 3', NULL, 'y', '2020-09-25 21:11:41');
/*!40000 ALTER TABLE `r_lokasi` ENABLE KEYS */;

-- Dumping structure for table dbsedia.r_simpan
DROP TABLE IF EXISTS `r_simpan`;
CREATE TABLE IF NOT EXISTS `r_simpan` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `kd_barang` varchar(12) DEFAULT NULL,
  `kd_lokasi` smallint(4) DEFAULT NULL,
  `ket_simpan` varchar(255) DEFAULT NULL,
  `aktif` enum('y','n') DEFAULT 'y',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table dbsedia.r_simpan: ~2 rows (approximately)
DELETE FROM `r_simpan`;
/*!40000 ALTER TABLE `r_simpan` DISABLE KEYS */;
INSERT INTO `r_simpan` (`id`, `kd_barang`, `kd_lokasi`, `ket_simpan`, `aktif`, `created_at`) VALUES
	(1, 'BRG01', 1, 'baris atas', 'y', '2020-09-25 21:35:32'),
	(2, 'BRG02', 2, 'baris tengah', 'y', '2020-09-25 21:51:41'),
	(3, 'BRG04', 3, 'rak nomor tiga baris atas', 'y', '2020-10-24 14:50:49');
/*!40000 ALTER TABLE `r_simpan` ENABLE KEYS */;

-- Dumping structure for table dbsedia.r_user
DROP TABLE IF EXISTS `r_user`;
CREATE TABLE IF NOT EXISTS `r_user` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `kd_level` varchar(2) DEFAULT NULL,
  `aktif` enum('y','n') DEFAULT 'y',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table dbsedia.r_user: ~2 rows (approximately)
DELETE FROM `r_user`;
/*!40000 ALTER TABLE `r_user` DISABLE KEYS */;
INSERT INTO `r_user` (`id`, `username`, `password`, `kd_level`, `aktif`, `created_at`) VALUES
	(1, 'admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', '00', 'y', '2020-09-27 12:53:03'),
	(2, 'spv', 'e360a9b5d44b33f1f12e90c306936383d5f9430d', '01', 'y', '2020-09-27 12:54:20'),
	(3, 'opr', '5399d7955b0fecd7659555f7b47b71ef4fefa119', '02', 'y', '2020-09-27 12:54:29');
/*!40000 ALTER TABLE `r_user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
