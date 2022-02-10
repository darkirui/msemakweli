<?php
    include '../functions.php';
    $obj = new myFunctions;

    $databaseid = $_POST["databaseid"];
    $deletetabledata = array("id"=>$databaseid);
    $townresults = $obj->deletedatawhere("facilitydatabases",$deletetabledata);
    echo "success";
?>