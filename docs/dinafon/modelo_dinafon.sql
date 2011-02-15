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
-- Table `din_files`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `din_files` (
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
  `din_file_id` INT NULL ,
  `jour_journal_id` INT NULL ,
  `publishing_status` ENUM('published','draft') NULL ,
  `title` TEXT NULL ,
  `abstract` VARCHAR(255) NULL ,
  `date` DATE NULL ,
  `complete_reference` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pap_papers_file_files1` (`din_file_id` ASC) ,
  INDEX `fk_pap_papers_jour_journals1` (`jour_journal_id` ASC) ,
  CONSTRAINT `fk_pap_papers_file_files1`
    FOREIGN KEY (`din_file_id` )
    REFERENCES `din_files` (`id` )
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
  `text` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
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
  `slug` VARCHAR(60) NULL ,
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
  UNIQUE INDEX `k_foreign` (`parent_id` ASC, `model` ASC) ,
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
  INDEX `fk_acos_acos1` (`parent_id` ASC) ,
  UNIQUE INDEX `k_foreign` (`parent_id` ASC, `model` ASC) ,
  INDEX `k_lft` (`lft` ASC) ,
  INDEX `k_rght` (`rght` ASC) ,
  INDEX `k_alias` (`alias` ASC) ,
  CONSTRAINT `fk_acos_acos1`
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

