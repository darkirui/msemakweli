<?php
	include '../functions.php';
	$obj = new myFunctions;
	$cookieexp = 2147483647;
	$regionnamesarray = array();

	if(isset($_POST['reportingfrequency'])){
		 setcookie("selectedreporttype", $_POST['reportingfrequency'],$cookieexp,"/",NULL);
	}else{
		setcookie("selectedreporttype", "quarter",$cookieexp,"/",NULL);
	}
?>

