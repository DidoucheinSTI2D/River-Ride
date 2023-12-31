-- BDD RiverRide --
DROP DATABASE IF EXISTS `RiverRide`;
CREATE DATABASE `RiverRide`;
USE `RiverRide`;	

CREATE TABLE utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(100),
    mot_de_passe VARCHAR(255),
    admin BOOLEAN DEFAULT FALSE,
    client BOOLEAN not null default 0
);

CREATE TABLE pointarret (
    id_point_arret INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    description TEXT
);

CREATE TABLE logements (
    id_logement INT AUTO_INCREMENT PRIMARY KEY,
    id_point_arret INT,
    nom VARCHAR(100),
    type VARCHAR(50),
    capacite INT,
    disponibilite BOOLEAN DEFAULT FALSE,
    prix DECIMAL(10, 2),
    FOREIGN KEY (id_point_arret) REFERENCES pointarret(id_point_arret)
);

CREATE TABLE packs (
    id_pack INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    description TEXT,
    prix DECIMAL(10, 2),
    date_debut DATE,
    date_fin DATE
);

CREATE TABLE packcontenu (
    id_pack_contenu INT AUTO_INCREMENT PRIMARY KEY,
    id_pack INT,
    id_point_arret INT,
    id_logement INT,
    FOREIGN KEY (id_pack) REFERENCES packs(id_pack),
    FOREIGN KEY (id_point_arret) REFERENCES pointarret(id_point_arret),
    FOREIGN KEY (id_logement) REFERENCES logements(id_logement)
);

CREATE TABLE reservation_pack (
    id_reservation_pack INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    id_pack INT,
    date_reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    validation BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur),
    FOREIGN KEY (id_pack) REFERENCES packs(id_pack)
);

CREATE TABLE reservations (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    id_logement INT,
    validation BOOLEAN DEFAULT FALSE,
    date_debut DATE,
    date_fin DATE,
    date_reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur),
    FOREIGN KEY (id_logement) REFERENCES logements(id_logement)
);

CREATE TABLE promotion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_debut DATE,
    date_fin DATE,
    reduction DECIMAL(5, 2),
    code VARCHAR(20),
    premier_usage BOOLEAN
);


INSERT INTO pointarret (nom, description) VALUES
    ('Nantes', 'Extrémité de notre espace d''action, Nantes vous propose de débuter le long du fleuve afin de découvrir divers paysages et logements !'),
    ('Angers', 'Angers est un petit détour de notre descente vers Lyon, il propose un beau chemin complet et des logements atypiques dans la capitale de la fête !'),
    ('Orléans', 'Orléans est le coup de coeur de nos cliens pour leur visite, ville rempli de paysage et activités à faire seul ou en famille.'),
    ('Saint-Etienne', 'Situé à la fin de notre champ d''action, St-Etienne est LA ville à visité !'),
    ('Tours', 'Ville magnifique et remplie d''histoire , Tours vous propose un magnifique séjour.');

INSERT INTO promotion (date_debut, date_fin, reduction, code, premier_usage) VALUES ('2020-01-01', '2030-12-31', 10, 'SananesLeGoat', TRUE);