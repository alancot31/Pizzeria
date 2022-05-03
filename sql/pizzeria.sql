DROP DATABASE IF EXISTS tppizzeria;
CREATE DATABASE tppizzeria;
USE tppizzeria;


DROP TABLE IF EXISTS `appartient`;
CREATE TABLE IF NOT EXISTS `appartient` (
    `idarticle` int(11) NOT NULL,
    `idcommande` int(11) NOT NULL,
    `quantiter` int(11) NOT NULL,
    PRIMARY KEY (`idarticle`,`idcommande`),
    KEY `appartient_commande0_FK` (`idcommande`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
    `idarticle` int(11) NOT NULL AUTO_INCREMENT,
    `prixarticle` float NOT NULL,
    `nomarticle` varchar(50) NOT NULL,
    `categoriearticle` varchar(50) NOT NULL,
    PRIMARY KEY (`idarticle`)
    ) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`idarticle`, `prixarticle`, `nomarticle`, `categoriearticle`) VALUES
                                                                                         (1, 2, 'coca', 'boissons'),
                                                                                         (2, 5, 'Smoothies', 'boissons'),
                                                                                         (3, 4, 'Cocktails ', 'boissons'),
                                                                                         (4, 2, 'ice tea', 'boissons'),
                                                                                         (5, 6, 'biere', 'boissons'),
                                                                                         (6, 2, 'coca', 'boissons'),
                                                                                         (7, 10, 'quatre fromages', 'pizzas'),
                                                                                         (8, 11, 'bianca', 'pizzas'),
                                                                                         (9, 9, 'calzone', 'pizzas '),
                                                                                         (10, 9, 'margherita', 'pizzas '),
                                                                                         (11, 2, 'tarte au fraise', 'desserts'),
                                                                                         (12, 10, 'margarita+', 'pizzas'),
                                                                                         (13, 3, 'tarte citron', 'desserts'),
                                                                                         (14, 15.5, 'pizza chorizo', 'pizzas'),
                                                                                         (15, 1.4, 'café', 'boissons'),
                                                                                         (16, 19.5, 'classique', 'pizzas');

-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
    `idcommande` int(11) NOT NULL AUTO_INCREMENT,
    `sommecommande` float NOT NULL,
    `idtablerestaurant` int(11) NOT NULL,
    `date` datetime NOT NULL,
    PRIMARY KEY (`idcommande`),
    KEY `tablerestaurant0_FK` (`idtablerestaurant`)
    ) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `historique`;
CREATE TABLE IF NOT EXISTS `historique` (
    `idhistorique` int(11) NOT NULL AUTO_INCREMENT,
    `date` date NOT NULL,
    `elementcommande` varchar(50) NOT NULL,
    `prix` float NOT NULL,
    `idcommande` int(11) NOT NULL,
    PRIMARY KEY (`idhistorique`)
    ) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`idhistorique`, `date`, `elementcommande`, `prix`, `idcommande`) VALUES
                                                                                               (1, '2021-09-08', 'maron', 11, 1),
                                                                                               (2, '2021-09-08', 'maron', 11, 1),
                                                                                               (3, '2021-09-08', 'maron', 11, 1),
                                                                                               (4, '2021-09-08', 'maron', 11, 1),
                                                                                               (5, '0000-00-00', 'bianca-1/', 11, 2),
                                                                                               (6, '0000-00-00', 'quatre fromages-1/', 10, 1),
                                                                                               (7, '0000-00-00', 'bianca-2/', 22, 3),
                                                                                               (8, '0000-00-00', 'bianca-1/', 21, 4),
                                                                                               (9, '0000-00-00', 'Cocktails -2/quatre fromages-1/bianca-1/', 29, 6),
                                                                                               (10, '0000-00-00', 'quatre fromages-2/bianca-1/', 20, 5),
                                                                                               (11, '2021-12-03', 'quatre fromages-1/', 10, 7),
                                                                                               (12, '2021-12-03', 'bianca-1/', 0, 8),
                                                                                               (13, '2021-12-13', 'quatre fromages-2/bianca-1/', 11, 9),
                                                                                               (14, '2021-12-13', 'quatre fromages-2/bianca-1/', 11, 10),
                                                                                               (15, '2021-12-13', 'quatre fromages-2/bianca-1/', 31, 11),
                                                                                               (16, '2021-12-13', 'quatre fromages-1/', 10, 12),
                                                                                               (17, '2021-12-13', 'bianca-2/tarte au fraise-1/', 24, 14),
                                                                                               (18, '2021-12-15', 'calzone-5/tarte au fraise-1/', 47, 13),
                                                                                               (19, '2021-12-15', 'quatre fromages-2/', 20, 15),
                                                                                               (20, '2021-12-16', 'quatre fromages-1/pizza chorizo-1/café-1/', 26.9, 16),
                                                                                               (21, '2021-12-16', 'Cocktails -1/margarita+-1/tarte citron-2/', 20, 17),
                                                                                               (22, '2021-12-16', 'Smoothies-1/margarita+-1/café-1/', 16.4, 18),
                                                                                               (23, '2021-12-16', 'bianca-1/margarita+-2/café-2/', 33.8, 19),
                                                                                               (24, '2021-12-16', 'coca-12/', 24, 30);

-- --------------------------------------------------------

--
-- Structure de la table `tablerestaurant`
--

DROP TABLE IF EXISTS `tablerestaurant`;
CREATE TABLE IF NOT EXISTS `tablerestaurant` (
    `idtablerestaurant` int(11) NOT NULL AUTO_INCREMENT,
    `nomtablerestaurant` varchar(50) NOT NULL,
    `nbpersonne` int(11) NOT NULL,
    `isoccuper` int(11) NOT NULL,
    PRIMARY KEY (`idtablerestaurant`)
    ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tablerestaurant`
--

INSERT INTO `tablerestaurant` (`idtablerestaurant`, `nomtablerestaurant`, `nbpersonne`, `isoccuper`) VALUES
                                                                                                         (1, 'les intime', 0, 0),
                                                                                                         (2, 'la belle', 0, 0),
                                                                                                         (3, 'whatever', 0, 0),
                                                                                                         (4, 'whatever', 0, 0),
                                                                                                         (5, 'bulle', 0, 0),
                                                                                                         (6, 'fillet', 0, 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartient`
--
ALTER TABLE `appartient`
    ADD CONSTRAINT `appartient_article_FK` FOREIGN KEY (`idarticle`) REFERENCES `article` (`idarticle`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appartient_commande0_FK` FOREIGN KEY (`idcommande`) REFERENCES `commande` (`idcommande`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
    ADD CONSTRAINT `tablerestaurant0_FK` FOREIGN KEY (`idtablerestaurant`) REFERENCES `tablerestaurant` (`idtablerestaurant`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;