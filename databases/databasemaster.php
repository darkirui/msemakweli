<?php include '../header.php'; ?>
<?php
	include 'countdbs.php';
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
								<div class="tablecelldiv">Facility Name</div>
								<div class="tablecelldiv">Database Name</div>
								<div class="tablecelldiv">Last Upload Date</div>
								<div class="tablecelldiv">Status</div>
								<div class="tablecelldiv">Action</div>
							</div>
							<?php
								$databaseresults = $obj->readAlldata("facilitydatabases");
								foreach($databaseresults as $dblist) {
									$datediff = strtotime($dblist["lastencounterdate"])-strtotime($lastreportingdate);
									$dayslapsed = round($datediff / (60 * 60 * 24));
									$dbstatus = '';
									if($dayslapsed > 0){
										$dbstatus = '<i class="fa fa-check" aria-hidden="true"></i>';
									}
									else{
										$dbstatus = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
									}
									echo '<div class="tablerowdiv tablerowbody">';
										echo '<div class="tablecelldiv facilitynamecell">'.$dblist["facilityname"].'</div>';
										echo '<div class="tablecelldiv">'.$dblist["databasename"].'</div>';
										echo '<div class="tablecelldiv">'.$dblist["uploaddate"].'</div>';
										// echo '<div class="tablecelldiv">'.$dbstatus.'</div>';
										echo '<div class="tablecelldiv"><button class="showdb" id="show'.$dblist["id"].'" data-toggle="modal" data-target="#modalshowdb">'.$dbstatus.'</i></button></div>';
										echo '<div class="tablecelldiv"><button class="deletedb" id="delete'.$dblist["id"].'" data-toggle="modal" data-target="#modaldeletedb"><i class="las la-trash"></i></button></div>';
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
<div class="modal fade" id="modaldeletedb" tabindex="-1" role="dialog" aria-labelledby="modaldeletedb" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Delete Database
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<form action="databases/deletedatabase.php" method="post" id="frmdeletedatabase">
	                <div class="dbdeletesection">
	                    Are you sure you want to delete this Database?
	                    <div>Facility Name: <span></span></div>
	                    <div>Database Name: <span></span></div>
	                    <div>Upload Date: <span></span></div>
	                </div>  
	            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="actiondeletedatabase" name="submit"><i class="las la-trash"></i> Yes Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="las la-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalshowdb" tabindex="-1" role="dialog" aria-labelledby="modalshowdb" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Delete Database
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="dbshowsection">
                    Are you sure you want to delete this Database?
                    <div>Facility Name: <span></span></div>
                    <div>Database Name: <span></span></div>
                    <div>Upload Date: <span></span></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="actionshowdatabase" data-dismiss="modal"><i class="las la-trash"></i> Okay</button>
            </div>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>