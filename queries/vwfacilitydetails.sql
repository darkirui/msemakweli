create view facilitydetails as 
SELECT f.facilityname,f.mflcode,c.countyname,sc.subcountyname,r.regionname FROM facility f 
	left join countylinkfacilities clf ON f.id = clf.facilityid
	left join county c ON c.id = clf.countyid
	left join subcountylinkfacilities slf ON f.id = slf.facilityid
	left join subcounty sc ON sc.id = slf.subcountyid
	left join regionlinkfacilities rlf ON f.id = rlf.facilityid
	left join region r ON r.id = rlf.regionid