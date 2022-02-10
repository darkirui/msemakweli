DELIMITER $$
drop procedure if exists spcountovc;
CREATE DEFINER=`root`@`localhost` PROCEDURE `spcountovc`(
	in reportingperiod varchar(100),
    in reportname varchar(100)
)
BEGIN
    set @querydropformerrecords = concat('
		select count(*) total from(
			select * from patientovc 
		)ovc left join(
			select * from ',reportname,' where voided = 0 and reportingperiod = ''',reportingperiod,'''
		)report on ovc.facilityname = report.facilityname and ovc.personid = report.personid
		left join(
			select * from patientlastvisitdetails where voided = 0 and reportingperiod = ''',reportingperiod,'''
		)plvd on ovc.facilityname = plvd.facilityname and ovc.personid = plvd.personid
		where plvd.ageatlastvisit < 19 and report.personid is not null
        and ovc.ovcenrollmentdate <= report.reportenddate');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;

END$$
DELIMITER ;
