<?php
	include 'functions.php';
	$obj = new myFunctions;
	$cookieexp = 2147483647;
		// Reset counties
	$companyresults = $obj->spfiltersubcounties();
	$countynamesarray = array();
	array_push($countynamesarray,"all");
	foreach($companyresults as $item) {
        array_push($subcountynamesarray,$item['subcountyname']);
    }
    //print_r($companyresults);
    //etcookie("selectedsubcounty", serialize($subcountynamesarray),$cookieexp,"/",NULL);
?>

