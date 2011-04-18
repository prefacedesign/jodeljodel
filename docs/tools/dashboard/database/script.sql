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