<?php
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
    $defaultreportingperiod = $lastreportingmonthname.$lastreportingperiodyear;
	//$txnewresults = $obj->groupendofperiodoutcomes($txnewtbl);
	$txcurrresults = $obj->countreportactiverecords('patienttxnew',$defaultreportingperiod);
?>
<div class="leftcontentitem">
	<div class="datatitle">Patient Sources</div>
	<div class="tablediv patientsourcessection">
		<div class="patientsourceswrap">
			<?php
				$patientsources = $obj->grouppatientsources($defaultreportingperiod);
				foreach($patientsources as $patientsourcesgroups) {
					echo '<div class="tablerowdiv">';
						echo '<div class="tablecelldiv dataname">'.$patientsourcesgroups['patientsource'].'</div>';
						echo '<div class="tablecelldiv datavalue">'.$patientsourcesgroups['total'].'</div>';
					echo '</div>';
				}
			?>
		</div>
	</div>
</div>
<div class="leftcontentitem">
	<div class="datatitle">Outcome at the end of period</div>
	<div class="tablediv">
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">Active:</div>
			<div class="tablecelldiv datavalue"><?php echo number_format($txcurrresults[0]["Total"]); ?></div>
		</div>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">Interruption In Treatment(LTFU):</div>
			<div class="tablecelldiv datavalue">0</div>
		</div>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">Deaths:</div>
			<div class="tablecelldiv datavalue">0</div>
		</div>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">TOs:</div>
			<div class="tablecelldiv datavalue">0</div>
		</div>
	</div>
</div>


<?php include 'downloads.php';?>
