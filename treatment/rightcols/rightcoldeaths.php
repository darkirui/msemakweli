<?php
	$lastreportingperiod = $_COOKIE['reportingperiod'];
?>
<div class="leftcontentitem">
	<div class="datatitle">Causes Of Deaths</div>
	<div class="deathcauseswrap">
		<div class="tablediv patientsourcessection">
			<?php
		  		$patientsources = $obj->groupdeathcauses($lastreportingperiod);
		  		foreach($patientsources as $patientsourcesgroups) {
		  			echo '<div class="tablerowdiv">';
						echo '<div class="tablecelldiv dataname maindeathcauses">'.$patientsourcesgroups['causesofdeath'].'</div>';
						echo '<div class="tablecelldiv datavalue maindeathcauses">'.$patientsourcesgroups['total'].'</div>';
					echo '</div>';
					$specificcauses = $obj->groupspecificdeathcauses($lastreportingperiod,$patientsourcesgroups['causesofdeath']);
					foreach($specificcauses as $specifics) {
						echo '<div class="tablerowdiv">';
							echo '<div class="tablecelldiv dataname subdeathcauses">'.$specifics['specificcausesofdeath'].'</div>';
							echo '<div class="tablecelldiv datavalue">'.$specifics['total'].'</div>';
						echo '</div>';
					}
		  		}
		  	?>
		</div>
	</div>
</div>

<?php include 'downloads.php';?>
