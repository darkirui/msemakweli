select tx.facilityname,pbd.cccnumber,pbd.personid,pbd.gender,pbd.birthdate,pbd.occupation as maritalstatus,
pbd.educationlevel,pbd.maritalstatus as occupation,pbd.keypop,pbd.keypoptype,pbi.hivdiagnosisdate,pbi.hivenrollmentdate,
TIMESTAMPDIFF(YEAR, pbd.birthdate, pbi.hivenrollmentdate) ageatenrollment,pbi.artstartdate,pbi.ageatartstart,pbi.patienttype,
pbi.baselinewho,baselinecd4.baselinecd4,pbi.baselinevl,pbi.baselineweight,pbi.baselineheight,pbi.baselinebmi,
baselinenutrition.nutritionbaseline,pbi.baselineregimen,pbi.baselineregimenline
from(
	select facilityname,personid from patienttxcurr where reportingperiod = 'march2017' and voided = 0
)tx left join(
	select * from personbasicdetails
)pbd on tx.facilityname = pbd.facilityname and tx.personid = pbd.personid
left join(
	select * from patientbaselineinfo
)pbi on tx.facilityname = pbi.facilityname and tx.personid = pbi.personid
left join(
	select * from patientbaselinecd4
)baselinecd4 on tx.facilityname = baselinecd4.facilityname and tx.personid = baselinecd4.personid
left join(
	select * from patientbaselinenutrition
)baselinenutrition on tx.facilityname = baselinenutrition.facilityname and tx.personid = baselinenutrition.personid
left join(
	select * from patientlasttriage
)
