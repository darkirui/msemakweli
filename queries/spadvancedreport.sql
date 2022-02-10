DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spadvancedreport`(
	in reportingperiod varchar(100),
    in reportname varchar(100)
)
BEGIN
    set @querydropformerrecords = concat('
		select fd.*,pbd.cccnumber,report.personid,pbd.patientclinicid,pbd.birthdate,pbd.gender,pbd.keypop,pbd.keypoptype,pbd.occupation,pbd.maritalstatus,
		pbd.educationlevel,pbi.patienttype,pbi.patientsource,pbi.registrationdate,pbi.transferindate,pbi.hivdiagnosisdate,
		pbi.hivenrollmentdate,pbi.artstartdate,pbi.baselineregimen,pbi.baselineregimenline,pbi.baselinevl,pbi.baselinevldate,pbi.baselinewho,
		pbi.baselineweight,pbi.baselineheight,pbi.baselinebmi,pbi.ageatregistration,pbi.ageatartstart,plvd.visitby,plvd.lastvisitdate,
		plvd.ageatlastvisit,CASE WHEN cast(plvd.ageatlastvisit AS Decimal) < 1 THEN ''<1''
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
		END AS agecategory,plvd.nextappointmentdate,plvd.appointmentreason,plvd.nextrefilldate,plvd.dcmethod,plvd.defaultingdate,
		plvd.adherence,pla.lastregimen,pla.lastregimenline,pla.regimenduration,pla.quantitydispensed,pla.regimenfrequencytext,
		pla.regimendispensedate,pla.regimenswitchingdate,plv.lastvldate,plv.lastvlresult,plv.lastvltext
		from(select facilityname,personid from ',reportname,' where voided = 0 
		and reportingperiod = ''',reportingperiod,'''
		)report 
		left join (select facilityname,cccnumber,personid,patientclinicid,birthdate,gender,keypop,keypoptype,occupation,
		maritalstatus,educationlevel from personbasicdetails
		)pbd ON report.facilityname = pbd.facilityname and report.personid = pbd.personid
		left join (select * from patientbaselineinfo
		)pbi ON report.facilityname = pbi.facilityname and report.personid = pbi.personid
		left join (select * from patientlastvisitdetails where voided = 0 and reportingperiod = ''',reportingperiod,''' group by facilityname,personid
		)plvd ON report.facilityname = plvd.facilityname and report.personid = plvd.personid
		left join (select * from patientlastart where voided = 0 and reportingperiod = ''',reportingperiod,''' group by facilityname,personid
		)pla ON report.facilityname = pla.facilityname and report.personid = pla.personid
		left join (select * from patientlastvl where voided = 0 and reportingperiod = ''',reportingperiod,''' group by facilityname,personid
		)plv ON report.facilityname = plv.facilityname and report.personid = plv.personid
		left join facilitydetails fd ON report.facilityname = fd.facilityname;');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;

END$$
DELIMITER ;
