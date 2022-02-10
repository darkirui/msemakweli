<?php
	$indicator = $_POST["indicator"];
	setcookie("indicator", $indicator);
	if($indicator == 'deaths' || $indicator == 'tos' || $indicator == 'ltfu'){
		setcookie("combinedindicator", 'txml');
	}
	else{
		$combinedindicator = '';
		setcookie("combinedindicator", 'other');
	}
	echo $indicator;
?>