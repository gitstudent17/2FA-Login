-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 11 apr 2025 om 21:06
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login2fa`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `2fa_secret` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `2fa_secret`) VALUES
(1, 'pim', '$2y$10$OtcFQcbuslvG..H/C1XJfePIGh5a1ShHUZUylG6DKp4gFZd/qvaaW', 'CGVEWDS2HD563YTE'),
(2, 'admin', '$2y$10$nP9mLKffvnyO0hHEoENeeeFTf358QkuEKBgz0o.c7VtfkwxkcBK9e', 'D7NAR4ZTONO3SWTJ'),
(4, 'mark', '$2y$10$taYJdooxW7hogEPfre5Yq.caNk3xlVl4VkRKE0flLP2R6qiFzda56', 'RLCLXI2ILGL2IGG5'),
(6, 'dani', '$2y$10$9iPFSXXtKl/9VMwEzy48QeK3.7LwpfK8xU7tSFiWNOc2Nmfg9yuUW', 'Q7JC3VVEGCV6MCUR'),
(7, 'Jan', '$2y$10$4cL6hdYbroDsB/ZxMBufw.OCHcbC/uu5UqTYCAy9cY.5a3r9IfFSK', '5UOMO7QVCYNDCT4Y');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
