DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spintermediatereport`(
	in reportingperiod varchar(100),
    in reportname varchar(100)
)
BEGIN
    set @querydropformerrecords = concat('
		select report.facilityname,fd.mflcode,fd.countyname,fd.subcountyname,pbd.cccnumber,report.personid,pbd.gender,
		plvd.ageatlastvisit,
		CASE WHEN cast(plvd.ageatlastvisit AS Decimal) < 1 THEN ''<1''
	    WHEN (cast(plvd.ageatlastvisit AS Decimal) >= 1 and cast(plvd.ageatlastvisit AS Decimal) <= 4) THEN ''1-4''
	    WHEN (cast(plvd.ageatlastvisit AS Decimal) >= 5 and cast(plvd.ageatlastvisit AS Decimal) <= 9) THEN ''5-9''
	    WHEN (cast(plvd.ageatlastvisit AS Decimal) >= 10 and cast(plvd.ageatlastvisit AS Decimal) <= 14) THEN ''10-14''
	    WHEN (cast(plvd.ageatlastvisit AS Decimal) >= 15 and cast(plvd.ageatlastvisit AS Decimal) <= 19) THEN ''15-19''
	    WHEN (cast(plvd.ageatlastvisit AS Decimal) >= 20 and cast(plvd.ageatlastvisit AS Decimal) <= 24) THEN ''20-24''
	    WHEN (cast(plvd.ageatlastvisit AS Decimal) >= 25 and cast(plvd.ageatlastvisit AS Decimal) <= 29) THEN ''25-29''
	    WHEN (cast(plvd.ageatlastvisit AS Decimal) >= 30 and cast(plvd.ageatlastvisit AS Decimal) <= 34) THEN ''30-34''
	    WHEN (cast(plvd.ageatlastvisit AS Decimal) >= 35 and cast(plvd.ageatlastvisit AS Decimal) <= 39) THEN ''35-39''
	    WHEN (cast(plvd.ageatlastvisit AS Decimal) >= 40 and cast(plvd.ageatlastvisit AS Decimal) <= 44) THEN ''40-44''
	    WHEN (cast(plvd.ageatlastvisit AS Decimal) >= 45 and cast(plvd.ageatlastvisit AS Decimal) <= 49) THEN ''45-49''
	    WHEN cast(plvd.ageatlastvisit AS Decimal) >= 50 THEN ''50+''
		END AS agecategory,pbi.patienttype,pbi.artstartdate,plvd.lastvisitdate,art.lastregimen,art.lastregimenline,
		art.regimenduration,vls.lastvldate,vls.lastvlresult
		from(
			select * from ',reportname,' where voided = 0 and reportingperiod = ''',reportingperiod,'''
		)report left join(
			select * from personbasicdetails
		)pbd  ON report.facilityname = pbd.facilityname and report.personid = pbd.personid
		left join facilitydetails fd on report.facilityname = fd.facilityname
		left join(
			select * from patientlastvisitdetails where voided = 0 and reportingperiod = ''',reportingperiod,'''
		)plvd ON report.facilityname = plvd.facilityname and report.personid = plvd.personid
		left join(
			select * from patientbaselineinfo 
		)pbi ON report.facilityname = pbi.facilityname and report.personid = pbi.personid
		left join(
			select * from patientlastart where voided = 0 and reportingperiod = ''',reportingperiod,''' group by facilityname,personid
		)art ON report.facilityname = art.facilityname and report.personid = art.personid
		left join(
			select * from patientlastvl where voided = 0 and reportingperiod = ''',reportingperiod,''' group by facilityname,personid
		)vls ON report.facilityname = vls.facilityname and report.personid = vls.personid;');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;

END$$
DELIMITER ;
