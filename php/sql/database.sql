-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 02 juin 2025 à 11:39
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
-- Base de données : `tfa_2025`
--

-- --------------------------------------------------------

--
-- Structure de la table `action`
--

CREATE TABLE `action` (
  `id_caracteristique` int(11) NOT NULL,
  `id_test_caracteristique` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `alignement`
--

CREATE TABLE `alignement` (
  `id_alignement` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `alignement`
--

INSERT INTO `alignement` (`id_alignement`, `nom`) VALUES
(1, 'Loyal Bon'),
(2, 'Neutre Bon'),
(3, 'Chaotique Bon'),
(4, 'Loyal Neutre'),
(5, 'Neutre'),
(6, 'Chaotique Neutre'),
(7, 'Loyal Mauvais'),
(8, 'Neutre Mauvais'),
(9, 'Chaotique Mauvais');

-- --------------------------------------------------------

--
-- Structure de la table `caracteristique`
--

CREATE TABLE `caracteristique` (
  `id_caracteristique` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `caracteristique`
--

INSERT INTO `caracteristique` (`id_caracteristique`, `nom`) VALUES
(1, 'FOR'),
(2, 'DEX'),
(3, 'CON'),
(4, 'INT'),
(5, 'SAG'),
(6, 'CHA');

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `id_classe` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `classe`
--

INSERT INTO `classe` (`id_classe`, `nom`) VALUES
(1, 'Guerrier'),
(2, 'Mage'),
(3, 'Voleur'),
(4, 'Prêtre'),
(5, 'Paladin'),
(6, 'Rôdeur'),
(7, 'Barbare'),
(8, 'Barde'),
(9, 'Druide'),
(10, 'Sorcier'),
(11, 'Clerc');

-- --------------------------------------------------------

--
-- Structure de la table `inventaire`
--

CREATE TABLE `inventaire` (
  `id_personnage` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inventaire`
--

INSERT INTO `inventaire` (`id_personnage`, `id_item`, `quantite`) VALUES
(2, 3, 1),
(2, 4, 1),
(2, 6, 1),
(3, 1, 1),
(3, 2, 1),
(3, 9, 1),
(4, 8, 1),
(4, 10, 2),
(5, 5, 1),
(5, 7, 1);

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `id_item` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `effet` varchar(50) DEFAULT NULL,
  `niveau_requis` int(11) DEFAULT NULL,
  `prix` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id_item`, `nom`, `type`, `effet`, `niveau_requis`, `prix`) VALUES
(1, 'Épée courte', 'Arme', 'Attaque +2', 1, 10),
(2, 'Bouclier', 'Armure', 'Défense +1', 1, 12),
(3, 'Potion de soin', 'Consommable', 'PV +10', 1, 5),
(4, 'Arc long', 'Arme', 'Attaque +3', 2, 18),
(5, 'Cape d''invisibilité', 'Accessoire', 'Invisibilité', 3, 30),
(6, 'Bottes de vitesse', 'Accessoire', 'Vitesse +2', 2, 20),
(7, 'Anneau de force', 'Accessoire', 'FOR +1', 2, 25),
(8, 'Bâton magique', 'Arme', 'INT +2', 3, 28),
(9, 'Armure lourde', 'Armure', 'Défense +3', 4, 35),
(10, 'Potion de mana', 'Consommable', 'Mana +10', 1, 7);

-- --------------------------------------------------------

--
-- Structure de la table `personnage`
--

CREATE TABLE `personnage` (
  `id_personnage` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `jouable` tinyint(1) NOT NULL COMMENT '1 = jouable, 0 = non-jouable',
  `pv` int(11) NOT NULL,
  `niveau` int(11) NOT NULL,
  `id_alignement` int(11) NOT NULL,
  `id_classe` int(11) NOT NULL,
  `id_race` int(11) NOT NULL,
  `xp` int(11) NOT NULL DEFAULT 0,
  `or` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `possedent`
--

CREATE TABLE `possedent` (
  `id_personnage` int(11) NOT NULL,
  `id_relation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `race`
--

CREATE TABLE `race` (
  `id_race` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `race`
--

INSERT INTO `race` (`id_race`, `nom`) VALUES
(1, 'Humain'),
(2, 'Elfe'),
(3, 'Nain'),
(4, 'Orc'),
(5, 'Gobelin'),
(6, 'Demi-Elfe'),
(7, 'Demi-Orc'),
(8, 'Gnome'),
(9, 'Tieffelin'),
(10, 'Drakéide');

-- --------------------------------------------------------

--
-- Structure de la table `relation`
--

CREATE TABLE `relation` (
  `id_relation` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Ajoute les types de relation
INSERT INTO relation (nom) VALUES ('Allié'), ('Ennemi'), ('Neutre');

-- --------------------------------------------------------

--
-- Structure de la table `test_caracteristique`
--

CREATE TABLE `test_caracteristique` (
  `id_test_caracteristique` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `caracteristique` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `valeur_caracteristique`
--

CREATE TABLE `valeur_caracteristique` (
  `id_personnage` int(11) NOT NULL,
  `id_caracteristique` int(11) NOT NULL,
  `valeur` int(11) NOT NULL,
  `modificateur` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sort`
--

CREATE TABLE `sort` (
  `id_sort` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `niveau_min` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id_sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Structure de la table `connait`
--

CREATE TABLE `connait` (
  `id_personnage` int(11) NOT NULL,
  `id_sort` int(11) NOT NULL,
  PRIMARY KEY (`id_personnage`, `id_sort`),
  FOREIGN KEY (`id_personnage`) REFERENCES `personnage`(`id_personnage`) ON DELETE CASCADE,
  FOREIGN KEY (`id_sort`) REFERENCES `sort`(`id_sort`) ON DELETE CASCADE
);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`id_caracteristique`,`id_test_caracteristique`),
  ADD KEY `id_test_caracteristique` (`id_test_caracteristique`);

--
-- Index pour la table `alignement`
--
ALTER TABLE `alignement`
  ADD PRIMARY KEY (`id_alignement`);

--
-- Index pour la table `caracteristique`
--
ALTER TABLE `caracteristique`
  ADD PRIMARY KEY (`id_caracteristique`);

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`id_classe`);

--
-- Index pour la table `inventaire`
--
ALTER TABLE `inventaire`
  ADD PRIMARY KEY (`id_personnage`,`id_item`),
  ADD KEY `id_item` (`id_item`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- Index pour la table `personnage`
--
ALTER TABLE `personnage`
  ADD PRIMARY KEY (`id_personnage`),
  ADD KEY `id_alignement` (`id_alignement`),
  ADD KEY `id_classe` (`id_classe`),
  ADD KEY `id_race` (`id_race`);

--
-- Index pour la table `possedent`
--
ALTER TABLE `possedent`
  ADD PRIMARY KEY (`id_personnage`,`id_relation`),
  ADD KEY `id_relation` (`id_relation`);

--
-- Index pour la table `race`
--
ALTER TABLE `race`
  ADD PRIMARY KEY (`id_race`);

--
-- Index pour la table `relation`
--
ALTER TABLE `relation`
  ADD PRIMARY KEY (`id_relation`);

--
-- Index pour la table `test_caracteristique`
--
ALTER TABLE `test_caracteristique`
  ADD PRIMARY KEY (`id_test_caracteristique`);

--
-- Index pour la table `valeur_caracteristique`
--
ALTER TABLE `valeur_caracteristique`
  ADD PRIMARY KEY (`id_personnage`,`id_caracteristique`),
  ADD KEY `id_caracteristique` (`id_caracteristique`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `alignement`
--
ALTER TABLE `alignement`
  MODIFY `id_alignement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `caracteristique`
--
ALTER TABLE `caracteristique`
  MODIFY `id_caracteristique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `classe`
--
ALTER TABLE `classe`
  MODIFY `id_classe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `personnage`
--
ALTER TABLE `personnage`
  MODIFY `id_personnage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `race`
--
ALTER TABLE `race`
  MODIFY `id_race` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `relation`
--
ALTER TABLE `relation`
  MODIFY `id_relation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `test_caracteristique`
--
ALTER TABLE `test_caracteristique`
  MODIFY `id_test_caracteristique` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `action`
--
ALTER TABLE `action`
  ADD CONSTRAINT `action_ibfk_1` FOREIGN KEY (`id_caracteristique`) REFERENCES `caracteristique` (`id_caracteristique`) ON DELETE CASCADE,
  ADD CONSTRAINT `action_ibfk_2` FOREIGN KEY (`id_test_caracteristique`) REFERENCES `test_caracteristique` (`id_test_caracteristique`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inventaire`
--
ALTER TABLE `inventaire`
  ADD CONSTRAINT `inventaire_ibfk_1` FOREIGN KEY (`id_personnage`) REFERENCES `personnage` (`id_personnage`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventaire_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`) ON DELETE CASCADE;

--
-- Contraintes pour la table `personnage`
--
ALTER TABLE `personnage`
  ADD CONSTRAINT `personnage_ibfk_1` FOREIGN KEY (`id_alignement`) REFERENCES `alignement` (`id_alignement`),
  ADD CONSTRAINT `personnage_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`),
  ADD CONSTRAINT `personnage_ibfk_3` FOREIGN KEY (`id_race`) REFERENCES `race` (`id_race`);

--
-- Contraintes pour la table `possedent`
--
ALTER TABLE `possedent`
  ADD CONSTRAINT `possedent_ibfk_1` FOREIGN KEY (`id_personnage`) REFERENCES `personnage` (`id_personnage`) ON DELETE CASCADE,
  ADD CONSTRAINT `possedent_ibfk_2` FOREIGN KEY (`id_relation`) REFERENCES `relation` (`id_relation`) ON DELETE CASCADE;

--
-- Contraintes pour la table `valeur_caracteristique`
--
ALTER TABLE `valeur_caracteristique`
  ADD CONSTRAINT `valeur_caracteristique_ibfk_1` FOREIGN KEY (`id_personnage`) REFERENCES `personnage` (`id_personnage`) ON DELETE CASCADE,
  ADD CONSTRAINT `valeur_caracteristique_ibfk_2` FOREIGN KEY (`id_caracteristique`) REFERENCES `caracteristique` (`id_caracteristique`) ON DELETE CASCADE;

--
-- Ajout des sorts
--
INSERT INTO `sort` (`nom`, `niveau_min`, `prix`, `description`) VALUES
('Projectile magique', 1, 5, 'Crée 3 projectiles magiques automatiques (1d4+1)'),
('Rayon de givre', 1, 4, 'Inflige des dégâts de froid et ralentit la cible'),
('Bouclier', 1, 6, '+5 CA jusqu’au prochain tour'),
('Armure de mage', 1, 8, 'Augmente la CA pendant 8h'),
('Main spectrale', 1, 5, 'Manipule à distance de petits objets'),
('Lumière dansante', 1, 3, 'Fait apparaître 4 orbes lumineuses mobiles'),
('Choc électrique', 2, 10, 'Inflige des dégâts à une cible métallique ou mouillée'),
('Saut', 2, 10, 'Triple la hauteur de saut d’un allié'),
('Invisibilité', 3, 15, 'Rend la cible invisible pendant 1 minute'),
('Détection de la magie', 1, 6, 'Permet de sentir les sources magiques proches'),
('Flèche acide de Melf', 3, 18, 'Crée un projectile acide infligeant 2d4 dégâts'),
('Mur de vent', 4, 20, 'Crée un mur qui bloque projectiles et fumées'),
('Cône de froid', 5, 25, 'Inflige 8d8 dégâts de froid en zone'),
('Hâte', 4, 22, 'Donne une action supplémentaire par tour'),
('Boule de feu', 5, 30, 'Inflige 8d6 dégâts de feu sur une grande zone'),
('Télékinésie', 4, 20, 'Déplace objets ou ennemis par la pensée'),
('Charme-personne', 2, 8, 'Force une cible à te considérer comme allié'),
('Lévitation', 2, 10, 'Permet de flotter à 6 m du sol'),
('Terreur', 3, 15, 'Provoque la fuite des ennemis faibles d’esprit'),
('Barrière magique', 4, 18, 'Réduit de moitié les dégâts magiques reçus');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;