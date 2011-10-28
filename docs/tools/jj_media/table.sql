CREATE TABLE IF NOT EXISTS `sfil_stored_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checksum` varchar(255) NOT NULL,
  `dirname` varchar(255) NOT NULL,
  `basename` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `mime_type` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `original_id` int(11) DEFAULT NULL,
  `transformation_version` int(11) DEFAULT NULL,
  `transformation` varchar(255) DEFAULT NULL,
  `data` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
