-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 26 Octobre 2017 à 13:53
-- Version du serveur :  5.7.19-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cyclaid`
--

-- --------------------------------------------------------

--
-- Structure des tables
--

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `firstname` VARCHAR(100) NOT NULL,
  `lastname` VARCHAR(100) NOT NULL,
  `city` VARCHAR(150) NOT NULL,
  `postal_code` CHAR(5) NOT NULL,
  `email_address` VARCHAR(255) NOT NULL,
  `profile_picture` VARCHAR(255) NULL,
  `coin` INT DEFAULT 0
);

--
-- Structure de la table `transaction`
--

CREATE TABLE `transaction` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `is_taken` BOOLEAN DEFAULT false,
  `created_at` DATE NOT NULL,
  `updated_at` DATE NULL,
  `post_id` INT NOT NULL,
  `taker_id` INT NOT NULL
);

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `reference` VARCHAR(255) NOT NULL,
  `creation_date` DATE NOT NULL,
  `description` TEXT,
  `wear_status` VARCHAR(20) NOT NULL,
  `user_id` INT NOT NULL,
  `brand_id` INT NOT NULL,
  `category_id` INT NOT NULL
);

--
-- Structure de la table `post_picture`
--

CREATE TABLE `post_picture` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `post_id` INT NOT NULL,
  `picture` VARCHAR(255) NOT NULL
);

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `label` VARCHAR(150) NOT NULL
);

--
-- Structure de la table `brand`
--

CREATE TABLE `brand` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `label` VARCHAR(100) NOT NULL
);

--
-- Insertion de valeurs dans les tables
--

--
-- Insertion des catégories dans la table `category`
--

INSERT INTO `category` (`label`) VALUES
('Accessories'),
('Brakes'),
('Cables and sheaths'),
('Frames'),
('Saddles'),
('Tools'),
('Fork and steering'),
('Wheels and tires'),
('Transmission');

--
-- Insertion des marques de vélos dans la table `brand`
--

INSERT INTO `brand` (`label`) VALUES
('Shimano'),
('Hutchinson'),
('Brooks'),
('Continental'),
('Schwalbe'),
('Magura'),
('Brompton'),
('Other');

--
-- Insertion de deux post TEST pour effectuer... ben des tests.
--
INSERT INTO post (title, reference, creation_date, description, wear_status, user_id, brand_id, category_id) VALUES ('Test1', 'Ref1', NOW(), 'Il roule, et il roule vite !!! Il a des pédales, appelés Zinedine', 'New', 1, 4, 6);
INSERT INTO post (title, reference, creation_date, description, wear_status, user_id, brand_id, category_id) VALUES ('Test2', 'Ref2', NOW(), 'Il roule, et il roule vite !!! Il a des pédales, appelés Zinedine', 'New', 1, 2, 3);
INSERT INTO post (title, reference, creation_date, description, wear_status, user_id, brand_id, category_id) VALUES ('Test3', 'Ref3', NOW(), 'Il roule, et il roule vite !!! Il a des pédales, appelés Zinedine', 'Used', 2, 6, 6);
INSERT INTO post (title, reference, creation_date, description, wear_status, user_id, brand_id, category_id) VALUES ('Test4', 'Ref4', NOW(), 'Il roule, et il roule vite !!! Il a des pédales, appelés Zinedine', 'New', 1, 4, 6);
INSERT INTO post (title, reference, creation_date, description, wear_status, user_id, brand_id, category_id) VALUES ('Test5', 'Ref5', NOW(), 'Il roule, et il roule vite !!! Il a des pédales, appelés Zinedine', 'Good', 1, 4, 6);
