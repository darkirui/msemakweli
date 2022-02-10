<?php include '../header.php'; ?>
<div class="queriesbanner" id="indicatortotalbanner">
	<div class="contentwrap">
		<div class="treatmentbannercontentwrap">
			<div class="tablediv">
				<div class="tablerowdiv">
					<div class="tablecelldiv">
						<div class="indicatortotal" id="indicatortotal">
							<div class="titleintroduction">DATABASES</div>
							<div class="contenttitle">57</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="summarysection" style="margin-top: 30px;margin-bottom: 30px;">
	<div class="contentwrap">
		<div class="querysectionwrap">
			<div class="tablediv">
				<div class="tablerowdiv">
					<div class="tablecelldiv queryleftcol querytoprows querydatabasetitle">
						<span id="selecteddbname">
							<div class="facilityfilter" id="filterfacilitycontainer">
								<div class="tablediv">
									<div class="tablerowdiv">
										<div class="tablecelldiv">
											<i class="fa fa-database" aria-hidden="true"></i> 
										</div>
										<div class="tablecelldiv">
											<select class="selectpicker selectfilter" id="selectdatabase" data-live-search="true" data-size="5">
												<option data-tokens="All Facilities">All Databases</option>
												<?php
											  		$databaseresults = $obj->getserverdatabases();
											  		//print_r($companyresults);
											  		foreach($databaseresults as $item) {
													    echo '<option data-tokens='.$item['Database'].'>'.$item['Database'].'</option>';
													}
											  	?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</span>
					</div>
					<div class="tablecelldiv queryrightcol querytoprows">
						<button class="showdb" id="" data-toggle="modal" data-target="#modalshowdb" title="Import Query"><i class="las la-folder-open"></i></button>
						<button class="showdb" id="" data-toggle="modal" data-target="#modalshowdb" title="Load Saved Query"><i class="las la-list"></i></button>
						<button class="showdb" id="" data-toggle="modal" data-target="#modalshowdb" title="Save Query"><i class="las la-save"></i></button>
						<button class="showdb" id="" data-toggle="modal" data-target="#modalshowdb" title="Design Query"><i class="las la-project-diagram"></i></button>
						<button class="showdb" id="" data-toggle="modal" data-target="#modalshowdb" title="Execute Query"><i class="las la-bolt"></i></button>
						<button class="showdb" id="" data-toggle="modal" data-target="#modalshowdb" title="Stop Execution"><i class="las la-stop-circle"></i></button>
						<button class="showdb" id="" data-toggle="modal" data-target="#modalshowdb" title="Indent Query"><i class="fa fa-indent" aria-hidden="true"></i></button>
						<button class="showdb" id="" data-toggle="modal" data-target="#modalshowdb" title="Design Query Conditions"><i class="las la-list-alt"></i></button>
						<button class="showdb" id="" data-toggle="modal" data-target="#modalshowdb" title="Report Bug"><i class="las la-bug"></i></button>
						<button class="showdb" id="" data-toggle="modal" data-target="#modalshowdb" title="Ask for Help"><i class="lar la-question-circle"></i></button>
					</div>
				</div>
				<div class="tablerowdiv">
					<div class="tablecelldiv queryleftcol">
						<div class="querytablestitle leftcolbody">
							<i class="las la-table"></i> TABLES
						</div>
						<div class="querytableslist leftcolbody" id="querytablelist">
							Tables
						</div>
					</div>
					<div class="tablecelldiv queryrightcol querymainbody">
						<form>
				            <textarea id="code" name="code"></textarea>
            			</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="summarysection" style="margin-top: 30px;margin-bottom: 30px;">
	<div class="contentwrap">
		<div class="" style="">
			
		</div>
	</div>
</div>
<?php include '../footer.php'; ?>