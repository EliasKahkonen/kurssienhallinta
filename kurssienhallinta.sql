-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2025 at 08:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kurssienhallinta`
--

-- --------------------------------------------------------

--
-- Table structure for table `kurssikirjautumiset`
--

CREATE TABLE `kurssikirjautumiset` (
  `kirjautumistunnus` int(11) NOT NULL,
  `opiskelija_id` int(11) NOT NULL,
  `kurssi_id` int(11) NOT NULL,
  `kirjautumispaiva` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kurssikirjautumiset`
--

INSERT INTO `kurssikirjautumiset` (`kirjautumistunnus`, `opiskelija_id`, `kurssi_id`, `kirjautumispaiva`) VALUES
(1, 1, 1, '2025-09-24');

-- --------------------------------------------------------

--
-- Table structure for table `kurssit`
--

CREATE TABLE `kurssit` (
  `ainetunnus` int(20) NOT NULL,
  `Nimi` varchar(20) NOT NULL,
  `Kuvaus` varchar(100) NOT NULL,
  `Alkupäivä` date NOT NULL,
  `Loppupäivä` date NOT NULL,
  `opettaja_id` int(11) NOT NULL,
  `tila_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kurssit`
--

INSERT INTO `kurssit` (`ainetunnus`, `Nimi`, `Kuvaus`, `Alkupäivä`, `Loppupäivä`, `opettaja_id`, `tila_id`) VALUES
(1, 'MySQL ja PHP', 'PHPmyadminia hyödyntäen tietokannat, taulut, relaatiot ja niiden sisällöt. Näiden yhdistäminen php k', '2025-08-10', '2025-10-10', 1, 1),
(2, 'Näyttötehtävä', '3. Vuoden \"näyttö\" osoittamaan valmiuden viimeiseen työssäoppimiseen. Tässä kaikki \"Ohjelmistokehitt', '2025-08-10', '2025-10-10', 2, 2),
(3, 'Tietovarastot', 'MySQL, SQLite, ja pythonin käyttö. Tarkoituksena tehdä tietovarastoja, jossa voi mm. tarkastella, li', '2025-08-10', '2025-10-10', 3, 3),
(4, 'Matikka', 'Laskeminen', '2025-09-30', '2025-10-29', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `opettajat`
--

CREATE TABLE `opettajat` (
  `opettajatunnus` int(11) NOT NULL,
  `Etunimi` varchar(20) NOT NULL,
  `Sukunimi` varchar(20) NOT NULL,
  `Aine` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `opettajat`
--

INSERT INTO `opettajat` (`opettajatunnus`, `Etunimi`, `Sukunimi`, `Aine`) VALUES
(1, 'Marko', 'Kairinen', 'MySQL'),
(2, 'Bogdan', 'Udrescu', 'Näyttötehtävä'),
(3, 'Topi', 'Saavalainen', 'Tietovarastot'),
(5, 'Kosper', 'Koolberg', 'Terveyys tieto'),
(6, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `opiskelijat`
--

CREATE TABLE `opiskelijat` (
  `opiskelijatunnus` int(11) NOT NULL,
  `Etunimi` varchar(20) NOT NULL,
  `Sukunimi` varchar(20) NOT NULL,
  `Syntymäpäivä` date NOT NULL,
  `Vuosikurssi` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `opiskelijat`
--

INSERT INTO `opiskelijat` (`opiskelijatunnus`, `Etunimi`, `Sukunimi`, `Syntymäpäivä`, `Vuosikurssi`) VALUES
(1, 'Kasper', 'Halonen', '2025-10-28', 3),
(2, 'Elias', 'Kähkönen', '2015-08-06', 3),
(3, 'Milo', 'Nurmi', '2015-02-19', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tilat`
--

CREATE TABLE `tilat` (
  `tilatunnus` int(11) NOT NULL,
  `nimi` varchar(20) NOT NULL,
  `kapasiteetti` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tilat`
--

INSERT INTO `tilat` (`tilatunnus`, `nimi`, `kapasiteetti`) VALUES
(1, 'A209', 15),
(2, 'A301', 20),
(3, 'A245', 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kurssikirjautumiset`
--
ALTER TABLE `kurssikirjautumiset`
  ADD PRIMARY KEY (`kirjautumistunnus`),
  ADD KEY `opiskelija_id` (`opiskelija_id`),
  ADD KEY `kurssi_id` (`kurssi_id`);

--
-- Indexes for table `kurssit`
--
ALTER TABLE `kurssit`
  ADD PRIMARY KEY (`ainetunnus`),
  ADD KEY `opettaja_id` (`opettaja_id`),
  ADD KEY `tila_id` (`tila_id`);

--
-- Indexes for table `opettajat`
--
ALTER TABLE `opettajat`
  ADD PRIMARY KEY (`opettajatunnus`);

--
-- Indexes for table `opiskelijat`
--
ALTER TABLE `opiskelijat`
  ADD PRIMARY KEY (`opiskelijatunnus`);

--
-- Indexes for table `tilat`
--
ALTER TABLE `tilat`
  ADD PRIMARY KEY (`tilatunnus`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kurssikirjautumiset`
--
ALTER TABLE `kurssikirjautumiset`
  MODIFY `kirjautumistunnus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kurssit`
--
ALTER TABLE `kurssit`
  MODIFY `ainetunnus` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `opettajat`
--
ALTER TABLE `opettajat`
  MODIFY `opettajatunnus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `opiskelijat`
--
ALTER TABLE `opiskelijat`
  MODIFY `opiskelijatunnus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tilat`
--
ALTER TABLE `tilat`
  MODIFY `tilatunnus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kurssikirjautumiset`
--
ALTER TABLE `kurssikirjautumiset`
  ADD CONSTRAINT `kurssikirjautumiset_ibfk_1` FOREIGN KEY (`opiskelija_id`) REFERENCES `opiskelijat` (`opiskelijatunnus`),
  ADD CONSTRAINT `kurssikirjautumiset_ibfk_2` FOREIGN KEY (`kurssi_id`) REFERENCES `kurssit` (`ainetunnus`);

--
-- Constraints for table `kurssit`
--
ALTER TABLE `kurssit`
  ADD CONSTRAINT `kurssit_ibfk_1` FOREIGN KEY (`tila_id`) REFERENCES `tilat` (`tilatunnus`),
  ADD CONSTRAINT `kurssit_ibfk_2` FOREIGN KEY (`opettaja_id`) REFERENCES `opettajat` (`opettajatunnus`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
