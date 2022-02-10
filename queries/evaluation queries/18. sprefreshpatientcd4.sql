DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sprefreshpatientlastcd4s`(
	in reportingtimespan varchar(100),
    in reportingperiod varchar(100),
    in reportenddate date,
    in refreshdate datetime
)
BEGIN
    declare selecteddatabasename varchar(250);
    declare newreportingperioddate varchar(250);

    DROP TABLE IF EXISTS schemapatientlastcd4;
    create table schemapatientlastcd4 (
        databasename varchar(250)
    );
	
    set @querydropformerrecords = concat('update patientlastcd4 set voided = 1 WHERE 
    reportingtimespan=''',reportingtimespan,''' and reportingperiod=''',reportingperiod,''' and reportenddate=''',reportenddate,''';');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;
    

    insert into schemapatientlastcd4
    SELECT databasename from facilitydatabases;
    
	refreshpatientlastcd4loop:LOOP
        set selecteddatabasename = (select databasename from schemapatientlastcd4 limit 1);
        set newreportingperioddate = DATE_ADD(reportenddate, INTERVAL 1 DAY);
        set @querypatientregimens = concat('insert into patientlastcd4(facilityname,personid,lastcd4,lastcd4date,
        reportingtimespan,reportingperiod,reportenddate,refreshdate) 
			select 
				(SELECT facilityname FROM msemakwelishujaa.facilitydatabases where databasename = ''',selecteddatabasename,''') facilityname,
				lastcd4.patient_id as personid,lastcd4.TestResults AS lastcd4,samplingdate,  
                ''',reportingtimespan,''',''',reportingperiod,''',''',reportenddate,''',''',refreshdate,''' AS refeshdate
                from
(
    SELECT * FROM(
			SELECT @row_no := IF(@prev_val = t.patient_id, @row_no + 1, 1) AS row_number
			   ,@prev_val := t.patient_id AS patient_id
			   ,t.visit_date, t.TestResults, t.obs_datetime AS samplingdate
			FROM (
				SELECT * FROM(
					SELECT labs.patient_id,labs.visit_date,labs.LabTest,labs.concept_id,
					labs.test_result AS TestResults,
					labs.date_created,labs.obs_datetime FROM(
					select
					e.patient_id,
					e.encounter_datetime as visit_date,
					o.concept_id,
					cn.name AS LabTest,
					od.urgency,
					(CASE when o.concept_id in(5497,730,654,790,856) then o.value_numeric
						when o.concept_id in(1030,1305) then o.value_coded
						END) AS test_result,
					e.date_created,
					o.obs_datetime
					from  ',selecteddatabasename,'.encounter e
						inner join  ',selecteddatabasename,'.person p on p.person_id=e.patient_id and p.voided=0
						inner join
					(
						select encounter_type_id, uuid, name from  ',selecteddatabasename,'.encounter_type where uuid in(''17a381d1-7e29-406a-b782-aa903b963c28'', ''a0034eee-1940-4e35-847f-97537a35d05e'',''e1406e88-e9a9-11e8-9f32-f2801f1b9fd1'', ''de78a6be-bfc5-4634-adc3-5f1a280455cc'')
					) et on et.encounter_type_id=e.encounter_type
					inner join  ',selecteddatabasename,'.obs o on e.encounter_id=o.encounter_id and o.voided=0 and o.concept_id in (5497,730,654,790,856,1030,1305)
					left join  ',selecteddatabasename,'.orders od on od.order_id = o.order_id and od.voided=0
					LEFT JOIN  ',selecteddatabasename,'.concept_name cn on cn.concept_id = o.concept_id
					where e.voided=0
					)labs LEFT JOIN  ',selecteddatabasename,'.concept_name cn ON cn.concept_id = labs.test_result
					WHERE LabTest LIKE ''%CD%'' and obs_datetime < ''',newreportingperioddate,'''
					)vls  GROUP BY patient_id, obs_datetime

			) t,
			  (SELECT @row_no := 0) x,
			  (SELECT @prev_val := '''') y
			ORDER BY t.patient_id ASC,t.visit_date DESC
			)cd4count WHERE row_number = 1
)lastcd4;
		');
		PREPARE stmtselectpatientregimens FROM @querypatientregimens;
        EXECUTE stmtselectpatientregimens;
        DEALLOCATE PREPARE stmtselectpatientregimens;

        delete from schemapatientlastcd4 where databasename = selecteddatabasename;
        IF ((select count(*) from schemapatientlastcd4) > 0) THEN
            ITERATE refreshpatientlastcd4loop;
		ELSE 
			DROP TABLE schemapatientlastcd4;
        END IF;
        LEAVE refreshpatientlastcd4loop;

    END LOOP refreshpatientlastcd4loop;
END$$
DELIMITER ;
