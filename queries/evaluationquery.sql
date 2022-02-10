select pbd.facilityname,pbd.cccnumber,pbd.personid,pbd.gender,pbi.artstartdate,pbi.ageatartstart,
CASE WHEN (cast(pbi.ageatartstart AS Decimal) < 1) THEN '<1'
WHEN (cast(pbi.ageatartstart AS Decimal) >= 1 and cast(pbi.ageatartstart AS Decimal) <= 4) THEN '1-4'
WHEN (cast(pbi.ageatartstart AS Decimal) >= 5 and cast(pbi.ageatartstart AS Decimal) <= 9) THEN '5-9'
WHEN (cast(pbi.ageatartstart AS Decimal) >= 10 and cast(pbi.ageatartstart AS Decimal) <= 14) THEN '10-14'
WHEN (cast(pbi.ageatartstart AS Decimal) >= 15 and cast(pbi.ageatartstart AS Decimal) <= 19) THEN '15-19'
WHEN (cast(pbi.ageatartstart AS Decimal) >= 20 and cast(pbi.ageatartstart AS Decimal) <= 24) THEN '20-24'
WHEN (cast(pbi.ageatartstart AS Decimal) >= 25 and cast(pbi.ageatartstart AS Decimal) <= 29) THEN '25-29'
WHEN (cast(pbi.ageatartstart AS Decimal) >= 30 and cast(pbi.ageatartstart AS Decimal) <= 34) THEN '30-34'
WHEN (cast(pbi.ageatartstart AS Decimal) >= 35 and cast(pbi.ageatartstart AS Decimal) <= 39) THEN '35-39'
WHEN (cast(pbi.ageatartstart AS Decimal) >= 40 and cast(pbi.ageatartstart AS Decimal) <= 44) THEN '40-44'
WHEN (cast(pbi.ageatartstart AS Decimal) >= 45 and cast(pbi.ageatartstart AS Decimal) <= 49) THEN '45-49'
WHEN cast(pbi.ageatartstart AS Decimal) >= 50 THEN '50+'
END AS ageatartstart_1,
CASE WHEN (cast(pbi.ageatartstart AS Decimal) < 15) THEN '<15'
WHEN (cast(pbi.ageatartstart AS Decimal) >= 15) THEN '15+'
END AS ageatartstart_2,
visits.lastvisitdate,
visits.ageatlastvisit,
CASE WHEN (cast(visits.ageatlastvisit AS Decimal) < 1) THEN '<1'
WHEN (cast(visits.ageatlastvisit AS Decimal) >= 1 and cast(visits.ageatlastvisit AS Decimal) <= 4) THEN '1-4'
WHEN (cast(visits.ageatlastvisit AS Decimal) >= 5 and cast(visits.ageatlastvisit AS Decimal) <= 9) THEN '5-9'
WHEN (cast(visits.ageatlastvisit AS Decimal) >= 10 and cast(visits.ageatlastvisit AS Decimal) <= 14) THEN '10-14'
WHEN (cast(visits.ageatlastvisit AS Decimal) >= 15 and cast(visits.ageatlastvisit AS Decimal) <= 19) THEN '15-19'
WHEN (cast(visits.ageatlastvisit AS Decimal) >= 20 and cast(visits.ageatlastvisit AS Decimal) <= 24) THEN '20-24'
WHEN (cast(visits.ageatlastvisit AS Decimal) >= 25 and cast(visits.ageatlastvisit AS Decimal) <= 29) THEN '25-29'
WHEN (cast(visits.ageatlastvisit AS Decimal) >= 30 and cast(visits.ageatlastvisit AS Decimal) <= 34) THEN '30-34'
WHEN (cast(visits.ageatlastvisit AS Decimal) >= 35 and cast(visits.ageatlastvisit AS Decimal) <= 39) THEN '35-39'
WHEN (cast(visits.ageatlastvisit AS Decimal) >= 40 and cast(visits.ageatlastvisit AS Decimal) <= 44) THEN '40-44'
WHEN (cast(visits.ageatlastvisit AS Decimal) >= 45 and cast(visits.ageatlastvisit AS Decimal) <= 49) THEN '45-49'
WHEN cast(visits.ageatlastvisit AS Decimal) >= 50 THEN '50+'
END AS ageatlastvisit_1,
CASE WHEN (cast(visits.ageatlastvisit AS Decimal) < 15) THEN '<15'
WHEN (cast(visits.ageatlastvisit AS Decimal) >= 15) THEN '15+'
END AS ageatlastvisit_2,
TIMESTAMPDIFF(MONTH, artstartdate,visits.lastvisitdate) monthsonart,
YEAR(visits.lastvisitdate) - YEAR(artstartdate) - (DATE_FORMAT(visits.lastvisitdate, '%m%d') < DATE_FORMAT(artstartdate, '%m%d'))AS yearsonart,
TIMESTAMPDIFF(MONTH, artstartdate,deaths.dateofdeath) monthsonartbeforedeath,
YEAR(deaths.dateofdeath) - YEAR(artstartdate) - (DATE_FORMAT(deaths.dateofdeath, '%m%d') < DATE_FORMAT(artstartdate, '%m%d'))AS yearsonartbeforedeath,
pbd.occupation as maritalstatus,
case when pbd.occupation = 'Polygamous' then 'Married'
when pbd.occupation = 'Divorced' then 'Divorced'
when pbd.occupation = 'Married' then 'Married'
when pbd.occupation = 'Widowed' then 'Widowed'
when pbd.occupation = 'Separated' then 'Divorced'
else 'Unknown' end as maritalstatus_1,
pbd.maritalstatus as occupation,cd.baseline as BaselineCD4,cd.last AS LastCD4,
pbi.baselinewho,triage.lastwho,visits.adherence,pbi.baselinevl,
case when cast(pbi.baselinevl as decimal) <= 10 and baselinevldate is not null then 'ldl'
when cast(pbi.baselinevl as decimal) > 10 and cast(pbi.baselinevl as decimal) < 400  and baselinevldate is not null then '<400'
when cast(pbi.baselinevl as decimal) >= 400 and cast(pbi.baselinevl as decimal) < 1000 and baselinevldate is not null then '400-999'
case when cast(pbi.baselinevl as decimal) >= 1000 and baselinevldate is not null then '>1000' else null end as baselinevl_1,
case when cast(pbi.baselinevl as decimal) < 400 and baselinevldate is not null then '<400'
when cast(pbi.baselinevl as decimal) >= 400 and baselinevldate is not null then '>400' else null
end as baselinevl_2,
vls.lastvlresult as lastvl,
case when cast(vls.lastvlresult as decimal) <= 10 and lastvldate is not null then 'ldl'
when cast(vls.lastvlresult as decimal) > 10 and cast(vls.lastvlresult as decimal) < 400 and lastvldate is not null then '<400'
when cast(vls.lastvlresult as decimal) >= 400 and cast(vls.lastvlresult as decimal) < 1000 and lastvldate is not null then '400-999'
case when cast(vls.lastvlresult as decimal) >= 1000 and lastvldate is not null then '>1000' else null end as lastvl_1,
case when cast(vls.lastvlresult as decimal) < 400 and lastvldate is not null then '<400'
when cast(vls.lastvlresult as decimal) >= 400 and lastvldate is not null then '>400' else null
end as lastvl_2
missedltfu.missedtimes,missedltfu.ltfutimes,
case when tx.personid is not null then 'active'
when deaths.personid is not null then 'death'
when tos.personid is not null then 'TO'
else 'ltfu'
END AS FinalOutcome
from(
	select * from patientbaselineinfo where artstartdate is not null
)pbi left join(
	select * from personbasicdetails
)pbd on pbd.facilityname = pbi.facilityname and pbd.personid = pbi.personid
left join(
	select * from patientcd4
)cd on pbd.facilityname = cd.facilityname and pbd.personid = cd.personid
left join(
	select * from patientmissedandltfutimes
)missedltfu on pbd.facilityname = missedltfu.facilityname and pbd.personid = missedltfu.personid
left join(
	select * from patienttxcurr where reportingperiod = '2021-09-30' and voided = 0
)tx on pbd.facilityname = tx.facilityname and pbd.personid = tx.personid
left join(
	select * from patientdeaths where reportingperiod = 'ever2021' and voided = 0
)deaths on pbd.facilityname = deaths.facilityname and pbd.personid = deaths.personid
left join(
	select * from patienttransferout where reportingperiod = 'ever2021' and voided = 0
)tos on pbd.facilityname = tos.facilityname and pbd.personid = tos.personid
left join(
	select * from patientlastvisitdetails where reportingperiod = '2021-09-30' and voided = 0
)visits on pbd.facilityname = visits.facilityname and pbd.personid = visits.personid
left join(
	select * from patientlasttriage where reportingperiod = '2021-09-30' and voided = 0
)triage on pbd.facilityname = triage.facilityname and pbd.personid = triage.personid
left join(
	select * from patientlastvl where reportingperiod = '2021-09-30' and voided = 0
)vls on pbd.facilityname = vls.facilityname and pbd.personid = vls.personid
