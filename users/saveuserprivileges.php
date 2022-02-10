<?php
    include '../functions.php';
    $obj = new myFunctions;

    $useridentifier = $_POST["useridentifier"];
    $userid = $_POST["userid"];
    $deletetabledata = array("useridentifier"=>$useridentifier);
    $townresults = $obj->deletedatawhere("userprivileges",$deletetabledata);
    foreach($_POST['privilege'] as $privilegename){
        $tabledata = array("userid"=>$userid,
                         "useridentifier"=>$useridentifier,
                         "userprivilege"=>$privilegename);
        $user = $obj->insertData("userprivileges",$tabledata);
    }
    
    $tablecol = array("approved"=>1);
    $where = array("useridentifier"=>$useridentifier);
    $savestatus = $obj->updateDatawhere("userdetails",$tablecol,$where);
    echo "success";
?>