SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


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
-- Table `jour_journals`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `jour_journals` (
  `id` INT NOT NULL AUTO_INCREMENT ,
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
-- Table `sfil_stored_files`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sfil_stored_files` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `checksum` VARCHAR(255) NOT NULL ,
  `dirname` VARCHAR(255) NOT NULL ,
  `basename` VARCHAR(255) NOT NULL ,
  `original_filename` VARCHAR(255) NOT NULL ,
  `mime_type` VARCHAR(255) NOT NULL ,
  `size` INT NOT NULL ,
  `width` INT NULL ,
  `height` INT NULL ,
  `original_id` INT NULL ,
  `transformation_version` INT NULL ,
  `transformation` VARCHAR(255) NULL ,
  `data` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
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
-- Table `eve_events`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `eve_events` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `publishing_status` ENUM('published','draft') NULL ,
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
  `dashable_id` VARCHAR(255) NULL ,
  `dashable_model` VARCHAR(60) NULL ,
  `status` ENUM('published','draft','removed') NULL ,
  `name` VARCHAR(255) NULL ,
  `info` VARCHAR(255) NULL ,
  `idiom` VARCHAR(255) NULL ,
  `type` VARCHAR(60) NULL ,
  PRIMARY KEY (`id`) )
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
  `cake_fooler_field` TINYINT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_groups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_groups` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `lft` INT NULL ,
  `rght` INT NULL ,
  `parent_id` INT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  `alias` VARCHAR(60) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_user_groups_user_groups1` (`parent_id` ASC) ,
  INDEX `klft` (`lft` ASC) ,
  INDEX `kname` (`name` ASC) ,
  INDEX `krght` (`rght` ASC) ,
  INDEX `kparent` (`parent_id` ASC) ,
  CONSTRAINT `fk_user_groups_user_groups1`
    FOREIGN KEY (`parent_id` )
    REFERENCES `user_groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_group_id` INT NOT NULL ,
  `username` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `surname` VARCHAR(80) NULL ,
  `name` VARCHAR(80) NULL ,
  `email` VARCHAR(255) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`, `user_group_id`) ,
  INDEX `fk_user_users_user_groups1` (`user_group_id` ASC) ,
  CONSTRAINT `fk_user_users_user_groups1`
    FOREIGN KEY (`user_group_id` )
    REFERENCES `user_groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `acos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `acos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `parent_id` INT NULL ,
  `model` VARCHAR(255) NULL ,
  `foreign_key` VARCHAR(255) NULL ,
  `alias` VARCHAR(255) NULL ,
  `lft` INT NULL ,
  `rght` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_acos_acos1` (`parent_id` ASC) ,
  UNIQUE INDEX `k_foreign` (`model` ASC, `foreign_key` ASC) ,
  INDEX `k_lft` (`lft` ASC) ,
  INDEX `k_rght` (`rght` ASC) ,
  INDEX `k_alias` (`alias` ASC) ,
  CONSTRAINT `fk_acos_acos1`
    FOREIGN KEY (`parent_id` )
    REFERENCES `acos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `aros`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `aros` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `parent_id` INT NULL ,
  `model` VARCHAR(255) NULL ,
  `foreign_key` VARCHAR(255) NULL ,
  `alias` VARCHAR(255) NULL ,
  `lft` INT NULL ,
  `rght` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_aros_aros1` (`parent_id` ASC) ,
  UNIQUE INDEX `k_foreign_1` (`model` ASC, `foreign_key` ASC) ,
  INDEX `k_lft_1` (`lft` ASC) ,
  INDEX `k_rght_1` (`rght` ASC) ,
  INDEX `k_alias_1` (`alias` ASC) ,
  CONSTRAINT `fk_aros_aros1`
    FOREIGN KEY (`parent_id` )
    REFERENCES `aros` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `aros_acos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `aros_acos` (
  `aco_id` INT NOT NULL ,
  `aro_id` INT NOT NULL ,
  `id` INT NOT NULL AUTO_INCREMENT ,
  `_create` VARCHAR(2) NULL ,
  `_read` VARCHAR(2) NULL ,
  `_edit` VARCHAR(2) NULL ,
  `_delete` VARCHAR(2) NULL ,
  `_draftread` VARCHAR(2) NULL ,
  `_draftcreate` VARCHAR(2) NULL ,
  `_draftedit` VARCHAR(2) NULL ,
  `_draftdelete` VARCHAR(2) NULL ,
  `_publish` VARCHAR(2) NULL ,
  `_critical` VARCHAR(2) NULL ,
  `_redbutton` VARCHAR(2) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_acos_has_aros_acos1` (`aco_id` ASC) ,
  INDEX `fk_acos_has_aros_aros1` (`aro_id` ASC) ,
  CONSTRAINT `fk_acos_has_aros_acos1`
    FOREIGN KEY (`aco_id` )
    REFERENCES `acos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acos_has_aros_aros1`
    FOREIGN KEY (`aro_id` )
    REFERENCES `aros` (`id` )
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
    REFERENCES `pers_people` (`id` )
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


-- -----------------------------------------------------
-- Table `eve_event_translations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `eve_event_translations` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `eve_event_id` INT NULL ,
  `name` VARCHAR(255) NULL ,
  `abstract` TEXT NULL ,
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
