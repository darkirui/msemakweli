<div class="topmenusection">
    <div class="contentwrap">
        <div class="topmenuwrap">
            <div class="tablediv">
                <div class="tablerowdiv">
                    <div class="tablecelldiv sitetilte">MSEMA KWELI</div>
                    <div class="tablecelldiv mainfilterlinks">
                        <a href="">KARP CENTRAL</a>
                        <?php
                            // print_r($_COOKIE['userprivileges']);
                        ?>
                        <a data-toggle="modal" data-target="#filterregions" class="filterlocation" id="afilterregion">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            Regions 
                            <?php 
                                $selectedregionsarray = unserialize($serializedregionarray);
                                if(in_array("all", $selectedregionsarray)){
                                    echo '<i class="fa fa-circle" aria-hidden="true"></i>';
                                }
                                else{
                                    echo '<i class="fa fa-circle-o" aria-hidden="true"></i>';
                                }
                            ?>
                        </a>
                        <a data-toggle="modal" data-target="#filtercounties" class="filterlocation" id="afiltercounty">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            Counties 
                            <?php 
                                //$selectedcountiesarray = unserialize($serializecountynamesarray);
                                if(in_array("all", unserialize($serializecountynamesarray))){
                                    echo '<i class="fa fa-circle" aria-hidden="true"></i>';
                                }
                                else{
                                    echo '<i class="fa fa-circle-o" aria-hidden="true"></i>';
                                }
                            ?>
                        </a>    
                        <a data-toggle="modal" data-target="#filtersubcounties" class="filterlocation" id="afiltersubcounty">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            Sub Counties 
                            <?php
                                $selectedsubcountiesarray = unserialize($serializedsubcountynamesarray); 
                                if(in_array("all", $selectedsubcountiesarray)){
                                    echo '<i class="fa fa-circle" aria-hidden="true"></i></a>';
                                }
                                else{
                                    echo '<i class="fa fa-circle-o" aria-hidden="true"></i>';
                                }
                            ?>
                        </a>
                        <a data-toggle="modal" data-target="#filterfacilities" class="filterlocation" id="afilterfacility">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            Facilities 
                            <?php 
                                $selectedfacilitiesarray = unserialize($serializedfacilitynamesarray); 
                                if(in_array("all", $selectedfacilitiesarray)){
                                    echo '<i class="fa fa-circle" aria-hidden="true"></i></a>';
                                }
                                else{
                                    echo '<i class="fa fa-circle-o" aria-hidden="true"></i>';
                                }
                            ?>
                        </a>
                        <a data-toggle="modal" data-target="#filterperiod" class="filterperiod" id="afilterperiod">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                            <span id="selectedreportingperiod">
                                <?php
                                    if($selectedreporttype != ""){
                                        echo $selectedreporttype;
                                    }
                                    else if($selectedreporttype != ''){
                                        echo $selectedreporttype;
                                    }
                                    else{
                                        echo "Reporting Period";
                                    }
                                ?>
                            </span>
                            <i class="fa fa-sliders" aria-hidden="true"></i>
                            <?php 
                                // if($selectedreporttype == 'all'){
                                //     echo '<i class="fa fa-circle" aria-hidden="true"></i></a>';
                                // }
                                // else{
                                //     echo '<i class="fa fa-circle-o" aria-hidden="true"></i>';
                                // }
                            ?>
                        </a>
                        <?php 
                            
                            
                            
                            // if($selectedreporttype != 'all' || $selectedcounty!= 'all' || $selectedsubcounty != 'all' || $selectedregion != 'all' || $selectedfacility != 'all'){
                            //     echo '<a href="">Reset Selection <i class="fa fa-refresh" aria-hidden="true"></i></a>';
                            // }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="primarymenusection">
    <div class="contentwrap">
        <div class="primarymenuwrap">
            <div class="tablediv">
                <div class="tablerowdiv">
                    <div class="tablecelldiv menuitems">
                        <a href="">Home <i class="las la-home"></i></a> 
                        <?php
                            if($userfirstname == ''){
                               echo '<a data-toggle="modal" data-target="#loginmodal" class="dropdownmainlink">Service Areas <i class="las la-stethoscope"></i></a>';
                               echo '<a data-toggle="modal" data-target="#loginmodal">Analytics and Interventions <i class="las la-chart-line"></i></a>';
                               echo '<a data-toggle="modal" data-target="#loginmodal" class="dropdownmainlink">Reporting & Validations <i class="las la-chart-bar"></i></a>';
                               echo '<a data-toggle="modal" data-target="#loginmodal">Queries <i class="las la-bolt"></i></a>';
                               echo '<a data-toggle="modal" data-target="#loginmodal" class="dropdownmainlink">Database Repository <i class="las la-database"></i></a>';
                            }
                            else{
                        ?>
                            <span class="withdropdown">
                                <a href="treatment" class="dropdownmainlink">Service Areas <i class="las la-stethoscope"></i></a>
                                <div class="menudropdown">
                                    <div class="dropdownlinkswrap">
                                        <a href="treatment"><i class="fa fa-caret-right" aria-hidden="true"></i> Treatment</a>
                                        <a href="hts"><i class="fa fa-caret-right" aria-hidden="true"></i> HTS</a>
                                        <a href=""><i class="fa fa-caret-right" aria-hidden="true"></i> PMTCT</a>
                                        <a href=""><i class="fa fa-caret-right" aria-hidden="true"></i> TB & IPT</a>
                                        <a href=""><i class="fa fa-caret-right" aria-hidden="true"></i> PREP</a>
                                        <a href=""><i class="fa fa-caret-right" aria-hidden="true"></i> VMMC</a>
                                        <a href=""><i class="fa fa-caret-right" aria-hidden="true"></i> Pharmacy</a>
                                        <a href=""><i class="fa fa-caret-right" aria-hidden="true"></i> Lab</a>
                                        <a href=""><i class="fa fa-caret-right" aria-hidden="true"></i> Patient Demographics</a>
                                    </div>
                                </div>
                            </span>
                            <a href="">Analytics and Interventions <i class="las la-chart-line"></i></a>
                            <span class="withdropdown">
                                <a href="reports" class="dropdownmainlink">Reporting & Validations <i class="las la-chart-bar"></i></a>
                                <div class="menudropdown">
                                    <div class="dropdownlinkswrap">
                                        <a href="reports"><i class="fa fa-caret-right" aria-hidden="true"></i> Report Summaries</a>
                                        <a href="databases"><i class="fa fa-caret-right" aria-hidden="true"></i> Report Validations</a>
                                    </div>
                                </div>
                            </span>
                            <a href="queries">Queries <i class="las la-bolt"></i></a>
                            <span class="withdropdown">
                                <a href="databases/uploaddatabase.php" class="dropdownmainlink">Database Repository <i class="las la-database"></i></a>
                                <div class="menudropdown">
                                    <div class="dropdownlinkswrap">
                                        <a href="databases/uploaddatabase.php"><i class="fa fa-caret-right" aria-hidden="true"></i> Databases</a>
                                        <a href="databases"><i class="fa fa-caret-right" aria-hidden="true"></i> Refresh Data</a>
                                    </div>
                                </div>
                            </span>
                        <?php
                            }
                        ?> 
                    </div>
                    <div class="tablecelldiv userlogin">
                        <?php
                            if($userfirstname == ''){
                                echo '<a data-toggle="modal" data-target="#loginmodal" class="loginlink"><i class="las la-key"></i> Sign In</a> |';
                                echo '<a data-toggle="modal" data-target="#signupmodal" class="loginlink" id="signupbasicdetails"><i class="las la-pen-alt"></i> Sign Up</a>';
                            }
                            else{
                                echo '<span class="withdropdown">';
                                    echo '<a href="databases/uploaddatabase.php" class="dropdownmainlink">Sasa '.$userfirstname.' <i class="las la-user"></i></a>';
                                    echo '<div class="menudropdown">';
                                        echo '<div class="dropdownlinkswrap">';
                                            echo '<a href="databases/uploaddatabase.php"><i class="las la-tools"></i> Manage Account</a>';
                                            $userprivilegesarray = unserialize($_COOKIE['userprivileges']);
                                            if(in_array("Approve Users", $userprivilegesarray)){
                                                echo '<a href="users/manageusers.php"><i class="las la-medal"></i> Manage Users</a>';
                                            }
                                            echo '<a id="userlogout" class="userlogout" data-toggle="modal" data-target="#logoutmodal"><i class="las la-lock"></i> Logout</a>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</span>';
                            }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filtercounties" tabindex="-1" role="dialog" aria-labelledby="filtercounties" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='filterlocations/savefiltercounties.php' method='post' id="countyfilterform">
                <div class="modal-header">
                    SELECT/UNSELECT COUNTIES
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="filterlocations/savefiltercounties.php">
                        <div class="locationfiltersection countyfiltersection">
                            <div class="blobs-container">
                                <div class="blob red"></div>
                            </div>
                            <div class="backgroundstatus">something running in the background, hold on..</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <span class="countyreportstatus"></span>
                    <button type="button" class="btn btn-primary" id="actionfiltercounty" name="submit"><span class="linelistdownloadstatus"><i class="las la-save"></i> Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="filterregions" tabindex="-1" role="dialog" aria-labelledby="filterregions" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='filterlocations/savefilterregions.php' method='post' id="regionfilterform">
                <div class="modal-header">
                    SELECT/UNSELECT REGIONS
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="filterlocations/savefilterregions.php">
                        <div class="locationfiltersection regionfiltersection">
                            <div class="blobs-container">
                                <div class="blob red"></div>
                            </div>
                            <div class="backgroundstatus">something running in the background, hold on..</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <span class="regionreportstatus"></span>
                    <button type="button" class="btn btn-primary" id="actionfilterregion" name="submit"><span class="linelistdownloadstatus"><i class="las la-save"></i> Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="filtersubcounties" tabindex="-1" role="dialog" aria-labelledby="filtersubcounties" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='export/datatoexcel.php' method='post'>
                <div class="modal-header">
                    FILTER SUB COUNTIES
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="locationfiltersection subcountyfiltersection">
                        <div class="blobs-container">
                            <div class="blob red"></div>
                        </div>
                        <div class="backgroundstatus">something running in the background, hold on..</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="actiondatimdownload" name="submit"><span class="linelistdownloadstatus"><i class="las la-download"></i></span> Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="filterfacilities" tabindex="-1" role="dialog" aria-labelledby="filterfacilities" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='export/datatoexcel.php' method='post'>
                <div class="modal-header">
                    FILTER FACILITIES
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="locationfiltersection facilityfiltersection">
                        <div class="blobs-container">
                            <div class="blob red"></div>
                        </div>
                        <div class="backgroundstatus">something running in the background, hold on..</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="actiondatimdownload" name="submit"><span class="linelistdownloadstatus"><i class="las la-download"></i></span> Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="filterperiod" tabindex="-1" role="dialog" aria-labelledby="filterperiod" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                CHANGE REPORTING PERIOD..
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="locationfiltersection periodfiltersection">
                    <form action="filterlocations/savereportingperiod.php" method="post" id="frmfilterreportingfrequency">
                        <div>
                            <input type="radio" id="reportweekly" name="reportingfrequency" value="weekly"
                                <?php 
                                    if($_COOKIE['selectedreporttype'] == 'weekly'){
                                        echo 'checked="checked"';
                                    }
                                ?>
                            ><label for="reportweekly">Weekly</label>
                        </div>
                        <div>
                            <input type="radio" id="reportmonthly" name="reportingfrequency" value="monthly"
                                <?php 
                                    if($_COOKIE['selectedreporttype'] == 'monthly'){
                                        echo 'checked="checked"';
                                    }
                                ?>
                            ><label for="reportmonthly">Monthly</label>
                        </div>
                        <div>
                            <input type="radio" id="reportquarterly" name="reportingfrequency" value="quarterly"
                                <?php 
                                    if($_COOKIE['selectedreporttype'] == 'quarterly'){
                                        echo 'checked="checked"';
                                    }
                                ?>
                            ><label for="reportquarterly">Quarterly</label>
                        </div>
                        <div>
                            <input type="radio" id="reportannually" name="reportingfrequency" value="annual"
                                <?php 
                                    if($_COOKIE['selectedreporttype'] == 'annual'){
                                        echo 'checked="checked"';
                                    }
                                ?>
                            ><label for="reportannually">Annual</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="actionsavereportingfrequency" name="submit"><span class="linelistdownloadstatus"><i class="las la-download"></i></span> Save Changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                LOGIN TO CONTINUE
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="users/userlogin.php" method="post" id="frmuserlogin">
                    <div class="locationfiltersection periodfiltersection">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="actionloginuser" name="submit"><span class="linelistdownloadstatus"><i class="las la-key"></i></span> Login</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="signupmodal" tabindex="-1" role="dialog" aria-labelledby="signupmodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Provide the required details
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="userloginstatus"></span>
                <div class="signupdetailssection">
                    
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="actionsavemoredetails" name="submit"><span class="linelistdownloadstatus"><i class="las la-award"></i> Done</button>
                <button type="button" class="btn btn-primary" id="actionsavebasicdetails" name="submit"><span class="linelistdownloadstatus"><i class="las la-angle-double-right"></i> Next</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="las la-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logoutmodal" tabindex="-1" role="dialog" aria-labelledby="ogoutmodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Logout
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="userloginstatus"></span>
                <div class="signupdetailssection">
                    Are you sure you want to logout?
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="actionlogout" name="submit"><span class="linelistdownloadstatus"><i class="las la-lock"></i> Yes, Logout</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="las la-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
        


        
