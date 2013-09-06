CREATE TABLE IF NOT EXISTS `text_text_corks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
