-- BDD RiverRide --
DROP DATABASE IF EXISTS `RiverRide`;
CREATE DATABASE `RiverRide`;
USE `RiverRide`;	


CREATE TABLE Utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(100),
    mot_de_passe VARCHAR(255),
    admin BOOLEAN DEFAULT FALSE,
    client BOOLEAN DEFAULT FALSE
);

CREATE TABLE PointsArret (
    id_point_arret INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    description TEXT
);

CREATE TABLE Logements (
    id_logement INT AUTO_INCREMENT PRIMARY KEY,
    id_point_arret INT,
    nom VARCHAR(100),
    type VARCHAR(50),
    capacite INT,
    disponibilite BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_point_arret) REFERENCES PointsArret(id_point_arret),
    prix DECIMAL(10, 2)
);

CREATE TABLE Itineraires (
    id_itineraire INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    duree INT,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateurs(id_utilisateur)
);

CREATE TABLE EtapesItineraire (
    id_etape INT AUTO_INCREMENT PRIMARY KEY,
    id_itineraire INT,
    id_point_arret INT,
    date_etape DATE,
    FOREIGN KEY (id_itineraire) REFERENCES Itineraires(id_itineraire),
    FOREIGN KEY (id_point_arret) REFERENCES PointsArret(id_point_arret)
);

CREATE TABLE Reservations (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    id_etape INT,
    id_logement INT,
    validation BOOLEAN DEFAULT FALSE,
    date_reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateurs(id_utilisateur),
    FOREIGN KEY (id_etape) REFERENCES EtapesItineraire(id_etape),
    FOREIGN KEY (id_logement) REFERENCES Logements(id_logement)
);

CREATE TABLE Packs (
    id_pack INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    description TEXT,
    prix DECIMAL(10, 2)
);

CREATE TABLE CompositionPack (
    id_composition INT AUTO_INCREMENT PRIMARY KEY,
    id_pack INT,
    id_etape INT,
    FOREIGN KEY (id_pack) REFERENCES Packs(id_pack),
    FOREIGN KEY (id_etape) REFERENCES EtapesItineraire(id_etape)
);

CREATE TABLE Promotion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_debut DATE,
    date_fin DATE,
    reduction DECIMAL(5, 2),
    code VARCHAR(20),
    premier_usage BOOLEAN
);

