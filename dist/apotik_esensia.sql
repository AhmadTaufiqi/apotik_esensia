-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table esensia_apotek.address
CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `negara` varchar(200) NOT NULL DEFAULT '',
  `provinsi` varchar(200) NOT NULL DEFAULT '',
  `kota` varchar(200) NOT NULL DEFAULT '',
  `kecamatan` varchar(200) NOT NULL DEFAULT '',
  `kelurahan` varchar(200) NOT NULL DEFAULT '',
  `catatan` varchar(200) NOT NULL DEFAULT '',
  `kode_pos` varchar(200) NOT NULL DEFAULT '',
  `long` varchar(200) NOT NULL DEFAULT '',
  `lat` varchar(200) NOT NULL DEFAULT '',
  `jalan` varchar(200) NOT NULL DEFAULT '',
  `jarak` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `address_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.address: ~1 rows (approximately)
DELETE FROM `address`;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` (`id`, `user_id`, `negara`, `provinsi`, `kota`, `kecamatan`, `kelurahan`, `catatan`, `kode_pos`, `long`, `lat`, `jalan`, `jarak`) VALUES
	(2, 1, 'Indonesia', 'Jawa Tengah', 'Semarang', 'Candisari', 'Jomblang', 'rumah warna pink', '50256', '110.43697357177736', '-7.0122247691904835', '', '7.2128000000000005');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qty` int(11) DEFAULT 0,
  `status` enum('onchart','unpaid','processing','shipped','completed') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table esensia_apotek.cart: ~2 rows (approximately)
DELETE FROM `cart`;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` (`id`, `qty`, `status`, `created_at`, `updated_at`, `created_by`, `customer_id`) VALUES
	(2, 1, NULL, '2025-10-20 20:10:39', '2025-10-20 20:10:39', 1, 1);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.cart_products
CREATE TABLE IF NOT EXISTS `cart_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table esensia_apotek.cart_products: ~15 rows (approximately)
DELETE FROM `cart_products`;
/*!40000 ALTER TABLE `cart_products` DISABLE KEYS */;
INSERT INTO `cart_products` (`id`, `product_id`, `qty`, `created_at`, `updated_at`, `customer_id`, `status`) VALUES
	(3, 2, 2, '2025-10-16 22:45:51', '2025-11-27 22:11:16', 1, b'0'),
	(5, 1, 3, '2025-10-20 22:10:56', '2025-11-27 22:11:16', 1, b'0'),
	(6, 1, 2, '2025-10-30 19:10:42', '2025-11-27 22:11:16', 1, b'0'),
	(15, 11, 3, '2025-11-02 21:11:33', '2025-11-27 22:11:16', 1, b'0'),
	(16, 11, 2, '2025-11-13 22:11:35', '2025-11-27 22:11:16', 1, b'0'),
	(17, 1, 1, '2025-11-15 23:11:11', '2025-11-27 22:11:16', 1, b'0'),
	(18, 1, 2, '2025-11-16 20:11:31', '2025-11-27 22:11:16', 1, b'0'),
	(19, 11, 1, '2025-11-16 20:11:33', '2025-11-27 22:11:16', 1, b'0'),
	(20, 1, 1, '2025-11-17 19:11:51', '2025-11-27 22:11:16', 1, b'0'),
	(21, 11, 2, '2025-11-17 19:11:52', '2025-11-27 22:11:16', 1, b'0'),
	(22, 1, 3, '2025-11-22 22:11:13', '2025-11-27 22:11:16', 1, b'0'),
	(23, 1, 3, '2025-11-27 20:11:20', '2025-11-27 22:11:16', 1, b'1'),
	(24, 2, 3, '2025-11-27 20:11:24', '2025-11-27 22:11:06', 1, b'0'),
	(25, 2, 5, '2025-11-30 19:11:14', '2025-11-30 19:11:14', 1, b'1'),
	(26, 10, 2, '2025-12-29 16:12:13', '2025-12-29 16:12:13', 1, b'1');
/*!40000 ALTER TABLE `cart_products` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.invoices
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `order_price` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `expired_at` datetime NOT NULL,
  `payment_id` int(11) NOT NULL DEFAULT 0,
  `payment_method` varchar(100) DEFAULT '0',
  `other` varchar(200) DEFAULT '0',
  `is_paid` bit(1) NOT NULL DEFAULT b'0',
  `payment_method_id` int(11) DEFAULT NULL,
  `bukti_transfer` varchar(250) DEFAULT NULL,
  `status` enum('confirm','reject','pending') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.invoices: ~4 rows (approximately)
DELETE FROM `invoices`;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` (`id`, `order_id`, `order_price`, `created_at`, `expired_at`, `payment_id`, `payment_method`, `other`, `is_paid`, `payment_method_id`, `bukti_transfer`, `status`) VALUES
	(8, 25, 14426, '2025-11-16 20:11:51', '2025-11-17 20:53:51', 0, 'BRI Virtual Account', NULL, b'0', NULL, NULL, NULL),
	(9, 26, 121236, '2025-11-17 21:11:18', '2025-11-18 21:10:18', 0, 'Bank BNI', NULL, b'0', NULL, NULL, NULL),
	(10, 27, 44426, '2025-11-27 20:11:36', '2025-11-28 20:07:36', 0, 'BNI Virtual Account', NULL, b'0', NULL, NULL, 'confirm'),
	(11, 28, 134966, '2026-01-01 22:11:06', '2026-01-03 22:11:06', 2, 'Qris', NULL, b'0', NULL, NULL, NULL);
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.log_activity
CREATE TABLE IF NOT EXISTS `log_activity` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table esensia_apotek.log_activity: ~21 rows (approximately)
DELETE FROM `log_activity`;
/*!40000 ALTER TABLE `log_activity` DISABLE KEYS */;
INSERT INTO `log_activity` (`id`, `user_id`, `activity`, `created_at`) VALUES
	('17bd572f-6e27-4f87-aed0-bf688c44eafd', '1', 'ahmad taufiqi mengubah data users [1]', '2025-10-12 22:27:05'),
	('feadead3-78e0-4545-8ddd-d5e8a9972528', '1', 'ahmad taufiqi mengubah data users [1]', '2025-10-12 22:42:11'),
	('2d9cb85e-1578-4986-b46d-f42f6cf52035', '1', 'ahmad taufiqi mengubah data users [1]', '2025-10-12 22:42:14'),
	('7dad54f8-dde9-4837-a711-e50a635dbd22', '1', 'ahmad taufiqi mengubah data users [1]', '2025-10-12 22:42:32'),
	('f635cfc9-91ff-411b-a780-47ccf5c0acf6', '1', 'test123 mengubah data users [1]', '2025-10-13 20:02:50'),
	('e7515378-1985-44ee-a8ea-5218bcb1f7ef', '1', 'test123 mengubah data users [1]', '2025-10-13 21:22:23'),
	('4042a7fb-7aad-44cf-8f7d-96ac15663663', '1', 'test123 mengubah data users [1]', '2025-10-13 21:44:27'),
	('0a3fb233-3674-445e-9923-b698ef51fe7c', '1', 'test123 mengubah data users [1]', '2025-10-13 21:44:41'),
	('06b6118e-154b-47b8-8029-8ffb107e172d', '1', 'test123 mengubah data users [1]', '2025-10-13 21:56:46'),
	('97904de6-8749-41e3-b4c4-d2f6b0288c99', '1', 'test123 mengubah data users [1]', '2025-10-13 21:59:27'),
	('284980ba-736a-43c2-b96a-d3c68b28ec17', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-11-19 21:58:15'),
	('3af60bf9-9553-467c-bc97-ccb7522934ab', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-12-02 21:57:41'),
	('e5e96378-9503-4c7a-be4f-dd424697c398', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-12-02 21:57:57'),
	('79585fac-6b92-44c1-8b42-bd2fe49ca585', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-12-02 21:59:22'),
	('74ec3a49-fd05-4be8-b5b5-e0f2c71ea59c', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-12-02 22:29:54'),
	('cbe379d7-a196-4767-8f86-3725ad2abe71', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-12-02 22:30:01'),
	('833e9466-51a1-4404-918d-04809ffc991f', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-12-02 22:42:13'),
	('b932a41d-d4ca-4f8e-9450-c9a20dae457e', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-12-02 22:42:17'),
	('96ba640b-dbad-4a84-9d2e-a42f61c462c9', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-12-02 22:42:18'),
	('f66fcae8-ecf6-4e6d-a46a-0b019e75949d', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-12-02 22:44:05'),
	('93c02ebd-2072-44a0-a55d-8a79bde0e517', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-12-03 19:04:15'),
	('58019988-6677-4096-ad50-c1b8bacea545', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-12-03 19:04:17');
/*!40000 ALTER TABLE `log_activity` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('unpaid','paid','payment accepted','processing','sending','shipped','completed','expired') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `cost_price` int(11) DEFAULT NULL,
  `raw_cost_price` int(11) DEFAULT NULL,
  `ongkir` int(11) DEFAULT NULL,
  `jarak` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.orders: ~3 rows (approximately)
DELETE FROM `orders`;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `status`, `created_at`, `updated_at`, `created_by`, `customer_id`, `cost_price`, `raw_cost_price`, `ongkir`, `jarak`) VALUES
	(26, 'processing', '2025-12-03 21:11:18', '2025-11-17 21:11:18', NULL, 1, 106811, 138021, NULL, NULL),
	(27, 'payment accepted', '2025-12-02 20:11:36', '2025-11-27 20:11:36', NULL, 1, 30000, 60000, NULL, NULL),
	(28, 'unpaid', '2026-01-01 22:11:06', '2026-01-01 22:11:06', NULL, 1, 120540, 123000, NULL, NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.order_products
CREATE TABLE IF NOT EXISTS `order_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.order_products: ~8 rows (approximately)
DELETE FROM `order_products`;
/*!40000 ALTER TABLE `order_products` DISABLE KEYS */;
INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
	(45, 25, 1, 2, '2025-11-16 20:11:51', '2025-11-16 20:11:51'),
	(46, 25, 11, 1, '2025-11-16 20:11:51', '2025-11-16 20:11:51'),
	(47, 26, 1, 1, '2025-11-17 21:11:18', '2025-11-17 21:11:18'),
	(48, 26, 11, 2, '2025-11-17 21:11:18', '2025-11-17 21:11:18'),
	(49, 27, 1, 3, '2025-11-27 20:11:36', '2025-11-27 20:11:36'),
	(50, 28, 2, 3, '2025-11-27 22:11:06', '2025-11-27 22:11:06'),
	(51, 30, 10, 3, '2025-12-29 16:12:08', '2025-12-29 16:12:08'),
	(52, 31, 10, 3, '2025-12-29 16:12:24', '2025-12-29 16:12:24');
/*!40000 ALTER TABLE `order_products` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.payment_method
CREATE TABLE IF NOT EXISTS `payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_code` varchar(50) DEFAULT NULL,
  `method_name` varchar(250) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `payment_id` varchar(250) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.payment_method: ~2 rows (approximately)
DELETE FROM `payment_method`;
/*!40000 ALTER TABLE `payment_method` DISABLE KEYS */;
INSERT INTO `payment_method` (`id`, `bank_code`, `method_name`, `image`, `payment_id`, `bank_name`) VALUES
	(1, '0', 'Transfer Danamon', 'danamon.png', '33901293923', 'Danamon'),
	(2, '0', 'Qris', 'qr_pay_example.png', '', 'Qris');
/*!40000 ALTER TABLE `payment_method` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `sku` varchar(150) NOT NULL DEFAULT '',
  `price` varchar(250) NOT NULL DEFAULT '',
  `is_discount` bit(1) NOT NULL DEFAULT b'0',
  `discount` int(11) NOT NULL DEFAULT 0,
  `image` text NOT NULL,
  `description` text NOT NULL,
  `category` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `tipe` varchar(150) DEFAULT NULL,
  `categories` varchar(100) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.products: ~87 rows (approximately)
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `sku`, `price`, `is_discount`, `discount`, `image`, `description`, `category`, `created_at`, `stock`, `tipe`, `categories`, `deleted_at`) VALUES
	(1, 'Tempra Anggur Sirup 60ml (per Botol) 60Ml Liter', 'TMPSY01', '20000', b'0', 50, 'pec1763484199.png', 'TEMPRA SIRUP merupakan obat untuk meredakan demam dan nyeri sakit kepala pada anak-anak. Sirup tempra paracetamol ini dapat menghambat pembentukan prostaglandin yang memicu nyeri dan juga bekerja pada pusat pengatur suhu di hipotalamus untuk menurunkan demam.', 3, '2025-11-18 23:11:19', 11, NULL, NULL, NULL),
	(2, 'Sanmol Forte 250mg/5ml Sirup 60ml (per Botol)', 'snm250', '41000', b'0', 2, 'chi1763974855.png', 'Sanmol Forte sirup diproduksi oleh PT. Sanbe Farma dan telah terdaftar pada BPOM. Pada setiap 5ml sirup Sanmol Forte mengandung 250mg paracetamol. Sanmol Forte dapat digunakan untuk meredakan nyeri seperti sakit kepala, sakit gigi, serta demam yang menyertai flu dan setelah imunisasi.', 5, '2025-11-19 21:11:54', 5, NULL, NULL, NULL),
	(9, 'Sanmol Forte 250mg/5ml Sirup 60ml (per Botol)', 'snm250', '41000', b'0', 0, '1759750699.png', 'Sanmol Forte sirup diproduksi oleh PT. Sanbe Farma dan telah terdaftar pada BPOM. Pada setiap 5ml sirup Sanmol Forte mengandung 250mg paracetamol. Sanmol Forte dapat digunakan untuk meredakan nyeri seperti sakit kepala, sakit gigi, serta demam yang menyertai flu dan setelah imunisasi.', 1, '2025-10-06 18:10:19', NULL, NULL, NULL, NULL),
	(10, 'Sanmol Forte 250mg/5ml Sirup 60ml (per Botol)', 'snm250', '41000', b'0', 2, 'sot1763974689.png', 'asdasdasdasd', 1, '2025-10-06 18:10:43', 200, NULL, '2', NULL),
	(11, 'Sanmol Forte 260mg/5ml Sirup 70ml (per Botol)', 'snm250', '42000', b'0', 5, 'pec1763974903.png', 'asdasdasdasd', 1, '2025-10-06 18:10:43', 100, NULL, NULL, NULL),
	(16, 'Tempra Anggur Paracetamol 2-6 Tahun 60ml', 'TMP009291', '20000', b'0', 10, 'tem1764398958.png', 'tempra paracetamol rasa anggur untuk anak 2-6 tahun 60ml', 4, '2025-11-29 13:11:18', 1000, NULL, '3,4', NULL),
	(17, 'Sgm Eksplor Gain Optigrow 1 Plus Vanila 400g Box (per Pcs)', 'SGME0132231', '54000', b'0', 5, 'sgm1764399370.png', 'SGM EKSPLOR GAIN OPTIGROW merupakan susu formula pertumbuhan khusus untuk anak usia 1 tahun ke atas. Secara khusus, susu ini dirancang untuk mendukung anak beresiko gagal tumbuh, gizi kurang ataupun gizi buruk.\r\n\r\n \r\n\r\nPENTING BUNDA KETAHUI\r\n\r\nSusu formula bayi bukan pengganti Air Susu Ibu (ASI). ASI Ekslusif diberikan sejak bayi lahir sampai usia 6 bulan dan dilanjutkan sampai dengan bayi berusia 2 tahun, ASI adalah makanan terbaik untuk bayi Anda.\r\n\r\n \r\n\r\nPenggunaan SGM Eksplor Gain Optigrow atas nasehat dokter, bidan dan perawat berdasarkan indikasi medis.', 2, '2025-11-29 13:11:10', 100, NULL, '2,4', NULL),
	(18, 'Sgm Eksplor Gain Optigrow 1 Plus Vanila 400g Box (per Pcs)', 'SGM001', '56000', b'0', 6, 'sgm1764407456.png', 'tes', 2, '2025-11-29 13:11:17', 5, NULL, NULL, NULL),
	(19, 'Sangobion 10 Kapsul', 'SNG002', '22000', b'0', 15, 'default_image.png', 'Suplemen zat besi dan vitamin penambah darah.', 0, '2026-01-01 12:01:04', 85, NULL, NULL, NULL),
	(20, 'Betadine Solution 30ml', 'BTD003', '35000', b'0', 10, 'default_image.png', 'Antiseptik luka luar untuk mencegah infeksi.', 0, '2026-01-01 12:01:04', 60, NULL, NULL, NULL),
	(21, 'Neurobion Forte 10 Tablet', 'NRB004', '48000', b'0', 20, 'default_image.png', 'Vitamin B kompleks dosis tinggi untuk saraf.', 0, '2026-01-01 12:01:04', 50, NULL, NULL, NULL),
	(22, 'Salonpas Koyo 10 Lembar', 'SLP005', '9000', b'0', 10, 'default_image.png', 'Meredakan nyeri otot dan pegal linu.', 0, '2026-01-01 12:01:04', 300, NULL, NULL, NULL),
	(23, 'CDR Effervescent 10 Tab', 'CDR006', '58000', b'0', 15, 'default_image.png', 'Kalsium untuk kekuatan tulang dan gigi.', 0, '2026-01-01 12:01:04', 45, NULL, NULL, NULL),
	(24, 'Hansaplast Kain Elastis', 'HNS007', '6000', b'0', 10, 'default_image.png', 'Plester pelindung luka yang elastis.', 0, '2026-01-01 12:01:04', 500, NULL, NULL, NULL),
	(25, 'Counterpain Cream 30gr', 'CTP008', '52000', b'0', 10, 'default_image.png', 'Gel pereda nyeri otot dan keseleo.', 0, '2026-01-01 12:01:04', 70, NULL, NULL, NULL),
	(26, 'Woods Peppermint Sirup 60ml', 'WDS009', '28500', b'0', 10, 'default_image.png', 'Obat batuk berdahak dengan rasa mint.', 0, '2026-01-01 12:01:04', 90, NULL, NULL, NULL),
	(27, 'Tolak Angin Cair 12 Sachet', 'TLA010', '45000', b'0', 10, 'default_image.png', 'Herbal untuk masuk angin dan daya tahan.', 0, '2026-01-01 12:01:04', 200, NULL, NULL, NULL),
	(28, 'Paracetamol 500mg GWS', 'PCM011', '5000', b'0', 0, 'default_image.png', 'Penurun demam dan nyeri ringan.', 0, '2026-01-01 12:01:04', 1000, NULL, NULL, NULL),
	(29, 'Sanmol Sirup 60ml', 'SNM012', '22000', b'0', 0, 'default_image.png', 'Paracetamol cair khusus anak dan bayi.', 0, '2026-01-01 12:01:04', 150, NULL, NULL, NULL),
	(30, 'Enervon C 30 Tablet', 'ENV013', '42000', b'0', 0, 'default_image.png', 'Suplemen harian Vitamin C dan B Kompleks.', 0, '2026-01-01 12:01:04', 120, NULL, NULL, NULL),
	(31, 'Bioplacenton Gel 15gr', 'BPC014', '33000', b'0', 0, 'default_image.png', 'Mengobati luka bakar dan mempercepat granulasi.', 0, '2026-01-01 12:01:04', 80, NULL, NULL, NULL),
	(32, 'Dettol Liquid 245ml', 'DTL015', '68000', b'0', 0, 'default_image.png', 'Cairan antiseptik pembunuh kuman multifungsi.', 0, '2026-01-01 12:01:04', 40, NULL, NULL, NULL),
	(33, 'My Baby Minyak Telon 60ml', 'MBB016', '23000', b'0', 0, 'default_image.png', 'Memberikan rasa hangat pada tubuh bayi.', 0, '2026-01-01 12:01:04', 150, NULL, NULL, NULL),
	(34, 'Diapet 4 Kapsul', 'DPT017', '6500', b'0', 0, 'default_image.png', 'Herbal efektif untuk menghentikan diare.', 0, '2026-01-01 12:01:04', 300, NULL, NULL, NULL),
	(35, 'Sutra Merah Isi 3', 'STR018', '13000', b'0', 0, 'default_image.png', 'Kondom dengan lubrikan khusus.', 0, '2026-01-01 12:01:04', 100, NULL, NULL, NULL),
	(36, 'Bodrex 10 Tablet', 'BDX019', '6000', b'0', 0, 'default_image.png', 'Meredakan sakit kepala dan sakit gigi.', 0, '2026-01-01 12:01:04', 400, NULL, NULL, NULL),
	(37, 'Kalpanax Salep 6gr', 'KLP020', '14000', b'0', 0, 'default_image.png', 'Mengatasi kutu air, panu, dan kadas.', 0, '2026-01-01 12:01:04', 110, NULL, NULL, NULL),
	(38, 'Stimuno Forte 10 Kapsul', 'STM021', '39000', b'0', 0, 'default_image.png', 'Menjaga sistem imun agar tetap kuat.', 0, '2026-01-01 12:01:04', 65, NULL, NULL, NULL),
	(39, 'Zwitsal Baby Powder 300gr', 'ZWT022', '32000', b'0', 0, 'default_image.png', 'Bedak tabur bayi aroma bunga lembut.', 0, '2026-01-01 12:01:04', 80, NULL, NULL, NULL),
	(40, 'Masker Sensi 3-Ply 50pcs', 'SNS023', '48000', b'0', 0, 'default_image.png', 'Masker medis pelindung debu dan bakteri.', 0, '2026-01-01 12:01:04', 50, NULL, NULL, NULL),
	(41, 'Antangin JRG Cair', 'ATG024', '3800', b'0', 0, 'default_image.png', 'Herbal hangat untuk mual dan kembung.', 0, '2026-01-01 12:01:04', 400, NULL, NULL, NULL),
	(42, 'Imboost Force 10 Tablet', 'IMB025', '78000', b'0', 0, 'default_image.png', 'Suplemen imun tubuh saat kondisi turun.', 0, '2026-01-01 12:01:04', 55, NULL, NULL, NULL),
	(43, 'OBH Combi Batuk Flu 100ml', 'OBH026', '26000', b'0', 0, 'default_image.png', 'Meredakan batuk berdahak dan pilek.', 0, '2026-01-01 12:01:04', 100, NULL, NULL, NULL),
	(44, 'Cetirizine 10mg', 'CTR027', '12000', b'0', 0, 'default_image.png', 'Obat antihistamin untuk gejala alergi.', 0, '2026-01-01 12:01:04', 250, NULL, NULL, NULL),
	(45, 'Tensimeter Digital Omron', 'OMR028', '680000', b'0', 0, 'default_image.png', 'Alat pengukur tekanan darah lengan atas.', 0, '2026-01-01 12:01:04', 15, NULL, NULL, NULL),
	(46, 'Sabun Lifebuoy Merah', 'LFB029', '6000', b'0', 0, 'default_image.png', 'Sabun mandi untuk perlindungan kuman harian.', 0, '2026-01-01 12:01:04', 200, NULL, NULL, NULL),
	(47, 'Johnson\'s Baby Oil 125ml', 'JNS030', '31000', b'0', 0, 'default_image.png', 'Menjaga kelembapan kulit bayi saat pijat.', 0, '2026-01-01 12:01:04', 45, NULL, NULL, NULL),
	(48, 'Redoxon Double Action', 'RDX031', '55000', b'0', 0, 'default_image.png', 'Vitamin C dan Zinc dosis tinggi.', 0, '2026-01-01 12:01:04', 70, NULL, NULL, NULL),
	(49, 'Voltaren Emulgel 10gr', 'VLT032', '63000', b'0', 0, 'default_image.png', 'Gel untuk peradangan sendi dan otot.', 0, '2026-01-01 12:01:04', 40, NULL, NULL, NULL),
	(50, 'Komix Rasa Jahe 1 Sachet', 'KMX033', '2500', b'0', 0, 'default_image.png', 'Obat batuk sachet praktis.', 0, '2026-01-01 12:01:04', 600, NULL, NULL, NULL),
	(51, 'Antis Hand Sanitizer 60ml', 'ATS034', '16000', b'0', 0, 'default_image.png', 'Pembersih tangan antiseptik non-bilas.', 0, '2026-01-01 12:01:04', 120, NULL, NULL, NULL),
	(52, 'Durex Together Isi 3', 'DRX035', '27000', b'0', 0, 'default_image.png', 'Kondom higienis dan nyaman dipakai.', 0, '2026-01-01 12:01:04', 60, NULL, NULL, NULL),
	(53, 'Polysilane Cair 100ml', 'PLS036', '35000', b'0', 0, 'default_image.png', 'Obat maag dan kembung rasa mint.', 0, '2026-01-01 12:01:04', 85, NULL, NULL, NULL),
	(54, 'Ponstan 500mg', 'PNS037', '45000', b'0', 0, 'default_image.png', 'Pereda nyeri intensitas sedang-berat.', 0, '2026-01-01 12:01:04', 180, NULL, NULL, NULL),
	(55, 'Promag 10 Tablet', 'PMG038', '9500', b'0', 0, 'default_image.png', 'Obat kunyah penawar asam lambung.', 0, '2026-01-01 12:01:04', 250, NULL, NULL, NULL),
	(56, 'Insto Regular 7.5ml', 'INS039', '17500', b'0', 0, 'default_image.png', 'Tetes mata untuk iritasi merah.', 0, '2026-01-01 12:01:04', 140, NULL, NULL, NULL),
	(57, 'Degirol 10 Tablet Hisap', 'DGR040', '15000', b'0', 0, 'default_image.png', 'Obat radang tenggorokan rasa jeruk.', 0, '2026-01-01 12:01:04', 190, NULL, NULL, NULL),
	(58, 'Listerine Cool Mint 250ml', 'LST041', '27000', b'0', 0, 'default_image.png', 'Cairan kumur pembunuh kuman mulut.', 0, '2026-01-01 12:01:04', 100, NULL, NULL, NULL),
	(59, 'Pampers Premium Care S32', 'PMP042', '88000', b'0', 0, 'default_image.png', 'Popok bayi dengan sirkulasi udara baik.', 0, '2026-01-01 12:01:04', 35, NULL, NULL, NULL),
	(60, 'Vicks Vaporub 25gr', 'VCK043', '24000', b'0', 0, 'default_image.png', 'Balsem pelega pernapasan saat flu.', 0, '2026-01-01 12:01:04', 120, NULL, NULL, NULL),
	(61, 'Madu TJ Murni 150gr', 'MTJ044', '29000', b'0', 0, 'default_image.png', 'Madu alami untuk stamina tubuh.', 0, '2026-01-01 12:01:04', 110, NULL, NULL, NULL),
	(62, 'Caretaker Hand Sanitizer 500ml', 'CRT045', '48000', b'0', 0, 'default_image.png', 'Antiseptik tangan kemasan isi ulang.', 0, '2026-01-01 12:01:04', 25, NULL, NULL, NULL),
	(63, 'Kondom Vivo Strawberry 3s', 'VVO046', '19500', b'0', 0, 'default_image.png', 'Kondom dengan aroma stroberi manis.', 0, '2026-01-01 12:01:04', 75, NULL, NULL, NULL),
	(64, 'Curcuma Plus Syrup 60ml', 'CRC047', '19500', b'0', 0, 'default_image.png', 'Vitamin untuk menambah nafsu makan anak.', 0, '2026-01-01 12:01:04', 80, NULL, NULL, NULL),
	(65, 'Blackmores Fish Oil 1000', 'BKM048', '98000', b'0', 0, 'default_image.png', 'Minyak ikan kaya Omega 3.', 0, '2026-01-01 12:01:04', 60, NULL, NULL, NULL),
	(66, 'Salonpas Liniment 30ml', 'SLN049', '22000', b'0', 0, 'default_image.png', 'Obat gosok untuk pegal linu cair.', 0, '2026-01-01 12:01:04', 90, NULL, NULL, NULL),
	(67, 'Thermometer Digital Gea', 'TRM050', '38000', b'0', 0, 'default_image.png', 'Pengukur suhu tubuh dengan akurasi digital.', 0, '2026-01-01 12:01:04', 40, NULL, NULL, NULL),
	(68, 'Amoxicillin 500mg', 'AMX051', '9000', b'0', 0, 'default_image.png', 'Antibiotik resep dokter (infeksi bakteri).', 0, '2026-01-01 12:01:04', 500, NULL, NULL, NULL),
	(69, 'Decolgen 4 Tablet', 'DCG052', '5000', b'0', 0, 'default_image.png', 'Obat flu, demam, dan bersin-bersin.', 0, '2026-01-01 12:01:04', 300, NULL, NULL, NULL),
	(70, 'Bisolvon Extra 60ml', 'BSL053', '58000', b'0', 0, 'default_image.png', 'Sirup obat batuk berdahak membandel.', 0, '2026-01-01 12:01:04', 65, NULL, NULL, NULL),
	(71, 'Bio Oil 60ml', 'BIO054', '138000', b'0', 0, 'default_image.png', 'Spesialis perawatan kulit bekas luka.', 0, '2026-01-01 12:01:04', 30, NULL, NULL, NULL),
	(72, 'Sebamed Baby Bath 200ml', 'SBM055', '148000', b'0', 0, 'default_image.png', 'Sabun bayi pH 5.5 untuk kulit sensitif.', 0, '2026-01-01 12:01:04', 20, NULL, NULL, NULL),
	(73, 'Hansaplast Salep Luka', 'HSL056', '19000', b'0', 0, 'default_image.png', 'Mempercepat penyembuhan luka terbuka.', 0, '2026-01-01 12:01:04', 100, NULL, NULL, NULL),
	(74, 'Pil Tuntas 10 Kaplet', 'PLT057', '19500', b'0', 0, 'default_image.png', 'Membantu siklus haid lebih teratur.', 0, '2026-01-01 12:01:04', 120, NULL, NULL, NULL),
	(75, 'Lifebuoy Handwash 200ml', 'LBH058', '16500', b'0', 0, 'default_image.png', 'Sabun cuci tangan anti bakteri.', 0, '2026-01-01 12:01:04', 150, NULL, NULL, NULL),
	(76, 'Test Pack Sensitif', 'TST059', '26000', b'0', 0, 'default_image.png', 'Alat uji kehamilan mandiri.', 0, '2026-01-01 12:01:04', 200, NULL, NULL, NULL),
	(77, 'Combantrin Jeruk 10ml', 'CBN060', '22500', b'0', 0, 'default_image.png', 'Obat cacing anak dengan rasa enak.', 0, '2026-01-01 12:01:04', 100, NULL, NULL, NULL),
	(78, 'Vicee 500mg 2 Tablet', 'VCE061', '2500', b'0', 0, 'default_image.png', 'Tablet hisap Vitamin C rasa buah.', 0, '2026-01-01 12:01:04', 800, NULL, NULL, NULL),
	(79, 'Ambeven 10 Kapsul', 'AMB062', '24000', b'0', 0, 'default_image.png', 'Herbal untuk wasir dan ambeien.', 0, '2026-01-01 12:01:04', 90, NULL, NULL, NULL),
	(80, 'Kasa Steril 16x16', 'KSA063', '8000', b'0', 0, 'default_image.png', 'Perban kasa steril untuk luka.', 0, '2026-01-01 12:01:04', 200, NULL, NULL, NULL),
	(81, 'Fresh Care Roll On', 'FRC064', '16000', b'0', 0, 'default_image.png', 'Minyak angin aromaterapi menyegarkan.', 0, '2026-01-01 12:01:04', 300, NULL, NULL, NULL),
	(82, 'Molto Baby Softener', 'MLT065', '34000', b'0', 0, 'default_image.png', 'Pelembut pakaian bayi aman di kulit.', 0, '2026-01-01 12:01:04', 50, NULL, NULL, NULL),
	(83, 'Pepsodent White 190g', 'PPS066', '19500', b'0', 0, 'default_image.png', 'Pasta gigi untuk gigi putih dan sehat.', 0, '2026-01-01 12:01:04', 180, NULL, NULL, NULL),
	(84, 'Masker Duckbill 10s', 'DKB067', '18000', b'0', 0, 'default_image.png', 'Masker pelindung wajah ergonomis.', 0, '2026-01-01 12:01:04', 150, NULL, NULL, NULL),
	(85, 'Fiesta Delay 3s', 'FST068', '27000', b'0', 0, 'default_image.png', 'Kondom durasi lebih lama.', 0, '2026-01-01 12:01:04', 80, NULL, NULL, NULL),
	(86, 'Loperamide 2mg', 'LPR069', '5000', b'0', 0, 'default_image.png', 'Obat diare akut (non-herbal).', 0, '2026-01-01 12:01:04', 200, NULL, NULL, NULL),
	(87, 'Siladex Cough & Cold', 'SLD070', '22000', b'0', 0, 'default_image.png', 'Sirup batuk tidak berdahak.', 0, '2026-01-01 12:01:04', 95, NULL, NULL, NULL),
	(88, 'Canesten Cream 5gr', 'CNS071', '48000', b'0', 0, 'default_image.png', 'Salep jamur kulit sangat efektif.', 0, '2026-01-01 12:01:04', 60, NULL, NULL, NULL),
	(89, 'Betadine Mouthwash 190ml', 'BTM072', '47000', b'0', 0, 'default_image.png', 'Kumur antiseptik tenggorokan.', 0, '2026-01-01 12:01:04', 45, NULL, NULL, NULL),
	(90, 'Cussons Baby Wipes 50s', 'CSW073', '21000', b'0', 0, 'default_image.png', 'Tisu basah bayi tanpa alkohol.', 0, '2026-01-01 12:01:04', 120, NULL, NULL, NULL),
	(91, 'Fatigon Spirit 6 Cap', 'FTG074', '8000', b'0', 0, 'default_image.png', 'Penambah energi dan stamina.', 0, '2026-01-01 12:01:04', 250, NULL, NULL, NULL),
	(92, 'Minyak Kayu Putih Cap Lang 60ml', 'MKP075', '28000', b'0', 0, 'default_image.png', 'Minyak kayu putih murni hangat.', 0, '2026-01-01 12:01:04', 180, NULL, NULL, NULL),
	(93, 'Handscoon Sensi L', 'HND076', '95000', b'0', 0, 'default_image.png', 'Sarung tangan medis latex.', 0, '2026-01-01 12:01:04', 30, NULL, NULL, NULL),
	(94, 'Sensodyne Repair & Protect', 'SND077', '45000', b'0', 0, 'default_image.png', 'Pasta gigi untuk gigi sensitif.', 0, '2026-01-01 12:01:04', 70, NULL, NULL, NULL),
	(95, 'Carefree Pantyliners 20s', 'CFR078', '15000', b'0', 0, 'default_image.png', 'Pantyliner harian wanita.', 0, '2026-01-01 12:01:04', 100, NULL, NULL, NULL),
	(96, 'Durex Invisible 2s', 'DRX079', '35000', b'0', 0, 'default_image.png', 'Kondom tertipis dari Durex.', 0, '2026-01-01 12:01:04', 40, NULL, NULL, NULL),
	(97, 'Betadine Salep Luka 5gr', 'BSL080', '18000', b'0', 0, 'default_image.png', 'Salep antiseptik untuk luka kecil.', 0, '2026-01-01 12:01:04', 90, NULL, NULL, NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.product_category
CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(150) DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `is_discount` bit(1) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.product_category: ~5 rows (approximately)
DELETE FROM `product_category`;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` (`id`, `category`, `icon`, `is_discount`, `discount`, `created_at`, `updated_at`) VALUES
	(1, 'vitamin', 'ico1763975020.png', NULL, NULL, '2025-11-17 22:11:31', '2025-11-24 16:11:40'),
	(2, 'susu', NULL, NULL, NULL, '2025-10-06 19:45:32', NULL),
	(3, 'alat kesehatan', 'ala1763975160.png', NULL, NULL, '2025-10-06 13:45:33', '2025-11-24 16:11:07'),
	(4, 'pereda nyeri', 'ico1763975050.png', NULL, NULL, '2025-10-14 22:10:57', '2025-11-24 16:11:10'),
	(5, 'test category', 'vak1763975222.png', NULL, NULL, '2025-11-17 23:11:20', '2025-11-24 16:11:02');
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `role` tinyint(1) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `telp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.users: ~4 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `deleted_at`, `created_at`, `updated_at`, `foto`, `telp`) VALUES
	(1, 'ahmad taufiqis', 'ahmadtaufiky@gmail.com', '1234', 2, NULL, '2025-12-03 22:09:36', '2025-10-13 21:10:27', 'das1763040846.png', '0878723873872'),
	(2, 'ahmad taufiqi admin', 'ahmadtaufiky1@gmail.com', '1234', 1, NULL, '2025-12-02 22:09:46', '2025-12-03 19:12:17', 'tem1764690245.png', '0893293923921'),
	(3, 'user kasir', 'adminkasir@gmail.com', '1234', 3, NULL, '2025-12-01 22:09:36', '2025-10-13 21:10:27', 'das1763040846.png', '0878723873872'),
	(4, 'user kuir', 'adminkurir@gmail.com', '1234', 4, NULL, '2025-12-01 22:09:36', '2025-10-13 21:10:27', 'das1763040846.png', '0878723873872');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
