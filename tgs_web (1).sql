-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jun 2024 pada 05.50
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tgs_web`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `tipe_pengunjung` varchar(20) NOT NULL,
  `prambanan_dewasa` int(11) NOT NULL,
  `prambanan_anak` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `id_users`, `tanggal`, `tipe_pengunjung`, `prambanan_dewasa`, `prambanan_anak`, `subtotal`, `metode_pembayaran`) VALUES
(7, 11, '2024-06-13', 'domestik', 1, 1, '75000.00', NULL),
(14, 13, '2024-06-25', 'domestik', 1, 2, '100000.00', 'credit'),
(18, 13, '2024-06-29', 'domestik', 0, 1, '25000.00', 'ewallet'),
(19, 11, '2024-06-20', 'domestik', 2, 1, '125000.00', 'ewallet'),
(20, 13, '2024-06-22', 'mancanegara', 1, 0, '500000.00', 'ewallet'),
(21, 11, '2024-06-28', 'domestik', 1, 2, '100000.00', 'transfer'),
(22, 7, '2024-07-02', 'mancanegara', 1, 1, '750000.00', 'ewallet');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  `email` varchar(200) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `usia` int(11) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_users`, `nama`, `no_hp`, `email`, `jenis_kelamin`, `usia`, `password`) VALUES
(7, 'Sepatu', '08996621234', 'spt@gmail.com', 'Laki-laki', 30, '$2y$10$g8.AdRZqJ87D4i5s8zfxse2ddZb4jf0lPLE8hzIQkEWNpl9Eahq3a'),
(8, 'Sepeda', '089976543212', 'hai@gmail.com', 'Laki-laki', 22, '$2y$10$7y41DDeNmf1qgjVRY8SbW.GYzrm2OIFyaS4XZwhepylT9kSbjl82K'),
(9, 'Maria', '082106099841', 'maria@gmail.com', 'Perempuan', 20, '$2y$10$n6FDFJy4Fk99/T5HYwy4BeIsjhwm1T22h9awODeKAYuGKUZDJT1uG'),
(10, 'Alam', '089976543212', 'lxs@gmail.com', 'Laki-laki', 30, '$2y$10$NSNyjqZDActf26ZtYPIy5Oa2mkr6muuaxdcrJ64fD1O1pa.DFAytq'),
(11, 'Faiza Putri Hasna', '08996621267', 'kelompok@gmail.com', 'Perempuan', 18, '$2y$10$.i.nEPtJ6BVo7Ky/NdVLrOC2erJyChDH3j9w1vDw00kg3e3d2TrGG'),
(12, 'roziqin', '081234567', 'zikin123@gmail.com', 'Laki-laki', 17, '$2y$10$xiqAN8yKluvoR0AekjybWuSEZKRxfhg7OVMPGuum/4kSygAvUCkTS'),
(13, 'Malika', '09876543211', 'kedelai@gmail.com', 'Laki-laki', 25, '$2y$10$RXpb27VPWCJtNDdQ2DHIvOfR2aQdQVT2ut2X.1xsGF9bOVnaNVLpW');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
