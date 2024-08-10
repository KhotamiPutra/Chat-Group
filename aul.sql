-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Bulan Mei 2024 pada 15.08
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aul`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `friends`
--

CREATE TABLE `friends` (
  `friend_id` int(11) NOT NULL,
  `user1_id` int(11) DEFAULT NULL,
  `user2_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `friends`
--

INSERT INTO `friends` (`friend_id`, `user1_id`, `user2_id`, `status`) VALUES
(2, 1, 3, NULL),
(3, 1, 5, NULL),
(4, 1, 2, NULL),
(5, 1, 4, NULL),
(6, 3, 5, NULL),
(7, 5, 2, NULL),
(8, 2, 2, NULL),
(9, 2, 3, NULL),
(10, 2, 4, NULL),
(11, 3, 4, NULL),
(12, 8, 2, NULL),
(13, 8, 5, NULL),
(14, 8, 1, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`) VALUES
(22, 'gepaowjpihafa'),
(23, 'test'),
(25, 'Pecinta aan android'),
(26, 'Keluarga pecinta alam');

-- --------------------------------------------------------

--
-- Struktur dari tabel `group_members`
--

CREATE TABLE `group_members` (
  `member_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `group_members`
--

INSERT INTO `group_members` (`member_id`, `user_id`, `group_id`, `role`) VALUES
(17, 1, 22, 'admin'),
(18, 4, 22, 'member'),
(19, 3, 22, 'member'),
(20, 3, 23, 'admin'),
(22, 2, 25, 'admin'),
(23, 5, 23, 'member'),
(24, 8, 26, 'admin'),
(25, 2, 26, 'member'),
(26, 1, 26, 'member');

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `messages`
--

INSERT INTO `messages` (`message_id`, `group_name`, `sender`, `message`, `timestamp`) VALUES
(1, 'test', 'Aulia69', 'halo', '2024-05-03 13:27:33'),
(2, 'test', 'Aulia69', 'susah banget', '2024-05-03 13:59:10'),
(3, 'Test grup 2', 'Aulia69', 'test', '2024-05-05 15:29:32'),
(4, 'Keluarga', 'Aulia69', 'hello world', '2024-05-05 15:29:42'),
(5, 'Test grup 3', 'Aulia69', 'test', '2024-05-08 20:24:51'),
(6, 'Test grup 2', 'Aulia69', 'lah', '2024-05-08 20:30:48'),
(7, 'test', 'Aulia69', 'test', '2024-05-08 21:00:43'),
(8, 'hese', 'Aulia69', 'adfyugcekcfgselahdgauiguigwiagdyadyuwdgagyidwdkauihl', '2024-05-08 21:01:13'),
(9, 'test', 'Wulan01', 'halooooowww', '2024-05-21 10:54:21'),
(10, 'test', 'Wulan01', 'asjgasyu', '2024-05-21 11:51:25'),
(11, 'apa coba', 'Wulan01', 'halloow', '2024-05-21 12:04:18'),
(12, 'gepaowjpihafa', 'Wulan01', 'haloo', '2024-05-21 12:05:28'),
(13, 'gepaowjpihafa', 'Aulia69', 'haloo', '2024-05-21 12:05:36'),
(14, 'test', 'Wulan01', 'test', '2024-05-21 12:06:53'),
(15, 'Keluarga pecinta alam', 'Aulia69', 'haiii', '2024-05-21 13:03:43'),
(16, 'Keluarga pecinta alam', 'aini123', 'haiii', '2024-05-21 13:03:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(1, 'Aulia69', 'Aulia_69'),
(2, 'Rima02', 'Rima_02'),
(3, 'Wulan01', 'Wulan01'),
(4, 'Dewi01', 'Dewi_01'),
(5, 'Eca09', 'Eca_09'),
(7, 'Krisna4', '123456'),
(8, 'aini123', 'aini123');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friend_id`),
  ADD KEY `user1_id` (`user1_id`),
  ADD KEY `user2_id` (`user2_id`);

--
-- Indeks untuk tabel `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indeks untuk tabel `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `friends`
--
ALTER TABLE `friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `group_members`
--
ALTER TABLE `group_members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `group_members_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
