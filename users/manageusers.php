<?php include '../header.php'; ?>
<?php
	// include 'countdbs.php';
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
							<div class="titleintroduction">All Uers</div>
							<div class="contenttitle">10</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="menusection" id="menusection">
	<div class="contentwrap">
		<div class="sectionmenuwrap databasemenuwrap">
			<a href="" class="backbutton"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</a>
			<a href="databases/uploaddatabase.php" class="databasemenuitem" data-id="uploaddatabase" id="uploaddatabase"><i class="las la-user-alt"></i> All Users</a>
			<a href="databases/databasemaster.php" class="databasemenuitem" data-id="databasemaster" id="databasemaster"><i class="las la-info-circle"></i> Pending Approval</a>
			<a href="databases/facilitiesmaster.php" class="databasemenuitem" data-id="facilitiesmaster" id="facilitiesmaster"><i class="las la-check-double"></i> Approved Users</a>
			<a href="" class="filterbutton">Filter <i class="fa fa-th-large" aria-hidden="true"></i></a>
		</div>
	</div>
</div>
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
								<div class="tablecelldiv">User</div>
								<div class="tablecelldiv">Email</div>
								<div class="tablecelldiv">office</div>
								<div class="tablecelldiv">location</div>
								<div class="tablecelldiv">department</div>
								<div class="tablecelldiv">Approved</div>
								<div class="tablecelldiv">Action</div>
							</div>
							<?php
								$userresults = $obj->readAlldata("userdata");
								foreach($userresults as $userlist) {
									echo '<div class="tablerowdiv tablerowbody">';
										echo '<div class="tablecelldiv facilitynamecell">'.$userlist["firstname"].' '.$userlist["lastname"].'</div>';
										echo '<div class="tablecelldiv">'.$userlist["email"].'</div>';
										echo '<div class="tablecelldiv">'.$userlist["office"].'</div>';
										echo '<div class="tablecelldiv">'.$userlist["location"].'</div>';
										echo '<div class="tablecelldiv">'.$userlist["department"].'</div>';
										echo '<div class="tablecelldiv">'.$userlist["approved"].'</div>';
										echo '<div class="tablecelldiv">
											<button class="approveuser" id="approve'.$userlist["id"].'" data-toggle="modal" data-target="#modalapproveuser"><i class="las la-check"></i></button>
											<button class="deleteuser" id="delete'.$userlist["id"].'" data-toggle="modal" data-target="#modaldeleteuser"><i class="las la-trash"></i></button>
											<button class="deleteuser" id="view'.$userlist["id"].'"><i class="las la-eye"></i></button>
										</div>';
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
<div class="modal fade" id="modalapproveuser" tabindex="-1" role="dialog" aria-labelledby="modalapproveuser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Select Privileges
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<form action="users/saveuserprivileges.php" method="post" id="frmuserprivileges">
	                <div class="userprivilegessection">
	                    
	                </div>  
	            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="actionapproveuser" name="submit"><span class="linelistdownloadstatus"><i class="las la-check-double"></i> Approve</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="las la-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaldeleteuser" tabindex="-1" role="dialog" aria-labelledby="modaldeleteuser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Delete User
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<form action="users/deleteuser.php" method="post" id="frmdeleteuser">
            		<input type="hidden" value="" name="deluserid" id="deleteselecteduser">
	                <div class="userdeletesection">
	                    Are you sure you want to delete this user?
	                </div>  
	            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="actiondeleteuser" name="submit"><i class="las la-trash"></i> Yes Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="las la-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>