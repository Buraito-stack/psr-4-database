-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 09 Agu 2024 pada 07.15
-- Versi server: 8.0.30
-- Versi PHP: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_intern`
--
CREATE DATABASE IF NOT EXISTS `demo_intern` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `demo_intern`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `brands`
--

CREATE TABLE `brands` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Panasinoc', '2024-08-09 07:14:42', '2024-08-09 07:14:42'),
(2, 'Syno', '2024-08-09 07:14:42', '2024-08-09 07:14:42'),
(3, 'SunFruit', '2024-08-09 07:14:42', '2024-08-09 07:14:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Fruit', '2024-08-09 07:14:42', '2024-08-09 07:14:42'),
(2, 'Cooking', '2024-08-09 07:14:42', '2024-08-09 07:14:42'),
(3, 'Electronic', '2024-08-09 07:14:42', '2024-08-09 07:14:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `brand_id` int DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Apple', 0.00, '2024-08-09 07:14:42', '2024-08-09 07:14:42'),
(2, 3, 2, 'TV', 0.00, '2024-08-09 07:14:42', '2024-08-09 07:14:42'),
(3, 2, 2, 'Electric Pan', 0.00, '2024-08-09 07:14:42', '2024-08-09 07:14:42'),
(4, 2, 2, 'Microwave', 0.00, '2024-08-09 07:14:42', '2024-08-09 07:14:42'),
(5, 3, 1, 'Radio', 0.00, '2024-08-09 07:14:42', '2024-08-09 07:14:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `product_id`, `product_name`, `price`, `qty`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 'Apple', 1000.00, 2, 2000, '2023-12-31 17:00:00', '2023-12-31 17:00:00'),
(2, 1, 'Apple', 1000.00, 5, 5000, '2024-01-14 17:00:00', '2024-01-14 17:00:00'),
(3, 1, 'Apple', 1000.00, 10, 10000, '2024-01-29 17:00:00', '2024-01-29 17:00:00'),
(4, 1, 'Apple', 1000.00, 3, 3000, '2024-02-04 17:00:00', '2024-02-04 17:00:00'),
(5, 1, 'Apple', 1000.00, 7, 7000, '2024-02-14 17:00:00', '2024-02-14 17:00:00'),
(6, 1, 'Apple', 1000.00, 6, 6000, '2024-02-24 17:00:00', '2024-02-24 17:00:00'),
(7, 1, 'Apple', 1000.00, 4, 4000, '2024-03-01 17:00:00', '2024-03-01 17:00:00'),
(8, 1, 'Apple', 1000.00, 8, 8000, '2024-03-11 17:00:00', '2024-03-11 17:00:00'),
(9, 1, 'Apple', 1000.00, 12, 12000, '2024-03-19 17:00:00', '2024-03-19 17:00:00'),
(10, 2, 'TV', 3000.00, 1, 3000, '2023-12-04 17:00:00', '2023-12-04 17:00:00'),
(11, 2, 'TV', 3000.00, 2, 6000, '2023-12-14 17:00:00', '2023-12-14 17:00:00'),
(12, 2, 'TV', 3000.00, 1, 3000, '2023-12-24 17:00:00', '2023-12-24 17:00:00'),
(13, 2, 'TV', 3000.00, 1, 3000, '2024-01-04 17:00:00', '2024-01-04 17:00:00'),
(14, 2, 'TV', 3000.00, 2, 6000, '2024-01-14 17:00:00', '2024-01-14 17:00:00'),
(15, 2, 'TV', 3000.00, 1, 3000, '2024-01-24 17:00:00', '2024-01-24 17:00:00'),
(16, 2, 'TV', 3000.00, 3, 9000, '2024-02-02 17:00:00', '2024-02-02 17:00:00'),
(17, 2, 'TV', 3000.00, 1, 3000, '2024-02-13 17:00:00', '2024-02-13 17:00:00'),
(18, 2, 'TV', 3000.00, 4, 12000, '2024-02-21 17:00:00', '2024-02-21 17:00:00'),
(19, 2, 'TV', 3000.00, 2, 6000, '2024-02-29 17:00:00', '2024-02-29 17:00:00'),
(20, 2, 'TV', 3000.00, 3, 9000, '2024-03-09 17:00:00', '2024-03-09 17:00:00'),
(21, 2, 'TV', 3000.00, 1, 3000, '2024-03-19 17:00:00', '2024-03-19 17:00:00'),
(22, 3, 'Electric Pan', 5000.00, 1, 5000, '2024-01-01 17:00:00', '2024-01-01 17:00:00'),
(23, 3, 'Electric Pan', 5000.00, 2, 10000, '2024-01-14 17:00:00', '2024-01-14 17:00:00'),
(24, 3, 'Electric Pan', 5000.00, 3, 15000, '2024-01-27 17:00:00', '2024-01-27 17:00:00'),
(25, 3, 'Electric Pan', 5000.00, 4, 20000, '2024-02-04 17:00:00', '2024-02-04 17:00:00'),
(26, 3, 'Electric Pan', 5000.00, 1, 5000, '2024-02-14 17:00:00', '2024-02-14 17:00:00'),
(27, 3, 'Electric Pan', 5000.00, 2, 10000, '2024-02-24 17:00:00', '2024-02-24 17:00:00'),
(28, 3, 'Electric Pan', 5000.00, 2, 10000, '2024-03-02 17:00:00', '2024-03-02 17:00:00'),
(29, 3, 'Electric Pan', 5000.00, 5, 25000, '2024-03-11 17:00:00', '2024-03-11 17:00:00'),
(30, 3, 'Electric Pan', 5000.00, 1, 5000, '2024-03-19 17:00:00', '2024-03-19 17:00:00'),
(31, 4, 'Microwave', 2000.00, 1, 2000, '2024-01-09 17:00:00', '2024-01-09 17:00:00'),
(32, 4, 'Microwave', 2000.00, 2, 4000, '2024-01-19 17:00:00', '2024-01-19 17:00:00'),
(33, 4, 'Microwave', 2000.00, 3, 6000, '2024-01-29 17:00:00', '2024-01-29 17:00:00'),
(34, 4, 'Microwave', 2000.00, 2, 4000, '2024-02-04 17:00:00', '2024-02-04 17:00:00'),
(35, 4, 'Microwave', 2000.00, 1, 2000, '2024-02-14 17:00:00', '2024-02-14 17:00:00'),
(36, 4, 'Microwave', 2000.00, 4, 8000, '2024-02-24 17:00:00', '2024-02-24 17:00:00'),
(37, 4, 'Microwave', 2000.00, 3, 6000, '2024-03-01 17:00:00', '2024-03-01 17:00:00'),
(38, 4, 'Microwave', 2000.00, 2, 4000, '2024-03-09 17:00:00', '2024-03-09 17:00:00'),
(39, 4, 'Microwave', 2000.00, 1, 2000, '2024-03-19 17:00:00', '2024-03-19 17:00:00'),
(40, 5, 'Radio', 1500.00, 2, 3000, '2024-01-02 17:00:00', '2024-01-02 17:00:00'),
(41, 5, 'Radio', 1500.00, 1, 1500, '2024-01-14 17:00:00', '2024-01-14 17:00:00'),
(42, 5, 'Radio', 1500.00, 3, 4500, '2024-01-27 17:00:00', '2024-01-27 17:00:00'),
(43, 5, 'Radio', 1500.00, 4, 6000, '2024-01-31 17:00:00', '2024-01-31 17:00:00'),
(44, 5, 'Radio', 1500.00, 2, 3000, '2024-02-11 17:00:00', '2024-02-11 17:00:00'),
(45, 5, 'Radio', 1500.00, 1, 1500, '2024-02-21 17:00:00', '2024-02-21 17:00:00'),
(46, 5, 'Radio', 1500.00, 3, 4500, '2024-03-04 17:00:00', '2024-03-04 17:00:00'),
(47, 5, 'Radio', 1500.00, 2, 3000, '2024-03-14 17:00:00', '2024-03-14 17:00:00'),
(48, 5, 'Radio', 1500.00, 4, 6000, '2024-03-24 17:00:00', '2024-03-24 17:00:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
