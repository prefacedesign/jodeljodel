SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb`;

-- -----------------------------------------------------
-- Table `auth_authors`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `auth_authors` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `surname` VARCHAR(255) NULL ,
  `name` VARCHAR(255) NULL ,
  `reference_name` VARCHAR(255) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `news_news`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `news_news` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `auth_author_id` INT NULL ,
  `publishing_status` ENUM('published','draft') NULL ,
  `title` VARCHAR(255) NULL ,
  `date` VARCHAR(255) NULL ,
  `abstract` TEXT NULL ,
  `content` TEXT NULL ,
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
-- Table `img_images`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `img_images` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pers_people`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pers_people` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `auth_author_id` INT NULL ,
  `img_image_id` INT NULL ,
  `publishing_status` ENUM('published','draft') NULL ,
  `surname` VARCHAR(255) NULL ,
  `name` VARCHAR(255) NULL ,
  `reference_name` VARCHAR(255) NULL ,
  `lattes_link` VARCHAR(255) NULL ,
  `research_fields` TEXT NULL ,
  `profile` TEXT NULL ,
  `cooperation_with_dinafon` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pers_people_auth_authors1` (`auth_author_id` ASC) ,
  INDEX `fk_pers_people_img_images1` (`img_image_id` ASC) ,
  CONSTRAINT `fk_pers_people_auth_authors1`
    FOREIGN KEY (`auth_author_id` )
    REFERENCES `auth_authors` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pers_people_img_images1`
    FOREIGN KEY (`img_image_id` )
    REFERENCES `img_images` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sfil_stored_files`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sfil_stored_files` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `file_files`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `file_files` (
  `id` INT NOT NULL ,
  `sfil_stored_file_id` INT NULL ,
  `type_o_file` ENUM('stored','link') NULL ,
  `title` INT NULL ,
  `type` VARCHAR(45) NULL ,
  `subtitle` VARCHAR(255) NULL ,
  `link` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_file_files_sfil_stored_files1` (`sfil_stored_file_id` ASC) ,
  CONSTRAINT `fk_file_files_sfil_stored_files1`
    FOREIGN KEY (`sfil_stored_file_id` )
    REFERENCES `sfil_stored_files` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `jour_journals`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `jour_journals` (
  `id` INT NOT NULL ,
  `full_name` VARCHAR(255) NULL ,
  `short_name` VARCHAR(255) NULL ,
  `link` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pap_papers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pap_papers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `file_file_id` INT NULL ,
  `jour_journal_id` INT NULL ,
  `publishing_status` ENUM('published','draft') NULL ,
  `title` TEXT NULL ,
  `abstract` VARCHAR(255) NULL ,
  `date` DATE NULL ,
  `complete_reference` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pap_papers_file_files1` (`file_file_id` ASC) ,
  INDEX `fk_pap_papers_jour_journals1` (`jour_journal_id` ASC) ,
  CONSTRAINT `fk_pap_papers_file_files1`
    FOREIGN KEY (`file_file_id` )
    REFERENCES `file_files` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pap_papers_jour_journals1`
    FOREIGN KEY (`jour_journal_id` )
    REFERENCES `jour_journals` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tags`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tags` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NULL ,
  `identifier` VARCHAR(255) NULL ,
  `keyname` VARCHAR(255) NULL ,
  `weight` INT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pap_papers_tags`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pap_papers_tags` (
  `pap_paper_id` INT NOT NULL ,
  `tag_id` INT NOT NULL ,
  PRIMARY KEY (`pap_paper_id`, `tag_id`) ,
  INDEX `fk_pap_papers_has_tags_pap_papers1` (`pap_paper_id` ASC) ,
  INDEX `fk_pap_papers_has_tags_tags1` (`tag_id` ASC) ,
  CONSTRAINT `fk_pap_papers_has_tags_pap_papers1`
    FOREIGN KEY (`pap_paper_id` )
    REFERENCES `pap_papers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pap_papers_has_tags_tags1`
    FOREIGN KEY (`tag_id` )
    REFERENCES `tags` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eve_events`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `eve_events` (
  `id` INT NOT NULL ,
  `publishing_status` ENUM('published','draft') NULL ,
  `name` VARCHAR(255) NULL ,
  `abstract` VARCHAR(255) NULL ,
  `link` TEXT NULL ,
  `begins` DATETIME NULL ,
  `ends` DATETIME NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `auth_authors_pap_papers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `auth_authors_pap_papers` (
  `auth_author_id` INT NOT NULL ,
  `pap_paper_id` INT NOT NULL ,
  PRIMARY KEY (`auth_author_id`, `pap_paper_id`) ,
  INDEX `fk_auth_authors_has_pap_papers_auth_authors1` (`auth_author_id` ASC) ,
  INDEX `fk_auth_authors_has_pap_papers_pap_papers1` (`pap_paper_id` ASC) ,
  CONSTRAINT `fk_auth_authors_has_pap_papers_auth_authors1`
    FOREIGN KEY (`auth_author_id` )
    REFERENCES `auth_authors` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_auth_authors_has_pap_papers_pap_papers1`
    FOREIGN KEY (`pap_paper_id` )
    REFERENCES `pap_papers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dash_dashboard_items`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dash_dashboard_items` (
  `id` VARCHAR(255) NOT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `dashable_id` INT NULL ,
  `dashable_model` VARCHAR(60) NULL ,
  `status` ENUM('published','draft','removed') NULL ,
  `name` VARCHAR(255) NULL ,
  `info` VARCHAR(255) NULL ,
  `idiom` VARCHAR(255) NULL ,
  `type` VARCHAR(60) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
