-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 30 nov. 2024 à 19:22
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetpaw`
--

-- --------------------------------------------------------

--
-- Structure de la table `demands`
--

CREATE TABLE `demands` (
  `id` int(12) NOT NULL,
  `document` varchar(25) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'encours',
  `urgency` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demands`
--

INSERT INTO `demands` (`id`, `document`, `status`, `urgency`) VALUES
(23145, 'Certificat de scolarité', 'accepted', 'urgent'),
(234521, 'Attestation de bonne cond', 'accepted', 'urgent'),
(234521, 'Certificat de scolarité', 'accepted', 'normal');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `event_title`, `event_description`, `created_at`) VALUES
(2, 'greve umbb', 'demmande de nouvelle specialite', '2024-11-29 13:21:36'),
(3, 'xgfgg', 'ss', '2024-11-30 16:56:40'),
(4, 'ijhi', 'ds', '2024-11-30 18:20:42');

-- --------------------------------------------------------

--
-- Structure de la table `professors`
--

CREATE TABLE `professors` (
  `prof_name` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `professors`
--

INSERT INTO `professors` (`prof_name`, `module`, `email`) VALUES
('badari', 'gl', 'badari@gmail.com'),
('vdd', 'dd', 'dd@gmail.com'),
('sss', 'fzs', 'jof@sg.com'),
('ss', 'ssq', 'sqq@gmail.com'),
('yahyatine ', 'php', 'yahyatien@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `role` enum('student','admin') DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `email`, `password`, `status`, `role`) VALUES
(1, 'admin', 'admin', 'administartion@gmail.com', '$2y$10$2KrGGRuvX9pHOjfFwoKXwedhFBL1injKV3ZgeyOzwE7Hu.xWBLtVe', 'approved', 'admin'),
(213, 'idias', 'walid', 'walid@gmail.com', '$2y$10$6A59F/ELIl2nguHM09luyuOZ3S.3DI6hC2.k.X2HRweireFlj5SDK', 'approved', 'student'),
(23145, 'cristiano', 'ronaldo', 'ronaldo@gmail.com', '$2y$10$UCl7kVkrZU3CtLucWJcsTecRgFqubHaVJnSMzpvabivgLMOMYHBdG', 'approved', 'student'),
(45678, 'chachoua', 'walid', 'walidjo@gmail.com', '$2y$10$90qXctEy0AYF7/z7igHjlO5NYxlB3.JpdiOW7Qb9HqWzCvMlfPZkS', 'approved', 'student'),
(234521, 'nechaf', 'hmed', 'hmed@nechaf.com', '$2y$10$knWNC2sQGrpMLnnsuUGWo..nzetbgTCBTNlhRqJy.Ns./ae9SLQYS', 'approved', 'student'),
(1234576, 'chibah', 'adel', 'adel@gmail.com', '$2y$10$q9I0BuvX2C8h7DMaTEcyvOTV9lVX.PUjJBTU6o6l.3FJhkO7xxfYe', 'approved', 'student');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `demands`
--
ALTER TABLE `demands`
  ADD PRIMARY KEY (`id`,`document`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `professors`
--
ALTER TABLE `professors`
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2345676;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
