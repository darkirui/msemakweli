<?php
	include '../functions.php';
	$obj = new myFunctions;
	ini_set('memory_limit', '-1'); 
	$selectedlocation = $_POST['selectedlocation'];
?>
<select class="selectpicker selectfilter" id="selectcounty" data-live-search="true" data-size="5">
	<option data-tokens="All Counties">All Counties</option>
	<?php
	    $companyresults = $obj->readAlldata("county");
	    //print_r($companyresults);
	    foreach($companyresults as $item) {
	        echo '<option data-tokens='.$item['countyname'].'>'.$item['countyname'].'</option>';
	    }
	?> 
</select>
