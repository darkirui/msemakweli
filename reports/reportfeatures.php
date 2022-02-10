<?php
	include '../functions.php';
	ini_set('memory_limit', '-1');
	$obj = new myFunctions;
    $reportfeature = $_POST['reportfeature'];
    $reportname = $_POST['reportname'];

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
    $defaultreportingperiod = $_COOKIE['reportingperiod'];

    $reportindicator = '';
    if($reportname == 'txcurr'){
        $reportindicator = 'patienttxcurr';
    }
    else if($reportname == 'txnew'){
        $reportindicator = 'patienttxnew';
    }
    else if($reportname == 'txrtt'){
        $reportindicator = 'patienttxrtt';
    }
    else if($reportname == 'tis'){
        $reportindicator = 'patienttransferin';
    }
    else if($reportname == 'deaths'){
        $reportindicator = 'patientdeaths';
    }
    else if($reportname == 'tos'){
        $reportindicator = 'patienttransferout';
    }
    else if($reportname == 'ltfu'){
        $reportindicator = 'patientltfu';
    }
    else if($reportname == 'appointments'){
        $reportindicator = 'patientappointments';
    }
    else if($reportname == 'tracing'){
        $reportindicator = 'patienttracing';
    }
    else{
        $reportindicator = 'patienttxcurr';
    }

    switch($reportfeature){
        case 'males':
            $reportresults = $obj->spreportmalescount($defaultreportingperiod,$reportindicator);
            break;
        case 'females':
            $reportresults = $obj->spreportfemalescount($defaultreportingperiod,$reportindicator);
            break;
        case 'adults':
            $reportresults = $obj->spreportadultscount($defaultreportingperiod,$reportindicator);
            break;
        case 'paeds':
            $reportresults = $obj->spreportpaedscount($defaultreportingperiod,$reportindicator);
            break;
        case 'adolescents':
            $reportresults = $obj->spreportadolescentscount($defaultreportingperiod,$reportindicator);
            break;
        case 'validvls':
            $reportresults = $obj->spreportvalidvlscount($defaultreportingperiod,$reportindicator);
            break;
        case 'unorderedvls':
            $reportresults = $obj->spreportunorderedvlscount($defaultreportingperiod,$reportindicator);
            break;
        case 'outdatedvls':
            $reportresults = $obj->spreportoutdatedvlscount($defaultreportingperiod,$reportindicator);
            break;
        case 'suppressed':
            $reportresults = $obj->spreportsuppressedcount($defaultreportingperiod,$reportindicator);
            break;
        case 'unsuppressed':
            $reportresults = $obj->spreportunsuppressedcount($defaultreportingperiod,$reportindicator);
            break;
        case 'ovc':
            $reportresults = $obj->spreportovccount($defaultreportingperiod,$reportindicator);
            break;
        // default:
        //     $reportresults = $obj->spreportmalescount($defaultreportingperiod,$reportname);
    }
    echo number_format($reportresults[0]["total"]);
?>
