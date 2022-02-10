<?php
	include '../functions.php';
	$obj = new myFunctions;
	$cookieexp = 2147483647;
	$regionnamesarray = array();

	if(isset($_POST['region'])){
		if (in_array("all", $_POST['region']))
		{
			array_push($regionnamesarray,"all");
			foreach($_POST['region'] as $regionname){
		    	array_push($regionnamesarray,$regionname);
		    }
			setcookie("selectedregion", serialize($regionnamesarray),$cookieexp,"/",NULL);
		}
		else
		{
			foreach($_POST['region'] as $regionname){
		    	array_push($regionnamesarray,$regionname);
		    }
		    setcookie("selectedregion", serialize($regionnamesarray),$cookieexp,"/",NULL);
		}
	}else{
		array_push($regionnamesarray,"all");
		setcookie("selectedregion", serialize($regionnamesarray),$cookieexp,"/",NULL);
	}
?>

