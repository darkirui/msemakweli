CREATE TABLE `patientevaluationtransferout` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `facilityname` varchar(255) DEFAULT NULL,
  `personid` int(6) DEFAULT NULL,
  `datetransferrecorded` datetime DEFAULT NULL,
  `datetransferverified` datetime DEFAULT NULL,
  `dateoftransfer` datetime DEFAULT NULL,
  `ageattransfer` int(6) DEFAULT NULL,
  `transferouttofacility` varchar(255) DEFAULT NULL,
  `previousartstatus` varchar(255) DEFAULT NULL,
  `monthsonart` int(6) DEFAULT NULL,
  `reportingtimespan` varchar(255) DEFAULT NULL,
  `reportingperiod` varchar(255) DEFAULT NULL,
  `reportenddate` varchar(255) DEFAULT NULL,
  `refreshdate` datetime DEFAULT NULL,
  `refreshedby` int(6) DEFAULT NULL,
  `voided` int(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57395 DEFAULT CHARSET=latin1;
