<?php
    include '../functions.php';
    $obj = new myFunctions;
    $userid = $_POST["userid"];
    $tabledata = array("id"=>$userid);
    $userresults = $obj->readAlldatawhere("userdata",$tabledata);
    $firstname = $userresults[0]["firstname"];
    $lastname = $userresults[0]["lastname"];
    $office = $userresults[0]["office"];
    $location = $userresults[0]["location"];
    $useridentifier = $userresults[0]["useridentifier"];
    $companyresults = $obj->readAlldata("accessprivileges");
    echo "<div class='approveuserdetailssection'>";
        echo $firstname.' '.$lastname.' - '.$office.'('.$location.')';
        echo '<input type="hidden" name="useridentifier" value="'.$useridentifier.'">';
        echo '<input type="hidden" name="userid" value="'.$userid.'">';
    echo "</div>";
    echo '<div class="filterselectall">';
        echo '<input type="checkbox" id="regionslectall" value="all">';
        echo '<label for="regionslectall">Select/Unselect Privilegess</label>';
    echo '</div>';
    foreach($companyresults as $item) {
        echo '<div>';
        echo '<input type="checkbox" class="regionselect" id="privilege'.$item['id'].'" name="privilege[]" value="'.$item['privilegename'].'">';        
        echo '<label for="privilege'.$item['id'].'">'.$item['privilegename'].'</label>';
        echo '</div>';
    }
?>