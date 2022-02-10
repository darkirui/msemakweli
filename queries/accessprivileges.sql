CREATE TABLE `accessprivileges` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `privilegename` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;