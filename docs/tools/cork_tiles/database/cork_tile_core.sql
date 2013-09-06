CREATE TABLE IF NOT EXISTS `cork_corktiles` (
  `id` varchar(255) NOT NULL,
  `type` varchar(128) DEFAULT NULL,
  `content_id` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `instructions` text,
  `location` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `options` text,
  PRIMARY KEY (`id`),
  KEY `k_type` (`type`),
  KEY `k_content_id` (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
