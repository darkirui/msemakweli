DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sprefreshpatientlastnutritions`(
	in reportingtimespan varchar(100),
    in reportingperiod varchar(100),
    in reportenddate date,
    in refreshdate datetime
)
BEGIN
    declare selecteddatabasename varchar(250);
    declare newreportingperioddate varchar(250);

    DROP TABLE IF EXISTS schemapatientlastnutrition;
    create table schemapatientlastnutrition (
        databasename varchar(250)
    );
	
    set @querydropformerrecords = concat('update patientlastnutrition set voided = 1 WHERE 
    reportingtimespan=''',reportingtimespan,''' and reportingperiod=''',reportingperiod,''' and reportenddate=''',reportenddate,''';');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;
    

    insert into schemapatientlastnutrition
    SELECT databasename from facilitydatabases;
    
	refreshpatientlastnutritionloop:LOOP
        set selecteddatabasename = (select databasename from schemapatientlastnutrition limit 1);
        set newreportingperioddate = DATE_ADD(reportenddate, INTERVAL 1 DAY);
        set @querypatientregimens = concat('insert into patientlastnutrition(facilityname,personid,lastnutritionstatus,
        reportingtimespan,reportingperiod,reportenddate,refreshdate) 
			select 
				(SELECT facilityname FROM msemakweli.facilitydatabases where databasename = ''',selecteddatabasename,''') facilityname,
					person_id as personid,nutritionstatus as lastnutrition,obs_datetime as nutritiondate,
                ''',reportingtimespan,''',''',reportingperiod,''',''',reportenddate,''',''',refreshdate,''' AS refeshdate
                from
				(
					SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
					   ,@prev_val := t.person_id AS personcheck
					   ,t.*
					FROM (
						select 
						case when cn.name = ''SELF'' then ''Normal'' else cn.name end as nutritionstatus,
						o.person_id,o.obs_datetime from ',selecteddatabasename,'.obs o
						left join(
							SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
						)cn on o.value_coded = cn.concept_id
						where o.concept_id = 163300
					) t,
					  (SELECT @row_no := 0) x,
					  (SELECT @prev_val := '''') y
					ORDER BY t.person_id ASC,t.obs_datetime desc
					)selecteddata where row_number = 1;
		');
		PREPARE stmtselectpatientregimens FROM @querypatientregimens;
        EXECUTE stmtselectpatientregimens;
        DEALLOCATE PREPARE stmtselectpatientregimens;

        delete from schemapatientlastnutrition where databasename = selecteddatabasename;
        IF ((select count(*) from schemapatientlastnutrition) > 0) THEN
            ITERATE refreshpatientlastnutritionloop;
		ELSE 
			DROP TABLE schemapatientlastnutrition;
        END IF;
        LEAVE refreshpatientlastnutritionloop;

    END LOOP refreshpatientlastnutritionloop;
END$$
DELIMITER ;
