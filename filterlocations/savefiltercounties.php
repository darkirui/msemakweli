<?php
	$cookieexp = 2147483647;
	$countynamesarray = array();

	if(isset($_POST['county'])){
		if (in_array("all", $_POST['county']))
		{
			array_push($countynamesarray,"all");
			foreach($_POST['county'] as $countyname){
		    	array_push($countynamesarray,$countyname);
		    }
			setcookie("selectedcounty", serialize($countynamesarray),$cookieexp,"/",NULL);
		}
		else
		{
			foreach($_POST['county'] as $countyname){
		    	array_push($countynamesarray,$countyname);
		    }
		    setcookie("selectedcounty", serialize($countynamesarray),$cookieexp,"/",NULL);
		}
	}else{
		array_push($countynamesarray,"all");
		setcookie("selectedcounty", serialize($countynamesarray),$cookieexp,"/",NULL);
	}

?>

