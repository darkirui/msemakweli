DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sprefreshpatientbaselinenutrition`()
BEGIN
    declare selecteddatabasename varchar(250);

    DROP TABLE IF EXISTS schemapatientbaselinenutrition;
    create table schemapatientbaselinenutrition (
        databasename varchar(250)
    );
	
    TRUNCATE TABLE patientbaselinenutrition;

    insert into schemapatientbaselinenutrition
    SELECT databasename from facilitydatabases;
    
	refreshpatientbaselinenutritionloop:LOOP
        set selecteddatabasename = (select databasename from schemapatientbaselinenutrition limit 1);
        set @querypatientbaselinenutrition = concat('insert into patientbaselinenutrition(facilityname,personid,nutritionbaseline,nutritiondate) 
						select 
					(SELECT facilityname FROM msemakweli.facilitydatabases where databasename = ''',selecteddatabasename,''') facilityname,
					person_id as personid,nutritionstatus as baselinenutrition,obs_datetime as nutritiondate from(
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
					ORDER BY t.person_id ASC,t.obs_datetime asc
					)selecteddata where row_number = 1;
		');
		PREPARE stmtselectpatientbaselinenutrition FROM @querypatientbaselinenutrition;
        EXECUTE stmtselectpatientbaselinenutrition;
        DEALLOCATE PREPARE stmtselectpatientbaselinenutrition;

        delete from schemapatientbaselinenutrition where databasename = selecteddatabasename;
        IF ((select count(*) from schemapatientbaselinenutrition) > 0) THEN
            ITERATE refreshpatientbaselinenutritionloop;
		ELSE 
			DROP TABLE schemapatientbaselinenutrition;
        END IF;
        LEAVE refreshpatientbaselinenutritionloop;

    END LOOP refreshpatientbaselinenutritionloop;
END$$
DELIMITER ;
