DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spcountmales`(
	in reportingperiod varchar(100),
    in reportname varchar(100)
)
BEGIN
    set @querydropformerrecords = concat('
		select count(report.personid) total from(
			select facilityname,personid from ',reportname,' where reportingperiod = ''',reportingperiod,''' and voided=0
		)report left join(
			select facilityname,personid,gender from personbasicdetails 
		)pbd on report.facilityname = pbd.facilityname 
		and report.personid = pbd.personid
		where pbd.gender = ''m'';');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;

END$$
DELIMITER ;
