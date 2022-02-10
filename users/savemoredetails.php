<?php
    $useridentifier = $_COOKIE['useridentifier'];
    include '../functions.php';
    $obj = new myFunctions;

    $useridentifier = $_COOKIE['useridentifier'];
    $office = '';
    $department = '';
    $region = '';
    $facility = '';
    $reasonforaccess = '';
    if( isset($_POST['office']) )
    {
        $office = $_POST['office'];
    }
    else{
        $office = '';
    }

    if( isset($_POST['department']) )
    {
        $department = $_POST['department'];
    }
    else{
        $department = '';
    }

    if( isset($_POST['region']) )
    {
        $region = $_POST['region'];
    }
    else{
        $region = '';
    }

    if( isset($_POST['facility']) )
    {
        $facility = $_POST['facility'];
    }
    else{
        $facility = '';
    }

    if( isset($_POST['reasonforaccess']) )
    {
        $reasonforaccess = $_POST['reasonforaccess'];
    }
    else{
        $reasonforaccess = '';
    }

    $tabledata = array("office"=>$office,
                     "department"=>$department,
                     "region"=>$region,
                     "facility"=>$facility,
                     "reasonforaccess"=>$reasaonforaccess,
                     "useridentifier"=>$useridentifier);
    $user = $obj->insertData("userdetails",$tabledata);
    $userdetailsstatus = 'success';
?>