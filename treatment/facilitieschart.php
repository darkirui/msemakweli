<?php
	//$reportingtbl = $_POST['tblname'];
	
	include '../functions.php';
	ini_set('memory_limit', '-1');
	$indicator = $_COOKIE['indicator'];
	$obj = new myFunctions;
	
	$reportindicator = '';
	$currentreportingyear = date('Y');
	$lastreportingmonth = date("m") - 1;
	$lastreportingmonthname = date("F", mktime(null, null, null, $lastreportingmonth));
	$lastreportingperiodyear = '';
	$indicatorname = '';
	if($lastreportingmonth == 0){
		$lastreportingperiodyear = $currentreportingyear - 1;
	}else{
		$lastreportingperiodyear = $currentreportingyear;
	}
	$lastreportingperiod = $lastreportingmonthname.$lastreportingperiodyear;

	if($indicator == 'txcurr'){
		$reportindicator = 'txcurr';
		$indicatorname = 'TxCURR';
	}
	else if($indicator == 'txnew'){
		$reportindicator = 'txnew';
		$indicatorname = 'TxNEW';
	}
	else if($indicator == 'txrtt'){
		$reportindicator = 'txrtt';
		$indicatorname = 'TxRTT';
	}
	else if($indicator == 'tis'){
		$reportindicator = 'transferin';
		$indicatorname = 'TIs';
	}
	else if($indicator == 'deaths'){
		$reportindicator = 'deaths';
		$indicatorname = 'Deaths';
	}
	else if($indicator == 'tos'){
		$reportindicator = 'transferout';
		$indicatorname = 'TOs';
	}
	else if($indicator == 'ltfu'){
		$reportindicator = 'ltfu';
		$indicatorname = 'IIT';
	}
	else if($indicator == 'appointments'){
		$reportindicator = 'appointments';
		$indicatorname = 'Appointments';
	}
	else if($indicator == 'tracing'){
		$reportindicator = 'tracing';
		$indicatorname = 'Patient Tracing';
	}
	else{
		$reportindicator = 'txcurr';
		$indicatorname = 'TxCURR';
	}
	
	$reportingtable = 'patient'.$reportindicator ;
	$facilityresultsarray = array();
    $facilitynamesarray = array();
	$txcurrresults = $obj->facilitydistribution($_COOKIE['reportingperiod'],$reportingtable);
	foreach($txcurrresults as $results) {
		array_push($facilityresultsarray,$results["value"]);
		array_push($facilitynamesarray,$results["name"]);
	}

	$dataresults[] = array('facilityname'=>$facilitynamesarray,'facilityresults'=>$facilityresultsarray,'selectedindicator'=>$indicatorname);
    echo json_encode($dataresults);
	// $drchartarray = array();
	// $drchartarray = array('d3chart' => $companyresults);
	// echo json_encode($drchartarray);
?>