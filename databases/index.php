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
?>
<div class="serverbanner" id="indicatortotalbanner">
	<div class="contentwrap">
		<div class="treatmentbannercontentwrap">
			<div class="tablediv">
				<div class="tablerowdiv">
					<div class="tablecelldiv">
						<div class="indicatortotal" id="indicatortotal">
							<div class="titleintroduction">DATABASES</div>
							<div class="contenttitle">57</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'databasemenu.php'; ?>
<div class="maincontentsection">
	<div class="contentwrap">
		<div class="maincontentsectionwrap treatmentdatawrap" id="databasedatawrap">
			<div class="tablediv">
				<div class="tablerowdiv">
					<div class="tablecelldiv leftcontent" id="dbleftcolcontainer">
					</div>
					<div class="tablecelldiv contentseparator">
					</div>
					<div class="tablecelldiv databasebody">
						<div class="scrollseparator"></div>
						<div class="mainbodyloading"><img src="theme/images/mbloading.gif"></div>
						<div class="mainbodycontainer" id="databasebodycontainer"></div>
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