CREATE DATABASE IF NOT EXISTS `exceptiontea`
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
USE `exceptiontea`;

-- Table t_utilisateur
CREATE TABLE `t_utilisateur` (
  `id_utilisateur` INT AUTO_INCREMENT PRIMARY KEY,
  `nom`           VARCHAR(100) NOT NULL,
  `email`         VARCHAR(100) NOT NULL UNIQUE,
  `mot_de_passe`  VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table t_provenance
CREATE TABLE `t_provenance` (
  `id_provenance` INT AUTO_INCREMENT PRIMARY KEY,
  `nom`           VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table t_type
CREATE TABLE `t_type` (
  `id_type` INT AUTO_INCREMENT PRIMARY KEY,
  `nom`     VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table t_variete
CREATE TABLE `t_variete` (
  `id_variete` INT AUTO_INCREMENT PRIMARY KEY,
  `nom`        VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table t_the
CREATE TABLE `t_the` (
  `id_the`           INT AUTO_INCREMENT PRIMARY KEY,
  `nom`              VARCHAR(100) NOT NULL,
  `preparation`      TEXT,
  `description`      TEXT,
  `quantite`         INT,
  `prix_100g`        DECIMAL(6,2),
  `date_recolte`     DATE,
  `fk_id_type`       INT NOT NULL,
  `fk_id_variete`    INT NOT NULL,
  `fk_id_provenance` INT NOT NULL,
  CONSTRAINT `fk_the_type`
    FOREIGN KEY (`fk_id_type`)
    REFERENCES `t_type` (`id_type`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_the_variete`
    FOREIGN KEY (`fk_id_variete`)
    REFERENCES `t_variete` (`id_variete`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_the_provenance`
    FOREIGN KEY (`fk_id_provenance`)
    REFERENCES `t_provenance` (`id_provenance`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table t_liste
CREATE TABLE `t_liste` (
  `id_liste`      INT AUTO_INCREMENT PRIMARY KEY,
  `nom`           VARCHAR(100) NOT NULL,
  `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table associative t_contient (relation n-n entre liste et thé)
CREATE TABLE `t_contient` (
  `fk_id_liste` INT NOT NULL,
  `fk_id_the`   INT NOT NULL,
  PRIMARY KEY (`fk_id_liste`, `fk_id_the`),
  CONSTRAINT `fk_liste_the_liste`
    FOREIGN KEY (`fk_id_liste`)
    REFERENCES `t_liste` (`id_liste`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_liste_the_the`
    FOREIGN KEY (`fk_id_the`)
    REFERENCES `t_the` (`id_the`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
