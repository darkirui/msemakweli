DELIMITER $$
drop procedure if exists sprefreshpatientlastobservation;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sprefreshpatientlastobservation`(
	in reportingtimespan varchar(100),
    in reportingperiod varchar(100),
    in reportenddate date,
    in refreshdate datetime
)
BEGIN
    declare selecteddatabasename varchar(250);
    declare newreportingperioddate varchar(250);

    DROP TABLE IF EXISTS schemapatientlastobservation;
    create table schemapatientlastobservation (
        databasename varchar(250)
    );
	
    set @querydropformerrecords = concat('update patientlastobservation set voided = 1 WHERE 
    reportingtimespan=''',reportingtimespan,''' and reportingperiod=''',reportingperiod,''' and reportenddate=''',reportenddate,''';');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;
    

    insert into schemapatientlastobservation
    SELECT databasename from facilitydatabases;
    
	refreshpatientlastobservationloop:LOOP
        set selecteddatabasename = (select databasename from schemapatientlastobservation limit 1);
        set newreportingperioddate = DATE_ADD(reportenddate, INTERVAL 1 DAY);
        set @querypatientobservations = concat('insert into patientlastobservation(facilityname,personid,stable,allergies,
        drugreactions,examinationfinding,complaints,cervicalcancer,chronicillness,iptstatus,tbstatus,
        reportingtimespan,reportingperiod,reportenddate,refreshdate) 
			select 
			(SELECT facilityname FROM msemakweli.facilitydatabases where databasename = ''',selecteddatabasename,''') AS facilityname,
			p.patient_id,stability.patientstable,allergy.hasallergy,drugreaction.hasdrugreaction,systemfindings.systemfinding,
			complaints.complaint,chronicdisease.chronicillness,cervicalcancer.cacxresult,ipt.iptstatus as patienteveronipt,
			tb.tbstatus as patienteverontbrx,''',reportingtimespan,''',''',reportingperiod,''',''',reportenddate,''',
                ''',refreshdate,''' AS refreshdate
			 from ',selecteddatabasename,'.patient p
			left join(
				select 
					person_id as personid,obs_datetime,patientstable from(
					SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
					   ,@prev_val := t.person_id AS personcheck
					   ,t.*
					FROM (
						select person_id,obs_datetime,
						case when value_coded = 1 then ''Yes''
							when value_coded = 2 then ''No''
							else ''Yes'' end as patientstable
						 from ',selecteddatabasename,'.obs where concept_id = 1855
						 and obs_datetime < ''',newreportingperioddate,'''
					) t,
					  (SELECT @row_no := 0) x,
					  (SELECT @prev_val := '''') y
					ORDER BY t.person_id ASC,t.obs_datetime desc
					)selecteddata where row_number = 1
			)stability on p.patient_id = stability.personid
			left join(
				select person_id,
			case when name is not null then ''yes'' end as hasallergy 
			from(
				SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
			   ,@prev_val := t.person_id AS personcheck
				,t.*
				FROM (
					select cn.name,o.person_id,o.obs_datetime from ',selecteddatabasename,'.obs o
					left join(
						SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
					)cn on o.value_coded = cn.concept_id
					where o.concept_id = 160643 and o.obs_datetime < ''',newreportingperioddate,'''
				) t,
				  (SELECT @row_no := 0) x,
				  (SELECT @prev_val := '''') y
				ORDER BY t.person_id ASC,t.obs_datetime asc
				)selecteddata where row_number = 1
			)allergy on allergy.person_id = p.patient_id
			left join(
				select person_id as personid,obs_datetime,drugreaction as hasdrugreaction from(
				SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
				   ,@prev_val := t.person_id AS personcheck
				   ,t.*
				FROM (
					select person_id,case when value_coded = 2 then ''no'' else ''yes'' end as drugreaction,value_coded,obs_datetime
					from ',selecteddatabasename,'.obs where concept_id = 121764 and obs_datetime < ''',newreportingperioddate,'''
				) t,
				  (SELECT @row_no := 0) x,
				  (SELECT @prev_val := '''') y
				ORDER BY t.person_id ASC,t.obs_datetime desc
				)selecteddata where row_number = 1
			)drugreaction on drugreaction.personid = p.patient_id
			left join(
				select person_id,systemfinding
				from(
					SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
					   ,@prev_val := t.person_id AS personcheck
					   ,t.*
					FROM (
						select cn.name systemfinding,o.person_id,o.obs_datetime,o.value_coded from ',selecteddatabasename,'.obs o
							left join(
								SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
							)cn on o.value_coded = cn.concept_id
							where o.concept_id = 162737 and o.obs_datetime < ''',newreportingperioddate,'''
					) t,
					  (SELECT @row_no := 0) x,
					  (SELECT @prev_val := '''') y
					ORDER BY t.person_id ASC,t.obs_datetime asc
				)selecteddata where row_number = 1
			)systemfindings on systemfindings.person_id = p.patient_id
			left join(
				select person_id,complaint
				from(
					SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
					   ,@prev_val := t.person_id AS personcheck
					   ,t.*
					FROM (
						select cn.name complaint,o.person_id,o.obs_datetime,o.value_coded from ',selecteddatabasename,'.obs o
							left join(
								SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
							)cn on o.value_coded = cn.concept_id
							where o.concept_id = 5219 and o.obs_datetime < ''',newreportingperioddate,'''
					) t,
					  (SELECT @row_no := 0) x,
					  (SELECT @prev_val := '''') y
					ORDER BY t.person_id ASC,t.obs_datetime asc
				)selecteddata where row_number = 1
			)complaints on complaints.person_id = p.patient_id
			left join(
				select person_id,chronicillness
				from(
					SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
					   ,@prev_val := t.person_id AS personcheck
					   ,t.*
					FROM (
						select cna.name as chronicillness,o.person_id,o.obs_datetime from ',selecteddatabasename,'.obs o
						left join(
							SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
						)cn on o.concept_id = cn.concept_id
						left join(
							SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
						)cna on o.value_coded = cna.concept_id
						where o.concept_id = 1284 and o.obs_datetime < ''',newreportingperioddate,'''
					) t,
					  (SELECT @row_no := 0) x,
					  (SELECT @prev_val := '''') y
					ORDER BY t.person_id ASC,t.obs_datetime asc
				)selecteddata where row_number = 1
			)chronicdisease on chronicdisease.person_id = p.patient_id
			left join(
				select person_id,cacxresult
				from(
					SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
					   ,@prev_val := t.person_id AS personcheck
					   ,t.*
					FROM (
						select cna.name as cacxresult,o.person_id,o.obs_datetime from ',selecteddatabasename,'.obs o
						left join(
							SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
						)cn on o.concept_id = cn.concept_id
						left join(
							SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
						)cna on o.value_coded = cna.concept_id
						where o.concept_id = 164934 and o.obs_datetime < ''',newreportingperioddate,'''
					) t,
					  (SELECT @row_no := 0) x,
					  (SELECT @prev_val := '''') y
					ORDER BY t.person_id ASC,t.obs_datetime asc
				)selecteddata where row_number = 1
			)cervicalcancer on cervicalcancer.person_id = p.patient_id
			left join(
				select person_id,iptstatus
				from(
					SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
					   ,@prev_val := t.person_id AS personcheck
					   ,t.*
					FROM (
						select cna.name as iptstatus,o.person_id,o.obs_datetime from ',selecteddatabasename,'.obs o
						left join(
							SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
						)cn on o.concept_id = cn.concept_id
						left join(
							SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
						)cna on o.value_coded = cna.concept_id
						where o.concept_id = 164950 and o.obs_datetime < ''',newreportingperioddate,'''
					) t,
					  (SELECT @row_no := 0) x,
					  (SELECT @prev_val := '''') y
					ORDER BY t.person_id ASC,t.obs_datetime asc
				)selecteddata where row_number = 1
			)ipt on ipt.person_id = p.patient_id
			left join(
				select person_id,tbstatus
				from(
					SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
					   ,@prev_val := t.person_id AS personcheck
					   ,t.*
					FROM (
						select cna.name as tbstatus,o.person_id,o.obs_datetime from ',selecteddatabasename,'.obs o
						left join(
							SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
						)cn on o.concept_id = cn.concept_id
						left join(
							SELECT * FROM ',selecteddatabasename,'.concept_name WHERE locale = ''en'' and concept_name_type = ''FULLY_SPECIFIED''
						)cna on o.value_coded = cna.concept_id
						where o.concept_id = 164949 and o.obs_datetime < ''',newreportingperioddate,'''
					) t,
					  (SELECT @row_no := 0) x,
					  (SELECT @prev_val := '''') y
					ORDER BY t.person_id ASC,t.obs_datetime asc
				)selecteddata where row_number = 1
			)tb on tb.person_id = p.patient_id
			where voided = 0;
		');
		PREPARE stmtselectpatientobservations FROM @querypatientobservations;
        EXECUTE stmtselectpatientobservations;
        DEALLOCATE PREPARE stmtselectpatientobservations;

        delete from schemapatientlastobservation where databasename = selecteddatabasename;
        IF ((select count(*) from schemapatientlastobservation) > 0) THEN
            ITERATE refreshpatientlastobservationloop;
		ELSE 
			DROP TABLE schemapatientlastobservation;
        END IF;
        LEAVE refreshpatientlastobservationloop;

    END LOOP refreshpatientlastobservationloop;
END$$
DELIMITER ;
