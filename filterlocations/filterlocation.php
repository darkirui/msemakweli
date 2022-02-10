<?php
	include '../functions.php';
	$obj = new myFunctions;
	ini_set('memory_limit', '-1'); 
	$selectedlocation = $_POST['selectedlocation'];


	if($selectedlocation == 'county'){
	    $companyresults = $obj->spfiltercounties();
	    $selectedcountiesarray = unserialize($_COOKIE['selectedcounty']);
    	echo '<div class="filterselectall">';
    	if(in_array("all", $selectedcountiesarray)){
    		echo '<input type="checkbox" id="countyslectall" name="county[]" value="all" checked>';
    	}
    	else{
    		echo '<input type="checkbox" id="countyslectall" name="county[]" value="all">';
    	}
        
		echo '<label for="countyslectall">Select/Unselect All Counties</label>';
        echo '</div>';
	    foreach($companyresults as $item) {
	        echo '<div>';
	        if(in_array("all", $selectedcountiesarray)){
    			echo '<input type="checkbox" class="countyselect" id="county'.$item['countyid'].'" name="county[]" value="'.$item['countyname'].'" checked>';
	    	}
	    	else if(in_array($item['countyname'], $selectedcountiesarray)){
	    		echo '<input type="checkbox" class="countyselect" id="county'.$item['countyid'].'" name="county[]" value="'.$item['countyname'].'" checked>';
	    	}
	    	else{
	    		echo '<input type="checkbox" class="countyselect" id="county'.$item['countyid'].'" name="county[]" value="'.$item['countyname'].'">';
	    	}
	        
			echo '<label for="county'.$item['countyid'].'">'.$item['countyname'].'</label>';
	        echo '</div>';
	    }
	}else if($selectedlocation == 'region'){
		$companyresults = $obj->readAlldata("region");
		//print_r($companyresults);
		$selectedregionsarray = unserialize($_COOKIE['selectedregion']);
		echo '<div class="filterselectall">';
		if(in_array("all", $selectedregionsarray)){
			echo '<input type="checkbox" id="regionslectall" name="region[]" value="all" checked>';
		}
		else{
			echo '<input type="checkbox" id="regionslectall" name="region[]" value="all">';
		}

		echo '<label for="regionslectall">Select/Unselect All regions</label>';
		echo '</div>';
		foreach($companyresults as $item) {
		    echo '<div>';
		    if(in_array("all", $selectedregionsarray)){
				echo '<input type="checkbox" class="regionselect" id="region'.$item['id'].'" name="region[]" value="'.$item['regionname'].'" checked>';
			}
			else if(in_array($item['regionname'], $selectedregionsarray)){
				echo '<input type="checkbox" class="regionselect" id="region'.$item['id'].'" name="region[]" value="'.$item['regionname'].'" checked>';
			}
			else{
				echo '<input type="checkbox" class="regionselect" id="region'.$item['id'].'" name="region[]" value="'.$item['regionname'].'">';
			}
		    
			echo '<label for="region'.$item['id'].'">'.$item['regionname'].'</label>';
		    echo '</div>';
		}
	}
	else if($selectedlocation == 'subcounty'){
		$companyresults = $obj->spfiltersubcounties();
		$selectedsubcountiesarray = unserialize($_COOKIE['selectedsubcounty']);
		echo '<div class="filterselectall">';
		if(in_array("all", $selectedsubcountiesarray)){
			echo '<input type="checkbox" id="subcountyslectall" name="subcounty[]" value="all" checked>';
		}
		else{
			echo '<input type="checkbox" id="subcountyslectall" name="subcounty[]" value="all">';
		}

		echo '<label for="subcountyslectall">Select/Unselect All subcounties</label>';
		echo '</div>';
		foreach($companyresults as $item) {
		    echo '<div>';
		    if(in_array("all", $selectedsubcountiesarray)){
				echo '<input type="checkbox" class="subcountyselect" id="subcounty'.$item['subcountyid'].'" name="subcounty[]" value="'.$item['subcountyname'].'" checked>';
			}
			else if(in_array($item['subcountyname'], $selectedsubcountiesarray)){
				echo '<input type="checkbox" class="subcountyselect" id="subcounty'.$item['subcountyid'].'" name="subcounty[]" value="'.$item['subcountyname'].'" checked>';
			}
			else{
				echo '<input type="checkbox" class="subcountyselect" id="subcounty'.$item['subcountyid'].'" name="subcounty[]" value="'.$item['subcountyname'].'">';
			}
		    
			echo '<label for="subcounty'.$item['subcountyid'].'">'.$item['subcountyname'].'</label>';
		    echo '</div>';
		}
	}
	else if($selectedlocation == 'facility'){
		$companyresults = $obj->spfilterfacilities();
		$selectedfacilitiesarray = unserialize($_COOKIE['selectedfacility']);
		echo '<div class="filterselectall">';
		if(in_array("all", $selectedfacilitiesarray)){
			echo '<input type="checkbox" id="facilityslectall" name="facility[]" value="all" checked>';
		}
		else{
			echo '<input type="checkbox" id="facilityslectall" name="facility[]" value="all">';
		}
		echo '<label for="facilityslectall">Select/Unselect All facilities ('.sizeof($companyresults).')</label>';
		echo '</div>';
		foreach($companyresults as $item) {
		    echo '<div>';
		    if(in_array("all", $selectedfacilitiesarray)){
				echo '<input type="checkbox" class="facilityselect" id="facility'.$item['facilityid'].'" name="facility[]" value="'.$item['facilityname'].'" checked>';
			}
			else if(in_array($item['facilityname'], $selectedfacilitiesarray)){
				echo '<input type="checkbox" class="facilityselect" id="facility'.$item['facilityid'].'" name="facility[]" value="'.$item['facilityname'].'" checked>';
			}
			else{
				echo '<input type="checkbox" class="facilityselect" id="facility'.$item['facilityid'].'" name="facility[]" value="'.$item['facilityname'].'">';
			}
		    
			echo '<label for="facility'.$item['facilityid'].'">'.$item['facilityname'].'</label>';
		    echo '</div>';
		}
	}else{
		echo '<select class="selectpicker selectfilter" id="selectcounty" data-live-search="true" data-size="5">';
			echo '<option data-tokens="All Counties">All Counties</option>';
		    $companyresults = $obj->readAlldata("county");
		    //print_r($companyresults);
		    foreach($companyresults as $item) {
		        echo '<option data-tokens='.$item['countyname'].'>'.$item['countyname'].'</option>';
		    }
		echo '</select>';
	}
?>