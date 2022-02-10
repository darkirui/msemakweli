select p.patient_id,stability.patientstable,allergy.hasallergy,drugreaction.hasdrugreaction,systemfindings.systemfinding

 from mumiasaltb.patient p
left join(
	select 
		person_id as personid,obs_datetime,patientstable from(
		SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
		   ,@prev_val := t.person_id AS personcheck
		   ,t.*
		FROM (
			select person_id,obs_datetime,
			case when value_coded = 1 then 'Yes'
				when value_coded = 2 then 'No'
				else 'Yes' end as patientstable
			 from mumiasaltb.obs where concept_id = 1855
			 and obs_datetime < '2021-04-01'
		) t,
		  (SELECT @row_no := 0) x,
		  (SELECT @prev_val := '') y
		ORDER BY t.person_id ASC,t.obs_datetime desc
		)selecteddata where row_number = 1
)stability on p.patient_id = stability.personid
left join(
	select person_id,
case when name is not null then 'yes' end as hasallergy 
from(
	SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
   ,@prev_val := t.person_id AS personcheck
	,t.*
	FROM (
		select cn.name,o.person_id,o.obs_datetime from mumiasaltb.obs o
		left join(
			SELECT * FROM mumiasaltb.concept_name WHERE locale = 'en' and concept_name_type = 'FULLY_SPECIFIED'
		)cn on o.value_coded = cn.concept_id
		where o.concept_id = 160643 and o.obs_datetime < '2021-04-01'
	) t,
	  (SELECT @row_no := 0) x,
	  (SELECT @prev_val := '') y
	ORDER BY t.person_id ASC,t.obs_datetime asc
	)selecteddata where row_number = 1
)allergy on allergy.person_id = p.patient_id
left join(
	select person_id as personid,obs_datetime,drugreaction as hasdrugreaction from(
	SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
	   ,@prev_val := t.person_id AS personcheck
	   ,t.*
	FROM (
		select person_id,case when value_coded = 2 then 'no' else 'yes' end as drugreaction,value_coded,obs_datetime
		from mumiasaltb.obs where concept_id = 121764 and obs_datetime < '2021-04-01'
	) t,
	  (SELECT @row_no := 0) x,
	  (SELECT @prev_val := '') y
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
			select cn.name systemfinding,o.person_id,o.obs_datetime,o.value_coded from mumiasaltb.obs o
				left join(
					SELECT * FROM mumiasaltb.concept_name WHERE locale = 'en' and concept_name_type = 'FULLY_SPECIFIED'
				)cn on o.value_coded = cn.concept_id
				where o.concept_id = 162737 and o.obs_datetime < '2017-04-01'
		) t,
		  (SELECT @row_no := 0) x,
		  (SELECT @prev_val := '') y
		ORDER BY t.person_id ASC,t.obs_datetime asc
	)selecteddata where row_number = 1
)systemfindings on systemfindings.person_id = p.patient_id
where voided = 0