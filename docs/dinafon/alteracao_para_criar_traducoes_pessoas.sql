SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb`;

-- -----------------------------------------------------
-- Table `pers_people`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pers_people` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `auth_author_id` INT NULL ,
  `img_id` INT NULL ,
  `publishing_status` ENUM('published','draft') NULL ,
  `lattes_link` VARCHAR(255) NULL ,
  `phone1` VARCHAR(100) NULL ,
  `phone2` VARCHAR(100) NULL ,
  `link1` VARCHAR(255) NULL ,
  `link1_caption` VARCHAR(50) NULL ,
  `link2` VARCHAR(255) NULL ,
  `link2_caption` VARCHAR(50) NULL ,
  `link3` VARCHAR(255) NULL ,
  `link3_caption` VARCHAR(50) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pers_people_auth_authors1` (`auth_author_id` ASC) ,
  INDEX `fk_pers_people_img_images1` (`img_id` ASC) ,
  CONSTRAINT `fk_pers_people_auth_authors1`
    FOREIGN KEY (`auth_author_id` )
    REFERENCES `auth_authors` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pers_person_translations`
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `pers_person_translations` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `pers_person_id` INT NOT NULL ,
  `research_fields` TEXT NULL ,
  `profile` TEXT NULL ,
  `cooperation_with_dinafon` TEXT NULL ,
  `position` TEXT NULL ,
  `language` VARCHAR(3) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pers_people_translations_pers_people` (`pers_person_id` ASC) ,
  CONSTRAINT `fk_pers_people_translations_pers_people`
    FOREIGN KEY (`pers_person_id` )
    REFERENCES `jodeljodel`.`pers_people` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
