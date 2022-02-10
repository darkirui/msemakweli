<?php
    include '../functions.php';
    ini_set('memory_limit', '-1');
    $obj = new myFunctions;
    $indicator = $_POST['indicator'];
    $reportingspan = $_POST['reportingspan'];
    // $indicator ='suppression';
    // $reportingspan = 'week';
    $reportingtable = 'patient'.$indicator;
    $quarteridentifier = 0;
    $quarterdayNumber = 0;
    $dateArr = array();


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
        //echo $startofquarterdate.'  -  '.$endofquarterdate;
        //echo '<br>';

        if(strtotime($currentdate) >= strtotime($startofquarterdate) && strtotime($currentdate) <= strtotime($endofquarterdate)){
            $currentquarter = $quarterslist["Qname"].' '.$currentyear;
            $currentquarternumber = str_replace("Q","",$quarterslist["Qname"]);
        }

    }

    $quarterscount = 7;
    do {
        
        if($quarterscount < 7){
            $quarterdetails = array("Qname"=>'Q'.$currentquarternumber);
            $quarterendmonth = $obj->readAlldatawhere("quarterdefinitions",$quarterdetails);
            $quarterlastmonthstartdate = $currentyear.'-'.$quarterendmonth[0]['Qendmonth'].'-01';
            $endofreportingperiod = date("Y-m-t", strtotime($quarterlastmonthstartdate));
            $dateArr[] = $endofreportingperiod;
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

    $datearray = array_reverse($dateArr);
    $quarterarray = array();
    $dataarray = array();
    $daysarray = array();
    foreach($datearray as $dates) {
        $quarteridentifier = $quarteridentifier + 1;
        if($indicator == 'suppression'){
            $suppressionrate = 0;
            $txcurrresults = $obj->getsuppressionrates($dates,$reportingspan);
            if (count($txcurrresults)>0){
                if($txcurrresults[0]["suppression"] > 0){
                   $suppressionrate = $txcurrresults[0]["suppression"];
                }else{
                    $suppressionrate = 0;
                }
            }
            else{
                $suppressionrate = 0;
            }
            
            array_push($dataarray,$suppressionrate);
            array_push($daysarray,$dates);
        }
        else if($indicator == 'missedappointments'){
             $suppressionrate = 0;
            $txcurrresults = $obj->getmissedrates($dates,$reportingspan);
            if (count($txcurrresults)>0){
                if($txcurrresults[0]["missedrate"] > 0){
                   $suppressionrate = $txcurrresults[0]["missedrate"];
                }else{
                    $suppressionrate = 0;
                }
            }
            else{
                $suppressionrate = 0;
            }
            
            array_push($dataarray,$suppressionrate);
            array_push($daysarray,$dates);
        }
        else{
            $txcurrresults = $obj->countreportactiverecords($reportingtable,'quarter',$dates);
            // if($txcurrresults[0]["Total"] > 0){
            array_push($dataarray,$txcurrresults[0]["Total"]);
            array_push($daysarray,$dates);
            //$newquartersarray = array('x'=>$dates,'y'=>$txcurrresults[0]["Total"]);
            //array_push($quarterarray ,$newquartersarray);
            // }
        }
    }

    $dataresults[] = array('data'=>array_reverse($dataarray),'days'=>array_reverse($daysarray));
    echo json_encode($dataresults);
?>