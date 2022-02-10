<?php
    error_reporting(E_ALL);
    ini_set("display_errors", true);
    ini_set('memory_limit', '-1');
    include '../functions.php';
    $obj = new myFunctions;
    ini_set('max_execution_time', 0);
    $reportingtimespan = $_POST['reportingtimespan'];
	$reportingperiod = $_POST['reportingperiod'];
	$reportenddate = $_POST['reportenddate'];
    $refreshreports = $obj->refreshalldata($reportingtimespan,$reportingperiod,$reportenddate);
    print_r($refreshreports);
    //echo $refreshstatus[0]["currentdata"];
?>