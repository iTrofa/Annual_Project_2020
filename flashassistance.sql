
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `flashAssistance`
--

-- --------------------------------------------------------

--
-- Structure de la table `bill`
--

CREATE TABLE `bill` (
  `idBill` varchar(50) NOT NULL,
  `price` varchar(45) DEFAULT NULL,
  `pdf` varchar(45) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  `idOrders` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `estimate`
--

CREATE TABLE `estimate` (
  `idestimate` varchar(50) NOT NULL,
  `pdf` varchar(100) DEFAULT NULL,
  `idService` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `idPerson` varchar(50) NOT NULL,
  `dateEstimate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

CREATE TABLE `log` (
  `idlog` varchar(50) NOT NULL,
  `dateLog` date DEFAULT NULL,
  `idService` varchar(50) DEFAULT NULL,
  `late` tinyint(4) DEFAULT 0,
  `idPerson` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `idOrders` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `idPerson` varchar(50) NOT NULL,
  `idService` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `person`
--

CREATE TABLE `person` (
  `idPerson` varchar(40) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phoneNumber` varchar(15) DEFAULT NULL,
  `function` varchar(45) DEFAULT NULL,
  `localisation` varchar(45) DEFAULT NULL,
  `qrCode` varchar(200) DEFAULT NULL,
  `subcription` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `idService` varchar(50) NOT NULL,
  `name` varchar(45) NOT NULL,
  `demo` tinyint(4) DEFAULT 0,
  `price` double DEFAULT NULL,
  `category` varchar(45) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`idBill`),
  ADD KEY `fk_idOrders` (`idOrders`);

--
-- Index pour la table `estimate`
--
ALTER TABLE `estimate`
  ADD PRIMARY KEY (`idestimate`),
  ADD KEY `fk_idPerson1` (`idPerson`),
  ADD KEY `fk_idService1` (`idService`);

--
-- Index pour la table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`idlog`),
  ADD KEY `fk_idPerson` (`idPerson`),
  ADD KEY `fk_idService` (`idService`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`idOrders`),
  ADD KEY `fk_idPerson2` (`idPerson`),
  ADD KEY `fk_idService2` (`idService`);

--
-- Index pour la table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`idPerson`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`idService`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `fk_idOrders` FOREIGN KEY (`idOrders`) REFERENCES `orders` (`idOrders`);

--
-- Contraintes pour la table `estimate`
--
ALTER TABLE `estimate`
  ADD CONSTRAINT `fk_idPerson1` FOREIGN KEY (`idPerson`) REFERENCES `person` (`idPerson`),
  ADD CONSTRAINT `fk_idService1` FOREIGN KEY (`idService`) REFERENCES `service` (`idService`);

--
-- Contraintes pour la table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `fk_idPerson` FOREIGN KEY (`idPerson`) REFERENCES `person` (`idPerson`),
  ADD CONSTRAINT `fk_idService` FOREIGN KEY (`idService`) REFERENCES `service` (`idService`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_idPerson2` FOREIGN KEY (`idPerson`) REFERENCES `person` (`idPerson`),
  ADD CONSTRAINT `fk_idService2` FOREIGN KEY (`idService`) REFERENCES `service` (`idService`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
