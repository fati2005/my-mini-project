-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:4306
-- Généré le : jeu. 10 avr. 2025 à 12:35
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hotelgestion`
--

-- --------------------------------------------------------

--
-- Structure de la table `room`
--

CREATE TABLE `room` (
  `room_number` int(11) NOT NULL,
  `type` enum('1BHK','2BHK') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `availability` enum('Available','Occupied') DEFAULT 'Available',
  `cleaning_status` enum('Clean','Dirty') DEFAULT 'Clean'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `room`
--

INSERT INTO `room` (`room_number`, `type`, `price`, `availability`, `cleaning_status`) VALUES
(5, '2BHK', 3000.00, 'Available', 'Clean'),
(8, '2BHK', 4000.00, 'Available', 'Clean'),
(13, '1BHK', 3000.00, 'Available', 'Clean'),
(14, '1BHK', 400.00, 'Available', 'Clean'),
(15, '1BHK', 300.00, 'Available', 'Clean'),
(16, '2BHK', 6000.00, 'Occupied', 'Clean'),
(23, '2BHK', 34000.00, 'Available', 'Clean'),
(123, '1BHK', 12000.00, 'Available', 'Clean'),
(200, '1BHK', 40.00, 'Available', 'Clean'),
(233, '2BHK', 1000.00, 'Available', 'Clean'),
(234, '1BHK', 200000.00, 'Available', 'Clean'),
(400, '2BHK', 20000.00, 'Occupied', 'Clean'),
(600, '2BHK', 20000.00, 'Available', 'Clean'),
(670, '2BHK', 20000.00, 'Available', 'Clean');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`) VALUES
(6, 'testUser', 'DfCrWl/fNUo3MTQSrWggt98XBxWTnLenlqwp6gLIvKA=', 'qgt2PfbiwxPyD5TIK2MFUQ=='),
(17, 'fati', '*3BC0D9CBA1E490FF97B09ED545D7EF2043DE097A', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_number`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
