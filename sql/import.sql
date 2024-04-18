SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `pizzeria` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `pizzeria`;

CREATE TABLE `hirlevelesek` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

CREATE TABLE `rendelesek` (
  `id` int(11) NOT NULL,
  `nev` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefonszam` varchar(11) NOT NULL,
  `sz_cim` varchar(255) NOT NULL,
  `termekek` text NOT NULL COMMENT 'termeknev:db',
  `vegosszeg` int(11) NOT NULL,
  `rendeles_datuma` timestamp NOT NULL DEFAULT current_timestamp(),
  `fizetve` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

INSERT INTO `rendelesek` (`id`, `nev`, `email`, `telefonszam`, `sz_cim`, `termekek`, `vegosszeg`, `rendeles_datuma`, `fizetve`) VALUES
(25, 'Ifju Zalán', 'ifjuzalan@nonexistent-mail.com', '+3640520783', '8440, Herend, Utcanév, 10', 'Erdei:2;Sajtburger:1', 5050, '2024-04-04 07:28:08', 0),
(26, 'Ifju Zalán', 'ifjuzalan@nonexistent-mail.com', '+3640520782', '8440, Herend, Utcanév, 10', 'Főnix:4;Cappy multi:4', 9400, '2024-04-04 07:28:53', 1),
(27, 'Ifju Zalán', 'ifjuzalan@nonexistent-mail.com', '+3640520787', '', 'Csak hús gyros tál:1', 2600, '2024-04-04 07:29:19', 1),
(28, 'Kovács Attila Marcell', '2004attila2004@nonexistent-mail.com', '+3630808969', '8200, Veszprém, Utcanév 2/a', 'Carbonara spagetti:1;Csirke nuggets:4', 8000, '2024-04-04 07:32:34', 1),
(29, 'Kovács Attila Marcell', '2004attila2004@nonexistent-mail.com', '+3630808961', '8200, Veszprém, Utcanév 2/a', 'Rántott hagymakarikák:20', 10000, '2024-04-04 07:32:55', 0),
(30, 'Boros Renátó', 'keszpenzesautofelvasarlas@nonexistent-email.com', '+3670460893', '8446, Kislőd-Borsodpuszta, Utcanév, 9', 'Grill tál:1;Vegyes tál:1;Gyros tál:5', 23700, '2024-04-04 07:34:31', 1),
(31, 'Boros Renátó', 'keszpenzesautofelvasarlas@nonexistent-email.com', '+3670460894', '8446, Kislőd, Utcanév, 12', 'Sajtburger:3;Hasábburgonya:3;Ketchup:3', 7800, '2024-04-04 07:35:12', 1),
(32, 'Boros Renátó', 'keszpenzesautofelvasarlas@nonexistent-email.com', '+3670488973', '8445, Csehbánya, Utcanév, 2', 'Dínó csirkefalat:3;Csirke nuggets:3;Bundás tál:2', 20800, '2024-04-04 07:36:37', 0),
(33, 'Szekeres Nándor', 'sz.nandor123@nonexistent-mail.com', '+3670464992', '8445, Városlőd, Utcanév 6', 'Zöld saláta:1', 1400, '2024-04-04 07:37:39', 1),
(34, 'Szekeres Nándor', 'sz.nandor123@nonexistent-mail.com', '+3670464998', '8445, Városlőd, Utcanév 6', 'Vega tál:1', 5900, '2024-04-04 07:41:15', 0),
(35, 'Siklósi Dániel', 'gtabugatti524@nonexistent-mail.com', '+3630664587', '8200, Veszprém, Utcanév 43', 'Csirkeburger:5', 9250, '2024-04-04 07:46:43', 1),
(36, 'Siklósi Dániel', 'gtabugatti524@nonexistent-mail.com', '+3630808961', '8200, Veszprém, Utcanév 43', 'Rántott csirkemell:1;Rántott csirkeszárny:1', 3500, '2024-04-04 07:47:19', 1),
(37, 'Kiss Sándor', 'kiss.sandor@nonexistent-mail.com', '+3640123875', '8446, Kislőd, Utcanév, 7', 'Rántott gomba:1;Rizibizi:1;Majonéz:1', 2450, '2024-04-04 07:48:29', 1),
(38, 'Kiss Sándor', 'kiss.sandor@nonexistent-mail.com', '+3640123875', '8446, Kislőd, Utcanév, 7', 'Csak hús gyros tál:1;Tartármártás:1', 3000, '2024-04-04 07:49:24', 1),
(39, 'Vilmos Sándor', 'vsandor98@nonexistent-mail.com', '+3680123123', '8443, Bánd, Utcanév 6', 'Zöld saláta:1', 1400, '2024-04-04 07:50:58', 1),
(40, 'Vilmos Sándor', 'vsandor98@nonexistent-mail.com', '+3680123123', '8443, Bánd, Utcanév 6', 'Carbonara spagetti:1', 1800, '2024-04-04 07:51:33', 1),
(41, 'Vilmos Sándor', 'vsandor98@nonexistent-mail.com', '+3680123123', '8443, Bánd, Utcanév 6', 'Dínó csirkefalat:5', 7500, '2024-04-04 07:51:49', 1),
(42, 'Horváth Ákos', 'akossh@nonexistent-mail.com', '+3670456957', '8582, Farkasgyepű, Utcanév 1', 'Majonéz:1;Steak burgonya:1;Fűszeres burgonya:1;Hasábburgonya:1;Cordon Bleu :1;Natúr csirkemell:1;Rántott hagymakarikák:10', 10450, '2024-04-04 07:53:43', 1),
(43, 'Papp Ottó', 'otto.san@nonexistent-mail.com', '+3660151533', '8582, Farkasgyepű, Utcanév 4', 'Csirke nuggets:1;Ketchup:2;Pikáns:2', 2700, '2024-04-04 07:54:53', 0),
(44, 'Papp Ottó', 'otto.san@nonexistent-mail.com', '+3660151533', '8582, Farkasgyepű, Utcanév 4', 'Natúr csirkemell:1;Rizs:1', 2100, '2024-04-04 07:55:29', 1),
(45, 'Kovács Liza', 'lizakovacs456@nonexistent-mail.com', '+3670532997', '8500, Pápa, Utcanév 5/a', 'Bundás tál:1', 5900, '2024-04-04 07:56:51', 1),
(46, 'Kovács Liza', 'lizakovacs456@nonexistent-mail.com', '+3670532997', '8500, Pápa, Utcanév 5/a', 'Rántott csirkés saláta:1;Csirkés saláta:1;Tonhalas saláta:1;Zöld saláta:1', 7100, '2024-04-04 07:57:25', 0),
(47, 'Kiss Miklós', 'kissmiklos@nonexistent-mail.com', '+3670170173', '', 'Bolognai spagetti sertésbordával:2', 4200, '2024-04-04 07:58:45', 1),
(48, 'Kerekes Sándorr', 'krksndr@nonexistent-mail.comm', '+3670886471', '', 'Vega tál:1;Coca Cola:4', 7401, '2024-04-04 07:59:36', 1),
(49, 'Kövesi Kevin Valentin', 'kkvalentin@nonexistent-mail.com', '+3680156278', '', 'Retro burger:3', 5550, '2024-04-04 08:00:57', 0),
(50, 'Mátyás László', 'mtylaci@nonexistent-mail.com', '+3680778413', '', 'Cowboy:1;Gyros:1;Griff:1;Atlantisz:1', 7800, '2024-04-04 08:01:51', 1),
(51, 'Varga Péter', 'vpetixd@nonexistent-mail.com', '+3630515487', '8445, Városlőd, Utcanév 9', 'Szekér:1;Kőhegy:1;Bolognai:1;Erdei:1;Margherita:1', 9400, '2024-04-04 08:03:26', 1),
(54, 'Teszt Felhasználó', 'tmp_user@nonexistent-email.com', '+3670123456', '8200, Veszprém, Utcanév, Házszám', 'Baltazár:1;Démon:1', 4000, '2024-04-05 14:12:04', 1),
(59, 'Teszt Felhasználó', 'tmp_user@nonexistent-mail.com', '+3612345678', '8200, Veszprém, Utcanév, Házszám', 'Evőeszköz:1;Hell energiaital:1;Margherita:1', 2100, '2024-04-08 19:22:23', 1);

CREATE TABLE `termekek` (
  `id` int(11) NOT NULL,
  `termek_nev` varchar(255) NOT NULL,
  `termek_ar` int(10) NOT NULL,
  `termek_kategoria` varchar(255) NOT NULL,
  `termek_leiras` varchar(255) NOT NULL,
  `termek_kepurl` varchar(255) NOT NULL DEFAULT 'placeholder.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

INSERT INTO `termekek` (`id`, `termek_nev`, `termek_ar`, `termek_kategoria`, `termek_leiras`, `termek_kepurl`) VALUES
(1, 'Margherita', 1600, 'pizza', 'paradicsomos alap,sajt,paradicsom', 'margarita.png'),
(2, 'Erdei', 1600, 'pizza', 'paradicsomos alap,sajt,gomba', 'erdei.png'),
(3, 'Vega', 1700, 'pizza', 'paradicsomos alap, sajt, gomba, brokkoli, hagyma', 'vega.png'),
(4, 'Vega 2', 1850, 'pizza', 'tejfölös alap, sajt, paradicsom, gomba, brokkoli, kukorica', 'vega2.png'),
(5, 'Sonkás', 1700, 'pizza', 'paradicsomos alap, sajt, sonka', 'sonkas.png'),
(6, 'Leveld', 1750, 'pizza', 'paradicsomos alap, sajt, csemege szalámi, kukorica', 'leveld.png'),
(7, 'Pille', 1750, 'pizza', 'paradicsomos alap, sajt, sonka, kukorica', 'pille.png'),
(8, 'Hawaii', 1850, 'pizza', 'paradicsomos alap, sajt, sonka, ananász', 'hawaii.png'),
(9, 'Hölgykő', 1850, 'pizza', 'paradicsomos alap, sajt, sonka, gomba, kukorica', 'holgyko.png'),
(10, 'Főnix', 1850, 'pizza', 'paradicsomos alap, sajt, paprikás szalámi, pepperoni, lilahagyma, chili', 'fonix.png'),
(11, 'Gyros', 1950, 'pizza', 'tejfölös alap, gyros hús, lilahagyma, bacon', 'gyros.png'),
(12, 'Griff', 1950, 'pizza', 'tejfölös alap, sajt, csirke csíkok, kukorica, lilahagyma', 'griff.png'),
(13, 'Lehel', 1950, 'pizza', 'paradicsomos alap, sajt, paprikás szalámi, főtt tojás szeletek, jalapeno', 'lehel.png'),
(14, 'Atlantisz', 1950, 'pizza', 'paradicsomos alap, sajt, tenger gyümölcsei, olivabogyó', 'atlantis.png'),
(15, 'Ötsajtos', 2000, 'pizza', 'paradicsomos alap, feta, gouda, mozzarella, cheddar, füstölt sajt', 'otsajtos.png'),
(16, 'Sellő', 2000, 'pizza', 'paradicsomos alap, sajt, tonhal, lilahagyma, oliva', 'sello.png'),
(17, 'Kőhegy', 2000, 'pizza', 'mustáros-tejfölös alap, sajt, sült csülök, lilahagyma, kukorica, vörösbab', 'kohegy.png'),
(18, 'Zorba', 2000, 'pizza', 'paradicsomos alap, sajt, gyros hús, lilahagyma, fetasajt, oliva', 'zorba.png'),
(19, 'Cowboy', 1950, 'pizza', 'paradicsomos alap, sajt, sonka, gomba, kukorica, pepperoni, chili', 'cowboy.png'),
(20, 'Bolognai', 2100, 'pizza', 'paradicsomos alap, sajt, bolognai ragu', 'bolognai.png'),
(21, 'Szekér', 2100, 'pizza', 'paradicsomos alap, sajt, füstölt tarja, kolbász, bacon, színes paprika, lilahagyma', 'szeker.png'),
(22, 'Démon', 2100, 'pizza', 'paradicsomos alap, sajt, kolbász, füstölt tarja, bacon, gépsonka, lilahagyma', 'demon.png'),
(23, 'Baltazár', 1900, 'pizza', 'paradicsomos alap, sajt, tojásos lecsó, kolbász, lilahagyma', 'baltazar.png'),
(36, 'Vega burger', 1850, 'hamburger', 'grillsajt, saláta, paradicsom, uborka, szósz', 'vegaburger.png'),
(37, 'Sajtburger', 1850, 'hamburger', 'marhahús, saláta, hagyma, sajt, szósz', 'sajtburger.png'),
(38, 'Csirkeburger', 1850, 'hamburger', 'grill csirkemell, saláta, paradicsom, bacon, szósz', 'csirkeburger.png'),
(39, 'Retro burger', 1850, 'hamburger', 'marhahús, saláta, ketchup, majonéz, uborka, hagyma, szósz', 'retroburger.png'),
(40, 'Cordon Bleu ', 2100, 'frissensult', '', 'cordonbleu.png'),
(41, 'Natúr csirkemell', 1600, 'frissensult', '', 'naturcsirkemell.png'),
(42, 'Natúr sertésszelet', 1600, 'frissensult', '', 'natursertesszelet.png'),
(43, 'Rántott camembert', 1700, 'frissensult', '', 'rantottcamembert.png'),
(44, 'Rántott csirkemell', 1800, 'frissensult', '', 'rantottcsirkemell.png'),
(45, 'Rántott csirkeszárny', 1700, 'frissensult', '', 'rantottcsirkeszarny.png'),
(46, 'Rántott gomba', 1700, 'frissensult', '', 'rantottgomba.png'),
(47, 'Rántott hagymakarikák', 500, 'frissensult', '', 'rantotthagymakarikak.png'),
(48, 'Rántott karfiol', 1700, 'frissensult', '', 'rantottkarfiol.png'),
(49, 'Rántott sajt', 1700, 'frissensult', '', 'rantottsajt.png'),
(50, 'Rántott sertésszelet', 1600, 'frissensult', '', 'rantottsertesszelet.png'),
(51, 'Zöld saláta', 1400, 'salata', 'friss saláta, paradicsom, uborka, rukkola, joghurtos öntet', 'zold.png'),
(52, 'Csirkés saláta', 1800, 'salata', 'friss saláta, paradicsom, pirított csirkemell, feta sajt, uborka, joghurtos öntet', 'csirkes.png'),
(53, 'Rántott csirkés saláta', 2100, 'salata', 'jégsaláta, rántott csirkemell, színes paprika, uborka, kukorica, lilahagyma, joghurtos öntet', 'rantottcsirkes.png'),
(54, 'Tonhalas saláta', 1800, 'salata', 'friss saláta, tonhal, hagyma, uborka, olivabogyó, joghurtos öntet, paradicsom', 'tonhalas.png'),
(55, 'Bundás tál', 5900, 'tal', '2db rántott sertésborda, 2db rántott csirkemell, 1 db cordon bleu, rizs, fűszeres burgonya', 'bundastal_v2.png'),
(56, 'Grill tál', 6100, 'tal', '1db natúr fokhagymás sertésborda, 2db natúr csirkemell, 1db natúr csirkemell, 2db natúr sertésszelet sonkával, gombával és sajttal', 'grilltal.png'),
(57, 'Vegyes tál', 6100, 'tal', 'Rántott sertésszelet, rántott csirkemell, natúr fokhagymás sertésszelet, natúr csirkemell, cordonbleu, réntott hagymakarika, ráántott sajt, rizs, burgonya', 'vegyestal.png'),
(58, 'Vega tál', 5900, 'tal', '2db rántott sajt, 4db hagymakarika, 4db rántott gomba, 4db rántott karfiol,2db rántott camembert, rizs, fűszeres burgonya', 'vegatal.png'),
(59, 'Dínó csirkefalat', 1500, 'tal', 'Dínó formájú csirkefalatok, köretnek rizs, krumpli', 'dinocsirkek.png'),
(60, 'Csirke nuggets', 1500, 'tal', 'Csirkemellből készült, köretnek rizs, krumpli', 'nuggets.png'),
(61, 'Bolognai spagetti', 1800, 'teszta', '', 'bolognaispagetti.png'),
(62, 'Carbonara spagetti', 2000, 'teszta', '', 'carbonara.png'),
(63, 'Bolognai spagetti sertésbordával', 2100, 'teszta', '', 'bolognaisertesborda.png'),
(64, 'Gyros tál', 2300, 'gyrostal', 'Gyroshús, saláta, hasábburgonya, joghurtos öntet', 'gyrostal1.png'),
(65, 'Sajtos gyros tál', 2500, 'gyrostal', 'Gyroshús, saláta, hasábburgonya, joghurtos öntet, reszelt sajt', 'gyrostal2.png'),
(66, 'Csak hús gyros tál', 2600, 'gyrostal', 'Gyros hús, joghurtos öntet', 'csakhus.png'),
(67, 'Fűszeres burgonya', 500, 'koret', '', 'fuszeresburgonya.png'),
(68, 'Hasábburgonya', 500, 'koret', '', 'hasabburgonya.png'),
(69, 'Krokeett', 500, 'koret', '', 'krokett.png'),
(70, 'Steak burgonya', 500, 'koret', '', 'steakburgonya.png'),
(71, 'Kukoricás rizs', 500, 'koret', '', 'kukoricasrizs.png'),
(72, 'Rizibizi', 500, 'koret', '', 'rizibizi.png'),
(73, 'Rizs', 500, 'koret', '', 'rizs.png'),
(74, 'Színes paprika', 500, 'koret', '', 'szinespaprika.png'),
(75, 'Uborka', 500, 'koret', '', 'uborka.png'),
(76, 'Ketchup', 250, 'ontet', '', 'ketchup.png'),
(77, 'Majonéz', 250, 'ontet', '', 'majonez.png'),
(78, 'Olivás', 350, 'ontet', '', 'olivas.png'),
(79, 'Pikáns', 350, 'ontet', '', 'pikans.png'),
(80, 'Csípős', 350, 'ontet', '', 'csipos.png'),
(81, 'Áfonyás', 400, 'ontet', '', 'afonyas.png'),
(82, 'Tartármártás', 400, 'ontet', '', 'tartarmartas.png'),
(83, 'Cola', 500, 'udito', '', 'cola.png'),
(85, 'Gyümölcslé', 500, 'udito', '', 'gyumolcsle.png'),
(86, 'Classic energiaital', 300, 'udito', '', 'energiaital.png'),
(87, 'Ice tea', 500, 'udito', '', 'icetea.png'),
(88, 'Narancsos üdítő', 500, 'udito', '', 'narancsudito.png'),
(89, 'Evőeszköz', 200, 'extra', '', 'placeholder.png'),
(90, 'Elviteles doboz', 200, 'extra', '', 'placeholder.png'),
(96, 'Próba Pizza', 2000, 'pizza', ' ', 'placeholder.png');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(75) NOT NULL,
  `admin` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `admin`) VALUES
(1, 'admin', 'admin', 'admin@nonexistent.com', '$2y$10$46nRbzkerkZ0571I3YEIBeQ9EpWoxbze1onyogqprdGVZKaZK9c9O', 1),
(43, 'Hunor Soós', 'hunorsoos', 'hunorsoos@nonexistent-mail.com', '$2y$10$OPB9N0GsqBW21Yp1m649SOkjkWrykx4lIt0nyN90jmPml6.c7KE1y', 0),
(44, 'Vilmos Sándor', 'vlmsndr', 'vsandor98@nonexistent-mail.com', '$2y$10$0c.ut2hqdmKhE/6GGc/IZuiOgQGD93nu5aH4KR6eZD1yAb6GonYHC', 0),
(45, 'Horváth Ákos', 'akossh', 'akossh@nonexistent-mail.com', '$2y$10$iClo4XBcSZb3psmsS3e6VuaMe9ocG28gGfq34FnwyFAaTVWwujcKS', 0),
(46, 'Papp Ottó', 'papp0tt0', 'otto.san@nonexistent-mail.com', '$2y$10$aKwsr6Qz2Yv.mGtnZDVzIujnq7tnMg1Z5Qs3wuegV.YZHjQbntNK2', 0),
(47, 'Kovács Liza', 'lizakovacs456', 'lizakovacs456@nonexistent-mail.com', '$2y$10$wpUuNcyrtb5GUsf/8WxXpOIgad32bGN5kXcfO55q/YH1XCjj/4gnm', 0),
(48, 'Mátyás László', 'mtylaci', 'mtylaci@nonexistent-mail.com', '$2y$10$6t1FU/KO9tkwn9YYUNJsgO.x7SZKY6hdztSTnB4cgTVxx0OoV43IG', 0),
(49, 'Kelemen Kíra', 'kkira', 'kkira@nonexistent-mail.com', '$2y$10$qkYeuImjzqZ8Jvex0cXZhu9D3LxvL00JYVYMtpXvkGa8sIRzZYEbe', 0),
(50, 'Kiss Sándor', 'kysndr', 'kiss.sandor@nonexistent-mail.com', '$2y$10$Qjzpek0KrWc14pGELcNmDO6/WGWQCCuNY0rU0XIgXU3raIkWJFh/O', 0),
(51, 'Ifju Zalán', 'ifjuzalan', 'ifjuzalan@nonexistent-mail.com', '$2y$10$WWRUviKi.WbIaG4DN59nQ./eHYArwphKJOFUqanBWN1GwK5XpiPEK', 0),
(52, 'Kovács Attila Marcell', '2004attila2004', '2004attila2004@nonexistent-mail.com', '$2y$10$tfamZBSQgnqilJC3gygS6O72aYS3U2pjgS3HKtIkWVV5aDZAqZQGS', 0),
(53, 'Siklósi Dániel', 'sdani', 'gtabugatti524@nonexistent-mail.com', '$2y$10$QH.Uuj5GygoF4H21FZmD1.gPKHpFtJUxy0lDU4Ze2yI2XkvffDwUa', 0),
(54, 'Boros Renátó', 'renato123', 'keszpenzesautofelvasarlas@nonexistent-email.com', '$2y$10$tu4R1WXIXKCeCYZWsB9KG.qzpiJRnJezqcaUuY.NA7H2H6S/3DSfW', 0),
(55, 'Szekeres Nándor', 'nandor123', 'sz.nandor123@nonexistent-mail.com', '$2y$10$EYqiWM9ltscgOlNAmSvphuZ7lZpR7lcfejfaYmy48SRInaIijogIG', 0),
(56, 'Teszt Admin', 'tmp_admin', 'tmp_admin@nonexistent-email.com', '$2y$10$GxmihnEVnjjd92aEKOfhuumGC/jUb5CKEjahkyZTacCitUSbz67K2', 1),
(57, 'Teszt Felhasználó', 'tmp_user', 'tmp_user@nonexistent-email.com', '$2y$10$6bJJqT.b1GUHUOpq6g8tTecnbNQ3NmgaNf7YibDUWD2Q6OTmha20O', 0);


ALTER TABLE `hirlevelesek`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rendelesek`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `termekek`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `hirlevelesek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `rendelesek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

ALTER TABLE `termekek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
