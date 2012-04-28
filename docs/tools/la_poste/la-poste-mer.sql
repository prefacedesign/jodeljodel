SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `lp_letters`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lp_letters` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `lp_letter_type_id` INT NULL ,
  `space` VARCHAR(255) NULL ,
  `subject` VARCHAR(255) NULL ,
  `element` VARCHAR(200) NULL ,
  `data` TEXT NULL ,
  `rendered` TINYINT(1)  NULL ,
  `content` TEXT NULL ,
  `addresses` TEXT NULL ,
  `priority` INT NULL ,
  `send_time` DATETIME NULL ,
  `max_tries` INT NULL ,
  `status` ENUM('sending', 'to_send', 'sent', 'cancelled') NULL ,
  `lp_copy_count` INT NULL ,
  `lp_sent_copy_count` INT NULL ,
  `aux_identifier` VARCHAR(200) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `index2` (`lp_letter_type_id` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `lp_spaces`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lp_spaces` (
  `id` VARCHAR(200) NOT NULL ,
  `name` VARCHAR(200) NULL ,
  `description` VARCHAR(1000) NULL ,
  `addresses` TEXT NULL ,
  `prefix` VARCHAR(45) NULL )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `lp_letter_types`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lp_letter_types` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `lp_space_id` VARCHAR(200) NULL ,
  `slug` VARCHAR(200) NULL ,
  `addresses` TEXT NULL ,
  `prefix` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `lp_addresses`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lp_addresses` (
  `id` VARCHAR(200) NOT NULL ,
  `name` VARCHAR(200) NULL ,
  `description` VARCHAR(1000) NULL ,
  `email` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `lp_copies`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lp_copies` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `lp_letter_id` INT NULL ,
  `address` TEXT NULL ,
  `lp_try_count` INT NULL ,
  `sent` TINYINT(1)  NULL ,
  `sent_content` TEXT NULL ,
  `specific_data` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `index2` (`lp_letter_id` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `lp_tries`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lp_tries` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `lp_copy_id` INT NULL ,
  `created` DATETIME NULL ,
  `successful` TINYINT(1)  NULL ,
  `time_spent` INT NULL ,
  `method` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `index2` (`lp_copy_id` ASC) )
ENGINE = MyISAM;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

