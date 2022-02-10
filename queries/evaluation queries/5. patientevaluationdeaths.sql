CREATE TABLE `patientevaluationdeaths` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `facilityname` varchar(255) DEFAULT NULL,
  `personid` int(6) DEFAULT NULL,
  `datedeathrecorded` datetime DEFAULT NULL,
  `dateofdeath` datetime DEFAULT NULL,
  `causesofdeath` varchar(255) DEFAULT NULL,
  `specificcausesofdeath` varchar(255) DEFAULT NULL,
  `ageatdeath` int(6) DEFAULT NULL,
  `monthsonart` int(6) DEFAULT NULL,
  `previousartstatus` varchar(255) DEFAULT NULL,
  `reportingtimespan` varchar(255) DEFAULT NULL,
  `reportingperiod` varchar(255) DEFAULT NULL,
  `reportenddate` varchar(255) DEFAULT NULL,
  `refreshdate` datetime DEFAULT NULL,
  `refreshedby` int(6) DEFAULT NULL,
  `voided` int(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37682 DEFAULT CHARSET=latin1;
