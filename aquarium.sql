-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 06 mei 2016 om 13:39
-- Serverversie: 5.6.20
-- PHP-versie: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `aquafriendly`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `aquarium`
--

CREATE TABLE IF NOT EXISTS `aquarium` (
`id` int(11) NOT NULL,
  `climate` int(2) NOT NULL,
  `temp` int(2) NOT NULL,
  `color` varchar(20) NOT NULL,
  `co2` float NOT NULL,
  `nitrate` float NOT NULL,
  `ph` float NOT NULL,
  `food` int(2) NOT NULL,
  `manual` tinyint(1) NOT NULL,
  `manual_temp` int(2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden geëxporteerd voor tabel `aquarium`
--

INSERT INTO `aquarium` (`id`, `climate`, `temp`, `color`, `co2`, `nitrate`, `ph`, `food`, `manual`, `manual_temp`) VALUES
(1, 2, 20, 'red', 1, 0.4, 7.1, 80, 0, 22),
(2, 3, 29, 'red', 1, 0, 7, 50, 0, 0);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `aquarium`
--
ALTER TABLE `aquarium`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `aquarium`
--
ALTER TABLE `aquarium`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
