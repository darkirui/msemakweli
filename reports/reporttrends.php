<?php
    include '../functions.php';
    ini_set('memory_limit', '-1');
    $obj = new myFunctions;
    
    echo '<div class="seasonalproducts">';
        echo '<div class="seasonheader iphonessection">';
            echo '<span id="spantitle"></span> TRENDS';
        echo '</div>';
        echo '<div class="seasonproducts trendswrap">';
            echo '<div class="tablediv">';
?>
                <div class="tablecelldiv trendindicatorstablecell">
                    <div class="trendindicators">
                        <a class="trendlink" id="txcurr">TxCURR</a>
                        <a class="trendlink" id="txnew">TxNEW</a>
                        <a class="trendlink" id="txrtt">TxRTT</a>
                        <a class="trendlink" id="transferin">TIs</a>
                        <a class="trendlink" id="ltfu">LTFU</a>
                        <a class="trendlink" id="transferout">TOs</a>
                        <a class="trendlink" id="deaths">Deaths</a>
                        <a class="trendlink" id="suppression">Suppression (%)</a>
                        <a class="trendlink" id="appointments">Appointments</a>
                        <a class="trendlink" id="missedappointments">Missed Apps. (%)</a>
                        <a class="trendlink" id="tracing">Tracing</a>
                        <br>
                        <a class="trendlink" id="missedappointments">TxNEW vs LTFU</a>
                        <a class="trendlink" id="tracing">TxRTT vs LTFU</a>
                        <a class="trendlink" id="tracing">Missed apps vs LTFU</a>
                        <a class="trendlink" id="tracing">VLs</a>
                    </div>
                </div>
                <div class="tablecelldiv trendindicatorcharts">
                    <div class="trendloading">
                        <img src="theme/images/trendloading.gif">
                    </div>
                    <div class="trendlinecontainer">
                        <div><canvas id="canvas"></canvas></div>
                    </div>
                </div>
<?php
                    //$countresults = $obj->getselectedreportdatacount($dates);
        echo '</div>';
        echo '<div class="productcategorylink trenddetailslink">';

            // echo '<button class="refreshdatabtn" id="refreshdata'.$weekidentifier.'"><i class="fa fa-circle-o-notch" aria-hidden="true"></i> Refresh Data</button>';
        echo '</div>';
        echo '<div class="refreshstatus">';
            
        echo '</div>';
    echo '</div>';
?>
