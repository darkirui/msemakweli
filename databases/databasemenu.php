<div class="menusection" id="menusection">
	<?php 
		$page = $_SERVER['PHP_SELF'];
		$databaseitem = '';
		if (strpos($page, 'uploaddatabase') !== false) {
		    $databaseitem = 'uploaddatabase';
		}
		if (strpos($page, 'databasemaster') !== false) {
		    $databaseitem = 'databasemaster';
		}
		if (strpos($page, 'facilitiesmaster') !== false) {
		    $databaseitem = 'facilitiesmaster';
		}
	?>
	<div class="contentwrap">
		<div class="sectionmenuwrap databasemenuwrap">
			<a href="" class="backbutton"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</a>
			<a href="databases/uploaddatabase.php" class="databasemenuitem <?php echo ($databaseitem=='uploaddatabase'? 'activelink':''); ?>" data-id="uploaddatabase" id="uploaddatabase"><i class="fa fa-upload" aria-hidden="true"></i> Upload Database(s)</a>
			<a href="databases/databasemaster.php" class="databasemenuitem <?php echo ($databaseitem=='databasemaster'? 'activelink':''); ?>" data-id="databasemaster" id="databasemaster"><i class="fa fa-database" aria-hidden="true"></i> Database Master</a>
			<a href="databases/facilitiesmaster.php" class="databasemenuitem <?php echo ($databaseitem=='facilitiesmaster'? 'activelink':''); ?>" data-id="facilitiesmaster" id="facilitiesmaster"><i class="fa fa-hospital-o" aria-hidden="true"></i> Facilities Master</a>
			<a href="" class="filterbutton">Filter <i class="fa fa-th-large" aria-hidden="true"></i></a>
		</div>
	</div>
</div>
