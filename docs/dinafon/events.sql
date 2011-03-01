SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

drop table `eve_events`;

-- -----------------------------------------------------
-- Table `eve_events`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `eve_events` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `publishing_status` ENUM('published','draft') NULL ,
  `link` TEXT NULL ,
  `begins` DATETIME NULL ,
  `ends` DATETIME NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eve_event_translations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `eve_event_translations` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `eve_event_id` INT NULL ,
  `name` VARCHAR(255) NULL ,
  `abstract` VARCHAR(255) NULL ,
  `language` VARCHAR(3) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_eve_event_translations_eve_events` (`eve_event_id` ASC) ,
  CONSTRAINT `fk_eve_event_translations_eve_events`
    FOREIGN KEY (`eve_event_id` )
    REFERENCES `eve_events` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
