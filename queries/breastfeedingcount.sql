
select report.facilityname,count(*) total
from(
	select * from patienttxcurr where reportingperiod = '2021-09-30' and voided = 0
)report left join(
	select * from patientlastvl where reportingperiod = '2021-09-30' and voided = 0
	group by facilityname,personid
)vls ON report.facilityname = vls.facilityname and report.personid = vls.personid
left join(
	select * from patientlastvisitdetails where reportingperiod = '2021-09-30' and voided = 0
	group by facilityname,personid
)visits ON report.facilityname = visits.facilityname and report.personid = visits.personid
left join(
	select * from personbasicdetails
)pbd ON report.facilityname = pbd.facilityname and report.personid = pbd.personid
left join(
	select * from pmtctdata where edd < '2021-09-30' and (dod is null OR dod > '2019-10-01')
)pregnant on report.facilityname = pregnant.facilityname and report.personid = pregnant.personid 
where lastvldate IS NOT NULL and TIMESTAMPDIFF(MONTH, lastvldate, '2021-09-30') < 13 and 
cast(vls.lastvlresult as decimal) < 1000 and pregnant.personid IS NOT null
group by report.facilityname