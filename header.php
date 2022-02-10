<?php
    include 'functions.php';
    $obj = new myFunctions;
	$cookieexp = 2147483647;
    //default indicator - txcurr
    if(isset($_COOKIE['indicator'])){
        $indicator = $_COOKIE['indicator'];
    }else{
        setcookie("indicator", "txcurr");
        $indicator = 'txcurr';
    } 
    // combined indicator - txmls but null for now
    if(isset($_COOKIE['combinedindicator'])){
        $combinedindicator = $_COOKIE['combinedindicator'];
    }else{
        setcookie("combinedindicator", "");
        $combinedindicator = '';
    } 
    //default report level - intermediate
    if(isset($_COOKIE['reportlevel'])){
        $reportlevel = $_COOKIE['reportlevel'];
    }else{
        setcookie("reportlevel", "intermediate");
        $reportlevel = 'intermediate';
    }
    //selected summary report
    if(isset($_COOKIE['selectedsummaryreport'])){
        $selectedsummaryreport = $_COOKIE['selectedsummaryreport'];
    }
    else{
        setcookie("selectedsummaryreport", "month");
        $selectedsummaryreport = 'month';
    }

    //main filters
    //county
    $serializecountynamesarray = '';
    if(isset($_COOKIE['selectedcounty'])){
        $selectedcounty = $_COOKIE['selectedcounty'];
        $serializecountynamesarray = $_COOKIE['selectedcounty'];
    }else{
        $countynamesarray = array();
        array_push($countynamesarray,"all");
        $serializecountynamesarray = serialize($countynamesarray);
        setcookie("selectedcounty", $serializecountynamesarray,$cookieexp,"/",NULL);
    } 
    //region
    $serializedregionarray = '';
    if(isset($_COOKIE['selectedregion'])){
        $selectedregion = $_COOKIE['selectedregion'];
        $serializedregionarray = $_COOKIE['selectedregion'];
    }else{
        $regionnamesarray = array();
        array_push($regionnamesarray,"all");
        setcookie("selectedregion", serialize($regionnamesarray),$cookieexp,"/",NULL);
        $serializedregionarray = serialize($regionnamesarray);
    } 
    //subcounty
    $serializedsubcountynamesarray = '';
    if(isset($_COOKIE['selectedsubcounty'])){
	    $selectedsubcounty = $_COOKIE['selectedsubcounty'];
        $serializedsubcountynamesarray = $_COOKIE['selectedsubcounty'];
	}else{
	    $subcountynamesarray = array();
        array_push($subcountynamesarray,"all");
        $serializedsubcountynamesarray = serialize($subcountynamesarray);
        setcookie("selectedsubcounty", $serializedsubcountynamesarray,$cookieexp,"/",NULL);
	}
	//facility
    $serializedfacilitynamesarray = '';
	if(isset($_COOKIE['selectedfacility'])){
	    $selectedfacility = $_COOKIE['selectedfacility'];
        $serializedfacilitynamesarray = $_COOKIE['selectedfacility'];
	}else{
	    $facilitynamesarray = array();
        array_push($facilitynamesarray,"all");
        $serializedfacilitynamesarray = serialize($facilitynamesarray);
        setcookie("selectedfacility", $serializedfacilitynamesarray,$cookieexp,"/",NULL);
	}
	//reporttype
    $selectedreporttype = '';
	if(isset($_COOKIE['selectedreporttype'])){
	    $selectedreporttype = $_COOKIE['selectedreporttype'];
	}else{
	    setcookie("selectedreporttype", "quarterly",$cookieexp,"/",NULL);
	    $selectedreporttype = 'quarterly';
	}

    //user identifier
    $useridentifier = '';
    if(isset($_COOKIE['useridentifier'])){
        $useridentifier = $_COOKIE['useridentifier'];
    }else{
        $useridentifier = rand(1000, 9999) ."".time();
        setcookie("useridentifier", $useridentifier,$cookieexp,"/",NULL);
    }

    $userfirstname = '';
    if(isset($_COOKIE['userfirstname'])){
        $userfirstname = $_COOKIE['userfirstname'];
    }else{
        setcookie("userfirstname", '',$cookieexp,"/",NULL);
        $userfirstname = '';
    }



    //reporting period
    $reporttype = $selectedreporttype;
    $lastreportingperiod = '';
    $reportingperiodinfo = '';
    if($reporttype == 'monthly'){
        $currentreportingyear = date('Y');
        $lastreportingmonth = date("m") - 1;
        $lastreportingmonthname = date("F", mktime(null, null, null, $lastreportingmonth));
        $lastreportingperiodyear = '';
        if($lastreportingmonth == 0){
            $lastreportingperiodyear = $currentreportingyear - 1;
        }else{
            $lastreportingperiodyear = $currentreportingyear;
        }
        $recentreportingperiod = $lastreportingmonthname.$lastreportingperiodyear;
        $txcurrresults = $obj->countreportactiverecords('patienttxcurr',$recentreportingperiod );
        if($txcurrresults[0]["Total"] > 0){
            $lastreportingperiod = $recentreportingperiod;
        }else{
            $currentreportingyear = date('Y');
            $lastreportingmonth = date("m") - 2;
            $lastreportingmonthname = date("F", mktime(null, null, null, $lastreportingmonth));
            $lastreportingperiodyear = '';
            if($lastreportingmonth == 0){
                $lastreportingperiodyear = $currentreportingyear - 1;
            }else{
                $lastreportingperiodyear = $currentreportingyear;
            }
            $lastreportingperiod = $lastreportingmonthname.$lastreportingperiodyear;
            $reportingperiodinfo = 'Data for '.$recentreportingperiod.' almost ready';
        }
    }
    else if($reporttype == 'quarterly'){
        $quarters = $obj->readAlldata('quarterdefinitions');
        //print_r($quarters);

        $currentmonth = date('m');
        $currentyear = date('Y');
        $currentdate = date("Y-m-d");

        $currentquarter = '';
        $currentquarternumber = 0;

        //identify the current quarter
        foreach($quarters as $quarterslist){
            $endofquartermonth = $currentyear.'-'.$quarterslist["Qendmonth"].'-01';
            $endofquarterdate = date("Y-m-t", strtotime($endofquartermonth));
            $startofquarterdate = $currentyear.'-'.$quarterslist["Qstartmonth"].'-01';

            if(strtotime($currentdate) >= strtotime($startofquarterdate) && strtotime($currentdate) <= strtotime($endofquarterdate)){
                $currentquarter = $quarterslist["Qname"].' '.$currentyear;
                $currentquarternumber = str_replace("Q","",$quarterslist["Qname"]);
            }

        }

        $quarterscount = 2;
        do {
            
            if($quarterscount < 2){
                $quarterdetails = array("Qname"=>'Q'.$currentquarternumber);
                $quarterendmonth = $obj->readAlldatawhere("quarterdefinitions",$quarterdetails);
                $quarterlastmonthstartdate = $currentyear.'-'.$quarterendmonth[0]['Qendmonth'].'-01';
                $endofreportingperiod = date("Y-m-t", strtotime($quarterlastmonthstartdate));
                $selectedquarter = 'Quarter'.$currentquarternumber.' '.$currentyear.' - Ending:'.$endofreportingperiod;
                $lastreportingperiod = $endofreportingperiod;
            }
            
            if($currentquarternumber == 2){
                $currentyear = $currentyear -1;
            }
            if($currentquarternumber == 1){
                $currentquarternumber = 4;
            }else{
                $currentquarternumber = (int)$currentquarternumber - 1;
            }

           
            $quarterscount = $quarterscount - 1;

        } while ($quarterscount > 0);
    }
    else if($reporttype == 'weekly'){

    }else if($reporttype == 'annual'){

    }
    else{

    }

    $reportingperiod = '';
    if(isset($_COOKIE['reportingperiod'])){
        if($_COOKIE['reportingperiod'] == $lastreportingperiod){
            $reportingperiod  = $_COOKIE['reportingperiod'];  
        }
        else{
            setcookie("reportingperiod", $lastreportingperiod,$cookieexp,"/",NULL);
            $reportingperiod  = $lastreportingperiod;
        }
    }else{
        setcookie("reportingperiod", $lastreportingperiod,$cookieexp,"/",NULL);
        $reportingperiod  = $lastreportingperiod;
    }

    // user privileges
    if(isset($_COOKIE['userprivileges'])){
        $userprivileges = $_COOKIE['userprivileges'];
    }else{
        $userprivilegesarray = array();
        array_push($userprivilegesarray,"");
        setcookie("userprivileges", serialize($userprivilegesarray),$cookieexp,"/",NULL);
    }


    $url =  $_SERVER['REQUEST_URI'];
    $page = $_SERVER['PHP_SELF'];
    $chartpage = '';
    if (strpos($url, 'loadapexchart') !== false) {
        $chartpage = 'yes';
    }
    else{
        $chartpage = 'no';
    }
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
    <!--<![endif]-->

    <head>
        <!-- {ele.ment: slide/split-testing} -->
        <meta charset="utf-8" />
        <meta name="language" content="english" />
        <meta name="author" content="saruk" />
        <meta name="googlebot" content="saruk" />
        <meta name="slurp" content="noydir" />
        <title>KCCB - KARP</title>
        <?php
            $servername = $_SERVER['SERVER_NAME'];
            $serverport = $_SERVER['SERVER_PORT'];
            if($servername =='localhost'){
                echo '<base href="http://'.$servername.'/msemakweli/"/>';
            }
            else{
                echo '<base href="https://'.$servername.'" />';
            }
        ?>
        <link rel="icon" type="image/png" href="theme/images/favicon.png" />
        <link href="theme/images/favicon.png" type="image/x-icon" rel="shortcut icon" />

        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="theme/css/bootstrap.min.css" />
        <link href="theme/css/bootstrap-select.min.css" rel="stylesheet" />
        <link href="theme/css/datepicker.css" rel="stylesheet" type="text/css" />
        <!-- <link rel="stylesheet" href="theme/css/main.css"> -->
        <!--<link rel="stylesheet" href="theme/css/backend.min.css" />-->
        <link rel="stylesheet" href="theme/css/arsfont.css" />
        <link rel="stylesheet" href="theme/css/fa/css/font-awesome.min.css" />
        <link rel="stylesheet" href="theme/js/slick/slick.css" />
        <link rel="stylesheet" type="text/css" href="theme/js/slick/slick-theme.css" />
         <link rel="stylesheet"  href="theme/light/css/lightslider.css"/>
        <link rel="stylesheet" type="text/css" href="theme/css/jquery.dataTables.css">
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet" />
        <link rel="stylesheet" href="theme/css/fonticons/css/line-awesome.min.css">
        <link rel="stylesheet" href="theme/css/arsfont.css" />
        <link rel="stylesheet" href="theme/css/arsfont.css" />
        <link rel="stylesheet" href="theme/css/fa/css/font-awesome.min.css" />
        <link rel="stylesheet" href="theme/js/slick/slick.css" />
        <!-- <link rel="stylesheet" href="theme/css/style.css"> -->
        <link rel="stylesheet" href="theme/css/main.css" />
        <link rel="stylesheet" href="theme/css/d3-instant-charts.css" />
        <link rel="stylesheet" href="theme/css/apexcss.css" />
        <link rel="stylesheet" href="theme/css/fonticons/css/line-awesome.min.css">
        <link href="theme/css/codemirror/codemirror.css" rel="stylesheet">
        <link href="theme/css/codemirror/show-hint.css" rel="stylesheet">
        <link href="theme/summernote/summernote.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Lato&family=Noto+Sans+JP&family=Open+Sans&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php
            error_reporting(E_ALL);
            ini_set("display_errors", true);
            if($chartpage == 'no'){
                include 'headertopmenu.php'; 
            }    
        ?> 

        


        
