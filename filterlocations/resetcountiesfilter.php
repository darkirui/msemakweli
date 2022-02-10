<?php
	include '../functions.php';
	$obj = new myFunctions;
	$cookieexp = 2147483647;
		// Reset counties
	$companyresults = $obj->spfiltercounties();
	$countynamesarray = array();
	array_push($countynamesarray,"all");
	foreach($companyresults as $item) {
        array_push($countynamesarray,$item['countyname']);
    }
    setcookie("selectedcounty", serialize($countynamesarray),$cookieexp,"/",NULL);
?>

