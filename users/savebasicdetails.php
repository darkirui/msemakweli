<?php
	$useridentifier = $_COOKIE['useridentifier'];
	include '../functions.php';
	$obj = new myFunctions;

	$useridentifier = $_COOKIE['useridentifier'];
	$firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["emailaddress"];
    $basicpassword = $_POST["password"];

    $hashvalue = $obj->generateHash($basicpassword);
    $passwordhash = $hashvalue["password"];
    $manganese = $hashvalue["salt"];
    /*** insert values into database ***/
    /*** check if the user exists ***/
    $userdata = array("email"=>$email);
    $finduser = $obj->readAlldatawhere("users",$userdata);
    $userid = 0;
    if (is_array($finduser)){
    	$finduserarraysize = count($finduser);
    	if($finduserarraysize > 1){
    		$userid = 1;
    	}
    }

    $usercreatestatus = '';
    if($userid >= 1){
        $usercreatestatus = 'User is existing';
    }
    else{
        $tabledata = array("firstname"=>$firstname,
                         "lastname"=>$lastname,
                         "email"=>$email,
                         "useridentifier"=>$useridentifier,
                         "passwordhash"=>$passwordhash,
                         "encryptionkey"=>$manganese);
        $user = $obj->insertData("users",$tabledata);
        $usercreatestatus = 'success';
    }
    echo $usercreatestatus;
?>