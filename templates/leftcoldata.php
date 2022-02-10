<?php
	//include '../functions.php';
	//ini_set('memory_limit', '-1');

	//$obj = new myFunctions;
	$lastreportingmonth = date('m') - 1;
	$lastreportingyear = date('Y');
	$reportingmonthanydate = $lastreportingyear.'-'.$lastreportingmonth.'-01';
	$lastreportingdate = date("Y-m-t", strtotime($reportingmonthanydate));
	$reportingmonth = date("F", mktime(null, null, null, $lastreportingmonth));
	$reportingtbl = 'txcurr'.$reportingmonth.$lastreportingyear;
	$genderresults = $obj->countartgender($reportingtbl);
	$agegroupresults = $obj->countartagegroups($reportingtbl);
	$vlresults = $obj->classifyvls($reportingtbl,$lastreportingdate);


	$artfemale = $genderresults[0]["female"];
	$artmale = $genderresults[0]["male"];
	$adult = $agegroupresults[0]["adult"];
	$children = $agegroupresults[0]["children"];
	$adolescents = $agegroupresults[0]["adolescents"];
	$validvls = $vlresults[0]["validvls"];
	$outdatedvls = $vlresults[0]["outdatedvls"];
	$unorderedvls = $vlresults[0]["unorderedvls"];
	$suppressed = $vlresults[0]["suppressed"];
	$unsuppressed = $vlresults[0]["unsuppressed"];
	// $drchartarray = array();
	// $drchartarray = array('d3chart' => $companyresults);
	// echo json_encode($drchartarray);
?>
<div class="">
	<div class="leftcontentitem">
		<div class="datatitle">GENDER</div>
		<div class="tablediv">
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname"><i class="fa fa-male" aria-hidden="true"></i> Male:</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($artmale); ?></div>
			</div>
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname"><i class="fa fa-female" aria-hidden="true"></i> Female:</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($artfemale); ?></div>
			</div>
		</div>
	</div>

	<div class="leftcontentitem">
		<div class="datatitle">Age</div>
		<div class="tablediv">
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname"><i class="fa fa-user" aria-hidden="true"></i> Adult (15+ Yrs):</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($adult); ?></div>
			</div>
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname"><i class="fa fa-child" aria-hidden="true"></i> Children (<15 Yrs):</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($children); ?></div>
			</div>
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname"><i class="fa fa-universal-access" aria-hidden="true"></i> Adolescents (10 - 19 Yrs):</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($adolescents); ?></div>
			</div>
		</div>
	</div>

	<div class="leftcontentitem">
		<div class="datatitle">Vls</div>
		<div class="tablediv">
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname"><i class="fa fa-check-square-o" aria-hidden="true"></i> Valid Vls:</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($validvls); ?></div>
			</div>
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname"><i class="fa fa-times" aria-hidden="true"></i> Due for Vl:</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($outdatedvls); ?></div>
			</div>
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Unordered Vl:</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($unorderedvls); ?></div>
			</div>
		</div>
	</div>

	<div class="leftcontentitem">
		<div class="datatitle">Suppression</div>
		<div class="tablediv">
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname">Suppressed:</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($suppressed); ?></div>
			</div>
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname">High Vls:</div>
				<div class="tablecelldiv datavalue"><?php echo number_format($unsuppressed); ?></div>
			</div>
		</div>
	</div>

	<div class="leftcontentitem">
		<div class="datatitle">Other Sets</div>
		<div class="tablediv">
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname">OVC:</div>
				<div class="tablecelldiv datavalue">_</div>
			</div>
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname">OTZ:</div>
				<div class="tablecelldiv datavalue">_</div>
			</div>
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname">PMTCT:</div>
				<div class="tablecelldiv datavalue">_</div>
			</div>
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname">TB:</div>
				<div class="tablecelldiv datavalue">_</div>
			</div>
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname">OIs:</div>
				<div class="tablecelldiv datavalue">_</div>
			</div>
		</div>
	</div>
</div>