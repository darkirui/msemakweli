DELIMITER $$
drop procedure if exists spcountsuppressed;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spcountsuppressed`(
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
		TIMESTAMPDIFF(MONTH, vls.lastvldate, vls.reportenddate) < 13 and cast(lastvlresult as decimal) < 1000');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;

END$$
DELIMITER ;
