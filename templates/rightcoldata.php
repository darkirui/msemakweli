<?php
	//include '../functions.php';
	//ini_set('memory_limit', '-1');

	//$obj = new myFunctions;
	$lastreportingmonth = date('m') - 1;
	$lastreportingyear = date('Y');
	$reportingmonthanydate = $lastreportingyear.'-'.$lastreportingmonth.'-01';
	$lastreportingdate = date("Y-m-t", strtotime($reportingmonthanydate));
	$reportingmonth = date("F", mktime(null, null, null, $lastreportingmonth));
	$txnewtbl = 'txnew'.$reportingmonth.$lastreportingyear;
	$txrtttbl = 'txrtt'.$reportingmonth.$lastreportingyear;
	$tistbl = 'tis'.$reportingmonth.$lastreportingyear;
	$ltfutbl = 'ltfu'.$reportingmonth.$lastreportingyear;
	$deathstbl = 'deaths'.$reportingmonth.$lastreportingyear;
	$tostbl = 'tos'.$reportingmonth.$lastreportingyear;

	$txnewresults = $obj->countAlldata($txnewtbl);
	$txrttresults = $obj->countAlldata($txrtttbl);
	$tisresults = $obj->countAlldata($tistbl);
	$ltfuresults = $obj->countAlldata($ltfutbl);
	$deathsresults = $obj->countAlldata($deathstbl);
	$tosresults = $obj->countAlldata($tostbl);

?>
<div class="leftcontentitem">
	<div class="datatitle">Entry</div>
	<a href="templates?indicator=txnew">
		<div class="tablediv">
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname">New on ART:</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($txnewresults[0]["Total"]); ?></div>
			</div>
		</div>
	</a>
	<a href="">
		<div class="tablediv">
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname">RTT:</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($txrttresults[0]["Total"]); ?></div>
			</div>
		</div>
	</a>
	<a href="">
		<div class="tablediv">
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname">TIs:</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($tisresults[0]["Total"]); ?></div>
			</div>
		</div>
	</a>
</div>

<div class="leftcontentitem">
	<div class="datatitle">Exits</div>
	<div class="tablediv">
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">Interruption In Treatment(LTFU):</div>
			<div class="tablecelldiv datavalue"><?php echo number_format($ltfuresults[0]["Total"]); ?></div>
		</div>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">Deaths:</div>
			<div class="tablecelldiv datavalue"><?php echo number_format($deathsresults[0]["Total"]); ?></div>
		</div>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">TOs:</div>
			<div class="tablecelldiv datavalue"><?php echo number_format($tosresults[0]["Total"]); ?></div>
		</div>
	</div>
</div>

<div class="leftcontentitem">
	<div class="datatitle">Patient Followup</div>
	<div class="tablediv">
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">Appointments:</div>
			<div class="tablecelldiv datavalue">_</div>
		</div>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">Defaulters(1-30 days):</div>
			<div class="tablecelldiv datavalue">_</div>
		</div>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">Patients Traced:</div>
			<div class="tablecelldiv datavalue">_</div>
		</div>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">DC Model:</div>
			<div class="tablecelldiv datavalue">_</div>
		</div>
	</div>
</div>

<div class="leftcontentitem">
	<div class="datatitle">Download</div>
	<div class="tablediv">
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">Line-Lists</div>
		</div>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">Datim Data Entry</div>
		</div>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname">Covid Effects</div>
		</div>
	</div>
</div>
