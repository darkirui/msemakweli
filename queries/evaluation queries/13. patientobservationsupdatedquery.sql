select p.patient_id,stability.patientstable,allergy.hasallergy,drugreaction.hasdrugreaction,systemfindings.systemfinding,
complaints.complaint,chronicdisease.chronicillness,cervicalcancer.cacxresult,ipt.iptstatus as patienteveronipt,
tb.tbstatus as patienteverontbrx
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
			 and obs_datetime < '2017-04-01'
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
		where o.concept_id = 160643 and o.obs_datetime < '2017-04-01'
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
		from mumiasaltb.obs where concept_id = 121764 and obs_datetime < '2017-04-01'
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
left join(
	select person_id,complaint
	from(
		SELECT @row_no := IF(@prev_val = t.person_id, @row_no + 1, 1) AS row_number
		   ,@prev_val := t.person_id AS personcheck
		   ,t.*
		FROM (
			select cn.name complaint,o.person_id,o.obs_datetime,o.value_coded from mumiasaltb.obs o
				left join(
					SELECT * FROM mumiasaltb.concept_name WHERE locale = 'en' and concept_name_type = 'FULLY_SPECIFIED'
				)cn on o.value_coded = cn.concept_id
				where o.concept_id = 5219 and o.obs_datetime < '2017-04-01'
		) t,
		  (SELECT @row_no := 0) x,
		  (SELECT @prev_val := '') y
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
			select cna.name as chronicillness,o.person_id,o.obs_datetime from mumiasaltb.obs o
			left join(
				SELECT * FROM mumiasaltb.concept_name WHERE locale = 'en' and concept_name_type = 'FULLY_SPECIFIED'
			)cn on o.concept_id = cn.concept_id
			left join(
				SELECT * FROM mumiasaltb.concept_name WHERE locale = 'en' and concept_name_type = 'FULLY_SPECIFIED'
			)cna on o.value_coded = cna.concept_id
			where o.concept_id = 1284 and o.obs_datetime < '2017-04-01'
		) t,
		  (SELECT @row_no := 0) x,
		  (SELECT @prev_val := '') y
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
			select cna.name as cacxresult,o.person_id,o.obs_datetime from mumiasaltb.obs o
			left join(
				SELECT * FROM mumiasaltb.concept_name WHERE locale = 'en' and concept_name_type = 'FULLY_SPECIFIED'
			)cn on o.concept_id = cn.concept_id
			left join(
				SELECT * FROM mumiasaltb.concept_name WHERE locale = 'en' and concept_name_type = 'FULLY_SPECIFIED'
			)cna on o.value_coded = cna.concept_id
			where o.concept_id = 164934 and o.obs_datetime < '2017-04-01'
		) t,
		  (SELECT @row_no := 0) x,
		  (SELECT @prev_val := '') y
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
			select cna.name as iptstatus,o.person_id,o.obs_datetime from mumiasaltb.obs o
			left join(
				SELECT * FROM mumiasaltb.concept_name WHERE locale = 'en' and concept_name_type = 'FULLY_SPECIFIED'
			)cn on o.concept_id = cn.concept_id
			left join(
				SELECT * FROM mumiasaltb.concept_name WHERE locale = 'en' and concept_name_type = 'FULLY_SPECIFIED'
			)cna on o.value_coded = cna.concept_id
			where o.concept_id = 164950 and o.obs_datetime < '2017-04-01'
		) t,
		  (SELECT @row_no := 0) x,
		  (SELECT @prev_val := '') y
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
			select cna.name as tbstatus,o.person_id,o.obs_datetime from mumiasaltb.obs o
			left join(
				SELECT * FROM mumiasaltb.concept_name WHERE locale = 'en' and concept_name_type = 'FULLY_SPECIFIED'
			)cn on o.concept_id = cn.concept_id
			left join(
				SELECT * FROM mumiasaltb.concept_name WHERE locale = 'en' and concept_name_type = 'FULLY_SPECIFIED'
			)cna on o.value_coded = cna.concept_id
			where o.concept_id = 164949 and o.obs_datetime < '2017-04-01'
		) t,
		  (SELECT @row_no := 0) x,
		  (SELECT @prev_val := '') y
		ORDER BY t.person_id ASC,t.obs_datetime asc
	)selecteddata where row_number = 1
)tb on tb.person_id = p.patient_id
where voided = 0