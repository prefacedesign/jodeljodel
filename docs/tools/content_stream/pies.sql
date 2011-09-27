SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `pie_texts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pie_texts` (
  `id` VARCHAR(36) NOT NULL ,
  `text` TEXT NULL ,
  `processed_text` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `pie_dividers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pie_dividers` (
  `id` VARCHAR(36) NOT NULL ,
  `type` VARCHAR(45) NULL ,
  `label` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pie_images`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pie_images` (
  `id` VARCHAR(36) NOT NULL ,
  `sfil_stored_file_id` INT NULL ,
  `title` VARCHAR(255) NULL ,
  `subtitle` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pie_files`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pie_files` (
  `id` VARCHAR(36) NOT NULL ,
  `sfilt_stored_file_id` INT NULL ,
  `title` VARCHAR(255) NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pie_titles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pie_titles` (
  `id` VARCHAR(36) NOT NULL ,
  `title` VARCHAR(255) NULL ,
  `level` VARCHAR(3) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
