DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spfacilitydistributionfilter`(
	in reportingperiod varchar(100),
    in reportname varchar(100),
    in filtervalues text
)
BEGIN

    set @querydropformerrecords = concat('
		select fd.countyname,f.facilityname as name,
			case when countdata.value > 0 then countdata.value else 0 end as value from facility f left join(
				select facilityname as name,count(*) value from ',reportname,'
				where voided = 0 and reportingperiod = ''', reportingperiod,'''  
				Group By facilityname ORDER BY count(*) desc
			)countdata on f.facilityname = countdata.name 
            left join facilitydetails fd on fd.facilityname = f.facilityname
            where fd.countyname in ',filtervalues,'
            order by value desc;');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;

END$$
DELIMITER ;
