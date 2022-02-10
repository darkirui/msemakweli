DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spdatimtxmldata`(
	in reportingperiod varchar(100),
    in reportname varchar(100)
)
BEGIN
    set @querydropformerrecords = concat('
			select 
			fd.*,
			deaths.*,
			ltfus.*,
			tos.*
			from facilitydetails fd left join(
				select fd.facilityname,
				0 AS ''d Female Unknown Age'',
				SUM(CASE WHEN died.AgeCategory = ''<1'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female <1'',
				SUM(CASE WHEN died.AgeCategory = ''1-4'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female 1-4'',
				SUM(CASE WHEN died.AgeCategory = ''5-9'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female5-9'',
				SUM(CASE WHEN died.AgeCategory = ''10-14'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female 10-14'',
				SUM(CASE WHEN died.AgeCategory = ''15-19'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female 15-19'',
				SUM(CASE WHEN died.AgeCategory = ''20-24'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female 20-24'',
				SUM(CASE WHEN died.AgeCategory = ''25-29'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female 25-29'',
				SUM(CASE WHEN died.AgeCategory = ''30-34'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female 30-34'',
				SUM(CASE WHEN died.AgeCategory = ''35-39'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female 35-39'',
				SUM(CASE WHEN died.AgeCategory = ''40-44'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female 40-44'',
				SUM(CASE WHEN died.AgeCategory = ''45-49'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female 45-49'',
				SUM(CASE WHEN died.AgeCategory = ''50+'' and died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female 50+'',
				SUM(CASE WHEN died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Female Total'',
				0 AS ''d Male Unknown Age'',
				SUM(CASE WHEN died.AgeCategory = ''<1'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male <1'',
				SUM(CASE WHEN died.AgeCategory = ''1-4'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male 1-4'',
				SUM(CASE WHEN died.AgeCategory = ''5-9'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male5-9'',
				SUM(CASE WHEN died.AgeCategory = ''10-14'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male 10-14'',
				SUM(CASE WHEN died.AgeCategory = ''15-19'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male 15-19'',
				SUM(CASE WHEN died.AgeCategory = ''20-24'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male 20-24'',
				SUM(CASE WHEN died.AgeCategory = ''25-29'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male 25-29'',
				SUM(CASE WHEN died.AgeCategory = ''30-34'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male 30-34'',
				SUM(CASE WHEN died.AgeCategory = ''35-39'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male 35-39'',
				SUM(CASE WHEN died.AgeCategory = ''40-44'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male 40-44'',
				SUM(CASE WHEN died.AgeCategory = ''45-49'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male 45-49'',
				SUM(CASE WHEN died.AgeCategory = ''50+'' and died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male 50+'',
				SUM(CASE WHEN died.gender = ''M'' THEN 1 ELSE 0 END) AS ''d Male Total'',
				SUM(CASE WHEN died.gender = ''M'' OR died.gender = ''F'' THEN 1 ELSE 0 END) AS ''d Total''
				from facilitydetails fd
				left join(
					select fd.*,report.personid,pbd.gender,lvd.ageatlastvisit,
					CASE WHEN cast(lvd.ageatlastvisit AS Decimal) < 1 THEN ''<1''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 1 and cast(lvd.ageatlastvisit AS Decimal) <= 4) THEN ''1-4''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 5 and cast(lvd.ageatlastvisit AS Decimal) <= 9) THEN ''5-9''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 10 and cast(lvd.ageatlastvisit AS Decimal) <= 14) THEN ''10-14''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 15 and cast(lvd.ageatlastvisit AS Decimal) <= 19) THEN ''15-19''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 20 and cast(lvd.ageatlastvisit AS Decimal) <= 24) THEN ''20-24''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 25 and cast(lvd.ageatlastvisit AS Decimal) <= 29) THEN ''25-29''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 30 and cast(lvd.ageatlastvisit AS Decimal) <= 34) THEN ''30-34''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 35 and cast(lvd.ageatlastvisit AS Decimal) <= 39) THEN ''35-39''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 40 and cast(lvd.ageatlastvisit AS Decimal) <= 44) THEN ''40-44''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 45 and cast(lvd.ageatlastvisit AS Decimal) <= 49) THEN ''45-49''
					WHEN cast(lvd.ageatlastvisit AS Decimal) >= 50 THEN ''50+''
					END AS agecategory,art.regimenduration,keypops.keypoptype
					from(
						select facilityname,personid from patientdeaths where voided = 0 and reportingperiod = ''',reportingperiod,'''
					)report left join(
						select facilityname,ageatlastvisit,personid from patientlastvisitdetails where voided = 0 and reportingperiod = ''',reportingperiod,'''
					)lvd ON report.facilityname = lvd.facilityname and report.personid = lvd.personid
					left join(
						select facilityname,personid,regimenduration from patientlastart where voided = 0 and reportingperiod = ''',reportingperiod,'''
						group by facilityname,personid
					)art ON report.facilityname = art.facilityname and report.personid = art.personid
					left join(
						select facilityname,personid,gender from personbasicdetails 
					)pbd ON report.facilityname = pbd.facilityname and report.personid = pbd.personid
					left join(
						select facilityname,personid,
						case when keypop = ''Key population'' and (keypoptype like ''%inject%'' or keypoptype like ''%pwid%'') then ''pwid''
						when keypop = ''Key population'' and (keypoptype like ''%transgenser%'' or keypoptype like ''%trans gender%'') then ''transgender''
						when keypop = ''Key population'' and (keypoptype like ''%female sex%'' or keypoptype like ''%fsw%'') then ''fsw''
						when keypop = ''Key population'' and gender = ''F'' and (keypoptype like ''%sex%'' or keypoptype like ''%fsw%'') then ''fsw''
						when keypop = ''Key population'' and (keypoptype like ''%male sex%'' or keypoptype like ''%msm%'') then ''msm''
						when keypop = ''Key population'' and gender = ''M'' and (keypoptype like ''%sex%'' or keypoptype like ''%msm%'') then ''msm''
						when keypop = ''Key population'' and (keypoptype like ''%prison%'' or keypoptype like ''%other%'') then ''other''
						end as keypoptype
						from personbasicdetails where keypoptype is not null and keypop = ''Key population''
					)keypops on report.facilityname = keypops.facilityname and report.personid = keypops.personid
					left join facilitydetails fd on fd.facilityname = report.facilityname
				)died on died.facilityname = fd.facilityname
				group by fd.facilityname
			)deaths ON deaths.facilityname = fd.facilityname
			left join(
				select
				fd.facilityname,
				0 AS ''iit1 Female Unknown Age'',
				SUM(CASE WHEN ltfu.AgeCategory = ''<1'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1Female <1'',
				SUM(CASE WHEN ltfu.AgeCategory = ''1-4'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1 Female 1-4'',
				SUM(CASE WHEN ltfu.AgeCategory = ''5-9'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1 Female5-9'',
				SUM(CASE WHEN ltfu.AgeCategory = ''10-14'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1 Female 10-14'',
				SUM(CASE WHEN ltfu.AgeCategory = ''15-19'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1 Female 15-19'',
				SUM(CASE WHEN ltfu.AgeCategory = ''20-24'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1 Female 20-24'',
				SUM(CASE WHEN ltfu.AgeCategory = ''25-29'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1 Female 25-29'',
				SUM(CASE WHEN ltfu.AgeCategory = ''30-34'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1 Female 30-34'',
				SUM(CASE WHEN ltfu.AgeCategory = ''35-39'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1 Female 35-39'',
				SUM(CASE WHEN ltfu.AgeCategory = ''40-44'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1 Female 40-44'',
				SUM(CASE WHEN ltfu.AgeCategory = ''45-49'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1 Female 45-49'',
				SUM(CASE WHEN ltfu.AgeCategory = ''50+'' and ltfu.gender = ''F'' and monthsonart < 3 THEN 1 ELSE 0 END) AS ''iit1 Female 50+'',
				SUM(CASE WHEN ltfu.gender = ''F'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Female Total'',
				0 AS ''iit1 Male Unknown Age'',
				SUM(CASE WHEN ltfu.AgeCategory = ''<1'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male <1'',
				SUM(CASE WHEN ltfu.AgeCategory = ''1-4'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male 1-4'',
				SUM(CASE WHEN ltfu.AgeCategory = ''5-9'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male5-9'',
				SUM(CASE WHEN ltfu.AgeCategory = ''10-14'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male 10-14'',
				SUM(CASE WHEN ltfu.AgeCategory = ''15-19'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male 15-19'',
				SUM(CASE WHEN ltfu.AgeCategory = ''20-24'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male 20-24'',
				SUM(CASE WHEN ltfu.AgeCategory = ''25-29'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male 25-29'',
				SUM(CASE WHEN ltfu.AgeCategory = ''30-34'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male 30-34'',
				SUM(CASE WHEN ltfu.AgeCategory = ''35-39'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male 35-39'',
				SUM(CASE WHEN ltfu.AgeCategory = ''40-44'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male 40-44'',
				SUM(CASE WHEN ltfu.AgeCategory = ''45-49'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male 45-49'',
				SUM(CASE WHEN ltfu.AgeCategory = ''50+'' and ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male 50+'',
				SUM(CASE WHEN ltfu.gender = ''M'' and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Male Total'',
				SUM(CASE WHEN (ltfu.gender = ''M'' or ltfu.gender = ''F'') and (ltfu.monthsonart < 3 or ltfu.monthsonart is null) THEN 1 ELSE 0 END) AS ''iit1 Total'',
				0 AS ''iit2 Female Unknown Age'',
				SUM(CASE WHEN ltfu.AgeCategory = ''<1'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2Female <1'',
				SUM(CASE WHEN ltfu.AgeCategory = ''1-4'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female 1-4'',
				SUM(CASE WHEN ltfu.AgeCategory = ''5-9'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female5-9'',
				SUM(CASE WHEN ltfu.AgeCategory = ''10-14'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female 10-14'',
				SUM(CASE WHEN ltfu.AgeCategory = ''15-19'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female 15-19'',
				SUM(CASE WHEN ltfu.AgeCategory = ''20-24'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female 20-24'',
				SUM(CASE WHEN ltfu.AgeCategory = ''25-29'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female 25-29'',
				SUM(CASE WHEN ltfu.AgeCategory = ''30-34'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female 30-34'',
				SUM(CASE WHEN ltfu.AgeCategory = ''35-39'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female 35-39'',
				SUM(CASE WHEN ltfu.AgeCategory = ''40-44'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female 40-44'',
				SUM(CASE WHEN ltfu.AgeCategory = ''45-49'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female 45-49'',
				SUM(CASE WHEN ltfu.AgeCategory = ''50+'' and ltfu.gender = ''F'' and monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female 50+'',
				SUM(CASE WHEN ltfu.gender = ''F'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Female Total'',
				0 AS ''iit2 Male Unknown Age'',
				SUM(CASE WHEN ltfu.AgeCategory = ''<1'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male <1'',
				SUM(CASE WHEN ltfu.AgeCategory = ''1-4'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male 1-4'',
				SUM(CASE WHEN ltfu.AgeCategory = ''5-9'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male5-9'',
				SUM(CASE WHEN ltfu.AgeCategory = ''10-14'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male 10-14'',
				SUM(CASE WHEN ltfu.AgeCategory = ''15-19'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male 15-19'',
				SUM(CASE WHEN ltfu.AgeCategory = ''20-24'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male 20-24'',
				SUM(CASE WHEN ltfu.AgeCategory = ''25-29'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male 25-29'',
				SUM(CASE WHEN ltfu.AgeCategory = ''30-34'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male 30-34'',
				SUM(CASE WHEN ltfu.AgeCategory = ''35-39'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male 35-39'',
				SUM(CASE WHEN ltfu.AgeCategory = ''40-44'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male 40-44'',
				SUM(CASE WHEN ltfu.AgeCategory = ''45-49'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male 45-49'',
				SUM(CASE WHEN ltfu.AgeCategory = ''50+'' and ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male 50+'',
				SUM(CASE WHEN ltfu.gender = ''M'' and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Male Total'',
				SUM(CASE WHEN (ltfu.gender = ''M'' or ltfu.gender = ''F'') and ltfu.monthsonart >=3 THEN 1 ELSE 0 END) AS ''iit2 Total'',
				SUM(CASE WHEN (ltfu.gender = ''M'' or ltfu.gender = ''F'') THEN 1 ELSE 0 END) AS ''iit Total''
				from facilitydetails fd
				left join(
					select report.facilityname,report.personid,report.monthsonart,pbd.gender,lvd.ageatlastvisit,
					CASE WHEN cast(lvd.ageatlastvisit AS Decimal) < 1 THEN ''<1''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 1 and cast(lvd.ageatlastvisit AS Decimal) <= 4) THEN ''1-4''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 5 and cast(lvd.ageatlastvisit AS Decimal) <= 9) THEN ''5-9''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 10 and cast(lvd.ageatlastvisit AS Decimal) <= 14) THEN ''10-14''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 15 and cast(lvd.ageatlastvisit AS Decimal) <= 19) THEN ''15-19''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 20 and cast(lvd.ageatlastvisit AS Decimal) <= 24) THEN ''20-24''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 25 and cast(lvd.ageatlastvisit AS Decimal) <= 29) THEN ''25-29''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 30 and cast(lvd.ageatlastvisit AS Decimal) <= 34) THEN ''30-34''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 35 and cast(lvd.ageatlastvisit AS Decimal) <= 39) THEN ''35-39''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 40 and cast(lvd.ageatlastvisit AS Decimal) <= 44) THEN ''40-44''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 45 and cast(lvd.ageatlastvisit AS Decimal) <= 49) THEN ''45-49''
					WHEN cast(lvd.ageatlastvisit AS Decimal) >= 50 THEN ''50+''
					END AS agecategory
					from(
						select facilityname,personid,monthsonart from patientltfu where voided = 0 and reportingperiod = ''',reportingperiod,'''
					)report left join(
						select facilityname,ageatlastvisit,personid from patientlastvisitdetails where voided = 0 and reportingperiod = ''',reportingperiod,'''
					)lvd ON report.facilityname = lvd.facilityname and report.personid = lvd.personid
					left join(
						select facilityname,personid,gender from personbasicdetails 
					)pbd ON report.facilityname = pbd.facilityname and report.personid = pbd.personid
				)ltfu on ltfu.facilityname = fd.facilityname
				group by fd.facilityname
			)ltfus ON ltfus.facilityname = fd.facilityname
			left join(
				select fd.facilityname,
				0 AS ''to Female Unknown Age'',
				SUM(CASE WHEN tos.AgeCategory = ''<1'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female <1'',
				SUM(CASE WHEN tos.AgeCategory = ''1-4'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female 1-4'',
				SUM(CASE WHEN tos.AgeCategory = ''5-9'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female5-9'',
				SUM(CASE WHEN tos.AgeCategory = ''10-14'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female 10-14'',
				SUM(CASE WHEN tos.AgeCategory = ''15-19'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female 15-19'',
				SUM(CASE WHEN tos.AgeCategory = ''20-24'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female 20-24'',
				SUM(CASE WHEN tos.AgeCategory = ''25-29'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female 25-29'',
				SUM(CASE WHEN tos.AgeCategory = ''30-34'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female 30-34'',
				SUM(CASE WHEN tos.AgeCategory = ''35-39'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female 35-39'',
				SUM(CASE WHEN tos.AgeCategory = ''40-44'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female 40-44'',
				SUM(CASE WHEN tos.AgeCategory = ''45-49'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female 45-49'',
				SUM(CASE WHEN tos.AgeCategory = ''50+'' and tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female 50+'',
				SUM(CASE WHEN tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Female Total'',
				0 AS ''to Male Unknown Age'',
				SUM(CASE WHEN tos.AgeCategory = ''<1'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male <1'',
				SUM(CASE WHEN tos.AgeCategory = ''1-4'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male 1-4'',
				SUM(CASE WHEN tos.AgeCategory = ''5-9'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male5-9'',
				SUM(CASE WHEN tos.AgeCategory = ''10-14'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male 10-14'',
				SUM(CASE WHEN tos.AgeCategory = ''15-19'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male 15-19'',
				SUM(CASE WHEN tos.AgeCategory = ''20-24'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male 20-24'',
				SUM(CASE WHEN tos.AgeCategory = ''25-29'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male 25-29'',
				SUM(CASE WHEN tos.AgeCategory = ''30-34'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male 30-34'',
				SUM(CASE WHEN tos.AgeCategory = ''35-39'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male 35-39'',
				SUM(CASE WHEN tos.AgeCategory = ''40-44'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male 40-44'',
				SUM(CASE WHEN tos.AgeCategory = ''45-49'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male 45-49'',
				SUM(CASE WHEN tos.AgeCategory = ''50+'' and tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male 50+'',
				SUM(CASE WHEN tos.gender = ''M'' THEN 1 ELSE 0 END) AS ''to Male Total'',
				SUM(CASE WHEN tos.gender = ''M'' OR tos.gender = ''F'' THEN 1 ELSE 0 END) AS ''to Total''
				from facilitydetails fd
				left join(
					select fd.*,report.personid,pbd.gender,lvd.ageatlastvisit,
					CASE WHEN cast(lvd.ageatlastvisit AS Decimal) < 1 THEN ''<1''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 1 and cast(lvd.ageatlastvisit AS Decimal) <= 4) THEN ''1-4''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 5 and cast(lvd.ageatlastvisit AS Decimal) <= 9) THEN ''5-9''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 10 and cast(lvd.ageatlastvisit AS Decimal) <= 14) THEN ''10-14''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 15 and cast(lvd.ageatlastvisit AS Decimal) <= 19) THEN ''15-19''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 20 and cast(lvd.ageatlastvisit AS Decimal) <= 24) THEN ''20-24''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 25 and cast(lvd.ageatlastvisit AS Decimal) <= 29) THEN ''25-29''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 30 and cast(lvd.ageatlastvisit AS Decimal) <= 34) THEN ''30-34''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 35 and cast(lvd.ageatlastvisit AS Decimal) <= 39) THEN ''35-39''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 40 and cast(lvd.ageatlastvisit AS Decimal) <= 44) THEN ''40-44''
					WHEN (cast(lvd.ageatlastvisit AS Decimal) >= 45 and cast(lvd.ageatlastvisit AS Decimal) <= 49) THEN ''45-49''
					WHEN cast(lvd.ageatlastvisit AS Decimal) >= 50 THEN ''50+''
					END AS agecategory,art.regimenduration,keypops.keypoptype
					from(
						select facilityname,personid from patienttransferout where voided = 0 and reportingperiod = ''',reportingperiod,'''
					)report left join(
						select facilityname,ageatlastvisit,personid from patientlastvisitdetails where voided = 0 and reportingperiod = ''',reportingperiod,'''
					)lvd ON report.facilityname = lvd.facilityname and report.personid = lvd.personid
					left join(
						select facilityname,personid,regimenduration from patientlastart where voided = 0 and reportingperiod = ''',reportingperiod,'''
						group by facilityname,personid
					)art ON report.facilityname = art.facilityname and report.personid = art.personid
					left join(
						select facilityname,personid,gender from personbasicdetails 
					)pbd ON report.facilityname = pbd.facilityname and report.personid = pbd.personid
					left join(
						select facilityname,personid,
						case when keypop = ''Key population'' and (keypoptype like ''%inject%'' or keypoptype like ''%pwid%'') then ''pwid''
						when keypop = ''Key population'' and (keypoptype like ''%transgenser%'' or keypoptype like ''%trans gender%'') then ''transgender''
						when keypop = ''Key population'' and (keypoptype like ''%female sex%'' or keypoptype like ''%fsw%'') then ''fsw''
						when keypop = ''Key population'' and gender = ''F'' and (keypoptype like ''%sex%'' or keypoptype like ''%fsw%'') then ''fsw''
						when keypop = ''Key population'' and (keypoptype like ''%male sex%'' or keypoptype like ''%msm%'') then ''msm''
						when keypop = ''Key population'' and gender = ''M'' and (keypoptype like ''%sex%'' or keypoptype like ''%msm%'') then ''msm''
						when keypop = ''Key population'' and (keypoptype like ''%prison%'' or keypoptype like ''%other%'') then ''other''
						end as keypoptype
						from personbasicdetails where keypoptype is not null and keypop = ''Key population''
					)keypops on report.facilityname = keypops.facilityname and report.personid = keypops.personid
					left join facilitydetails fd on fd.facilityname = report.facilityname
				)tos on tos.facilityname = fd.facilityname
				group by fd.facilityname
			)tos ON tos.facilityname = fd.facilityname;');
    PREPARE stmtdropformerrecords FROM @querydropformerrecords;
	EXECUTE stmtdropformerrecords;
	DEALLOCATE PREPARE stmtdropformerrecords;

END$$
DELIMITER ;
