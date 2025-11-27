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

-- Dumping data for table esensia_apotek.cart: ~1 rows (approximately)
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table esensia_apotek.cart_products: ~13 rows (approximately)
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
	(23, 1, 2, '2025-11-27 20:11:20', '2025-11-27 22:11:16', 1, b'1'),
	(24, 2, 3, '2025-11-27 20:11:24', '2025-11-27 22:11:06', 1, b'0');
/*!40000 ALTER TABLE `cart_products` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.invoices
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `order_price` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `expiry_date` datetime NOT NULL,
  `payment_id` int(11) NOT NULL DEFAULT 0,
  `payment_method` varchar(100) DEFAULT '0',
  `other` varchar(200) DEFAULT '0',
  `is_paid` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.invoices: ~4 rows (approximately)
DELETE FROM `invoices`;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` (`id`, `order_id`, `order_price`, `created_at`, `expiry_date`, `payment_id`, `payment_method`, `other`, `is_paid`) VALUES
	(8, 25, 14426, '2025-11-16 20:11:51', '2025-11-17 20:53:51', 0, 'BRI Virtual Account', NULL, b'0'),
	(9, 26, 121236, '2025-11-17 21:11:18', '2025-11-18 21:10:18', 0, 'Bank BNI', NULL, b'0'),
	(10, 27, 44426, '2025-11-27 20:11:36', '2025-11-28 20:07:36', 0, 'BNI Virtual Account', NULL, b'0'),
	(11, 28, 134966, '2025-11-27 22:11:06', '2025-11-28 22:30:06', 0, 'BRI Virtual Account', NULL, b'0');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.log_activity
CREATE TABLE IF NOT EXISTS `log_activity` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table esensia_apotek.log_activity: ~11 rows (approximately)
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
	('284980ba-736a-43c2-b96a-d3c68b28ec17', '2', 'ahmad taufiqi admin mengubah data users [2]', '2025-11-19 21:58:15');
/*!40000 ALTER TABLE `log_activity` ENABLE KEYS */;

-- Dumping structure for table esensia_apotek.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('onchart','unpaid','processing','sending','shipped','completed') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `cost_price` int(11) DEFAULT NULL,
  `raw_cost_price` int(11) DEFAULT NULL,
  `ongkir` int(11) DEFAULT NULL,
  `jarak` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.orders: ~4 rows (approximately)
DELETE FROM `orders`;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `status`, `created_at`, `updated_at`, `created_by`, `customer_id`, `cost_price`, `raw_cost_price`, `ongkir`, `jarak`) VALUES
	(25, 'unpaid', '2025-11-16 20:11:51', '2025-11-16 20:11:51', NULL, 1, 93921, 150042, NULL, NULL),
	(26, 'shipped', '2025-11-23 21:11:18', '2025-11-17 21:11:18', NULL, 1, 106811, 138021, NULL, NULL),
	(27, 'unpaid', '2025-11-27 20:11:36', '2025-11-27 20:11:36', NULL, 1, 30000, 60000, NULL, NULL),
	(28, 'unpaid', '2025-11-27 22:11:06', '2025-11-27 22:11:06', NULL, 1, 120540, 123000, NULL, NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.order_products: ~6 rows (approximately)
DELETE FROM `order_products`;
/*!40000 ALTER TABLE `order_products` DISABLE KEYS */;
INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
	(45, 25, 1, 2, '2025-11-16 20:11:51', '2025-11-16 20:11:51'),
	(46, 25, 11, 1, '2025-11-16 20:11:51', '2025-11-16 20:11:51'),
	(47, 26, 1, 1, '2025-11-17 21:11:18', '2025-11-17 21:11:18'),
	(48, 26, 11, 2, '2025-11-17 21:11:18', '2025-11-17 21:11:18'),
	(49, 27, 1, 3, '2025-11-27 20:11:36', '2025-11-27 20:11:36'),
	(50, 28, 2, 3, '2025-11-27 22:11:06', '2025-11-27 22:11:06');
/*!40000 ALTER TABLE `order_products` ENABLE KEYS */;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.products: ~5 rows (approximately)
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `sku`, `price`, `is_discount`, `discount`, `image`, `description`, `category`, `created_at`, `stock`, `tipe`) VALUES
	(1, 'Tempra Anggur Sirup 60ml (per Botol) 60Ml Liter', 'TMPSY01', '20000', b'0', 50, 'pec1763484199.png', 'TEMPRA SIRUP merupakan obat untuk meredakan demam dan nyeri sakit kepala pada anak-anak. Sirup tempra paracetamol ini dapat menghambat pembentukan prostaglandin yang memicu nyeri dan juga bekerja pada pusat pengatur suhu di hipotalamus untuk menurunkan demam.', 3, '2025-11-18 23:11:19', 11, NULL),
	(2, 'Sanmol Forte 250mg/5ml Sirup 60ml (per Botol)', 'snm250', '41000', b'0', 2, 'chi1763974855.png', 'Sanmol Forte sirup diproduksi oleh PT. Sanbe Farma dan telah terdaftar pada BPOM. Pada setiap 5ml sirup Sanmol Forte mengandung 250mg paracetamol. Sanmol Forte dapat digunakan untuk meredakan nyeri seperti sakit kepala, sakit gigi, serta demam yang menyertai flu dan setelah imunisasi.', 5, '2025-11-19 21:11:54', 5, NULL),
	(9, 'Sanmol Forte 250mg/5ml Sirup 60ml (per Botol)', 'snm250', '41000', b'0', 0, '1759750699.png', 'Sanmol Forte sirup diproduksi oleh PT. Sanbe Farma dan telah terdaftar pada BPOM. Pada setiap 5ml sirup Sanmol Forte mengandung 250mg paracetamol. Sanmol Forte dapat digunakan untuk meredakan nyeri seperti sakit kepala, sakit gigi, serta demam yang menyertai flu dan setelah imunisasi.', 1, '2025-10-06 18:10:19', NULL, NULL),
	(10, 'Sanmol Forte 250mg/5ml Sirup 60ml (per Botol)', 'snm250', '41000', b'0', 2, 'sot1763974689.png', 'asdasdasdasd', 1, '2025-10-06 18:10:43', 200, NULL),
	(11, 'Sanmol Forte 260mg/5ml Sirup 70ml (per Botol)', 'snm250', '42000', b'0', 5, 'pec1763974903.png', 'asdasdasdasd', 1, '2025-10-06 18:10:43', 100, NULL);
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
  `updated_at` datetime DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `telp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table esensia_apotek.users: ~2 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `deleted_at`, `updated_at`, `foto`, `telp`) VALUES
	(1, 'ahmad taufiqis', 'ahmadtaufiky@gmail.com', '1234', 2, NULL, '2025-10-13 21:10:27', 'das1763040846.png', '087878878787'),
	(2, 'ahmad taufiqi admin', 'ahmadtaufiky1@gmail.com', '1234', 1, NULL, '2025-11-19 21:11:15', 'default.png', '089329392392');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
