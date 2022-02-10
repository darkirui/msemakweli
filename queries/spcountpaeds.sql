DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spcountpaeds`(
	in reportingperiod varchar(100),
    in reportname varchar(100)
)
BEGIN
    set @querydropformerrecords = concat('
		select count(report.personid) total from(
			select facilityname,personid from ',reportname,' where reportingperiod = ''',reportingperiod,''' and voided=0
		)report left join(
			select facilityname,personid,ageatlastvisit from patientlastvisitdetails where voided = 0 and reportingperiod = ''',reportingperiod,''' 
		)plv on report.facilityname = plv.facilityname 
		and report.personid = plv.personid
		where plv.ageatlastvisit < 15;');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;

END$$
DELIMITER ;
