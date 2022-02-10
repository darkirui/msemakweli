drop table if exists patientbaselinenutrition;
CREATE TABLE `patientbaselinenutrition` (
 `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `facilityname` varchar(255) DEFAULT NULL,
  `personid` int(6) DEFAULT NULL,
  `nutritionbaseline` varchar(255) DEFAULT NULL,
  `nutritiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
