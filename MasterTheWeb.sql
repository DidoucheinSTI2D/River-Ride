

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `MasterTheWeb` DEFAULT CHARACTER SET utf8 ;
USE `MasterTheWeb` ;

-- -----------------------------------------------------
-- Table `MasterTheWeb`.`Chat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`Chat` (
  `id_Chat` INT(11) NOT NULL AUTO_INCREMENT,
  `privé/publique` VARCHAR(8) NOT NULL,
  `Id_rédacteur` INT(11) NOT NULL,
  PRIMARY KEY (`id_Chat`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `MasterTheWeb`.`Journal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`Journal` (
  `id_Journal` INT(11) NOT NULL AUTO_INCREMENT,
  `Titre` VARCHAR(100) NOT NULL,
  `date_création` DATE NOT NULL,
  `Contenu` TEXT NOT NULL,
  `Rédacteur` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id_Journal`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `MasterTheWeb`.`Utilisateur`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`Utilisateur` (
  `id_Utilisateur` INT(11) NOT NULL AUTO_INCREMENT,
  `Pseudo` VARCHAR(30) NOT NULL,
  `Droits` VARCHAR(5) NOT NULL,
  `e-mail` VARCHAR(45) NOT NULL,
  `Mot_de_passe` VARCHAR(60) NOT NULL,
  `date_de_naissance` DATE NOT NULL,
  `last_login` DATE NOT NULL,
  `isban` BOOLEAN DEFAULT FALSE,
  `rond`  VARCHAR(50) NOT NULL,
  `yeux`  VARCHAR(50) NOT NULL,
  `nez`  VARCHAR(50) NOT NULL,
  `sourire`  VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_Utilisateur`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `MasterTheWeb`.`Topic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`Topic` (
  `id_Topic` INT(11) NOT NULL AUTO_INCREMENT,
  `titre` VARCHAR(60) NOT NULL,
  `date_création` DATE NOT NULL,
  `contenu` TEXT NOT NULL,
  `Utilisateur_id_Utilisateur` INT(11) NOT NULL,
  PRIMARY KEY (`id_Topic`),
  INDEX `fk_Topic_Utilisateur1_idx` (`Utilisateur_id_Utilisateur` ASC) ,
  CONSTRAINT `fk_Topic_Utilisateur1`
    FOREIGN KEY (`Utilisateur_id_Utilisateur`)
    REFERENCES `MasterTheWeb`.`Utilisateur` (`id_Utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `MasterTheWeb`.`Commentaires`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`Commentaires` (
  `id_Commentaires` INT(11) NOT NULL AUTO_INCREMENT,
  `Contenu` VARCHAR(255) NOT NULL,
  `Pseudo` VARCHAR(20) NOT NULL,
  `Date` DATETIME NOT NULL,
  `Utilisateur_id_Utilisateur` INT(11) NULL,
  `Journal_id_Journal` INT(11) NULL,
  `Topic_id_Topic` INT(11) NULL,
  PRIMARY KEY (`id_Commentaires`),
  INDEX `fk_Commentaires_Utilisateur1_idx` (`Utilisateur_id_Utilisateur` ASC) ,
  INDEX `fk_Commentaires_Journal1_idx` (`Journal_id_Journal` ASC) ,
  INDEX `fk_Commentaires_Topic1_idx` (`Topic_id_Topic` ASC) ,
  CONSTRAINT `fk_Commentaires_Journal1`
    FOREIGN KEY (`Journal_id_Journal`)
    REFERENCES `MasterTheWeb`.`Journal` (`id_Journal`)
    ON DELETE CASCADE,
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Commentaires_Utilisateur1`
    FOREIGN KEY (`Utilisateur_id_Utilisateur`)
    REFERENCES `MasterTheWeb`.`Utilisateur` (`id_Utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Commentaires_Topic1`
    FOREIGN KEY (`Topic_id_Topic`)
    REFERENCES `MasterTheWeb`.`Topic` (`id_Topic`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `MasterTheWeb`.`LearnToWin_Cours`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`LearnToWin_Cours` (
  `idLearnToWin_Cours` INT(11) NOT NULL AUTO_INCREMENT,
  `Contenu` TEXT NOT NULL,
  `Utilisateur_id_Utilisateur` INT(11) NOT NULL,
  PRIMARY KEY (`idLearnToWin_Cours`),
  INDEX `fk_LearnToWin_Cours_Utilisateur1_idx` (`Utilisateur_id_Utilisateur` ASC) ,
  CONSTRAINT `fk_LearnToWin_Cours_Utilisateur1`
    FOREIGN KEY (`Utilisateur_id_Utilisateur`)
    REFERENCES `MasterTheWeb`.`Utilisateur` (`id_Utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `MasterTheWeb`.`Messages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`Messages` (
  `Id_message` INT(11) NOT NULL AUTO_INCREMENT,
  `Date_du_message` DATE NOT NULL,
  `Utilisateur_id_Utilisateur` INT(11) NOT NULL,
  `Contenu` VARCHAR(255) NOT NULL,
  `Chat_id_Chat` INT(11) NOT NULL,
  PRIMARY KEY (`Id_message`),
  INDEX `fk_Messages_Utilisateur1_idx` (`Utilisateur_id_Utilisateur` ASC) ,
  INDEX `fk_Messages_Chat1_idx` (`Chat_id_Chat` ASC) ,
  CONSTRAINT `fk_Messages_Chat1`
    FOREIGN KEY (`Chat_id_Chat`)
    REFERENCES `MasterTheWeb`.`Chat` (`id_Chat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Messages_Utilisateur1`
    FOREIGN KEY (`Utilisateur_id_Utilisateur`)
    REFERENCES `MasterTheWeb`.`Utilisateur` (`id_Utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `MasterTheWeb`.`Note`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`Note` (
  `id_Note` INT(11) NOT NULL AUTO_INCREMENT,
  `Valeur` INT(11) NOT NULL,
  `Date` DATE NOT NULL,
  `Utilisateur_id_Utilisateur` INT(11) NOT NULL,
  `Journal_id_Journal` INT(11) NOT NULL,
  PRIMARY KEY (`id_Note`),
  INDEX `fk_Note_Utilisateur1_idx` (`Utilisateur_id_Utilisateur` ASC) ,
  INDEX `fk_Note_Journal1_idx` (`Journal_id_Journal` ASC) ,
  CONSTRAINT `fk_Note_Journal1`
    FOREIGN KEY (`Journal_id_Journal`)
    REFERENCES `MasterTheWeb`.`Journal` (`id_Journal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Note_Utilisateur1`
    FOREIGN KEY (`Utilisateur_id_Utilisateur`)
    REFERENCES `MasterTheWeb`.`Utilisateur` (`id_Utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `MasterTheWeb`.`Quizz`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`Quizz` (
  `idQuizz` INT(11) NOT NULL AUTO_INCREMENT,
  `Questions` TEXT NOT NULL,
  `LearnToWin_Cours_idLearnToWin_Cours` INT(11) NOT NULL,
  `Reponse` INT(11) NOT NULL,
  PRIMARY KEY (`idQuizz`),
  INDEX `fk_Quizz_LearnToWin_Cours1_idx` (`LearnToWin_Cours_idLearnToWin_Cours` ASC) ,
  CONSTRAINT `fk_Quizz_LearnToWin_Cours1`
    FOREIGN KEY (`LearnToWin_Cours_idLearnToWin_Cours`)
    REFERENCES `MasterTheWeb`.`LearnToWin_Cours` (`idLearnToWin_Cours`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `MasterTheWeb`.`Token`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`Token` (
  `id_Token` INT(11) NOT NULL AUTO_INCREMENT,
  `Tx_Id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_Token`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `MasterTheWeb`.`Utilisateur_chat_Utilisateur`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`Utilisateur_chat_Utilisateur` (
  `Utilisateur_id_Utilisateur` INT(11) NOT NULL AUTO_INCREMENT,
  `Utilisateur_id_Utilisateur1` INT(11) NOT NULL,
  `contenu` TEXT NOT NULL,
  `date` DATE NOT NULL,
  PRIMARY KEY (`Utilisateur_id_Utilisateur`, `Utilisateur_id_Utilisateur1`),
  INDEX `fk_Utilisateur_has_Utilisateur_Utilisateur2_idx` (`Utilisateur_id_Utilisateur1` ASC) ,
  INDEX `fk_Utilisateur_has_Utilisateur_Utilisateur1_idx` (`Utilisateur_id_Utilisateur` ASC) ,
  CONSTRAINT `fk_Utilisateur_has_Utilisateur_Utilisateur1`
    FOREIGN KEY (`Utilisateur_id_Utilisateur`)
    REFERENCES `MasterTheWeb`.`Utilisateur` (`id_Utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Utilisateur_has_Utilisateur_Utilisateur2`
    FOREIGN KEY (`Utilisateur_id_Utilisateur1`)
    REFERENCES `MasterTheWeb`.`Utilisateur` (`id_Utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `MasterTheWeb`.`Utilisateur_has_Token`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`Utilisateur_has_Token` (
  `Utilisateur_id_Utilisateur` INT(11) NOT NULL,
  `Token_id_Token` INT(11) NOT NULL,
  `nombre` INT(11) NOT NULL,
  PRIMARY KEY (`Utilisateur_id_Utilisateur`, `Token_id_Token`),
  INDEX `fk_Utilisateur_has_Token_Token1_idx` (`Token_id_Token` ASC) ,
  INDEX `fk_Utilisateur_has_Token_Utilisateur1_idx` (`Utilisateur_id_Utilisateur` ASC) ,
  CONSTRAINT `fk_Utilisateur_has_Token_Token1`
    FOREIGN KEY (`Token_id_Token`)
    REFERENCES `MasterTheWeb`.`Token` (`id_Token`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Utilisateur_has_Token_Utilisateur1`
    FOREIGN KEY (`Utilisateur_id_Utilisateur`)
    REFERENCES `MasterTheWeb`.`Utilisateur` (`id_Utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;



CREATE TABLE IF NOT EXISTS `MasterTheWeb`.`coindumoment` (
  `id_Coin` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(60) NOT NULL,
  `prix` FLOAT NOT NULL,
  `potentiel` CHAR(8) NOT NULL,
  `commentaire` TEXT,
  `lien` VARCHAR(255),
  'date' DATETIME NOT NULL,
  PRIMARY KEY (`id_Coin`)) 
ENGINE = InnoDB 
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
