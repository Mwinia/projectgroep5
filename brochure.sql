-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 08 mei 2018 om 12:45
-- Serverversie: 10.1.24-MariaDB-cll-lve
-- PHP-versie: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u5329p19512_brochure`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `afstudeerjaar`
--

CREATE TABLE `afstudeerjaar` (
  `id` int(11) NOT NULL,
  `jaar` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `afstudeerjaar`
--

INSERT INTO `afstudeerjaar` (`id`, `jaar`) VALUES
(1, '2018'),
(2, '2019'),
(3, '2020'),
(4, '2021');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `brochure`
--

CREATE TABLE `brochure` (
  `id` int(11) NOT NULL,
  `pad` varchar(255) NOT NULL,
  `afkorting` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `brochure`
--

INSERT INTO `brochure` (`id`, `pad`, `afkorting`) VALUES
(1, './files/brochure_lkn.pdf', 'lkn'),
(3, './files/brochure_tb&ab.pdf', 'ta'),
(4, './files/brochure_boomverzorger.pdf', 'b'),
(5, './files/brochure_l&wm.pdf', 'w');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opleiding`
--

CREATE TABLE `opleiding` (
  `id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `opleiding`
--

INSERT INTO `opleiding` (`id`, `naam`) VALUES
(1, 'HAVO'),
(2, 'VWO'),
(3, 'MBO');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `voornaam` varchar(50) DEFAULT NULL,
  `tussenvoegsel` varchar(10) DEFAULT NULL,
  `achternaam` varchar(50) DEFAULT NULL,
  `emailadres` varchar(1024) DEFAULT NULL,
  `opleiding` int(11) DEFAULT NULL,
  `afstudeerjaar` int(11) DEFAULT NULL,
  `interesse` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `afstudeerjaar`
--
ALTER TABLE `afstudeerjaar`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `brochure`
--
ALTER TABLE `brochure`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `opleiding`
--
ALTER TABLE `opleiding`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `afstudeerjaar`
--
ALTER TABLE `afstudeerjaar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `brochure`
--
ALTER TABLE `brochure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `opleiding`
--
ALTER TABLE `opleiding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
