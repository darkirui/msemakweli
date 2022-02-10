<?php include '../header.php'; ?>
<?php
	//include '../functions.php';
	//ini_set('memory_limit', '-1');

	//$obj = new myFunctions;
	$lastreportingmonth = date('m') - 1;
	$lastreportingyear = date('Y');
	$reportingmonthanydate = $lastreportingyear.'-'.$lastreportingmonth.'-01';
	$lastreportingdate = date("Y-m-t", strtotime($reportingmonthanydate));
	$reportingmonth = date("F", mktime(null, null, null, $lastreportingmonth));
	$txcurrtbl = 'patienttxcurr';
	$txcurrresults = $obj->countAlldata($txcurrtbl);

?>
<div class="servicebanner" id="indicatortotalbanner">
	<div class="contentwrap">
		<div class="servicebannercontentwrap">
			<div class="tablediv">
				<div class="tablerowdiv">
					<div class="tablecelldiv">
						<div class="indicatortotal" id="indicatortotal">
							<div class="titleintroduction">TxCURR</div>
							<div class="contenttitle"><?php echo number_format($txcurrresults[0]["Total"]); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'htsmenu.php'; ?>
<div class="maincontentsection">
	<div class="contentwrap">
		<div class="maincontentsectionwrap servicedatawrap" id="htsdatawrap">
			<div class="tablediv">
				<div class="tablerowdiv">
					<div class="tablecelldiv leftcontent" id="leftcolcontainer">
						<div class="leftcoltotalclients"></div>
						<div class="leftloading"><img src="theme/images/shimmerloading.gif" width="200px;"></div>
						<div class="leftdatacontainer" id="leftdatacontainer"></div>
					</div>
					<div class="tablecelldiv contentseparator">
					</div>
					<div class="tablecelldiv mainbody">
						<div class="scrollseparator"></div>
						<div class="mainbodyloading"><img src="theme/images/mbloading.gif"></div>
						<div class="mainbodycontainer" id="mainbodycontainer"></div>
					</div>
					<div class="tablecelldiv contentseparator">
					</div>
					<div class="tablecelldiv rightcontent" id="rightcolcontainer">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include '../footer.php'; ?>