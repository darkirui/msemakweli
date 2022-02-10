<?php
	//$reportingtbl = $_POST['tblname'];
	
	include '../functions.php';
	ini_set('memory_limit', '-1');

	$obj = new myFunctions;
	// $companyresults = $obj->drugdistribution();
	// $drchartarray = array();
	// $drchartarray = array('d3chart' => $companyresults);
	// echo json_encode($drchartarray);
	$indicator = $_COOKIE['indicator'];
	$i=0;
	$lastreportingmonth = date('m') - 1;
	$lastreportingyear = date('Y');
	$monthsarray = array();
	for($i=0;$i<6;$i++){
		$indicatortotal = 0;
		$reportingmonth = date("F", mktime(null, null, null, $lastreportingmonth));
		//echo $lastreportingyear;
		$reportingtbl = $indicator.$reportingmonth.$lastreportingyear;
		$monthformat = date('m', strtotime($reportingmonth));
		$reportingtime = $lastreportingyear.'-'.$monthformat;
		$txcurrtotal = $obj->countAlldata($reportingtbl);
		if($txcurrtotal[0]["Total"] > 0){
			$indicatortotal = $txcurrtotal[0]["Total"];
		}else{
			$indicatortotal = 1;
		}
		$newmonthsarray = array('x'=>$reportingtime,'y'=>$indicatortotal);
		array_push($monthsarray ,$newmonthsarray);
		if($lastreportingmonth==1){
			$lastreportingmonth = 13;
			$lastreportingyear = $lastreportingyear -1;
		}
		$lastreportingmonth = $lastreportingmonth-1;
	}
	$datanamearray[] = array('name'=>$indicator,'values'=>$monthsarray);
	$linechartarray = array('d3chart'=>$datanamearray);
	echo json_encode($linechartarray);
?>