-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Bulan Mei 2023 pada 18.21
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warehouse`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `item`
--

CREATE TABLE `item` (
  `id_product` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `id_supplier` int(8) NOT NULL,
  `date` date NOT NULL,
  `product_qty` int(8) NOT NULL,
  `product_price` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `item`
--

INSERT INTO `item` (`id_product`, `product_name`, `id_supplier`, `date`, `product_qty`, `product_price`) VALUES
(15, 'Sirup ABC', 1, '2023-04-15', 50, 120000),
(16, 'Indomilk 125ml', 1, '2023-04-20', 25, 150000),
(17, 'Mizone', 7, '2023-04-24', 50, 120000),
(18, 'Aqua', 0, '2023-04-24', 50, 250000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_in`
--

CREATE TABLE `transaction_in` (
  `id_transaction_in` int(30) NOT NULL,
  `id_supplier` int(30) NOT NULL,
  `id_product` int(30) NOT NULL,
  `quantity_in` int(30) NOT NULL,
  `transaction_in_date` date NOT NULL,
  `description_in` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaction_in`
--

INSERT INTO `transaction_in` (`id_transaction_in`, `id_supplier`, `id_product`, `quantity_in`, `transaction_in_date`, `description_in`) VALUES
(8, 1, 16, 120, '2023-04-13', 'product in'),
(13, 1, 15, 14, '2023-04-18', 'Transit before outbound '),
(15, 8, 18, 120, '2023-04-01', 'Transit before outbound'),
(16, 7, 17, 25, '2023-04-08', 'Transit before outbound');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_out`
--

CREATE TABLE `transaction_out` (
  `id_transaction_out` int(30) NOT NULL,
  `id_supplier` int(30) NOT NULL,
  `id_product` int(30) NOT NULL,
  `quantity_out` int(11) NOT NULL,
  `transaction_out_date` date NOT NULL,
  `description_out` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaction_out`
--

INSERT INTO `transaction_out` (`id_transaction_out`, `id_supplier`, `id_product`, `quantity_out`, `transaction_out_date`, `description_out`) VALUES
(1, 1, 15, 12, '2023-04-23', 'outbond to jatiasih'),
(3, 5, 16, 23, '2023-04-22', 'outbond to Bekasi'),
(4, 7, 18, 20, '2023-04-25', 'outbond to Bekasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(8) NOT NULL,
  `user_type` varchar(8) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `user_type`, `address`, `phone`) VALUES
(1, 'Natta', '12', 'user', 'PT. Galaxy 1', '121212 4'),
(2, 'abi', '12', 'admin', 'PT. IndoGuna', '1212'),
(5, 'Gaby', '12', 'user', 'PT. GALATAMA SENTOSA', '0812'),
(7, 'andi', '-', 'user', 'PT. NUSA Expedisi', '08122'),
(8, 'Ananta', '-', 'user', 'PT. Jaya Sentosa', '0812');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_product`);

--
-- Indeks untuk tabel `transaction_in`
--
ALTER TABLE `transaction_in`
  ADD PRIMARY KEY (`id_transaction_in`);

--
-- Indeks untuk tabel `transaction_out`
--
ALTER TABLE `transaction_out`
  ADD PRIMARY KEY (`id_transaction_out`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `item`
--
ALTER TABLE `item`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `transaction_in`
--
ALTER TABLE `transaction_in`
  MODIFY `id_transaction_in` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `transaction_out`
--
ALTER TABLE `transaction_out`
  MODIFY `id_transaction_out` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
