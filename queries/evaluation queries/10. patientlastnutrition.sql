drop table if exists patientlastnutrition;
CREATE TABLE `patientlastnutrition` (
	`id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `facilityname` varchar(255) DEFAULT NULL,
  `personid` int(6) DEFAULT NULL,
  `lastnutritionstatus` varchar(255) DEFAULT NULL,
  `nutrtiondate` datetime DEFAULT NULL,
  `reportingtimespan` varchar(255) DEFAULT NULL,
  `reportingperiod` varchar(255) DEFAULT NULL,
  `refreshdate` datetime DEFAULT NULL,
  `refreshedby` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;