SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `wsb_calls`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `wsb_calls` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `post` TEXT NULL ,
  `get` TEXT NULL ,
  `priority` INT NULL ,
  `max_tries` INT NULL ,
  `try_count` INT NULL ,
  `status` ENUM('trying', 'failed', 'successful', 'cancelled') NULL ,
  `successful_response` TEXT NULL ,
  `send_time` DATETIME NULL ,
  `created` DATETIME NULL ,
  `minimum_interval` INT NULL ,
  `last_try` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `wsb_tries`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `wsb_tries` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `wsb_call_id` INT NULL ,
  `created` DATETIME NULL ,
  `response` TEXT NULL ,
  `successful` TINYINT(1)  NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

