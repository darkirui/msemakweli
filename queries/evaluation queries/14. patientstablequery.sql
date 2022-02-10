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