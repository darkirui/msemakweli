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

	$lastreportingperiod = $_COOKIE['reportingperiod'];

	$reportresults = $obj->spcoviddata($lastreportingperiod);

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	ini_set('memory_limit', '-1');
	$spreadsheet = new Spreadsheet();
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("templates\covidtemplate.xlsx");
	$sheet = $spreadsheet->getActiveSheet();

	$sheet->setCellValueByColumnAndRow(3, 1, $lastreportingperiod);
	$i = 4;
	foreach($reportresults as $results){
		//print_r($results);
		//echo '<br>';
		$col = 1;
		foreach($results as $value){
			$sheet->setCellValueByColumnAndRow($col, $i, $value);
			$col++;
		}
		$i++;
	}

	$writer = new Xlsx($spreadsheet);
	$filename = 'covid'.$lastreportingperiod.'.xlsx';
	$writer->save($filename);

	header('Content-disposition: attachment; filename='.$filename);
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Length: ' . filesize($filename));
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    ob_clean();
    flush(); 

    readfile($filename);
    unlink($filename);

?>