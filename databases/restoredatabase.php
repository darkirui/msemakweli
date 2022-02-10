<?php
	include '../functions.php';
	$obj = new myFunctions;
	$databasename = $_POST["databasename"];
	//$dbfile = $dbname.".sql";
	// $restore_file  = '../uploads/'.$dbfile;
	$databasefolder = '../uploads/';
	$server_name   = "localhost";
	$username      = "root";
	$password      = "Finess@Xeon";
	$database_name = $databasename;
	$databaseextension = '';
	$dbnamenoext = '';
	$databasepath = '../uploads/'.$databasename;

	ini_set('max_execution_time', 0);
	//echo "Creating Database";

	if (substr($databasename, -7) == '.tar.gz') {
	    $databaseextension = 'tar.gz';
	    $dbnamenoext = str_replace(".tar.gz","",$databasename);
  	}else{
	    if(strpos($databasename, 'gz') !== false) {
		   	$databaseextension = 'gz';
		   	$dbnamenoext = str_replace(".gz","",$databasename);
		}
		else if(strpos($databasename, 'sql') !== false){
			$databaseextension = 'sql';
			$dbnamenoext = str_replace(".sql","",$databasename);
		}
		else if(strpos($databasename, 'zip') !== false){
			$databaseextension = 'zip';
		}
		else{
			$databaseextension = '';
			$dbnamenoext = $databasename;
		}
  	}

  	//remove special characters
  	$newdbname  = str_replace(' ', '', $dbnamenoext);
  	$newdbname = str_replace('-', '', $newdbname);
  	$newdbname = str_replace('_', '', $newdbname);
  	$newdbname = preg_replace('/[^A-Za-z0-9\-]/', '', $newdbname);

  	//extratct and rename to .sql
  	if($databaseextension == 'gz'){
		//This input should be from somewhere else, hard-coded in this example
		$file_name = $databasepath;

		// Raising this value may increase performance
		$buffer_size = 4096; // read 4kb at a time
		$out_file_name = str_replace('.gz', '', $file_name); 

		// Open our files (in binary mode)
		$file = gzopen($file_name, 'rb');
		$out_file = fopen($out_file_name, 'wb'); 

		// Keep repeating until the end of the input file
		while (!gzeof($file)) {
		    // Read buffer-size bytes
		    // Both fwrite and gzread and binary-safe
		    fwrite($out_file, gzread($file, $buffer_size));
		}

		// Files are done, close files
		fclose($out_file);
		gzclose($file);

		rename($databasefolder.$dbnamenoext,$databasefolder.$newdbname.'.sql');
	}

	if($databaseextension == 'tar.gz'){
		// decompress from gz
		$p = new PharData($uploadfile);
		$p->decompress(); // creates /path/to/my.tar
		$tarfile = $databasefolder.$dbnamenoext . '.' . 'tar';
		//$path_parts['filename'];
		// unarchive from the tar
		$phar = new PharData($tarfile);
		$phar->extractTo($databasefolder);
		// $path_parts = pathinfo($path);
		// $extractedfile = $path_parts['filename'];
		// $filetoberenamed = str_replace(".tar","",$extractedfile);
		rename($databasefolder.$dbnamenoext,$databasefolder.$newdbname.'.sql');
	}

	if($databaseextension == 'sql'){
		rename($databasefolder.$dbnamenoext,$databasefolder.$newdbname.'.sql');
	}

	if($databaseextension == ''){
		rename($databasefolder.$dbnamenoext,$databasefolder.$newdbname.'.sql');
	}

	$databasepath = '../uploads/'.$newdbname.'.sql';
	$restoreresult = $obj->restoredatabase($databasepath,$newdbname);

	//check if db was restored successsfully
	if(strpos($restoreresult, $newdbname) !== false) {
		//if database was restored successfully then delete former records
		// 1. get facilityname of restored database
		$facilitydetails = $obj->getdbfacilitydetails($newdbname);
		$facilityname = $facilitydetails[0]["facilityname"];
		$mflcode = $facilitydetails[0]["mflcode"];
		$lastencounterdate = $facilitydetails[0]["lastencounterdate"];
		$lastencountercreatedate = $facilitydetails[0]["lastencountercreatedate"];
		$uploaddate = $facilitydetails[0]["uploaddate"];

		//2. get the names of former databases and drop
		$fname = str_replace("'","\\'",$facilityname);
		$tabledata = array("facilityname"=>$fname);
		$databaseresults = $obj->readAlldatawhere("facilitydatabases",$tabledata);
		foreach($databaseresults as $dblist) {
			$dbname = $dblist["databasename"];
			$dropresult = $obj->dropformerdbs($dbname);
		}

		//3. drop former records
		$droptabledata = array("facilityname"=>$fname);
		$deletedbresults = $obj->deletedatawhere("facilitydatabases",$droptabledata);

		//4. insert record into 
		$inserttabledata = array("databasename"=>$newdbname,
                         "facilityname"=>$facilityname,
                         "mflcode"=>$mflcode,
                         "lastencounterdate"=>$lastencounterdate,
                         "lastencountercreatedate"=>$lastencountercreatedate,
                         "uploaddate"=>$uploaddate
                     );
	  	$passdata = serialize($inserttabledata);
	  	$savestatus = $obj->insertData("facilitydatabases",$inserttabledata);


	   	echo $dbnamenoext;
	}
	else{
		echo "error";
	}
	//echo $restoreresult;
?>