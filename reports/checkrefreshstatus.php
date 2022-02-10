<?php
    error_reporting(E_ALL);
    ini_set("display_errors", true);
    include '../functions.php';
    $obj = new myFunctions;
    $refreshstatus = $obj->readAlldata('datarefreshstatus');
    if($refreshstatus[0]["refreshendtime"] == null OR $refreshstatus[0]["refreshendtime"] == ''){
    	echo $refreshstatus[0]["currentdata"];
    }else{
    	echo 'All refresh completed';
    }
?>