DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spsimplereport`(
	in reportingperiod varchar(100),
    in reportname varchar(100)
)
BEGIN
    set @querydropformerrecords = concat('
		select report.facilityname,pbd.cccnumber,report.personid from(
			select * from ',reportname,' where voided = 0 and reportingperiod = ''',reportingperiod,'''
		)report left join(
			select * from personbasicdetails
		)pbd  ON report.facilityname = pbd.facilityname and report.personid = pbd.personid;');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;

END$$
DELIMITER ;
