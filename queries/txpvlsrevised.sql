select 
fd.facilityid,
fd.facilityname,fd.mflcode,fd.countyname,fd.subcountyname,fd.regionname,numerator.*,pregnantnumerator.total as pregnum,
bfnumerator.total as bfnum,numeratorkeypops.*,
denominator.*,pregnantdenominator.total as pregden,bfdenominator.total as bfden,denominatorkeypops.*
from facilitydetails fd
left join(
	select  
	facilityname,
	0 AS 'Female Unknown Age',
	SUM(CASE WHEN numerator.agecategory = '<1' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female <1',
	SUM(CASE WHEN numerator.agecategory = '1-4' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 1-4',
	SUM(CASE WHEN numerator.agecategory = '5-9' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female5-9',
	SUM(CASE WHEN numerator.agecategory = '10-14' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 10-14',
	SUM(CASE WHEN numerator.agecategory = '15-19' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 15-19',
	SUM(CASE WHEN numerator.agecategory = '20-24' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 20-24',
	SUM(CASE WHEN numerator.agecategory = '25-29' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 25-29',
	SUM(CASE WHEN numerator.agecategory = '30-34' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 30-34',
	SUM(CASE WHEN numerator.agecategory = '35-39' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 35-39',
	SUM(CASE WHEN numerator.agecategory = '40-44' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 40-44',
	SUM(CASE WHEN numerator.agecategory = '45-49' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 45-49',
	SUM(CASE WHEN numerator.agecategory = '50+' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 50+',
	SUM(CASE WHEN gender = 'F' THEN 1 ELSE 0 END) AS 'Female Total',
	0 AS 'Male Unknown Age',
	SUM(CASE WHEN numerator.agecategory = '<1' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male <1',
	SUM(CASE WHEN numerator.agecategory = '1-4' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 1-4',
	SUM(CASE WHEN numerator.agecategory = '5-9' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male5-9',
	SUM(CASE WHEN numerator.agecategory = '10-14' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 10-14',
	SUM(CASE WHEN numerator.agecategory = '15-19' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 15-19',
	SUM(CASE WHEN numerator.agecategory = '20-24' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 20-24',
	SUM(CASE WHEN numerator.agecategory = '25-29' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 25-29',
	SUM(CASE WHEN numerator.agecategory = '30-34' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 30-34',
	SUM(CASE WHEN numerator.agecategory = '35-39' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 35-39',
	SUM(CASE WHEN numerator.agecategory = '40-44' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 40-44',
	SUM(CASE WHEN numerator.agecategory = '45-49' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 45-49',
	SUM(CASE WHEN numerator.agecategory = '50+' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 50+',
	SUM(CASE WHEN gender = 'M' THEN 1 ELSE 0 END) AS 'Male Total',
	Count(*) As Total
	from(
		select report.facilityname,report.personid,vls.lastvldate,vls.lastvlresult,visits.ageatlastvisit,pbd.gender,
		CASE WHEN (cast(visits.ageatlastvisit AS Decimal) >= 1 and cast(visits.ageatlastvisit AS Decimal) <= 4) THEN '1-4'
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
		END AS agecategory
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
		where lastvldate IS NOT NULL and TIMESTAMPDIFF(MONTH, lastvldate, '2021-09-30') < 13 and 
		cast(vls.lastvlresult as decimal) < 1000
	)numerator group by facilityname
)numerator on numerator.facilityname = fd.facilityname
left join(
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
		select * from pmtctdata where edd >= '2021-07-01' -- and (dod is null OR dod <= '2021-07-01')
	)pregnant on report.facilityname = pregnant.facilityname and report.personid = pregnant.personid 
	where lastvldate IS NOT NULL and TIMESTAMPDIFF(MONTH, lastvldate, '2021-09-30') < 13 and 
	cast(vls.lastvlresult as decimal) < 1000 and pregnant.personid IS NOT null
	group by report.facilityname
)pregnantnumerator on pregnantnumerator.facilityname = fd.facilityname
left join(
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
)bfnumerator on bfnumerator.facilityname = fd.facilityname
left join(
			select report.facilityname,
        SUM(CASE WHEN pbd.keypoptype = 'pwid' THEN 1 ELSE 0 END) AS 'pwid',
		SUM(CASE WHEN pbd.keypoptype = 'msm' THEN 1 ELSE 0 END) AS 'msm',
		SUM(CASE WHEN pbd.keypoptype = 'transgender' THEN 1 ELSE 0 END) AS 'transgender',
		SUM(CASE WHEN pbd.keypoptype = 'fsw' THEN 1 ELSE 0 END) AS 'fsw',
		SUM(CASE WHEN pbd.keypoptype = 'other' THEN 1 ELSE 0 END) AS 'other'
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
		where lastvldate IS NOT NULL and TIMESTAMPDIFF(MONTH, lastvldate, '2021-09-30') < 13 and 
		cast(vls.lastvlresult as decimal) < 1000 group by facilityname
)numeratorkeypops on numeratorkeypops.facilityname = fd.facilityname
left join(
	select  
	facilityname,
	0 AS 'Female Unknown Age',
	SUM(CASE WHEN denominator.agecategory = '<1' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female <1',
	SUM(CASE WHEN denominator.agecategory = '1-4' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 1-4',
	SUM(CASE WHEN denominator.agecategory = '5-9' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female5-9',
	SUM(CASE WHEN denominator.agecategory = '10-14' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 10-14',
	SUM(CASE WHEN denominator.agecategory = '15-19' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 15-19',
	SUM(CASE WHEN denominator.agecategory = '20-24' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 20-24',
	SUM(CASE WHEN denominator.agecategory = '25-29' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 25-29',
	SUM(CASE WHEN denominator.agecategory = '30-34' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 30-34',
	SUM(CASE WHEN denominator.agecategory = '35-39' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 35-39',
	SUM(CASE WHEN denominator.agecategory = '40-44' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 40-44',
	SUM(CASE WHEN denominator.agecategory = '45-49' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 45-49',
	SUM(CASE WHEN denominator.agecategory = '50+' and gender = 'F' THEN 1 ELSE 0 END) AS 'Female 50+',
	SUM(CASE WHEN gender = 'F' THEN 1 ELSE 0 END) AS 'Female Total',
	0 AS 'Male Unknown Age',
	SUM(CASE WHEN denominator.agecategory = '<1' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male <1',
	SUM(CASE WHEN denominator.agecategory = '1-4' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 1-4',
	SUM(CASE WHEN denominator.agecategory = '5-9' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male5-9',
	SUM(CASE WHEN denominator.agecategory = '10-14' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 10-14',
	SUM(CASE WHEN denominator.agecategory = '15-19' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 15-19',
	SUM(CASE WHEN denominator.agecategory = '20-24' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 20-24',
	SUM(CASE WHEN denominator.agecategory = '25-29' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 25-29',
	SUM(CASE WHEN denominator.agecategory = '30-34' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 30-34',
	SUM(CASE WHEN denominator.agecategory = '35-39' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 35-39',
	SUM(CASE WHEN denominator.agecategory = '40-44' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 40-44',
	SUM(CASE WHEN denominator.agecategory = '45-49' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 45-49',
	SUM(CASE WHEN denominator.agecategory = '50+' and gender = 'M' THEN 1 ELSE 0 END) AS 'Male 50+',
	SUM(CASE WHEN gender = 'M' THEN 1 ELSE 0 END) AS 'Male Total',
	Count(*) As Total
	from(
		select report.facilityname,report.personid,vls.lastvldate,vls.lastvlresult,visits.ageatlastvisit,pbd.gender,
		CASE WHEN (cast(visits.ageatlastvisit AS Decimal) >= 1 and cast(visits.ageatlastvisit AS Decimal) <= 4) THEN '1-4'
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
		END AS agecategory
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
		where lastvldate IS NOT NULL and TIMESTAMPDIFF(MONTH, lastvldate, '2021-09-30') < 13 
	)denominator group by facilityname
)denominator on denominator.facilityname = fd.facilityname
left join(
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
		select * from pmtctdata where edd >= '2021-07-01' -- and (dod is null OR dod <= '2021-07-01')
	)pregnant on report.facilityname = pregnant.facilityname and report.personid = pregnant.personid 
	where lastvldate IS NOT NULL and TIMESTAMPDIFF(MONTH, lastvldate, '2021-09-30') < 13 and 
	pregnant.personid IS NOT null
	group by report.facilityname
)pregnantdenominator on pregnantdenominator.facilityname = fd.facilityname
left join(
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
	pregnant.personid IS NOT null
	group by report.facilityname
)bfdenominator on bfdenominator.facilityname = fd.facilityname
left join(
			select report.facilityname,
        SUM(CASE WHEN pbd.keypoptype = 'pwid' THEN 1 ELSE 0 END) AS 'pwid',
		SUM(CASE WHEN pbd.keypoptype = 'msm' THEN 1 ELSE 0 END) AS 'msm',
		SUM(CASE WHEN pbd.keypoptype = 'transgender' THEN 1 ELSE 0 END) AS 'transgender',
		SUM(CASE WHEN pbd.keypoptype = 'fsw' THEN 1 ELSE 0 END) AS 'fsw',
		SUM(CASE WHEN pbd.keypoptype = 'other' THEN 1 ELSE 0 END) AS 'other'
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
		where lastvldate IS NOT NULL and TIMESTAMPDIFF(MONTH, lastvldate, '2021-09-30') < 13 and 
		cast(vls.lastvlresult as decimal) < 1000 group by facilityname
)denominatorkeypops on denominatorkeypops.facilityname = fd.facilityname
