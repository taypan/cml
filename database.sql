-- phpMyAdmin SQL Dump
-- version 3.2.5deb2
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Středa 17. února 2010, 22:00
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Vypisuji data pro tabulku `items`
--

INSERT INTO `items` (`id`, `cat`, `subcat`, `nazev`, `popis`, `cena`, `dostupnost`, `rozmery`) VALUES
(53, 'doplnkyahracky', '', 'sdf', 'sdf', 543, 1, 'sdf'),
(77, 'doplnkyahracky', '', 'Nazevsdfs', 'asdfsd', 4123, 1, 'sdf'),
(76, 'detskynabytek', '', 'sdf', 'sdf', 543, 1, 'sdf'),
(75, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(74, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(73, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(72, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(71, 'stoly', 'jidelni', 'sdf', 'sdf', 543, 1, 'sdf'),
(69, 'stoly', 'jidelni', 'Nazevsdfs', 'asdfsd', 4123, 1, 'sdf'),
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
(88, 'stoly', 'jidelni', 'Nazevsdfs', 'asdfsd', 4123, 1, 'sdf');

-- --------------------------------------------------------

--
-- Struktura tabulky `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `menus`
--

INSERT INTO `menus` (`id`, `menu`, `title`) VALUES
(1, 'main', 'Hlavni menu'),
(2, 'Logged_in_menu', 'Prihlasen');

-- --------------------------------------------------------

--
-- Struktura tabulky `menus_items`
--

CREATE TABLE IF NOT EXISTS `menus_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alt` varchar(150) NOT NULL,
  `link` varchar(500) NOT NULL,
  `position` int(11) NOT NULL,
  `level` varchar(50) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `deny_for` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Vypisuji data pro tabulku `menus_items`
--

INSERT INTO `menus_items` (`id`, `alt`, `link`, `position`, `level`, `menu`, `deny_for`) VALUES
(1, 'Hlavni strana', 'index.php', 0, 'guest', 'main', ''),
(2, 'Registrace', 'index.php?page=Registrator', 2, 'guest', 'main', 'member'),
(3, 'Settings', 'index.php?page=Settings', 2, 'administrator', 'main', ''),
(7, 'OdhlÃ¡sit', 'logout.php', 2, 'member', 'Logged_in_menu', ''),
(35, 'Kdo jsme', 'http://localhost/index.php?page=Texty&action=show&text=kdojsme', 0, 'guest', 'main', ''),
(9, 'KoÅ¡Ã­k', 'index.php?page=Kosik', 10, 'guest', 'main', ''),
(17, 'Objednavky ', 'index.php?page=Admin_prehled', 2, 'administrator', 'main', ''),
(16, 'SprÃ¡va zboÅ¾Ã­', 'index.php?page=Zbozi_manager', 8, 'administrator', 'main', ''),
(34, 'Action', 'index.php?page=Tester&action=test', 56, 'superadmin', 'main', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `objednatele`
--

CREATE TABLE IF NOT EXISTS `objednatele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registrovan` enum('ano','ne') NOT NULL,
  `jmeno` varchar(100) NOT NULL,
  `prijmeni` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ulice` varchar(100) NOT NULL,
  `mesto` varchar(100) NOT NULL,
  `psc` int(11) NOT NULL,
  `tel_num` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Vypisuji data pro tabulku `objednatele`
--

INSERT INTO `objednatele` (`id`, `registrovan`, `jmeno`, `prijmeni`, `email`, `ulice`, `mesto`, `psc`, `tel_num`, `username`) VALUES
(1, 'ano', 'test1', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(2, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(3, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(4, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(5, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(6, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(7, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(8, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(9, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(10, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(11, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(12, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(13, 'ano', '', '', '', '', '', 0, '', 'jirka'),
(14, 'ano', '', '', '', '', '', 0, '', 'jirka'),
(15, 'ano', '', '', '', '', '', 0, '', 'jirka'),
(16, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(17, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(18, 'ano', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764', 'jirrik'),
(19, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(20, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(21, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(22, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(23, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(24, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(25, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(26, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(27, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(28, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(29, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(30, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(31, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(32, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(33, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(34, 'ne', 'jmeno', 'jkbdsf', 'mail@sdf.cz', 'ul', 'pra', 14300, '12321345646', ''),
(35, 'ne', 'sdf', 'sdf', 'sdf@sdf.cz', 'sdf', 'sdf', 13455, '2313123131213', ''),
(36, 'ne', 'sdf', 'sdf', 'sdf@sdf.cz', 'sdf', 'sdf', 13455, '2313123131213', ''),
(37, 'ne', 'sdf', 'sdf', 'sdf@sdf.cz', 'sdf', 'sdf', 13455, '2313123131213', ''),
(38, 'ano', '', '', '', '', '', 0, '', 'jirka'),
(39, 'ano', '', '', '', '', '', 0, '', 'jirka');

-- --------------------------------------------------------

--
-- Struktura tabulky `objednavky`
--

CREATE TABLE IF NOT EXISTS `objednavky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `objednatel` int(11) NOT NULL,
  `status` enum('nepotvrzeno','potvrzeno','zpracovani','pripraveno','zrealizovano') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Vypisuji data pro tabulku `objednavky`
--

INSERT INTO `objednavky` (`id`, `date`, `objednatel`, `status`) VALUES
(1, '0000-00-00 00:00:00', 8, 'nepotvrzeno'),
(2, '2009-12-19 13:44:58', 11, 'nepotvrzeno'),
(3, '2009-12-19 13:45:43', 12, 'nepotvrzeno'),
(4, '2009-12-19 14:16:59', 13, 'nepotvrzeno'),
(5, '2009-12-19 14:40:37', 14, 'nepotvrzeno'),
(6, '2009-12-19 14:42:30', 15, 'nepotvrzeno'),
(7, '2009-12-19 18:09:56', 16, 'nepotvrzeno'),
(8, '2009-12-19 18:12:18', 17, 'nepotvrzeno'),
(9, '2009-12-19 18:24:59', 18, 'potvrzeno'),
(10, '2009-12-19 18:43:57', 19, 'nepotvrzeno'),
(11, '2009-12-19 18:49:10', 20, 'nepotvrzeno'),
(12, '2009-12-19 18:52:07', 21, 'nepotvrzeno'),
(13, '2009-12-19 18:53:10', 22, 'nepotvrzeno'),
(14, '2009-12-19 18:54:12', 23, 'nepotvrzeno'),
(15, '2009-12-19 18:55:43', 24, 'nepotvrzeno'),
(16, '2009-12-19 18:57:30', 25, 'nepotvrzeno'),
(17, '2009-12-19 18:58:21', 26, 'nepotvrzeno'),
(18, '2009-12-19 19:00:06', 27, 'nepotvrzeno'),
(19, '2009-12-19 19:00:58', 28, 'nepotvrzeno'),
(20, '2009-12-19 19:01:17', 29, 'nepotvrzeno'),
(21, '2009-12-19 19:02:34', 30, 'nepotvrzeno'),
(22, '2009-12-19 19:02:51', 31, 'nepotvrzeno'),
(23, '2009-12-19 19:03:20', 32, 'nepotvrzeno'),
(24, '2009-12-19 19:04:18', 33, 'nepotvrzeno'),
(25, '2009-12-19 19:05:52', 34, 'potvrzeno'),
(26, '2009-12-19 19:07:15', 35, 'nepotvrzeno'),
(27, '2009-12-19 19:15:03', 36, 'nepotvrzeno'),
(28, '2009-12-19 19:19:33', 37, 'nepotvrzeno'),
(29, '2009-12-19 20:07:28', 38, 'nepotvrzeno'),
(30, '2009-12-28 14:26:10', 39, 'nepotvrzeno');

-- --------------------------------------------------------

--
-- Struktura tabulky `objednavky_polozky`
--

CREATE TABLE IF NOT EXISTS `objednavky_polozky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_obj` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `status` enum('zpracovani','pripraveno','zrealizovano') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Vypisuji data pro tabulku `objednavky_polozky`
--

INSERT INTO `objednavky_polozky` (`id`, `id_obj`, `id_item`, `status`) VALUES
(1, 1, 65, 'zpracovani'),
(2, 1, 53, 'zpracovani'),
(3, 1, 53, 'zpracovani'),
(4, 3, 53, 'zpracovani'),
(5, 3, 63, 'zpracovani'),
(6, 4, 53, 'zpracovani'),
(7, 4, 63, 'zpracovani'),
(8, 5, 53, 'zpracovani'),
(9, 5, 63, 'zpracovani'),
(10, 6, 53, 'zpracovani'),
(11, 6, 63, 'zpracovani'),
(12, 7, 53, 'zpracovani'),
(13, 7, 63, 'zpracovani'),
(14, 8, 53, 'zpracovani'),
(15, 8, 53, 'zpracovani'),
(16, 8, 53, 'zpracovani'),
(17, 8, 53, 'zpracovani'),
(18, 9, 64, 'zpracovani'),
(19, 9, 66, 'zpracovani'),
(20, 9, 67, 'zpracovani'),
(21, 10, 53, 'zpracovani'),
(22, 11, 53, 'zpracovani'),
(23, 12, 53, 'zpracovani'),
(24, 13, 53, 'zpracovani'),
(25, 14, 53, 'zpracovani'),
(26, 15, 53, 'zpracovani'),
(27, 16, 53, 'zpracovani'),
(28, 17, 53, 'zpracovani'),
(29, 18, 53, 'zpracovani'),
(30, 19, 53, 'zpracovani'),
(31, 20, 53, 'zpracovani'),
(32, 21, 53, 'zpracovani'),
(33, 22, 53, 'zpracovani'),
(34, 23, 53, 'zpracovani'),
(35, 24, 53, 'zpracovani'),
(36, 25, 53, 'zpracovani'),
(37, 26, 53, 'zpracovani'),
(38, 26, 63, 'zpracovani'),
(39, 27, 53, 'zpracovani'),
(40, 27, 63, 'zpracovani'),
(41, 28, 53, 'zpracovani'),
(42, 29, 53, 'zpracovani'),
(43, 29, 63, 'zpracovani'),
(44, 29, 64, 'zpracovani'),
(45, 29, 65, 'zpracovani'),
(46, 29, 66, 'zpracovani'),
(47, 30, 64, 'zpracovani'),
(48, 30, 67, 'zpracovani'),
(49, 30, 69, 'zpracovani'),
(50, 30, 70, 'zpracovani'),
(51, 30, 53, 'zpracovani');

-- --------------------------------------------------------

--
-- Struktura tabulky `panels`
--

CREATE TABLE IF NOT EXISTS `panels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area` varchar(255) NOT NULL,
  `position` int(3) NOT NULL COMMENT 'hlavni panel musím mít nejvyšší prioritu!!(tzn. nejnizzsi position)',
  `modul` varchar(255) NOT NULL,
  `arguments` varchar(1024) NOT NULL,
  `level` varchar(30) NOT NULL,
  `deny_for` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `panels`
--

INSERT INTO `panels` (`id`, `area`, `position`, `modul`, `arguments`, `level`, `deny_for`) VALUES
(1, 'left', 1, 'Menu', 'menu=main', 'guest', ''),
(2, 'center', 0, 'General', '', 'guest', ''),
(3, 'left', 2, 'Login', 'menu=Logged_in_menu', 'guest', ''),
(4, 'left', 3, 'Kosik_panel', '', 'guest', ''),
(0, 'style', 3, 'Style', '', 'guest', ''),
(6, 'kosik', 3, 'Kosik_info', '', 'guest', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `atribut` varchar(255) NOT NULL,
  `value` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Vypisuji data pro tabulku `settings`
--

INSERT INTO `settings` (`id`, `atribut`, `value`) VALUES
(1, 'TEMPLATES_DIRECTORY', 'templates/'),
(2, 'CURRENT_TEMPLATE', 'Rukodilna'),
(3, 'MUDULES_DIRECTORY', 'modules/'),
(4, 'general_enabled_panels', 'Tester,Admin_prehled,Confirm,Objednat,Feeder,Zbozi_manager,Zbozi,Clanky,Settings,Enter,Menuator,Logout,Registrator,Kosik,Texty'),
(7, 'RAND1', '0-9vVFO-9w3ldNhue_-p'),
(6, 'DEFAULT_PAGE', 'Zbozi'),
(8, 'RAND2', '_KoV5017zK03E_9gyPGB'),
(9, 'RAND3', '1B6h_-VnRwWw107GFC-9'),
(10, 'RAND4', 'ph5j__-5I6dL6X0-_---'),
(11, 'MSG_BEGIN', '<h2>'),
(12, 'MSG_END', '</h2>'),
(13, 'levels', 'guest,member,administrator,superadmin'),
(14, 'support_mail', 'taypan@email.cz'),
(15, 'KOSIK_MAX_ITEMS_SHOWN', '3'),
(16, 'ITEMS_ON_PAGE', '6'),
(17, 'IMG_BIG_DIR', 'img/big/'),
(18, 'IMG_DIR', 'img/'),
(19, 'TMP_DIR', 'img/'),
(20, 'IMG_DIR_SMALL', 'img/sml/'),
(21, 'IMG_DIR_BIG', 'img/big/'),
(22, 'MODWIDTH_SML', '200'),
(23, 'MODWIDTH_BIG', '800'),
(24, 'NO_IMG', 'no_img.jpg'),
(25, 'POPIS_LENGHT', '50'),
(26, 'RAND_STRING_LENGHT', '10'),
(27, 'EMAIL_FROM_NAME', 'Jiri Muller'),
(28, 'EMAIL_FROM_ADDR', 'objednavky@omnique.cz'),
(29, 'SITE', 'localhost/'),
(30, 'HASH_START', '10'),
(31, 'HASH_LENGHT', '31'),
(35, 'mena', 'KÄ');

-- --------------------------------------------------------

--
-- Struktura tabulky `texty`
--

CREATE TABLE IF NOT EXISTS `texty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(100) NOT NULL,
  `text` blob NOT NULL,
  `nadpis` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `texty`
--

INSERT INTO `texty` (`id`, `jmeno`, `text`, `nadpis`) VALUES
(1, 'kdojsme', 0x3c703e204c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e73656374657475722061646970697363696e6720656c69742e204e756c6c61207075727573206c616375732c20636f6e7365717561742073697420616d657420626c616e6469742061742c20626962656e64756d207669746165206c65637475732e2050656c6c656e7465737175652072686f6e6375732061726375206e6f6e20657261742074696e636964756e74207363656c657269737175652e2051756973717565206665726d656e74756d206665726d656e74756d206e756c6c612e20496e20696d7065726469657420636f6d6d6f646f206c61637573206574206d6f6c6c69732e20457469616d20696163756c69732064696374756d206469616d2073697420616d657420646170696275732e2053656420612073617069656e206e756c6c612e205574206e6563206e65717565206d61757269732c206469676e697373696d206f726e61726520656e696d2e20496e7465676572207363656c6572697371756520736f6c6c696369747564696e207072657469756d2e205072616573656e7420616363756d73616e207068617265747261206f726e6172652e20467573636520736f6c6c696369747564696e2c20707572757320612064696374756d206c6163696e69612c20656c69742073617069656e206d616c65737561646120646f6c6f722c20657420616c697175616d20647569206d6574757320756c747269636965732075726e612e2053757370656e6469737365206f726369206d617373612c20766f6c75747061742065676574207363656c6572697371756520766976657272612c2076697665727261206174206e6962682e2043726173206e6563206e657175652073697420616d6574206c6967756c6120616c697175616d20616c697175616d2e204d61757269732064696374756d20637572737573206f7263692e3c2f703e0a0a202020203c703e204c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e73656374657475722061646970697363696e6720656c69742e204e756c6c61207075727573206c616375732c20636f6e7365717561742073697420616d657420626c616e6469742061742c20626962656e64756d207669746165206c65637475732e2050656c6c656e7465737175652072686f6e6375732061726375206e6f6e20657261742074696e636964756e74207363656c657269737175652e2051756973717565206665726d656e74756d206665726d656e74756d206e756c6c612e20496e20696d7065726469657420636f6d6d6f646f206c61637573206574206d6f6c6c69732e20457469616d20696163756c69732064696374756d206469616d2073697420616d657420646170696275732e2053656420612073617069656e206e756c6c612e205574206e6563206e65717565206d61757269732c206469676e697373696d206f726e61726520656e696d2e20496e7465676572207363656c6572697371756520736f6c6c696369747564696e207072657469756d2e205072616573656e7420616363756d73616e207068617265747261206f726e6172652e20467573636520736f6c6c696369747564696e2c20707572757320612064696374756d206c6163696e69612c20656c69742073617069656e206d616c65737561646120646f6c6f722c20657420616c697175616d20647569206d6574757320756c747269636965732075726e612e2053757370656e6469737365206f726369206d617373612c20766f6c75747061742065676574207363656c6572697371756520766976657272612c2076697665727261206174206e6962682e2043726173206e6563206e657175652073697420616d6574206c6967756c6120616c697175616d20616c697175616d2e204d61757269732064696374756d20637572737573206f7263692e3c2f703e0a0a202020203c703e204c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e73656374657475722061646970697363696e6720656c69742e204e756c6c61207075727573206c616375732c20636f6e7365717561742073697420616d657420626c616e6469742061742c20626962656e64756d207669746165206c65637475732e2050656c6c656e7465737175652072686f6e6375732061726375206e6f6e20657261742074696e636964756e74207363656c657269737175652e2051756973717565206665726d656e74756d206665726d656e74756d206e756c6c612e20496e20696d7065726469657420636f6d6d6f646f206c61637573206574206d6f6c6c69732e20457469616d20696163756c69732064696374756d206469616d2073697420616d657420646170696275732e2053656420612073617069656e206e756c6c612e205574206e6563206e65717565206d61757269732c206469676e697373696d206f726e61726520656e696d2e20496e7465676572207363656c6572697371756520736f6c6c696369747564696e207072657469756d2e205072616573656e7420616363756d73616e207068617265747261206f726e6172652e20467573636520736f6c6c696369747564696e2c20707572757320612064696374756d206c6163696e69612c20656c69742073617069656e206d616c65737561646120646f6c6f722c20657420616c697175616d20647569206d6574757320756c747269636965732075726e612e2053757370656e6469737365206f726369206d617373612c20766f6c75747061742065676574207363656c6572697371756520766976657272612c2076697665727261206174206e6962682e2043726173206e6563206e657175652073697420616d6574206c6967756c6120616c697175616d20616c697175616d2e204d61757269732064696374756d20637572737573206f7263692e3c2f703e0a0a0a0a2020203c703e204c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e73656374657475722061646970697363696e6720656c69742e204e756c6c61207075727573206c616375732c20636f6e7365717561742073697420616d657420626c616e6469742061742c20626962656e64756d207669746165206c65637475732e2050656c6c656e7465737175652072686f6e6375732061726375206e6f6e20657261742074696e636964756e74207363656c657269737175652e2051756973717565206665726d656e74756d206665726d656e74756d206e756c6c612e20496e20696d7065726469657420636f6d6d6f646f206c61637573206574206d6f6c6c69732e20457469616d20696163756c69732064696374756d206469616d2073697420616d657420646170696275732e2053656420612073617069656e206e756c6c612e205574206e6563206e65717565206d61757269732c206469676e697373696d206f726e61726520656e696d2e20496e7465676572207363656c6572697371756520736f6c6c696369747564696e207072657469756d2e205072616573656e7420616363756d73616e207068617265747261206f726e6172652e20467573636520736f6c6c696369747564696e2c20707572757320612064696374756d206c6163696e69612c20656c69742073617069656e206d616c65737561646120646f6c6f722c20657420616c697175616d20647569206d6574757320756c747269636965732075726e612e2053757370656e6469737365206f726369206d617373612c20766f6c75747061742065676574207363656c6572697371756520766976657272612c2076697665727261206174206e6962682e2043726173206e6563206e657175652073697420616d6574206c6967756c6120616c697175616d20616c697175616d2e204d61757269732064696374756d20637572737573206f7263692e3c2f703e0a0a2020203c703e266e6273703b3c2f703e0a0a2020203c703e266e6273703b3c2f703e0a0a2020203c703e266e6273703b3c2f703e0a, 'Kdo jsme');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `ulice` varchar(100) NOT NULL,
  `mesto` varchar(50) NOT NULL,
  `psc` int(5) NOT NULL,
  `tel_num` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `group`, `username`, `password`, `jmeno`, `prijmeni`, `email`, `ulice`, `mesto`, `psc`, `tel_num`) VALUES
(1, 'superadmin', 'jirka', '248a4bbbfc114108840d5ac78ed4d3bbb74dec2815b275d811cd908c164838a8', '', '', '', '', '', 0, ''),
(13, 'member', 'bosss', '0379ae19f0781f96673cea395e6f5d78026f9f6c6d0b621ff5bb6ee5b5c5b6b3', '54', '2132', '5243@54.cz', '513', '561', 12345, '213122113213'),
(14, 'member', 'bossss', '0379ae19f0781f96673cea395e6f5d78026f9f6c6d0b621ff5bb6ee5b5c5b6b3', 'sdfsd', 'sdf', 'sdf@sdf.cz', 'sdfsd', 'sd', 12354, 'sssssssssssss'),
(15, 'member', 'jirik', '0379ae19f0781f96673cea395e6f5d78026f9f6c6d0b621ff5bb6ee5b5c5b6b3', 'djfhhj', 'hjfv', 'hj@djh.cz', 'hjgfhv', '1', 12345, 'dfnjkfbdfdfdff'),
(16, 'member', 'jirrik', '248a4bbbfc114108840d5ac78ed4d3bbb74dec2815b275d811cd908c164838a8', 'jmeno', 'prijmeni', 'email@email.cz', 'Mladen 3231', 'Praha 1253', 12345, '603219764');
