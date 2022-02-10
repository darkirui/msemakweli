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
			where o.concept_id = 1533 and o.obs_datetime < '2017-04-01'
	) t,
	  (SELECT @row_no := 0) x,
	  (SELECT @prev_val := '') y
	ORDER BY t.person_id ASC,t.obs_datetime asc
)selecteddata where row_number = 1