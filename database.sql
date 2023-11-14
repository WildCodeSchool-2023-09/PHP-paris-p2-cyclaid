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
-- Insertion de plusieurs post TEST pour effectuer... ben des tests.
--
INSERT INTO post (title, reference, creation_date, description, wear_status, user_id, brand_id, category_id) VALUES ('Pédales Keo carbone', 'Ref1', NOW(), 'Pédales Keo carbone taille L état neuf : jamais utilisées', 'new', 1, 4, 6);
INSERT INTO post (title, reference, creation_date, description, wear_status, user_id, brand_id, category_id) VALUES ('Lot de roues anciennes', 'Ref2', NOW(), 'A donner, lot de roues anciennes toutes tailles. Me demander pour plus de détails', 'to-fix', 2, 2, 3);
INSERT INTO post (title, reference, creation_date, description, wear_status, user_id, brand_id, category_id) VALUES ('Guidon type Gravel taille M', 'Ref3', NOW(), 'Suite à un changement, je donne un guidon de gravel diamètre 38, taille M. Il a un peu vécu et a subi une chute mais il fonctionne parfaitement', 'used', 3, 6, 6);
INSERT INTO post (title, reference, creation_date, description, wear_status, user_id, brand_id, category_id) VALUES ('Cadre de vélo hollandais noir L', 'Ref4', NOW(), 'A donner cadre de vélo hollandais noir, neuf taille M, il prend de la place dans mon garage', 'new', 4, 4, 6);
INSERT INTO post (title, reference, creation_date, description, wear_status, user_id, brand_id, category_id) VALUES ('Cassette Shimano 18*38', 'Ref5', NOW(), 'Donne Cassette Shimano, bon état général, 18*38 démontée de mon gravel pour être remplacée par une cassette type route', 'good', 5, 4, 6);
INSERT INTO post_picture (post_id, picture) VALUES ('1', 'test1.jfif');
INSERT INTO post_picture (post_id, picture) VALUES ('2', 'test2.jfif');
INSERT INTO post_picture (post_id, picture) VALUES ('3', 'test3.png');
INSERT INTO post_picture (post_id, picture) VALUES ('4', 'test4.jfif');
INSERT INTO user (id, city) VALUES ('1', 'Saint-Germain');
INSERT INTO user (id, city) VALUES ('2', 'Paris');
INSERT INTO user (id, city) VALUES ('3', 'Toulouse');
INSERT INTO user (id, city) VALUES ('4', 'Sain-Rémy-de-chevreuse');
