CREATE TABLE `acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `k_foreign` (`model`,`foreign_key`),
  KEY `fk_acos_acos1` (`parent_id`),
  KEY `k_lft` (`lft`),
  KEY `k_rght` (`rght`),
  KEY `k_alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `aros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `k_foreign_1` (`model`,`foreign_key`),
  KEY `fk_aros_aros1` (`parent_id`),
  KEY `k_lft_1` (`lft`),
  KEY `k_rght_1` (`rght`),
  KEY `k_alias_1` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `aros_acos` (
  `aco_id` int(11) NOT NULL,
  `aro_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_create` varchar(2) DEFAULT NULL,
  `_read` varchar(2) DEFAULT NULL,
  `_edit` varchar(2) DEFAULT NULL,
  `_delete` varchar(2) DEFAULT NULL,
  `_draftread` varchar(2) DEFAULT NULL,
  `_draftcreate` varchar(2) DEFAULT NULL,
  `_draftedit` varchar(2) DEFAULT NULL,
  `_draftdelete` varchar(2) DEFAULT NULL,
  `_publish` varchar(2) DEFAULT NULL,
  `_critical` varchar(2) DEFAULT NULL,
  `_redbutton` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_acos_has_aros_acos1` (`aco_id`),
  KEY `fk_acos_has_aros_aros1` (`aro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `alias` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_groups_user_groups1` (`parent_id`),
  KEY `klft` (`lft`),
  KEY `kname` (`name`),
  KEY `krght` (`rght`),
  KEY `kparent` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `user_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `surname` varchar(80) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`user_group_id`),
  KEY `fk_user_users_user_groups1` (`user_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


ALTER TABLE `acos`
  ADD CONSTRAINT `fk_acos_acos1` FOREIGN KEY (`parent_id`) REFERENCES `acos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `aros`
  ADD CONSTRAINT `fk_aros_aros1` FOREIGN KEY (`parent_id`) REFERENCES `aros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `aros_acos`
  ADD CONSTRAINT `fk_acos_has_aros_acos1` FOREIGN KEY (`aco_id`) REFERENCES `acos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_acos_has_aros_aros1` FOREIGN KEY (`aro_id`) REFERENCES `aros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `user_groups`
  ADD CONSTRAINT `fk_user_groups_user_groups1` FOREIGN KEY (`parent_id`) REFERENCES `user_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `user_users`
  ADD CONSTRAINT `fk_user_users_user_groups1` FOREIGN KEY (`user_group_id`) REFERENCES `user_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
