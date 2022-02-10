<?php
    include '../functions.php';
    ini_set('memory_limit', '-1');
    $obj = new myFunctions;
    $indicator = $_POST['indicator'];
    $reportingspan = $_POST['reportingspan'];
    // $indicator ='suppression';
    // $reportingspan = 'month';
    $reportingtable = 'patient'.$indicator;
    //$startDate = strtotime('2021-07-22');
    // $endDate = strtotime(date("Y-m-d"));
    // $enddatetry = date_sub(date_create(date("Y-m-d")),date_interval_create_from_date_string("42 days"));
    // $resultdate = date_format($enddatetry,"Y-m-d");
    // $startDate = strtotime($resultdate);
    // //echo date_format($enddatetry,"Y-m-d");
    // $monthidentifier = 0;
    // $monthdayNumber = 0;

    // $dateArr = array();

    // do
    // {
    //     if(date("w", $startDate) != $monthdayNumber)
    //     {
    //         $startDate += (24 * 3600); // add 1 day
    //     }
    // } while(date("w", $startDate) != $monthdayNumber);


    // while($startDate <= $endDate)
    // {
    //     $dateArr[] = date('Y-m-d', $startDate);
    //     $startDate += (7 * 24 * 3600); // add 7 days
    // }
    $monthidentifier = 0;
    $monthdayNumber = 0;
    $dateArr = array();

    $endDate = strtotime(date("Y-m-d"));
    $i=0;
    $lastreportingmonth = date('m') - 1;
    $lastreportingyear = date('Y');

    for($i=0;$i<6;$i++){
        $indicatortotal = 0;
        $reportingmonth = date("F", mktime(null, null, null, $lastreportingmonth));
        //echo $lastreportingyear;
        $reportingperiod = $reportingmonth.$lastreportingyear;
        $monthformat = date('m', strtotime($reportingmonth));
        $reportingtime = $lastreportingyear.'-'.$monthformat;
        $monthstartdate = $lastreportingyear.'-'.$reportingmonth.'-01';
        $monthenddate = date("Y-m-t", strtotime($monthstartdate));

        $dateArr[] = $reportingperiod;

        if($lastreportingmonth==1){
            $lastreportingmonth = 13;
            $lastreportingyear = $lastreportingyear -1;
        }
        $lastreportingmonth = $lastreportingmonth-1;
    }

    $datearray = $dateArr;
    $monthsarray = array();
    $dataarray = array();
    $daysarray = array();
    foreach($datearray as $dates) {
        $monthidentifier = $monthidentifier + 1;
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
            $txcurrresults = $obj->countreportactiverecords($reportingtable,'month',$dates);
            // if($txcurrresults[0]["Total"] > 0){
            array_push($dataarray,$txcurrresults[0]["Total"]);
            array_push($daysarray,$dates);
            //$newmonthssarray = array('x'=>$dates,'y'=>$txcurrresults[0]["Total"]);
            //array_push($monthsarray ,$newmonthssarray);
            // }
        }
    }

    $dataresults[] = array('data'=>array_reverse($dataarray),'days'=>array_reverse($daysarray));
    echo json_encode($dataresults);
?>