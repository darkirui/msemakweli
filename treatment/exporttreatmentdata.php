<?php
	$indicator = $_COOKIE['indicator'];
	$reportlevel = $_COOKIE['reportlevel'];
	include '../functions.php';
	$obj = new myFunctions;
	ini_set('memory_limit', '-1');
	ini_set('max_execution_time', 0);
	require_once "../vendor/autoload.php";

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

	$lastreportingperiod = $_COOKIE['reportingperiod'];
	$reportingtable = 'patient'.$reportindicator;

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	ini_set('memory_limit', '-1');
	$spreadsheet = new Spreadsheet();
	$Excel_writer = new Xlsx($spreadsheet);
	 
	$spreadsheet->setActiveSheetIndex(0);
	$activeSheet = $spreadsheet->getActiveSheet();
	$activeSheet->setTitle($indicator);

	$reportresults = array();
	if($reportlevel == 'simple'){
		$reportresults = $obj->spgetsimplereport($lastreportingperiod,$reportingtable);
	}
	else if($reportlevel == 'intermediate'){
		$reportresults = $obj->spgetintermediatereport($lastreportingperiod,$reportingtable);
	}
	else if($reportlevel == 'advanced'){
		$reportresults = $obj->spgetadvancedreport($lastreportingperiod,$reportingtable);
	}
	else{
		$reportresults = $obj->spgetintermediatereport($lastreportingperiod,$reportingtable);
	}
	
	$activeSheet->fromArray(array_keys(current($reportresults)), NULL, 'A1');
	$activeSheet->fromArray($reportresults, NULL, 'A2');
	$filename = $reportingtable.$lastreportingperiod.'.xlsx';
	 
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename='. $filename);
	header('Cache-Control: max-age=0');
	$Excel_writer->save('php://output');
	die;
?>