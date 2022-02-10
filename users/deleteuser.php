<?php
    include '../functions.php';
    $obj = new myFunctions;

    $userid = $_POST["deluserid"];
    $deletetabledata = array("id"=>$userid);
    $townresults = $obj->deletedatawhere("users",$deletetabledata);
    echo "success";
?>