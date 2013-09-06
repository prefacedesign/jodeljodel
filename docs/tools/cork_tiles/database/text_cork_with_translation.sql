CREATE TABLE IF NOT EXISTS `text_text_corks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cake_fooler_field` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `text_text_cork_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text_text_cork_id` int(11) DEFAULT NULL,
  `text` text,
  `language` varchar(3) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_text_text_cork_translations_text_text_corks1` (`text_text_cork_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


ALTER TABLE `text_text_cork_translations`
  ADD CONSTRAINT `fk_text_text_cork_translations_text_text_corks1` FOREIGN KEY (`text_text_cork_id`) REFERENCES `text_text_corks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
