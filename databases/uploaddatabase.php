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
					<div class="tablecelldiv mainbody">
						<div class="uploaddbsection" id="uploaddbsection">
							<div class="contentwrap">
								<div class="uploaddbwrap">
									<div class="uploadcontainer">
										<div id="mulitplefileuploader">Upload</div>
										<div id="status"></div>
										<!-- <div class="ajax-file-upload-statusbar"><img class="ajax-file-upload-preview" style="width: 100%; height: auto; display: none;"><div class="ajax-file-upload-filename">10). openmrsstmonica.gz (140.54 MB)</div><div class="ajax-file-upload-progress" style=""><div class="ajax-file-upload-bar" style="width: 100%;"></div></div><div class="ajax-file-upload-red ajax-file-upload-1629209920000 ajax-file-upload-abort" style="display: inline-block;">Abort</div><div class="ajax-file-upload-green" style="display: none;">Done</div><div class="ajax-file-upload-green" style="display: none;">Download</div><div class="ajax-file-upload-red" style="display: none;">Delete</div></div> -->
									</div>
								</div>
							</div>
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