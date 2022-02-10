<?php
  include '../functions.php';
  $obj = new myFunctions;
  $facilitydetails = $obj->getdbfacilitydetails("openmrslwakg7st");
  $facilityname = $facilitydetails[0]["facilityname"];
  $mflcode = $facilitydetails[0]["mflcode"];
  $lastencounterdate = $facilitydetails[0]["lastencounterdate"];
  $lastencountercreatedate = $facilitydetails[0]["lastencountercreatedate"];
  $uploaddate = $facilitydetails[0]["uploaddate"];

  //2. get the names of former databases and drop
  $tabledata = array("facilityname"=>$facilityname);
  $databaseresults = $obj->readAlldatawhere("facilitydatabases",$tabledata);
  foreach($databaseresults as $dblist) {
    $dbname = $dblist["databasename"];
    $dropresult = $obj->dropformerdbs($dbname);
  }

  //3. drop former records
  $droptabledata = array("facilityname"=>$facilityname);
  $deletedbresults = $obj->deletedatawhere("facilitydatabases",$droptabledata);
?>