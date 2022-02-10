DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sprefreshpatientevaluationtxcurr`(
	in reportingtimespan varchar(100),
    in reportingperiod varchar(100),
    in reportenddate date,
    in refreshdate datetime
)
BEGIN
    declare selecteddatabasename varchar(250);
    declare newreportingperioddate varchar(250);

    DROP TABLE IF EXISTS schemapatientevaluationtxcurr;
    create table schemapatientevaluationtxcurr (
        databasename varchar(250)
    );
	
    set @querydropformerrecords = concat('update patientevaluationtxcurr set voided = 1 WHERE 
    reportingtimespan=''',reportingtimespan,''' and reportingperiod=''',reportingperiod,''' and reportenddate=''',reportenddate,''';');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;
    

    insert into schemapatientevaluationtxcurr
    SELECT databasename from facilitydatabases;
    
	refreshpatientevaluationtxcurrloop:LOOP
        set selecteddatabasename = (select databasename from schemapatientevaluationtxcurr limit 1);
        set newreportingperioddate = DATE_ADD(reportenddate, INTERVAL 1 DAY);
        set @querypatientvisits = concat('insert into patientevaluationtxcurr(facilityname,personid,txcurrstatus,daysdefaulted,
        reportingtimespan,reportingperiod,reportenddate,refreshdate) 
			SELECT
				(SELECT facilityname FROM msemakweli.facilitydatabases where databasename = ''',selecteddatabasename,''') facilityname, 
				activeclients.person_id as personid,
				CASE WHEN activeclients.NextAppointmentDate < ''',newreportingperioddate,''' THEN ''defaulter'' else ''active'' end as txcurrstatus,
				CASE WHEN activeclients.NextAppointmentDate < ''',newreportingperioddate,''' THEN 
				DATEDIFF(''',newreportingperioddate,''', activeclients.NextAppointmentDate) ELSE 0 end as daysdefaulted
				,''',reportingtimespan,''',''',reportingperiod,''',''',reportenddate,''',
                ''',refreshdate,''' AS refreshdate
				FROM(
				SELECT * FROM(
					SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
					   ,@prev_val := t.person_id AS personcheck
					   ,t.*
					FROM (
						SELECT o.person_id,o.obs_datetime AS LastVisitDate,o.value_datetime AS NextAppointmentDate,
						o.concept_id,DATE_ADD(o.value_datetime, INTERVAL 30 DAY) AS defaultingday,o.encounter_id,e.form_id,o.date_created
						FROM ',selecteddatabasename,'.obs o LEFT JOIN  ',selecteddatabasename,'.encounter e ON o.encounter_id = e.encounter_id
						WHERE concept_id = 5096 and DATE_ADD(value_datetime, INTERVAL 30 DAY) >= ''2017-04-01'' 
						and obs_datetime < ''',newreportingperioddate,''' and o.voided = 0 and e.form_id = 34
						order by obs_datetime desc 
					) t,
					  (SELECT @row_no := 0) x,
					  (SELECT @prev_val := '''') y
					ORDER BY t.person_id ASC,t.NextAppointmentDate DESC
					)appointments WHERE row_number = 1
				)activeclients LEFT JOIN(
					SELECT patient_id,ExitDate,ExitReason,to_facility,program_name AS ExitedFrom FROM(
							SELECT @row_no := IF(@prev_val = t.patient_id, @row_no + 1, 1) AS row_number
							   ,@prev_val := t.patient_id AS patient_id
							   ,t.encounter_datetime AS ExitDate, t.program_name,t.name AS ExitReason,t.to_facility
							FROM (
								SELECT pd.patient_id,pd.encounter_datetime,pd.program_name,cn.name,pd.to_facility FROM(
							select 
								e.patient_id,
								e.uuid,
								e.visit_id,
								e.encounter_datetime,
								 -- et.uuid,
								(case et.uuid
									when ''2bdada65-4c72-4a48-8730-859890e25cee'' then ''HIV''
									when ''d3e3d723-7458-4b4e-8998-408e8a551a84'' then ''TB''
									when ''01894f88-dc73-42d4-97a3-0929118403fb'' then ''MCH Child HEI''
									when ''5feee3f1-aa16-4513-8bd0-5d9b27ef1208'' then ''MCH Child''
									when ''7c426cfc-3b47-4481-b55f-89860c21c7de'' then ''MCH Mother''
									when ''162382b8-0464-11ea-9a9f-362b9e155667'' then ''OTZ''
									when ''5cf00d9e-09da-11ea-8d71-362b9e155667'' then ''OVC''
									when ''d7142400-2495-11e9-ab14-d663bd873d93'' then ''KP''
								end) as program_name,
								e.encounter_id,
								max(if(o.concept_id=161555, o.value_coded, null)) as reason_discontinued,
								max(if(o.concept_id=164384, o.value_datetime, null)) as effective_discontinuation_date,
								max(if(o.concept_id=164384, o.value_datetime, null)) as visit_date,
								max(if(o.concept_id=1285, o.value_coded, null)) as trf_out_verified,
								max(if(o.concept_id=164133, o.value_datetime, null)) as trf_out_verification_date,
								max(if(o.concept_id=1543, o.value_datetime, null)) as date_died,
								max(if(o.concept_id=159495, left(trim(o.value_text),100), null)) as to_facility,
								max(if(o.concept_id=160649, o.value_datetime, null)) as to_date
								from  ',selecteddatabasename,'.encounter e
								inner join  ',selecteddatabasename,'.person p on p.person_id=e.patient_id and p.voided=0
								inner join  ',selecteddatabasename,'.obs o on o.encounter_id=e.encounter_id and o.voided=0 and o.concept_id in (161555,164384,1543,159495,160649,165380,1285,164133)
								inner join 
								(
									select encounter_type_id, uuid, name from  ',selecteddatabasename,'.encounter_type where 
									uuid in(''2bdada65-4c72-4a48-8730-859890e25cee'',''d3e3d723-7458-4b4e-8998-408e8a551a84'',''5feee3f1-aa16-4513-8bd0-5d9b27ef1208'',
									''7c426cfc-3b47-4481-b55f-89860c21c7de'',''01894f88-dc73-42d4-97a3-0929118403fb'',''162382b8-0464-11ea-9a9f-362b9e155667'',''5cf00d9e-09da-11ea-8d71-362b9e155667'',''d7142400-2495-11e9-ab14-d663bd873d93'')
								) et on et.encounter_type_id=e.encounter_type
								WHERE e.encounter_datetime < ''',newreportingperioddate,'''
								group by e.encounter_id
							)pd LEFT JOIN (
								SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en''
							) cn ON pd.reason_discontinued = cn.concept_id
							WHERE pd.program_name = ''HIV''
							) t,
							  (SELECT @row_no := 0) x,
							  (SELECT @prev_val := '''') y
					ORDER BY t.patient_id ASC,t.encounter_datetime DESC
					)exits WHERE row_number = 1 and ExitReason IN (''Transferred out'',''Died'',''Lost to followup'') and program_name = ''HIV''
				)exits ON activeclients.person_id = exits.patient_id 
				LEFT JOIN(
					SELECT * FROM(
						SELECT @row_no := IF(@prev_val = t.patient_id, @row_no + 1, 1) AS row_number
					   ,@prev_val := t.patient_id AS patient_id
					   ,t.identifier,t.encounter_datetime,t.program, t.regimen,t.regimen_name,t.regimen_line
						FROM (SELECT * FROM(
						SELECT pids.identifier,regimens.patient_id,regimens.encounter_datetime,regimens.program,
						CASE WHEN regimens.regimen = '''' THEN NULL ELSE regimens.regimen END AS regimen,
						CASE WHEN regimens.regimen_name = '''' THEN NULL ELSE regimens.regimen_name END AS regimen_name,
						CASE WHEN regimens.regimen_line = '''' THEN NULL ELSE regimens.regimen_line END AS regimen_line
						FROM(
							select
									e.uuid,
									e.patient_id,
									e.encounter_datetime,
									-- e.encounter_datetime,
									e.creator,
									e.encounter_id,
									max(if(o.concept_id=1255,''HIV'',if(o.concept_id=1268, ''TB'', null))) as program,
									max(if(o.concept_id=1193,(
										case o.value_coded
										when 162565 then "3TC/NVP/TDF"
										when 164505 then "TDF/3TC/EFV"
										when 1652 then "AZT/3TC/NVP"
										when 160124 then "AZT/3TC/EFV"
										when 792 then "D4T/3TC/NVP"
										when 160104 then "D4T/3TC/EFV"
										when 164971 then "TDF/3TC/AZT"
										when 165357 then "ABC/3TC/ATV/r"
										when 164968 then "AZT/3TC/DTG"
										when 164969 then "TDF/3TC/DTG"
										when 164970 then "ABC/3TC/DTG"
										when 162561 then "AZT/3TC/LPV/r"
										when 164511 then "AZT/3TC/ATV/r"
										when 162201 then "TDF/3TC/LPV/r"
										when 1067 then "Unknown"
										when 164512 then "TDF/3TC/ATV/r"
										when 162560 then "D4T/3TC/LPV/r"
										when 164972 then "AZT/TDF/3TC/LPV/r"
										when 164973 then "ETR/RAL/DRV/RTV"
										when 164974 then "ETR/TDF/3TC/LPV/r"
										when 162200 then "ABC/3TC/LPV/r"
										when 162199 then "ABC/3TC/NVP"
										when 162563 then "ABC/3TC/EFV"
										when 817 then "AZT/3TC/ABC"
										when 164975 then "D4T/3TC/ABC"
										when 162562 then "TDF/ABC/LPV/r"
										when 162559 then "ABC/DDI/LPV/r"
										when 164976 then "ABC/TDF/3TC/LPV/r"
										when 165375 then "RAL+3TC+DRV+RTV"
										when 165376 then "RAL+3TC+DRV+RTV+AZT"
										when 165377 then "RAL+3TC+DRV+RTV+ABC"
										when 165378 then "ETV+3TC+DRV+RTV"
										when 165379 then "RAL+3TC+DRV+RTV+TDF"
										when 165369 then "TDF+3TC+DTG+DRV/r"
										when 165370 then "TDF+3TC+RAL+DRV/r"
										when 165371 then "TDF+3TC+DTG+EFV+DRV/r"
										when 165372 then "ABC+3TC+RAL"
										when 165373 then "AZT+3TC+RAL+DRV/r"
										when 165374 then "ABC+3TC+RAL+DRV/r"
										when 1675 then "RHZE"
										when 768 then "RHZ"
										when 1674 then "SRHZE"
										when 164978 then "RfbHZE"
										when 164979 then "RfbHZ"
										when 164980 then "SRfbHZE"
										when 84360 then "S (1 gm vial)"
										when 75948 then "E"
										when 1194 then "RH"
										when 159851 then "RHE"
										when 1108 then "EH"
										else ""
										end ),null)) as regimen,
									max(if(o.concept_id=1193,(
										case o.value_coded
										when 162565 then "3TC+NVP+TDF"
										when 164505 then "TDF+3TC+EFV"
										when 1652 then "AZT+3TC+NVP"
										when 160124 then "AZT+3TC+EFV"
										when 792 then "D4T+3TC+NVP"
										when 160104 then "D4T+3TC+EFV"
										when 164971 then "TDF+3TC+AZT"
										when 164968 then "AZT+3TC+DTG"
										when 1067 then "Unknown"
										when 164969 then "TDF+3TC+DTG"
										when 164970 then "ABC+3TC+DTG"
										when 162561 then "AZT+3TC+LPV/r"
										when 164511 then "AZT+3TC+ATV/r"
										when 162201 then "TDF+3TC+LPV/r"
										when 165357 then "ABC/3TC/ATV/r"
										when 164512 then "TDF+3TC+ATV/r"
										when 162560 then "D4T+3TC+LPV/r"
										when 164972 then "AZT+TDF+3TC+LPV/r"
										when 164973 then "ETR+RAL+DRV+RTV"
										when 164974 then "ETR+TDF+3TC+LPV/r"
										when 162200 then "ABC+3TC+LPV/r"
										when 162199 then "ABC+3TC+NVP"
										when 162563 then "ABC+3TC+EFV"
										when 817 then "AZT+3TC+ABC"
										when 164975 then "D4T+3TC+ABC"
										when 162562 then "TDF+ABC+LPV/r"
										when 162559 then "ABC+DDI+LPV/r"
										when 164976 then "ABC+TDF+3TC+LPV/r"
										when 165375 then "RAL+3TC+DRV+RTV"
										when 165376 then "RAL+3TC+DRV+RTV+AZT"
										when 165377 then "RAL+3TC+DRV+RTV+ABC"
										when 165378 then "ETV+3TC+DRV+RTV"
										when 165379 then "RAL+3TC+DRV+RTV+TDF"
										when 165369 then "TDF+3TC+DTG+DRV/r"
										when 165370 then "TDF+3TC+RAL+DRV/r"
										when 165371 then "TDF+3TC+DTG+EFV+DRV/r"
										when 165372 then "ABC+3TC+RAL"
										when 165373 then "AZT+3TC+RAL+DRV/r"
										when 165374 then "ABC+3TC+RAL+DRV/r"
										when 1675 then "RHZE"
										when 768 then "RHZ"
										when 1674 then "SRHZE"
										when 164978 then "RfbHZE"
										when 164979 then "RfbHZ"
										when 164980 then "SRfbHZE"
										when 84360 then "S (1 gm vial)"
										when 75948 then "E"
										when 1194 then "RH"
										when 159851 then "RHE"
										when 1108 then "EH"
										else ""
										end ),null)) as regimen_name,
									max(if(o.concept_id=1193,(
										case o.value_coded
										when 162565 then "First line"
										when 164505 then "First line"
										when 1652 then "First line"
										when 160124 then "First line"
										when 792 then "First line"
										when 160104 then "First line"
										when 164971 then "First line"
										when 164968 then "First line"
										when 164969 then "First line"
										when 164970 then "First line"
										when 162561 then "First line"
										when 164511 then "First line"
										when 164512 then "First line"
										when 162201 then "First line"
										when 162561 then "Second line"
										when 164511 then "Second line"
										when 162201 then "Second line"
										when 164512 then "Second line"
										when 162560 then "Second line"
										when 164972 then "Second line"
										when 164973 then "Second line"
										when 164974 then "Second line"
										when 165357 then "Second line"
										when 164968 then "Second line"
										when 164969 then "Second line"
										when 164970 then "Second line"
										when 165375 then "Third line"
										when 165376 then "Third line"
										when 165379 then "Third line"
										when 165378 then "Third line"
										when 165369 then "Third line"
										when 165370 then "Third line"
										when 165371 then "Third line"
										when 162200 then "First line"
										when 162199 then "First line"
										when 162563 then "First line"
										when 817 then "First line"
										when 164975 then "First line"
										when 162562 then "First line"
										when 162559 then "First line"
										when 164976 then "First line"
										when 165372 then "First line"
										when 162561 then "Second line"
										when 164511 then "Second line"
										when 162200 then "Second line"
										when 165357 then "Second line"
										when 165373 then "Second line"
										when 165374 then "Second line"
										when 165375 then "Third line"
										when 165376 then "Third line"
										when 165377 then "Third line"
										when 165378 then "Third line"
										when 165373 then "Third line"
										when 165374 then "Third line"
										when 1675 then "Adult intensive"
										when 768 then "Adult intensive"
										when 1674 then "Adult intensive"
										when 164978 then "Adult intensive"
										when 164979 then "Adult intensive"
										when 164980 then "Adult intensive"
										when 84360 then "Adult intensive"
										when 75948 then "Child intensive"
										when 1194 then "Child intensive"
										when 159851 then "Adult continuation"
										when 1108 then "Adult continuation"
										else ""
										end ),null)) as regimen_line,
									max(if(o.concept_id=1191,(case o.value_datetime when NULL then 0 else 1 end),null)) as discontinued,
									null as regimen_discontinued,
									max(if(o.concept_id=1191,o.value_datetime,null)) as date_discontinued,
									max(if(o.concept_id=1252,o.value_coded,null)) as reason_discontinued,
									max(if(o.concept_id=5622,o.value_text,null)) as reason_discontinued_other

								from  ',selecteddatabasename,'.encounter e
									inner join  ',selecteddatabasename,'.person p on p.person_id=e.patient_id and p.voided=0
									inner join  ',selecteddatabasename,'.obs o on e.encounter_id = o.encounter_id and o.voided =0
																			and o.concept_id in(1193,1252,5622,1191,1255,1268)
									inner join
									(
										select encounter_type, uuid,name from  ',selecteddatabasename,'.form where
											uuid in(''da687480-e197-11e8-9f32-f2801f1b9fd1'')
									) f on f.encounter_type=e.encounter_type 
							WHERE e.encounter_datetime < ''',newreportingperioddate,'''
							group by e.encounter_id
						)regimens LEFT JOIN(
							SELECT * FROM  ',selecteddatabasename,'.patient_identifier WHERE identifier_type = 6
						)pids ON pids.patient_id = regimens.patient_id
						)regimendetails WHERE regimen IS NOT null GROUP BY patient_id, encounter_datetime ORDER BY encounter_datetime
						) t,
						  (SELECT @row_no := 0) x,
						  (SELECT @prev_val := '''') y
						ORDER BY t.patient_id ASC,t.encounter_datetime ASC
						)reg  where row_number = 1
				)artstatus ON artstatus.patient_id = activeclients.person_id
				WHERE -- (exits.patient_id IS NULL or (exits.patient_id IS NOT NULL 
				-- and cast(ExitDate as date) < cast(activeclients.LastVisitDate as date)))
				-- and 
                artstatus.encounter_datetime IS NOT NULL
				ORDER BY activeclients.person_id ASC;
		');
		PREPARE stmtselectpatientvisits FROM @querypatientvisits;
        EXECUTE stmtselectpatientvisits;
        DEALLOCATE PREPARE stmtselectpatientvisits;

        delete from schemapatientevaluationtxcurr where databasename = selecteddatabasename;
        IF ((select count(*) from schemapatientevaluationtxcurr) > 0) THEN
            ITERATE refreshpatientevaluationtxcurrloop;
		ELSE 
			DROP TABLE schemapatientevaluationtxcurr;
        END IF;
        LEAVE refreshpatientevaluationtxcurrloop;

    END LOOP refreshpatientevaluationtxcurrloop;
END$$
DELIMITER ;
