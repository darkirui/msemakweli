<?php
	include '../functions.php';
	$obj = new myFunctions;
	$databaseid = $_POST["databaseid"];

	$tabledata = array("id"=>$databaseid);
	$databaseresults = $obj->readAlldatawhere("facilitydatabases",$tabledata);
	$databasename = '';
	$facilityname = '';
	$uploaddate = '';
	$lastencounterdate = '';
	$lastencountercreatedate = '';
	foreach($databaseresults as $dblist) {
		$dbname = $dblist["databasename"];
		$facilityname = $dblist["facilityname"];
		$uploaddate = $dblist["uploaddate"];
		$lastencounterdate = $dblist["lastencounterdate"];
		$lastencountercreatedate = $dblist["lastencountercreatedate"];
	}

?>
<div class="">
	<input type="hidden" name="databaseid" value="<?php echo $databaseid; ?>">
	<input type="hidden" name="databasename" value="<?php echo $dbname; ?>">
	<div>Are you sure you want to delete this Database?</div>
    <div>Facility Name: <span><?php echo $facilityname; ?></span></div>
    <div>Database Name: <span><?php echo $dbname; ?></span></div>
    <div>Upload Date: <span><?php echo $uploaddate; ?></span></div>
    <div>Last Encounter Date: <span><?php echo $lastencounterdate; ?></span></div>
    <div>Last Encounter Create Date: <span><?php echo $lastencountercreatedate; ?></span></div>
</div>