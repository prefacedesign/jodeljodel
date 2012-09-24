SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

-- -----------------------------------------------------
-- Table `user_users`
-- -----------------------------------------------------
CREATE TABLE `user_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `surname` varchar(80) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


-- -----------------------------------------------------
-- Table `user_profiles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_profiles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NULL ,
  `slug` VARCHAR(60) NULL ,
  `description` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_permissions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_permissions` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NULL ,
  `slug` VARCHAR(255) NULL ,
  `description` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_profiles_user_permissions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_profiles_user_permissions` (
  `user_profile_id` INT NOT NULL ,
  `user_permission_id` INT NOT NULL ,
  PRIMARY KEY (`user_profile_id`, `user_permission_id`) ,
  INDEX `fk_user_profiles_user_permissions_user_permissions1` (`user_permission_id` ASC) ,
  INDEX `fk_user_profiles_user_permissions_user_profiles` (`user_profile_id` ASC) ,
  CONSTRAINT `fk_user_profiles_user_permissions_user_profiles`
    FOREIGN KEY (`user_profile_id` )
    REFERENCES `user_profiles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_profiles_user_permissions_user_permissions1`
    FOREIGN KEY (`user_permission_id` )
    REFERENCES `user_permissions` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_users_user_profiles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_users_user_profiles` (
  `user_user_id` INT NOT NULL ,
  `user_profile_id` INT NOT NULL ,
  PRIMARY KEY (`user_user_id`, `user_profile_id`) ,
  INDEX `fk_user_users_user_profiles_user_profiles1` (`user_profile_id` ASC) ,
  INDEX `fk_user_users_user_profiles_user_users1` (`user_user_id` ASC) ,
  CONSTRAINT `fk_user_users_user_profiles_user_users1`
    FOREIGN KEY (`user_user_id` )
    REFERENCES `user_users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_users_user_profiles_user_profiles1`
    FOREIGN KEY (`user_profile_id` )
    REFERENCES `user_profiles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
