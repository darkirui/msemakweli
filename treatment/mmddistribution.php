<?php
	//$reportingtbl = $_POST['tblname'];
		include '../functions.php';
	ini_set('memory_limit', '-1');
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

	$reportindicator = '';
	if($indicator == 'txcurr'){
		$reportindicator = 'txcurr';
	}
	else if($indicator == 'txnew'){
		$reportindicator = 'txnew';
	}
	else if($indicator == 'txrtt'){
		$reportindicator = 'txrtt';
	}
	else if($indicator == 'tis'){
		$reportindicator = 'transferin';
	}
	else if($indicator == 'deaths'){
		$reportindicator = 'deaths';
	}
	else if($indicator == 'tos'){
		$reportindicator = 'transferout';
	}
	else if($indicator == 'ltfu'){
		$reportindicator = 'ltfu';
	}
	else if($indicator == 'appointments'){
		$reportindicator = 'appointments';
	}
	else if($indicator == 'tracing'){
		$reportindicator = 'tracing';
	}
	else{
		$reportindicator = 'txcurr';
	}

	$lastreportingperiod = $lastreportingmonthname.$lastreportingperiodyear;
	$reportingtable = 'patient'.$reportindicator;
	
	$companyresults = $obj->mmddistribution($lastreportingperiod,$reportingtable);
	$drchartarray = array();
	$drchartarray = array('d3chart' => $companyresults);
	echo json_encode($drchartarray);

	// $obj = new myFunctions;
	// $companyresults = $obj->mmddistribution('july2021','patienttxcurr');
	// $drchartarray = array();
	// $drchartarray = array('d3chart' => $companyresults);
	// echo json_encode($drchartarray);
?>