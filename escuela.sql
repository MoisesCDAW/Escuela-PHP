-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 12:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE escuela;
USE escuela;

-- --------------------------------------------------------

--
-- Table structure for table `actividad`
--

CREATE TABLE `actividad` (
  `actividad` varchar(30) NOT NULL,
  `unidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumno`
--

CREATE TABLE `alumno` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(15) DEFAULT NULL,
  `apellidos` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asignatura`
--

CREATE TABLE `asignatura` (
  `asignatura` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calificaciones`
--

CREATE TABLE `calificaciones` (
  `dni` varchar(9) NOT NULL,
  `actividad` varchar(30) NOT NULL,
  `nota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cursa`
--

CREATE TABLE `cursa` (
  `dni` varchar(9) NOT NULL,
  `asignatura` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unidad`
--

CREATE TABLE `unidad` (
  `unidad` int(11) NOT NULL,
  `asignatura` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`actividad`),
  ADD KEY `unidad` (`unidad`);

--
-- Indexes for table `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`dni`);

--
-- Indexes for table `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`asignatura`);

--
-- Indexes for table `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`dni`),
  ADD KEY `actividad` (`actividad`),
  ADD KEY `dni` (`dni`);

--
-- Indexes for table `cursa`
--
ALTER TABLE `cursa`
  ADD PRIMARY KEY (`dni`,`asignatura`),
  ADD KEY `asignatura` (`asignatura`);

--
-- Indexes for table `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`unidad`),
  ADD KEY `asignatura` (`asignatura`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_ibfk_1` FOREIGN KEY (`unidad`) REFERENCES `unidad` (`unidad`);

--
-- Constraints for table `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`actividad`) REFERENCES `actividad` (`actividad`),
  ADD CONSTRAINT `calificaciones_ibfk_2` FOREIGN KEY (`dni`) REFERENCES `alumno` (`dni`);

--
-- Constraints for table `cursa`
--
ALTER TABLE `cursa`
  ADD CONSTRAINT `cursa_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `alumno` (`dni`),
  ADD CONSTRAINT `cursa_ibfk_2` FOREIGN KEY (`asignatura`) REFERENCES `asignatura` (`asignatura`);

--
-- Constraints for table `unidad`
--
ALTER TABLE `unidad`
  ADD CONSTRAINT `unidad_ibfk_1` FOREIGN KEY (`asignatura`) REFERENCES `asignatura` (`asignatura`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
