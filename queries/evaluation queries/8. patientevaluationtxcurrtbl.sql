CREATE TABLE `patientevaluationtxcurr` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `facilityname` varchar(255) DEFAULT NULL,
  `personid` int(6) DEFAULT NULL,
  `txcurrstatus` varchar(255) DEFAULT NULL,
  `daysdefaulted` int(6) DEFAULT NULL,
  `reportingtimespan` varchar(255) DEFAULT NULL,
  `reportingperiod` varchar(255) DEFAULT NULL,
  `reportenddate` varchar(255) DEFAULT NULL,
  `refreshdate` datetime DEFAULT NULL,
  `refreshedby` int(6) DEFAULT NULL,
  `voided` int(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2725756 DEFAULT CHARSET=latin1;
