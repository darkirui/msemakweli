DELIMITER $$
DROP procedure if exists spcountvalidvls;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spcountvalidvls`(
	in reportingperiod varchar(100),
    in reportname varchar(100)
)
BEGIN
    set @querydropformerrecords = concat('
		select count(*) total from(
			select * from ',reportname,' where reportingperiod = ''',reportingperiod,''' and voided = 0
		)report left join
		(
			select * from patientlastvl where reportingperiod = ''',reportingperiod,''' and voided = 0
		)vls on report.facilityname = vls.facilityname and report.personid = vls.personid
		where 
		TIMESTAMPDIFF(MONTH, vls.lastvldate, vls.reportenddate) < 13');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;

END$$
DELIMITER ;
