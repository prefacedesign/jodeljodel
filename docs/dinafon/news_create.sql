SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb`;

-- -----------------------------------------------------
-- Table `news_news`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `news_news` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `auth_author_id` INT NULL ,
  `publishing_status` ENUM('published','draft') NULL ,
  `date` DATETIME NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_news_news_auth_authors` (`auth_author_id` ASC) ,
  CONSTRAINT `fk_news_news_auth_authors`
    FOREIGN KEY (`auth_author_id` )
    REFERENCES `auth_authors` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `news_new_translations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `news_new_translations` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `news_new_id` INT NOT NULL ,
  `language` VARCHAR(3) NULL ,
  `title` VARCHAR(255) NULL ,
  `abstract` TEXT NULL ,
  `content` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_news_new_translations_news_news1` (`news_new_id` ASC) ,
  CONSTRAINT `fk_news_new_translations_news_news1`
    FOREIGN KEY (`news_new_id` )
    REFERENCES `news_news` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
