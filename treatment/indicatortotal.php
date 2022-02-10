<?php
	error_reporting(E_ALL);
	ini_set("display_errors", true);
	include '../functions.php';
	$obj = new myFunctions;
	$indicator = $_COOKIE['indicator'];
	$currentreportingyear = date('Y');
	$lastreportingmonth = date("m") - 1;
	$lastreportingmonthname = date("F", mktime(null, null, null, $lastreportingmonth));
	$lastreportingperiodyear = '';
	if($lastreportingmonth == 0){
		$lastreportingperiodyear = $currentreportingyear - 1;
	}else{
		$lastreportingperiodyear = $currentreportingyear;
	}
	$lastreportingperiod = $_COOKIE['reportingperiod'];

	$txcurrresults = 0;
	if($indicator == 'txcurr'){
		$txcurrresults = $obj->countreportactiverecords('patienttxcurr',$lastreportingperiod);
	}
	else if($indicator == 'txnew'){
		$txcurrresults = $obj->countreportactiverecords('patienttxnew',$lastreportingperiod);
	}
	else if($indicator == 'txrtt'){
		$txcurrresults = $obj->countreportactiverecords('patienttxrtt',$lastreportingperiod);
	}
	else if($indicator == 'tis'){
		$txcurrresults = $obj->countreportactiverecords('patienttransferin',$lastreportingperiod);
	}
	else if($indicator == 'deaths'){
		$txcurrresults = $obj->countreportactiverecords('patientdeaths',$lastreportingperiod);
	}
	else if($indicator == 'tos'){
		$txcurrresults = $obj->countreportactiverecords('patienttransferout',$lastreportingperiod);
	}
	else if($indicator == 'ltfu'){
		$txcurrresults = $obj->countreportactiverecords('patientltfu',$lastreportingperiod);
	}
	else if($indicator == 'appointments'){
		$txcurrresults = $obj->countreportactiverecords('patientappointments',$lastreportingperiod);
	}
	else if($indicator == 'tracing'){
		$txcurrresults = $obj->countreportactiverecords('patienttracing','month',$lastreportingperiod);
	}
	else{
		$txcurrresults = $obj->countreportactiverecords('patienttxcurr','month',$lastreportingperiod);
	}
?>

<div class="titleintroduction"><?php echo strtoupper($indicator); ?></div>
<div class="contenttitle"><?php echo number_format($txcurrresults[0]["Total"]); ?></div>