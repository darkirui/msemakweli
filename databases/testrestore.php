<?php
	include '../functions.php';
	$obj = new myFunctions;

	$facilitydetails = $obj->getdbfacilitydetails('mumiasaltb');
	//print_r($facilitydetails);
	$facilityname = $facilitydetails[0]["facilityname"];
	$mflcode = $facilitydetails[0]["mflcode"];
	$lastencounterdate = $facilitydetails[0]["lastencounterdate"];
	$lastencountercreatedate = $facilitydetails[0]["lastencountercreatedate"];
	$uploaddate = $facilitydetails[0]["uploaddate"];

	echo $facilityname;
	echo '<br>';

	// //2. get the names of former databases and drop
	//$fname = $facilityname.replace("'", "\\'");
	$fname = str_replace("'","\\'",$facilityname);
	$tabledata = array("facilityname"=>$fname);
	$databaseresults = $obj->readAlldatawhere("facilitydatabases",$tabledata);
	print_r($databaseresults);
	// foreach($databaseresults as $dblist) {
	// 	$dbname = $dblist["databasename"];
	// 	$dropresult = $obj->dropformerdbs($dbname);
	// }

	// //3. drop former records
	// $droptabledata = array("facilityname"=>$facilityname);
	// $deletedbresults = $obj->deletedatawhere("facilitydatabases",$droptabledata);

	// //4. insert record into 
	// $inserttabledata = array("databasename"=>$newdbname,
 //                     "facilityname"=>$facilityname,
 //                     "mflcode"=>$mflcode,
 //                     "lastencounterdate"=>$lastencounterdate,
 //                     "lastencountercreatedate"=>$lastencountercreatedate,
 //                     "uploaddate"=>$uploaddate
 //                 );
 //  	$passdata = serialize($inserttabledata);
 //  	$savestatus = $obj->insertData("facilitydatabases",$inserttabledata);


 //   	echo $dbnamenoext;
?>