<div class="leftcontentitem downloadssection">
	<div class="datatitle">Downloads</div>
	<div class="tablediv">
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname"><button data-toggle="modal" data-target="#txcurrmodal"><i class="las la-file-excel"></i> Line-Lists</button></div>
		</div>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname"><button data-toggle="modal" data-target="#datimmodal"><i class="las la-file-excel"></i> Datim Data Entry Template</button></div>
		</div>
		<?php
			if($_COOKIE['indicator']=='txcurr'){
		?>
			<div class="tablerowdiv">
				<div class="tablecelldiv dataname"><button data-toggle="modal" data-target="#covidmodal"><i class="las la-file-excel"></i> Covid Effects Template</button></div>
			</div>
		<?php
			}
		?>
		<div class="tablerowdiv">
			<div class="tablecelldiv dataname"><button><i class="las la-chart-bar"></i> Charts</button></div>
		</div>
	</div>
</div>


<div class="modal fade" id="txcurrmodal" tabindex="-1" role="dialog" aria-labelledby="txcurrmodal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action='export/datatoexcel.php' method='post'>
				<div class="modal-header">
					TxCURR Line-Lists
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="itemdownload">
						<input type="radio" id="txcurrdownloadtypesimple" name="txcurrdownloadtype" value="simple"><label for="txcurrdownloadtypesimple"> <span class="downloadmainname">Simple</span> - Facility name and client identifiers only</label>
					</div>
					<div class="itemdownload">
						<input type="radio" id="txcurrdownloadtypeintermediate" name="txcurrdownloadtype" value="intermediate" checked="checked"><label for="txcurrdownloadtypeintermediate"> <span class="downloadmainname">Intermediate (Recommended)</span> - Most requested variables</label>
					</div>
					<div class="itemdownload">
						<input type="radio" id="txcurrdownloadtypeadvanced" name="txcurrdownloadtype" value="advanced"><label for="txcurrdownloadtypeadvanced"> <span class="downloadmainname">Advanced</span> - Several variables</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="actiontxcurrdownload" name="submit"><span class="linelistdownloadstatus"><i class="las la-download"></i></span> Download</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="datimmodal" tabindex="-1" role="dialog" aria-labelledby="datimmodal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action='export/datatoexcel.php' method='post'>
				<div class="modal-header">
					Datim Data Entry Templates
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="itemdownload">
						<input type="checkbox" id="txcurr" class="datimdownload" name="datimdownload[]" value="txcurr" <?php echo ($_COOKIE['indicator']=='txcurr'? 'checked':'disabled'); ?>><label for="txcurr"> TxCURR</label>
					</div>
					<div class="itemdownload">
						<input type="checkbox" id="txnew" class="datimdownload" name="datimdownload[]" value="txnew" <?php echo ($_COOKIE['indicator']=='txnew'? 'checked':'disabled'); ?>><label for="txnew"> TxNEW</label>
					</div>
					<div class="itemdownload">
						<input type="checkbox" id="txrtt" class="datimdownload" name="datimdownload[]" value="txrtt" <?php echo ($_COOKIE['indicator']=='txrtt'? 'checked':'disabled'); ?>><label for="txrtt"> TxRTT</label>
					</div>
					<div class="itemdownload">
						<input type="checkbox" id="txmls" class="datimdownload" name="datimdownload[]" value="txml" <?php echo ($combinedindicator=='txml'? 'checked':'disabled'); ?>><label for="txmls"> TxMLs</label>
					</div>
					<div class="itemdownload">
						<input type="checkbox" id="txpvls" class="datimdownload" name="datimdownload[]" value="txpvls" disabled><label for="txpvls"> TxPVLs</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="actiondatimdownload" name="submit"><span class="linelistdownloadstatus"><i class="las la-download"></i></span> Download</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="covidmodal" tabindex="-1" role="dialog" aria-labelledby="covidmodal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action='export/exportcoviddata.php' method='post'>
				<div class="modal-header">
					Effects Of C-19 on Treament and Appoointments
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Continue to download Covid effects on treatment and appointments data?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="actioncoviddownload" name="submit"><span class="linelistdownloadstatus"><i class="las la-download"></i></span> Download</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>