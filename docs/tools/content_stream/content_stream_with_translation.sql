SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `cs_content_streams`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cs_content_streams` (
  `id` VARCHAR(36) NOT NULL ,
  `type` VARCHAR(255) NULL DEFAULT NULL ,
  `created` DATETIME NULL DEFAULT NULL ,
  `modified` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cs_items`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cs_items` (
  `id` VARCHAR(36) NOT NULL ,
  `cs_content_stream_id` VARCHAR(36) NOT NULL ,
  `order` INT NULL DEFAULT NULL ,
  `foreign_key` VARCHAR(36) NULL DEFAULT NULL ,
  `type` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cs_items_cs_content_streams1` (`cs_content_stream_id` ASC) ,
  CONSTRAINT `fk_cs_items_cs_content_streams1`
    FOREIGN KEY (`cs_content_stream_id` )
    REFERENCES `cs_content_streams` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cs_corks`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cs_corks` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `type` VARCHAR(25) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cs_corks_cs_content_streams1` (`cs_content_stream_id` ASC) ,
  CONSTRAINT `fk_cs_corks_cs_content_streams1`
    FOREIGN KEY (`cs_content_stream_id` )
    REFERENCES `cs_content_streams` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cs_cork_translations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cs_cork_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_cork_id` int(11) DEFAULT NULL,
  `cs_content_stream_id` varchar(36) DEFAULT NULL,
  `language` varchar(3) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cs_cork_translations_cs_corks1` (`cs_cork_id`),
  KEY `fk_cs_cork_translations_cs_content_streams1` (`cs_content_stream_id`)
) ENGINE=InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
