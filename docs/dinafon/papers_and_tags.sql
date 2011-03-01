SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

-- -----------------------------------------------------
-- Table `jour_journals`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `jour_journals` (
  `id` INT NOT NULL AUTO_INCREMENT,
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
  `jour_journal_id` INT NULL ,
  `publishing_status` ENUM('published','draft') NULL ,
  `date` DATE NULL ,
  `complete_reference` TEXT NULL ,
  `file_id` INT NULL ,
  `link_to_it` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pap_papers_jour_journals1` (`jour_journal_id` ASC) ,
  CONSTRAINT `fk_pap_papers_jour_journals1`
    FOREIGN KEY (`jour_journal_id` )
    REFERENCES `jour_journals` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tags_tags`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tags_tags` (
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
-- Table `cork_corktiles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cork_corktiles` (
  `id` VARCHAR(255) NOT NULL ,
  `type` VARCHAR(128) NULL ,
  `content_id` VARCHAR(255) NULL ,
  `title` VARCHAR(255) NULL ,
  `instructions` TEXT NULL ,
  `location` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `options` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `k_type` (`type` ASC) ,
  INDEX `k_content_id` (`content_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `text_text_corks`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `text_text_corks` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pap_paper_translations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pap_paper_translations` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `pap_paper_id` INT NULL ,
  `title` TEXT NULL ,
  `abstract` TEXT NULL ,
  `language` VARCHAR(3) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pap_paper_translations_pap_papers` (`pap_paper_id` ASC) ,
  INDEX `k_paper_language` (`pap_paper_id` ASC, `language` ASC) ,
  CONSTRAINT `fk_pap_paper_translations_pap_papers`
    FOREIGN KEY (`pap_paper_id` )
    REFERENCES `pap_papers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pap_paper_translations_tags_tags`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pap_paper_translations_tags_tags` (
  `pap_paper_translation_id` INT NOT NULL ,
  `tags_tag_id` INT NOT NULL ,
  PRIMARY KEY (`pap_paper_translation_id`, `tags_tag_id`) ,
  INDEX `fk_pap_paper_translations_has_tags_tags_pap_paper_translations` (`pap_paper_translation_id` ASC) ,
  INDEX `fk_pap_paper_translations_has_tags_tags_tags_tags` (`tags_tag_id` ASC) ,
  CONSTRAINT `fk_pap_paper_translations_has_tags_tags_pap_paper_translations`
    FOREIGN KEY (`pap_paper_translation_id` )
    REFERENCES `pap_paper_translations` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pap_paper_translations_has_tags_tags_tags_tags`
    FOREIGN KEY (`tags_tag_id` )
    REFERENCES `tags_tags` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `text_text_cork_translations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `text_text_cork_translations` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `text_text_cork_id` INT NULL ,
  `text` TEXT NULL ,
  `language` VARCHAR(3) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_text_text_cork_translations_text_text_corks` (`text_text_cork_id` ASC) ,
  INDEX `k_language_id` (`text_text_cork_id` ASC, `language` ASC) ,
  CONSTRAINT `fk_text_text_cork_translations_text_text_corks`
    FOREIGN KEY (`text_text_cork_id` )
    REFERENCES `text_text_corks` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
