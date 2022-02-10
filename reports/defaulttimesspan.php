<?php
    include '../functions.php';
    ini_set('memory_limit', '-1');
    $obj = new myFunctions;
    $reportingspan = $_POST['reportingtimespan'];
    setcookie("selectedsummaryreport", $reportingspan);
    echo $reportingspan;
?>