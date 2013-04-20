SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `request_logs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `request_logs` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `time` DATETIME NULL ,
  `user_id` INT NULL ,
  `session_id` VARCHAR(255) NULL ,
  `ip` VARCHAR(255) NULL ,
  `user_agent` TEXT NULL ,
  `browser_name` VARCHAR(255) NULL ,
  `browser_version` VARCHAR(255) NULL ,
  `os` VARCHAR(255) NULL ,
  `url` TEXT NULL ,
  `plugin` VARCHAR(111) NULL ,
  `controller` VARCHAR(111) NULL ,
  `action` VARCHAR(111) NULL ,
  `params` TEXT NULL ,
  `method` VARCHAR(10) NULL ,
  `post` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL ,
  `extra_fields` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `k_plugin_controller_action` (`plugin` ASC, `controller` ASC, `action` ASC) ,
  INDEX `k_time` (`time` ASC) ,
  INDEX `k_session_id` (`session_id` ASC) ,
  INDEX `k_ip` (`ip` ASC) ,
  INDEX `k_url` (`url`(255) ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1
COLLATE = latin1_general_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
