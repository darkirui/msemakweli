<?php
	$indicator = $_COOKIE['indicator'];
	$reportlevel = $_COOKIE['reportlevel'];
	include '../functions.php';
	$obj = new myFunctions;
?>
<form action="users/savemoredetails.php" method="post" id="frmusermoredetails">
	<div class="officedetails">
        <input type="radio" class="selectoffice" id="centraloffice" name="office" value="central" checked><label for="centraloffice">KARP Central Office</label>
        <input type="radio" class="selectoffice" id="regionaloffice" name="office" value="region"><label for="regionaloffice">Regional Office</label>
        <input type="radio" class="selectoffice" id="facilityoffice" name="office" value="facility"><label for="facilityoffice">Facility Office</label>
        <input type="radio" class="selectoffice" id="otheroffice" name="office" value="other"><label for="otheroffice">Other</label>
    </div>
    <div id="grpfacility">
	    <label for="exampleInputEmail1">Facility</label>
	    <div class="signupselectitem" id="filtercountycontainer">
	        <select class="selectpicker selectfilter" name="facility" data-live-search="true" data-size="5" data-width="100%">
	          <option data-tokens="All Counties">Select Facility</option>
	          <?php
	                $companyresults = $obj->readalldata("facility");
	                //print_r($companyresults);
	                foreach($companyresults as $item) {
	                    echo '<option data-tokens='.$item['id'].'>'.$item['facilityname'].'</option>';
	                }
	            ?>
	        </select>
	    </div>
	</div>
    <div id="grpregion">
	    <label for="exampleInputEmail1">Region</label>
	    <div class="signupselectitem" id="filtercountycontainer">
	        <select class="selectpicker selectfilter" name="region" data-live-search="true" data-size="5" data-width="100%">
	          <option data-tokens="All Counties">Select Region</option>
	          <?php
	                $companyresults = $obj->readalldata("region");
	                //print_r($companyresults);
	                foreach($companyresults as $item) {
	                    echo '<option data-tokens='.$item['id'].'>'.$item['regionname'].'</option>';
	                }
	            ?>
	        </select>
	    </div>
	</div>
    <div class="form-group" id="grpdepartment">
        <label for="exampleInputEmail1">Department</label>
        <input type="department" class="form-control" id="department" name="department" aria-describedby="emailHelp" placeholder="Enter Department">
        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
    </div>
    <div class="form-group" id="grpreasonforaccess">
        <label for="exampleInputEmail1">Reason for access</label>
        <input type="accessreason" class="form-control" id="accessreason" name="reasonforaccess" aria-describedby="emailHelp" placeholder="access reason">
        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
    </div>
</form>