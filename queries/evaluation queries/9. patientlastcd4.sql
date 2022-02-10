drop table if exists patientlastcd4;
CREATE TABLE `patientlastcd4` (
	`id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `facilityname` varchar(255) DEFAULT NULL,
  `personid` int(6) DEFAULT NULL,
  `lastcd4` varchar(255) DEFAULT NULL,
  `lastcd4date` datetime DEFAULT NULL,
  `reportingtimespan` varchar(255) DEFAULT NULL,
  `reportingperiod` varchar(255) DEFAULT NULL,
  `refreshdate` datetime DEFAULT NULL,
  `refreshedby` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
