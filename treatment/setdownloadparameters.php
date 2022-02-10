<?php
    $reportlevel = $_POST["reportlevel"];
	setcookie("reportlevel", $reportlevel);
	echo $reportlevel;
?>