-- MySQL Script generated by MySQL Workbench
-- mié 20 nov 2019 17:38:59 -03
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema FinanceLibre
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `FinanceLibre` ;

-- -----------------------------------------------------
-- Schema FinanceLibre
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `FinanceLibre` ;
USE `FinanceLibre` ;

-- -----------------------------------------------------
-- Table `FinanceLibre`.`fcl_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FinanceLibre`.`fcl_user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(200) NOT NULL,
  `name` VARCHAR(45) NULL,
  `locale` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FinanceLibre`.`fcl_account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FinanceLibre`.`fcl_account` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `currency` VARCHAR(45) NULL,
  `balance` DOUBLE NULL,
  `type` VARCHAR(45) NOT NULL,
  `description` VARCHAR(300) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_account_user_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_account_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `FinanceLibre`.`fcl_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FinanceLibre`.`fcl_transaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `FinanceLibre`.`fcl_transaction` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `amount` DOUBLE NOT NULL,
  `short` VARCHAR(45) NOT NULL,
  `description` VARCHAR(300) NULL,
  `date` DATETIME(4) NOT NULL,
  `from_account` INT NOT NULL,
  `to_account` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_fcl_transaction_flc_account1_idx` (`from_account` ASC) VISIBLE,
  INDEX `fk_fcl_transaction_flc_account2_idx` (`to_account` ASC) VISIBLE,
  CONSTRAINT `fk_fcl_transaction_flc_account1`
    FOREIGN KEY (`from_account`)
    REFERENCES `FinanceLibre`.`fcl_account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fcl_transaction_flc_account2`
    FOREIGN KEY (`to_account`)
    REFERENCES `FinanceLibre`.`fcl_account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
