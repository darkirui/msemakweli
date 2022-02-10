drop table if exists patientbaselinecd4;
CREATE TABLE `patientbaselinecd4` (
	`id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `facilityname` varchar(255) DEFAULT NULL,
  `personid` int(6) DEFAULT NULL,
  `baselinecd4` varchar(255) DEFAULT NULL,
  `baselinecd4date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
