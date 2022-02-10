<?php
//If directory doesnot exists create it.
$output_dir = "../uploads/";

if(isset($_FILES["myfile"]))
{
	$ret = array();

	$error =$_FILES["myfile"]["error"];
   {
    
    	if(!is_array($_FILES["myfile"]['name'])) //single file
    	{
       	 	$fileName = $_FILES["myfile"]["name"];
          $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
          $uniqueidentifier = substr(str_shuffle($permitted_chars), 0, 4);
          $databasename = "";
          if (substr($fileName, -7) == '.tar.gz') {
            $checkedname = str_replace(".tar.gz","",$fileName);
            $databasename = $uniqueidentifier.$checkedname;
          }else{
            $checkedname = pathinfo($fileName, PATHINFO_FILENAME);
            $databasename = $checkedname.$uniqueidentifier;
          }

          //$temp = explode(".", $_FILES["dbfile"]["name"]);
          $ext = pathinfo($fileName, PATHINFO_EXTENSION);
          $newfilename = '';
          if($ext == ''){
            $newfilename = $databasename . '.' . 'sql';
          }
          if($ext == 'sql'){
            $newfilename = $databasename . '.' . 'sql';
          }
          if($ext == 'gz'){
          //$newfilename = $databasename . '.' . 'gz';
            $path_parts = pathinfo($fileName);
            $basename = $path_parts['basename'];
            if (strpos($basename, 'tar') !== false) {
              $newfilename = $databasename . '.tar.gz';
              $ext = 'tar.gz';
            }
            else{
              $newfilename = $databasename . '.' . 'gz';
            }
          }
          //$ret[$newfilename]= $output_dir.$newfilename;
          //move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$newfilename);
       	 	move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$newfilename);
       	 	 //echo "<br> Error: ".$_FILES["myfile"]["error"];
       	 	$ret[$newfilename]= $output_dir.$newfilename;
    	}
    	else
    	{
  	    	$fileCount = count($_FILES["myfile"]['name']);
    		  for($i=0; $i < $fileCount; $i++)
    		  {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $uniqueidentifier = substr(str_shuffle($permitted_chars), 0, 4);
    		  	$fileName = $_FILES["myfile"]["name"][$i];
       	 	  //$ret[$fileName]= $output_dir.$fileName;
    		    //move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName );

            //generating database name
            $databasename = "";
            if (substr($fileName, -7) == '.tar.gz') {
              $checkedname = str_replace(".tar.gz","",$fileName);
              $databasename = $uniqueidentifier.$checkedname;
            }else{
              $checkedname = pathinfo($fileName, PATHINFO_FILENAME);
              $databasename = $checkedname.$uniqueidentifier;
            }

            //$temp = explode(".", $_FILES["dbfile"]["name"]);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newfilename = '';
            if($ext == ''){
              $newfilename = $databasename . '.' . 'sql';
            }
            if($ext == 'sql'){
              $newfilename = $databasename . '.' . 'sql';
            }
            if($ext == 'gz'){
              //$newfilename = $databasename . '.' . 'gz';
              $path_parts = pathinfo($fileName);
              $basename = $path_parts['basename'];
              if (strpos($basename, 'tar') !== false) {
                  $newfilename = $databasename . '.tar.gz';
                  $ext = 'tar.gz';
              }
              else{
                $newfilename = $databasename . '.' . 'gz';
              }
            }
            $ret[$newfilename]= $output_dir.$newfilename;
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$newfilename);
    		  }
    	
    	}
    }
    echo json_encode($ret);
 
}

?>