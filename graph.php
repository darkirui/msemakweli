<?php include 'header.php'; ?>
<div class="contentwrap">
	<div id="linechararttrend">
		<?php
			$i=0;
			$lastreportingmonth = date('m') - 1;
			$lastreportingyear = date('Y');
			$monthsarray = array();
			for($i=0;$i<6;$i++){
				$reportingmonth = date("F", mktime(null, null, null, $lastreportingmonth));
				//echo $lastreportingyear;
				$reportingtbl = 'txcurr'.$reportingmonth.$lastreportingyear;
				$monthformat = date('m', strtotime($reportingmonth));
				$reportingtime = $lastreportingyear.'-'.$monthformat;
				$txcurrtotal = $obj->countAlldata($reportingtbl);
				$newmonthsarray = array('x'=>$reportingtime,'y'=>$txcurrtotal[0]["Total"]);
				array_push($monthsarray ,$newmonthsarray);
				if($lastreportingmonth==1){
					$lastreportingmonth = 13;
					$lastreportingyear = $lastreportingyear -1;
				}
				$lastreportingmonth = $lastreportingmonth-1;
			}
			$datanamearray[] = array('name'=>'txcurr','values'=>$monthsarray);
			$linechartarray = array('d3chart'=>$datanamearray);
			echo json_encode($linechartarray);
		?>
	</div>
</div>
<?php include 'footer.php'; ?>
