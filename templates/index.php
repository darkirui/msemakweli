<?php include '../header.php'; ?>
<?php
	//include '../functions.php';
	//ini_set('memory_limit', '-1');

	//$obj = new myFunctions;
	$indicatortype = $_GET["indicator"];
	$lastreportingmonth = date('m') - 1;
	$lastreportingyear = date('Y');
	$reportingmonthanydate = $lastreportingyear.'-'.$lastreportingmonth.'-01';
	$lastreportingdate = date("Y-m-t", strtotime($reportingmonthanydate));
	$reportingmonth = date("F", mktime(null, null, null, $lastreportingmonth));
	$txtbl = $indicatortype.$reportingmonth.$lastreportingyear;
	$txresults = $obj->countAlldata($txtbl);

	if($indicatortype == 'txnew'){
		echo '<div class="txnewbanner indicatorbanner">';
			echo '<div class="contentwrap">';
				echo '<div class="treatmentbannercontentwrap indicatorbannercontentwrap">';
					echo '<div class="tablediv">';
						echo '<div class="tablerowdiv">';
							echo '<div class="tablecelldiv">';
								echo '<div class="titleintroduction">TxNEW</div>';
								echo '<div class="contenttitle">'.number_format($txresults[0]["Total"]).'</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
?>
<div class="maincontentsection">
	<div class="contentwrap">
		<div class="maincontentsectionwrap">
			<div class="tablediv">
				<div class="tablerowdiv">
					<div class="tablecelldiv leftcontent" id="leftcolcontainer">
						<?php include 'leftcoldata.php'; ?>
					</div>
					<div class="tablecelldiv contentseparator">
					</div>
					<div class="tablecelldiv mainbody">
						<?php include 'mainbodydata.php'; ?>
					</div>
					<div class="tablecelldiv contentseparator">
					</div>
					<div class="tablecelldiv rightcontent" id="rightcolcontainer">
						<?php include 'rightcoldata.php'; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include '../footer.php'; ?>