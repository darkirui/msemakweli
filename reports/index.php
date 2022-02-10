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
<div class="servicebanner reportbanner" id="indicatortotalbanner">
	<div class="contentwrap">
		<div class="servicebannercontentwrap">
			<div class="tablediv">
				<div class="tablerowdiv">
					<div class="tablecelldiv">
						<div class="indicatortotal" id="indicatortotal">
							<div class="titleintroduction">REPORTS</div>
							<div class="contenttitle">summary</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="maincontentsection">
	<div class="contentwrap">
		<div class="maincontentsectionwrap servicedatawrap" id="reportssummarywrap">
			<div class="selecttimespanwrap">
				<div class="selecttimespancontainer">
					<div class="tablediv">
						<div class="tablerowdiv">
							<div class="tablecelldiv">
								<input type="radio" id="leapreport" name="reporttype" value="week" class="selectreporttype" <?php echo ($_COOKIE['selectedsummaryreport']=='week'? 'checked':''); ?>>
								<label for="leapreport">Weekly (LEAP)</label>
							</div>
							<div class="tablecelldiv">
								<input type="radio" id="monthlyreport" name="reporttype" value="month" class="selectreporttype" <?php echo ($_COOKIE['selectedsummaryreport']=='month'? 'checked':''); ?>>
								<label for="monthlyreport">Monthly</label>
							</div>
							<div class="tablecelldiv">
								<input type="radio" id="quartlyreport" name="reporttype" value="quarter" class="selectreporttype" <?php echo ($_COOKIE['selectedsummaryreport']=='quarter'? 'checked':''); ?>>
								<label for="quartlyreport">Quarterly</label>
							</div>
							<div class="tablecelldiv">
								<input type="radio" id="annualreport" name="reporttype" value="year" class="selectreporttype" <?php echo ($_COOKIE['selectedsummaryreport']=='year'? 'checked':''); ?>>
								<label for="annualreport">Annual</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="reportdisplaytype">
				<a class="selectreportdisplaytype" id="selectquicksummary"><i class="fa fa-th" aria-hidden="true"></i> Quick Summary</a>
				<a class="selectreportdisplaytype" id="selectdatatrends"><i class="fa fa-bar-chart" aria-hidden="true"></i> Data Trends</a>
			</div>
			<div class="selectedreportwrap">
				<div class="selectedreportloading"><img src="theme/images/loadingreport.gif"></div>
				<div class="selectedreportreceivingcontainer"></div>
			</div>
		</div>
	</div>
</div>
<div class="datarefreshstatus">
	<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i> <span id="currentrefreshdata"></span>
</div>
<?php include '../footer.php'; ?>