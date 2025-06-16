-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 16 juin 2025 à 17:57
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `nfe`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(10) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`category_id`, `category`) VALUES
(1, 'Clavier'),
(2, 'Souris'),
(3, 'écran');

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `customer` varchar(25) NOT NULL,
  `customer_address` varchar(25) NOT NULL,
  `customer_phone_number` varchar(20) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer`, `customer_address`, `customer_phone_number`, `customer_email`) VALUES
(68, 'Client1', 'Client1_Adresse', '06 001', 'client1@client.com');

-- --------------------------------------------------------

--
-- Structure de la table `customerorder`
--

DROP TABLE IF EXISTS `customerorder`;
CREATE TABLE IF NOT EXISTS `customerorder` (
  `customer_order_id` int NOT NULL AUTO_INCREMENT,
  `customer_order_reference` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `customer_order_date` date NOT NULL,
  `customer_order_status` varchar(25) NOT NULL,
  `customer_id` int DEFAULT NULL,
  PRIMARY KEY (`customer_order_id`),
  KEY `fk_customerOrder_customer` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `customerorder`
--

INSERT INTO `customerorder` (`customer_order_id`, `customer_order_reference`, `customer_order_date`, `customer_order_status`, `customer_id`) VALUES
(66, 'CMD-06-14:15', '2025-06-16', 'En cours', 68);

-- --------------------------------------------------------

--
-- Structure de la table `customerorderdetail`
--

DROP TABLE IF EXISTS `customerorderdetail`;
CREATE TABLE IF NOT EXISTS `customerorderdetail` (
  `customer_order_detail_id` int NOT NULL AUTO_INCREMENT,
  `co_quantity` int NOT NULL,
  `selling_price` decimal(12,2) NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `customer_order_id` int NOT NULL,
  PRIMARY KEY (`customer_order_detail_id`),
  KEY `fk_cod_product` (`product_id`),
  KEY `fk_cod_user` (`user_id`),
  KEY `fk_cod_order` (`customer_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `customerorderdetail`
--

INSERT INTO `customerorderdetail` (`customer_order_detail_id`, `co_quantity`, `selling_price`, `user_id`, `product_id`, `customer_order_id`) VALUES
(63, 15, 60.00, 2, 16, 66),
(64, 10, 70.00, 2, 14, 66);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_reference` varchar(25) NOT NULL,
  `product_name` varchar(25) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_quantity_stock` int NOT NULL,
  `product_alert_threshold` int NOT NULL,
  `product_unit_price` decimal(12,2) NOT NULL,
  `supplier_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_reference` (`product_reference`),
  UNIQUE KEY `product_name` (`product_name`),
  KEY `fk_product_category` (`category_id`),
  KEY `fk_product_supplier` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`product_id`, `product_reference`, `product_name`, `product_description`, `product_quantity_stock`, `product_alert_threshold`, `product_unit_price`, `supplier_id`, `category_id`) VALUES
(13, 'RF-01', 'Souris gamer sans fil', 'Souris gamer de couleur noir sans fil', 30, 10, 7.00, 2, 2),
(14, 'RF-02', 'Clavier filaire', 'Clavier de couleur noir avec fil', 10, 10, 7.00, 2, 1),
(15, 'RF-03', 'Ecran 24 pouce', 'Ecran ASUS', 20, 10, 400.00, 3, 3),
(16, 'RF-04', 'Souris filaire', 'Souris de couleur gris avec fil', 0, 8, 4.00, 1, 2),
(17, 'RF-05', 'Souris-Clavier sans fil', 'Combo souris et clavier', 20, 10, 12.00, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(25) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role_id`, `role`) VALUES
(1, 'admin'),
(2, 'employe');

-- --------------------------------------------------------

--
-- Structure de la table `stockmovement`
--

DROP TABLE IF EXISTS `stockmovement`;
CREATE TABLE IF NOT EXISTS `stockmovement` (
  `sm_id` int NOT NULL AUTO_INCREMENT,
  `sm_type` varchar(25) NOT NULL,
  `sm_date` date NOT NULL,
  `sm_quantity` int NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`sm_id`),
  KEY `fk_stockMovement_product` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `stockmovement`
--

INSERT INTO `stockmovement` (`sm_id`, `sm_type`, `sm_date`, `sm_quantity`, `product_id`) VALUES
(50, 'sortie', '2025-06-16', 15, 16),
(51, 'sortie', '2025-06-16', 10, 14);

-- --------------------------------------------------------

--
-- Structure de la table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` int NOT NULL AUTO_INCREMENT,
  `supplier` varchar(25) NOT NULL,
  `supplier_address` varchar(25) NOT NULL,
  `supplier_phone_number` varchar(20) NOT NULL,
  `supplier_email` varchar(100) NOT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier`, `supplier_address`, `supplier_phone_number`, `supplier_email`) VALUES
(1, 'Amazon', 'AmazonAdress', '01', 'Amazon@amazon.com'),
(2, 'Itech', 'ItechAdress', '02', 'Itech@itech.com'),
(3, 'Test', 'testAD', '09', 'test@sup.com');

-- --------------------------------------------------------

--
-- Structure de la table `supplierorder`
--

DROP TABLE IF EXISTS `supplierorder`;
CREATE TABLE IF NOT EXISTS `supplierorder` (
  `supplier_order_id` int NOT NULL AUTO_INCREMENT,
  `supplier_order_reference` varchar(10) NOT NULL,
  `supplier_order_date` date NOT NULL,
  `supplier_order_status` varchar(25) NOT NULL,
  `supplier_id` int DEFAULT NULL,
  PRIMARY KEY (`supplier_order_id`),
  KEY `fk_supplierOrder_supplier` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `supplierorder`
--

INSERT INTO `supplierorder` (`supplier_order_id`, `supplier_order_reference`, `supplier_order_date`, `supplier_order_status`, `supplier_id`) VALUES
(4, 'REF-01', '2025-06-16', 'En attente', 1),
(5, 'REF-05', '2025-06-16', 'En attente', 1);

-- --------------------------------------------------------

--
-- Structure de la table `supplierorderdetail`
--

DROP TABLE IF EXISTS `supplierorderdetail`;
CREATE TABLE IF NOT EXISTS `supplierorderdetail` (
  `supplier_order_detail_id` int NOT NULL AUTO_INCREMENT,
  `so_quantity` int NOT NULL,
  `purchase_price` decimal(12,2) NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `supplier_order_id` int NOT NULL,
  PRIMARY KEY (`supplier_order_detail_id`),
  UNIQUE KEY `uq_sod` (`supplier_order_id`,`user_id`,`product_id`),
  KEY `fk_sod_product` (`product_id`),
  KEY `fk_sod_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `supplierorderdetail`
--

INSERT INTO `supplierorderdetail` (`supplier_order_detail_id`, `so_quantity`, `purchase_price`, `user_id`, `product_id`, `supplier_order_id`) VALUES
(5, 30, 4.00, 1, 16, 5);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `user_email` (`user_email`),
  KEY `fk_user_role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `username`, `user_email`, `password`, `role_id`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$3QsmXH7ycUfJG5nwXEWNhunjoUWgKWPSPhJzTGwziNoFukzerretu', 1),
(2, 'employe', 'employe@employe.com', '$2y$10$I7zKFasmtIGPW6/azz4t/eDNPWLNPyCD0baRpP9NAW5jC.JFPbqJ2', 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `customerorder`
--
ALTER TABLE `customerorder`
  ADD CONSTRAINT `fk_customerOrder_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Contraintes pour la table `customerorderdetail`
--
ALTER TABLE `customerorderdetail`
  ADD CONSTRAINT `fk_cod_order` FOREIGN KEY (`customer_order_id`) REFERENCES `customerorder` (`customer_order_id`),
  ADD CONSTRAINT `fk_cod_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `fk_product_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`);

--
-- Contraintes pour la table `stockmovement`
--
ALTER TABLE `stockmovement`
  ADD CONSTRAINT `fk_stockMovement_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Contraintes pour la table `supplierorder`
--
ALTER TABLE `supplierorder`
  ADD CONSTRAINT `fk_supplierOrder_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`);

--
-- Contraintes pour la table `supplierorderdetail`
--
ALTER TABLE `supplierorderdetail`
  ADD CONSTRAINT `fk_sod_order` FOREIGN KEY (`supplier_order_id`) REFERENCES `supplierorder` (`supplier_order_id`),
  ADD CONSTRAINT `fk_sod_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `fk_sod_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
