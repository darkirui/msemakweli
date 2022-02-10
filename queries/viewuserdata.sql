create or replace view userdata as
select u.id,u.useridentifier,u.firstname,u.lastname,u.email, 
ud.office,
case when ud.office = 'region' then ud.region
when ud.office = 'facility' then ud.facility
else null end as location,
ud.department,
case when ud.approved = 0 then 'No' else 'Yes' end as approved
from users u left join
userdetails ud on u.useridentifier = ud.useridentifier
group by u.email