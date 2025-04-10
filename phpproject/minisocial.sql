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
-- Base de données : `minisocial`
--

-- --------------------------------------------------------

--
-- Structure de la table `amis`
--

CREATE TABLE `amis` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ami_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `comment`, `created_at`) VALUES
(2, 13, 37, 'slm', '2025-04-05 18:06:03'),
(3, 13, 37, 'slm', '2025-04-05 18:10:17'),
(4, 13, 1, 'slm', '2025-04-05 18:14:54'),
(5, 13, 1, 'slm', '2025-04-05 18:17:25'),
(6, 13, 2, 'slm', '2025-04-05 18:17:40'),
(7, 13, 46, 'slm', '2025-04-05 18:31:15'),
(8, 13, 47, 'wow', '2025-04-05 18:36:36'),
(9, 21, 51, 'hi', '2025-04-05 18:50:08'),
(10, 21, 52, 'hi', '2025-04-05 19:23:45'),
(11, 21, 53, 'hi', '2025-04-05 19:27:01'),
(12, 21, 56, 'super', '2025-04-05 19:34:49'),
(13, 13, 57, 'hello', '2025-04-07 22:42:58'),
(14, 21, 53, 'wow', '2025-04-08 23:24:19');

-- --------------------------------------------------------

--
-- Structure de la table `invitations`
--

CREATE TABLE `invitations` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `status` enum('pending','accepted','refused') NOT NULL DEFAULT 'pending',
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `invitations`
--

INSERT INTO `invitations` (`id`, `sender_id`, `receiver_id`, `status`, `date`) VALUES
(6, 11, 9, 'pending', '2025-03-20 11:42:38'),
(7, 7, 11, 'accepted', '2025-03-20 11:45:07'),
(8, 12, 7, 'accepted', '2025-03-20 20:26:46'),
(9, 7, 9, 'pending', '2025-03-20 21:28:23'),
(11, 13, 7, 'accepted', '2025-03-21 03:04:27'),
(16, 13, 16, 'accepted', '2025-03-23 22:21:10'),
(17, 13, 11, 'accepted', '2025-03-23 22:58:56'),
(18, 20, 13, 'accepted', '2025-03-23 23:03:33'),
(19, 13, 12, 'pending', '2025-03-23 23:05:28'),
(20, 20, 11, 'accepted', '2025-03-24 13:03:26'),
(21, 19, 13, 'accepted', '2025-03-24 13:10:42'),
(22, 21, 13, 'accepted', '2025-03-25 00:05:04'),
(23, 11, 19, 'accepted', '2025-03-25 00:24:52'),
(24, 11, 21, 'accepted', '2025-03-25 01:53:05');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `type` enum('like','dislike') NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `type`, `user_id`, `created_at`) VALUES
(1, 12, 'like', 11, '2025-04-04 23:14:02'),
(2, 16, 'like', 21, '2025-04-04 23:22:44'),
(3, 17, 'like', 21, '2025-04-04 23:35:43'),
(4, 39, 'like', 7, '2025-04-05 00:30:17'),
(5, 39, 'like', 20, '2025-04-05 01:57:10'),
(6, 39, 'like', 21, '2025-04-05 03:11:38'),
(18, 56, 'dislike', 13, '2025-04-05 19:56:46'),
(20, 55, 'dislike', 13, '2025-04-05 19:57:11'),
(22, 57, 'like', 13, '2025-04-07 22:42:44'),
(24, 38, 'dislike', 21, '2025-04-08 22:19:52'),
(27, 53, 'like', 21, '2025-04-08 23:37:27');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `sender_id`, `receiver_id`, `text`, `created_at`) VALUES
(2, 7, 0, 0, '', '2025-03-25 09:26:44'),
(3, 7, 0, 0, '', '2025-03-25 09:26:44'),
(4, 7, 0, 0, '', '2025-03-25 09:26:44'),
(9, 11, 0, 0, '', '2025-03-25 09:26:44'),
(10, 7, 0, 0, '', '2025-03-25 09:26:44'),
(11, 7, 0, 0, '', '2025-03-25 09:26:44'),
(12, 11, 0, 0, '', '2025-03-25 09:26:44'),
(13, 11, 0, 0, '', '2025-03-25 09:26:44'),
(14, 21, 0, 0, '', '2025-03-25 09:26:44'),
(15, 13, 0, 0, '', '2025-03-25 09:26:44'),
(16, NULL, 13, 11, 'hi', '2025-03-25 09:27:36'),
(17, NULL, 13, 11, 'bonjour', '2025-03-25 09:29:19'),
(18, NULL, 13, 7, 'bonjour', '2025-03-25 09:34:59'),
(19, NULL, 13, 21, 'slm', '2025-03-25 09:36:00'),
(20, 13, 0, 0, '', '2025-03-25 09:41:53'),
(21, NULL, 13, 21, 'slm', '2025-03-25 09:46:55'),
(22, NULL, 13, 7, 'hi', '2025-03-25 09:56:08'),
(23, NULL, 11, 20, 'bonjour', '2025-03-25 10:14:55'),
(24, NULL, 11, 11, 'slm', '2025-03-25 10:31:51'),
(25, NULL, 11, 19, 'hi', '2025-03-29 19:25:03'),
(26, 21, 0, 0, '', '2025-04-08 21:18:30'),
(27, 21, 0, 0, '', '2025-04-08 21:21:45'),
(28, 21, 0, 0, '', '2025-04-08 21:21:57'),
(29, 21, 0, 0, '', '2025-04-08 21:54:09'),
(30, 21, 0, 0, '', '2025-04-08 21:55:52'),
(31, 21, 0, 0, '', '2025-04-08 21:55:58'),
(32, 21, 0, 0, '', '2025-04-08 21:56:09'),
(33, 21, 0, 0, '', '2025-04-08 22:15:45'),
(34, 21, 21, 21, 'hu', '2025-04-08 23:22:27');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `created_at`, `image`) VALUES
(1, 7, 'hii', '2025-04-04 01:38:46', ''),
(2, 7, 'hii', '2025-04-04 01:39:17', ''),
(3, 7, 'slm', '2025-04-04 19:46:42', ''),
(5, 21, 'hi', '2025-04-04 20:11:37', ''),
(6, 21, 'hello', '2025-04-04 20:17:26', '1743797846_template4.jpg'),
(7, 21, 'hello', '2025-04-04 20:20:14', '1743798014_proba5.PNG'),
(8, 21, 'slm', '2025-04-04 20:28:27', '1743798507_h1.jpg'),
(9, 21, 'hii', '2025-04-04 20:34:02', '1743798842_proba5.PNG'),
(10, 21, 'slm', '2025-04-04 20:39:16', '1743799156_h1.jpg'),
(11, 11, 'wa lbachir', '2025-04-04 20:42:07', '1743799327_tm1.jpg'),
(12, 21, 'hi', '2025-04-04 20:48:17', '1743799697_home3.jpg'),
(13, 11, 'wal3fo', '2025-04-04 23:14:33', 'chat4.jpg'),
(15, 11, 'wal3fo', '2025-04-04 23:15:14', 'chat4.jpg'),
(16, 21, 'hey', '2025-04-04 23:22:33', 'h1.jpg'),
(17, 21, 'oui', '2025-04-04 23:35:27', '1743809727_proba5.PNG'),
(18, 21, 'ffffffff', '2025-04-04 23:36:07', '1743809767_proba4.PNG'),
(33, 11, 'brahim', '2025-04-04 23:56:35', '67f071b38f76d_moroco.jpg'),
(34, 11, 'brahim', '2025-04-04 23:56:35', '67f071b3b1495_moroco.jpg'),
(35, 11, 'tttttttttt', '2025-04-04 23:57:21', '67f071e1c537e_reserve.jpg'),
(36, 11, 'tttttttttt', '2025-04-04 23:57:23', '67f071e31ba08_reserve.jpg'),
(37, 11, 'tttttttttt', '2025-04-04 23:57:23', '67f071e3800d0_reserve.jpg'),
(38, 11, 'tttttttttt', '2025-04-04 23:57:23', '67f071e3e02ab_reserve.jpg'),
(39, 11, 'tttttttttt', '2025-04-04 23:57:24', '67f071e45de83_reserve.jpg'),
(40, 11, 'tttttttttt', '2025-04-04 23:57:24', '67f071e48e5c5_reserve.jpg'),
(42, 20, 'mariposa', '2025-04-05 18:01:08', '1743876068_WIN_20250221_21_57_37_Pro.jpg'),
(43, 20, 'hiiii', '2025-04-05 18:04:26', '1743876266_WIN_20250312_23_56_16_Pro.jpg'),
(44, 13, 'fes', '2025-04-05 18:19:06', '1743877146_Cours de cuisine marocaine à Fès.jpeg'),
(45, 13, 'travel', '2025-04-05 18:25:05', '1743877505_Tripco - Travel Landing Page.jpeg'),
(46, 13, 'hii', '2025-04-05 18:31:02', ''),
(47, 13, 'hi', '2025-04-05 18:36:20', '1743878180_post.jpg'),
(48, 13, 'yes', '2025-04-05 18:44:51', NULL),
(49, 13, 'ohh', '2025-04-05 18:45:12', 'uploads/67f17a381afb5-Nuit sous les étoiles dans un campement nomade.jpg'),
(50, 13, 'wow', '2025-04-05 18:45:36', 'uploads/67f17a509e7a6-face.PNG'),
(51, 13, 'hey', '2025-04-05 18:49:12', 'uploads/67f17b2874b36-face.PNG'),
(52, 21, 'het', '2025-04-05 18:50:28', 'uploads/67f17b74b0f74-pc.jpg'),
(53, 21, 'slmm', '2025-04-05 19:23:59', '67f1834fb9718-singe.jpg'),
(54, 21, 'slm', '2025-04-05 19:27:31', '67f18423a5e03-14954f39ec268b3c3b71121ffb437d3c.jpg'),
(55, 21, '11', '2025-04-05 19:32:30', '67f1854e1c8ee-836c77cffd7996fc5936930b94f7af64.jpg'),
(56, 21, 'interface', '2025-04-05 19:34:29', '67f185c593315-ajout.png'),
(57, 13, 'heyy', '2025-04-07 22:42:35', '67f454db0df1c-graphe.PNG');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profession` varchar(100) DEFAULT 'Non spécifié',
  `image` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `profession`, `image`) VALUES
(7, 'nejd', 'fadwa', 'fadwa@gmail.com', '$2y$10$3DOiqOYT5OJx5xTxKMUlquGKXQbFokd6y8CzqI4TLTzl4WwZPKrZy', 'prof', 'ami7.jpg'),
(9, 'mariposa', 'mari', 'maria@gmail.com', '$2y$10$elhfBq/yJ6uFAe9pNidXF.XRt.U7ZT12Og6nOs4CCWpBZONOVhpFu', 'developpeuse', 'ami4.jpg'),
(11, 'wiam', 'boui', 'wiam@gmail.com', '$2y$10$euSZAgbkw/dbaZm4TF5FkuOZHPJJAd6iRVi2arjlhT6dm7HalKY7u', 'dentiste', 'ami5.jpg'),
(12, 'bilakaya', 'hajar', 'hajar@gmail.com', '$2y$10$W.kRQGZF0ONqZAbF1is.OOzAf6vCqUeJI73XvduhSjh7bOYPCPxBS', 'etudiante', 'ami6.jpg'),
(13, 'malak', 'bel', 'malak@gmail.com', '$2y$10$0XAN1bmqhGB0Hf4HVD0IYu.ybd36B4Gad7HJd7TQbVdELksRlUoiG', 'ingenieur', 'ami8.jpg'),
(16, 'ily', 'amina', 'amina@gmail.com', '$2y$10$zDN2V2yvKReDP9/AvG.bkOTZxMhivMURG3ePwAcjACACHoTloWbtG', 'designer', 'ami1.jpg'),
(19, 'neyla', 'mirale', 'mirale@gmail.com', '$2y$10$cQpC6SQPwIBp0nR4MvcoP.lsgk1boYCluG7GU6gk8Ezq8KH.3FzX.', 'ingenieur', '1742768675_Capture2.PNG'),
(20, 'chattar', 'imane', 'imane@gmail.com', '$2y$10$NWHrQTzYt5eLC5P8lS/bO.zdf3Ew1CXNyqbh7GVW4H1CwnlxDeCv6', 'etudiante', '1742770976_ami2.png'),
(21, 'nina', 'ghayt', 'ghayt@gmail.com', '$2y$10$flDzz5tY8g2V0CLY1CSVjeOl5dF7DczQKiyYTN6ncA8ZpeYpcAnf.', 'constructeur', '1742860956_ami11.jpg'),
(22, 'boui', 'inas', 'inas@gmail.com', '$2y$10$VOQD13Fi6iSudqa.xPUiTOcbrWzrUOQ9zz5S7X.SCLv0Qo7g9V.7O', 'dentiste', '1742894228_ami10.jpg'),
(23, 'ihab', 'bl', 'ihab@gmail.com', '$2y$10$itpx23mopws7gPRFUbRLluAX3UzI8vxmr4lHFhZJjUU9fb5T1zvn2', 'proffesseur', '1742899552_ami11.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `amis`
--
ALTER TABLE `amis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ami_id` (`ami_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sender` (`sender_id`),
  ADD KEY `fk_receiver` (`receiver_id`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `amis`
--
ALTER TABLE `amis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `amis`
--
ALTER TABLE `amis`
  ADD CONSTRAINT `amis_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amis_ibfk_2` FOREIGN KEY (`ami_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `invitations`
--
ALTER TABLE `invitations`
  ADD CONSTRAINT `fk_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invitations_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `invitations_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
