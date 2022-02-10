<?php include '../header.php'; ?>
<?php
	include 'countdbs.php';
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
							<div class="contenttitle"><?php echo $alldbs; ?></div>
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
					<div class="tablecelldiv mainbody databaselist">
						<div class="tablediv">
							<div class="tablerowdiv tablerowheader">
								<div class="tablecelldiv">Facility</div>
								<div class="tablecelldiv">MFL Code</div>
								<div class="tablecelldiv">County</div>
								<div class="tablecelldiv">Sub County</div>
								<div class="tablecelldiv">Region</div>
							</div>
							<?php
								$facilityname= '';
								$mflcode = '';
								$countyname = '';
								$subcountyname = '';
								$regionname = '';
								$facilityresults = $obj->filterlocations($facilityname,$mflcode,$countyname,$subcountyname,$regionname);
								foreach($facilityresults as $facilitylist) {
									echo '<div class="tablerowdiv tablerowbody">';
										echo '<div class="tablecelldiv facilitynamecell">'.$facilitylist["facilityname"].'</div>';
										echo '<div class="tablecelldiv">'.$facilitylist["mflcode"].'</div>';
										echo '<div class="tablecelldiv">'.$facilitylist["countyname"].'</div>';
										echo '<div class="tablecelldiv">'.$facilitylist["subcountyname"].'</div>';
										echo '<div class="tablecelldiv">'.$facilitylist["regionname"].'</div>';
									echo '</div>';
								}
							?>
						</div>
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