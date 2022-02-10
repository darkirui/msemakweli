select fd.*,pbd.cccnumber,report.personid,pbd.patientclinicid,pbd.birthdate,pbd.gender,pbd.keypop,pbd.keypoptype,pbd.occupation,pbd.maritalstatus,
pbd.educationlevel,pbi.patienttype,pbi.patientsource,pbi.registrationdate,pbi.transferindate,pbi.hivdiagnosisdate,
pbi.hivenrollmentdate,pbi.artstartdate,pbi.baselineregimen,pbi.baselineregimenline,pbi.baselinevl,pbi.baselinevldate,pbi.baselinewho,
pbi.baselineweight,pbi.baselineheight,pbi.baselinebmi,pbi.ageatregistration,pbi.ageatartstart,plvd.visitby,plvd.lastvisitdate,
plvd.ageatlastvisit,plvd.nextappointmentdate,plvd.appointmentreason,plvd.nextrefilldate,plvd.dcmethod,plvd.defaultingdate,
plvd.adherence,pla.lastregimen,pla.lastregimenline,pla.regimenduration,pla.quantitydispensed,pla.regimenfrequencytext,
pla.regimendispensedate,pla.regimenswitchingdate,plv.lastvldate,plv.lastvlresult,plv.lastvltext
from(select facilityname,personid from patienttxcurr where voided = 0 
and reportingperiod = 'august2021'
)report 
left join (select facilityname,cccnumber,personid,patientclinicid,birthdate,gender,keypop,keypoptype,occupation,
maritalstatus,educationlevel from personbasicdetails
)pbd ON report.facilityname = pbd.facilityname and report.personid = pbd.personid
left join (select * from patientbaselineinfo
)pbi ON report.facilityname = pbi.facilityname and report.personid = pbi.personid
left join (select * from patientlastvisitdetails where voided = 0 and reportingperiod = 'august2021' group by facilityname,personid
)plvd ON report.facilityname = plvd.facilityname and report.personid = plvd.personid
left join (select * from patientlastart where voided = 0 and reportingperiod = 'august2021' group by facilityname,personid
)pla ON report.facilityname = pla.facilityname and report.personid = pla.personid
left join (select * from patientlastvl where voided = 0 and reportingperiod = 'august2021' group by facilityname,personid
)plv ON report.facilityname = plv.facilityname and report.personid = plv.personid
left join facilitydetails fd ON report.facilityname = fd.facilityname

