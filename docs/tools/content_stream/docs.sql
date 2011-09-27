SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `cs_content_streams`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cs_content_streams` (
  `id` VARCHAR(36) NOT NULL ,
  `type` VARCHAR(255) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cs_items`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cs_items` (
  `id` VARCHAR(36) NOT NULL ,
  `cs_content_stream_id` VARCHAR(36) NOT NULL ,
  `order` INT NULL ,
  `foreign_key` VARCHAR(36) NULL ,
  `type` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cs_items_cs_content_streams1` (`cs_content_stream_id` ASC) ,
  CONSTRAINT `fk_cs_items_cs_content_streams1`
    FOREIGN KEY (`cs_content_stream_id` )
    REFERENCES `cs_content_streams` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
