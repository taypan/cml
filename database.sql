-- phpMyAdmin SQL Dump
-- version 3.2.5deb2
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Pátek 26. února 2010, 23:11
-- Verze MySQL: 5.1.41
-- Verze PHP: 5.2.12-2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `cml`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat` varchar(50) NOT NULL,
  `subcat` varchar(100) NOT NULL,
  `nazev` varchar(100) NOT NULL,
  `popis` varchar(1024) NOT NULL,
  `cena` int(11) NOT NULL,
  `dostupnost` int(11) NOT NULL,
  `rozmery` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Vypisuji data pro tabulku `items`
--

INSERT INTO `items` (`id`, `cat`, `subcat`, `nazev`, `popis`, `cena`, `dostupnost`, `rozmery`) VALUES
(53, '0', '0', 'ÄŒaj', 'sdf', 543, 1, '55x55'),
(77, 'doplnkyahracky', '', 'Nazevsdfs', 'asdfsd', 4123, 1, 'sdf'),
(76, 'detskynabytek', '', 'sdf', 'sdf', 543, 1, 'sdf'),
(75, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(74, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(73, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(72, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(71, '0', '11', 'Loznice', 'sdf', 543, 1, 'sdf'),
(94, '6', '0', 'hracka', 'sdfsdf', 516, 1, '213'),
(78, 'stoly', 'konferencni', 'Nazevsdfs', 'asdfsd', 4123, 1, 'sdf'),
(79, 'stoly', 'konferencni', 'Nazevsdfs', 'asdfsd', 4123, 1, 'sdf'),
(80, 'stoly', 'konferencni', 'Nazevsdfs', 'asdfsd', 4123, 1, 'sdf'),
(81, 'stoly', 'konferencni', 'Nazevsdfs', 'asdfsd', 4123, 1, 'sdf'),
(82, 'stoly', 'konferencni', 'Nazevsdfs', 'asdfsd', 4123, 1, 'sdf'),
(83, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(84, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(85, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(86, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(87, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(88, 'stoly', 'jidelni', 'Nazevsdfs', 'asdfsd', 4123, 1, 'sdf'),
(89, 'xxx', '1', '1', 'xx', 56, 1, 'sdf'),
(90, 'xxx', '1', '1', 'xx', 56, 1, 'sdf'),
(91, 'novÃ¡', '2', '1', 'popis', 123, 1, 'roz'),
(92, 'nová', '2', '1', 'popis', 123, 1, 'roz'),
(93, '0', '0', 'novÃ¡cek', 'popis', 123, 1, 'roz');
