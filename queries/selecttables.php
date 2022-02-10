<?php
	include '../functions.php';
	$obj = new myFunctions;
	$databasename = $_POST["databasename"];
  	$tables = $obj->getdatabasetables($databasename);
  	foreach($tables as $tableslist) {
	    echo '<div><input type="checkbox" id="'.$tableslist['table_name'].'" name="tablename[]" value="'.$tableslist['table_name'].'" class="selectdatabasetable"><label for="'.$tableslist['table_name'].'">'.$tableslist['table_name'].'</label></div>';
	}
?>