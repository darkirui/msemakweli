<?php
	include '../functions.php';
	$obj = new myFunctions;
	$cookieexp = 2147483647;
		// Reset counties
	$companyresults = $obj->spfiltersubcounties();
	$subcountynamesarray = array();
	array_push($subcountynamesarray,"all");
	foreach($companyresults as $item) {
        array_push($subcountynamesarray,$item['subcountyname']);
    }
    setcookie("selectedsubcounty", serialize($subcountynamesarray),$cookieexp,"/",NULL);
?>

