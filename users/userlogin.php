<?php
	$useridentifier = $_COOKIE['useridentifier'];
	include '../functions.php';
	$obj = new myFunctions;
    $cookieexp = 2147483647;

    $email = $_POST["email"];
    $basicpassword = $_POST["password"];
    $loginstatus = '';

    if($email != '' || $basicpassword != ''){
        $passwordhash = '';
        $useridentifier = '';
        $useridentifier = '';
        $firstname = '';
        $tabledata = array("email"=>$email);
        $userresults = $obj->readAlldatawhere("users",$tabledata);
        if (is_array($userresults)){
            foreach($userresults as $value){
                $encryptionkey = $value["encryptionkey"];
                $passwordhash = $value["passwordhash"];
                $email = $value["email"];
                $useridentifier= $value["useridentifier"];
                $firstname= $value["firstname"];
                $userid= $value["id"];
            }
        }
        $loginPassword = $obj->hashPassword($basicpassword,$encryptionkey);
        if($loginPassword==$passwordhash){
            $loginstatus = "success";
            setcookie("userfirstname", $firstname,$cookieexp,"/",NULL);
            setcookie("useridentifier", $useridentifier,$cookieexp,"/",NULL);
            $tabledata = array("useridentifier"=>$useridentifier);
            $userdetails = $obj->readAlldatawhere("userdetails",$tabledata);
            $userprivileges = $obj->readAlldatawhere("userprivileges",$tabledata);
            setcookie("userdetails", serialize($userdetails),$cookieexp,"/",NULL);


            //create user privileges array 
            $userprivilegesarray = array();
            foreach($userprivileges as $privileges){
                array_push($userprivilegesarray,$privileges['userprivilege']);
            }
            setcookie("userprivileges", serialize($userprivilegesarray),$cookieexp,"/",NULL);

        }else{
            $loginstatus = "something went wrong";
        }
    }
    else{
        $loginstatus = 'Details Missing';
    }
    echo $loginstatus;
?>