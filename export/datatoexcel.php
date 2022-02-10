<?php
$db_host = 'localhost';
$db_username = 'root';
$db_password = 'karp@2018';
$db_name = 'msemakweli';
$tblname ='patienttxcurr';
 
$db = new mysqli($db_host, $db_username, $db_password, $db_name);
 
if($db->connect_error){
    die("Unable to connect database: " . $db->connect_error);
}

require_once "../vendor/autoload.php";
//require_once "db.php";
 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ini_set('memory_limit', '-1');
$spreadsheet = new Spreadsheet();
$Excel_writer = new Xlsx($spreadsheet);
 
$spreadsheet->setActiveSheetIndex(0);
$activeSheet = $spreadsheet->getActiveSheet();
$activeSheet->setTitle($tblname);
 

$query = $db->query("SHOW FULL COLUMNS FROM patienttxcurr");
if($query->num_rows > 0) {
    $i = 1;
    while($row = $query->fetch_assoc()) {
        $activeSheet->setCellValueByColumnAndRow($i, 1, $row['Field']);
        $i++;
    }
}

 
$query = $db->query("SELECT * FROM patienttxcurr where voided = 0 and reportingperiod = 'August2021'");
 
if($query->num_rows > 0) {
    $i = 2;
    while($row = $query->fetch_assoc()) {
        $col = 1;
        //print_r($row);
        foreach($row as $key=>$value) {
            $activeSheet->setCellValueByColumnAndRow($col, $i, $value);
            $col++;
        }
        $i++;
    }
}
 
 $filename = $tblname.'.xlsx';
 
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='. $filename);
header('Cache-Control: max-age=0');
$Excel_writer->save('php://output');