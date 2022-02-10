select facilitymaster.*,'August',tx.TxCURR,appointmentcounts.appointments,honouredappointmentcounts.honoured,
missedappointmentcounts.missed,mmdcounts.mmd,tldcounts.tld
 from(	
    select facilityname,count(*) TxCURR from patienttxcurr where voided = 0 and reportingperiod = 'august2021'
	GROUP BY facilityname
)tx left join(
	select facilityname,count(*) mmd from(
		select tx.facilityname,tx.personid,art.regimenduration from( 
			select * from patienttxcurr where voided = 0 and reportingperiod = 'august2021'
		)tx left join( 
			select * from patientlastart where voided = 0 and reportingperiod = 'august2021'
			group by facilityname,personid
		)art on tx.facilityname = art.facilityname and tx.personid = art.personid
		where art.regimenduration > 60
	)mmddata group by facilityname
)mmdcounts on mmdcounts.facilityname = tx.facilityname
left join(
	select facilityname,count(*) tld from(
		select tx.facilityname,tx.personid,art.regimenduration from( 
			select * from patienttxcurr where voided = 0 and reportingperiod = 'august2021'
		)tx left join( 
			select * from patientlastart where voided = 0 and reportingperiod = 'august2021'
			group by facilityname,personid
		)art on tx.facilityname = art.facilityname and tx.personid = art.personid
		where art.lastregimen LIKE '%DTG%'
	)tlddata group by facilityname
)tldcounts on tldcounts.facilityname = tx.facilityname
left join(
	select facilityname,count(*) appointments from patientappointments where voided = 0 and reportingperiod = 'august2021'
	group by facilityname
)appointmentcounts on appointmentcounts.facilityname = tx.facilityname
left join(
	select facilityname,count(*) honoured from patientappointments where voided = 0 and reportingperiod = 'august2021'
    and finalappointmentstatus = 'met' group by facilityname
)honouredappointmentcounts on honouredappointmentcounts.facilityname = tx.facilityname
left join(
	select facilityname,count(*) missed from patientappointments where voided = 0 and reportingperiod = 'august2021'
    and finalappointmentstatus = 'missed' group by facilityname
)missedappointmentcounts on missedappointmentcounts.facilityname = tx.facilityname
left join(
	SELECT f.facilityname,f.mflcode,c.countyname,sc.subcountyname,r.regionname FROM facility f 
	left join countylinkfacilities clf ON f.id = clf.facilityid
	left join county c ON c.id = clf.countyid
	left join subcountylinkfacilities slf ON f.id = slf.facilityid
	left join subcounty sc ON sc.id = slf.subcountyid
	left join regionlinkfacilities rlf ON f.id = rlf.facilityid
	left join region r ON r.id = rlf.regionid
)facilitymaster on facilitymaster.facilityname = tx.facilityname
