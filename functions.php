<?php
	class myFunctions{
		private $host = "localhost";
		private $user = "root";
		private $db = "msemakwelidec";
		private $pass = "karp@2018";
		private $conn;

		/*** function to create database connection ***/
		public function __construct(){
			$this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db,$this->user,$this->pass,[PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
		}

		/*** function to insert data ***/
		public function insertData($table,$tabledata){
			try{
				$prefix = "";
				$tablelist = "";
				foreach($tabledata as $col=>$value){
					$listvalues = $prefix."".$col."=:".$col;
					$prefix = ",";
					$tablelist = $tablelist."".$listvalues;
				}

				$dataprefix = "";
				$datalist = "";
				foreach($tabledata as $col=>$value){
					$listvalues = $dataprefix."':".$col."'=>".$value;
					$dataprefix = ",";
					$datalist = $datalist."".$listvalues;
				}

				$sql = "INSERT INTO $table SET ".$tablelist."";
				$q = $this ->conn->prepare($sql);
				$q->execute($tabledata);
				return true;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}			
		}

		/*** function to read all data from a table without a condition ****/
		public function readAlldata($table){
			try{
				$sql = "SELECT * FROM $table";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				if (isset($data)) {
			  		return $data;
				}
				else{
					$error = "No Data";
					return $error;
				}
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		//select all facilities 
		public function selectAllFacilities($table){
			try{
				$sql = "SELECT * FROM $table ORDER BY facilityname";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				if (isset($data)) {
			  		return $data;
				}
				else{
					$error = "No Data";
					return $error;
				}
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		public function selectAllRegions($table){
			try{
				$sql = "SELECT region FROM $table GROUP BY region ORDER BY region";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				if (isset($data)) {
			  		return $data;
				}
				else{
					$error = "No Data";
					return $error;
				}
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		public function selectAllCounties($table){
			try{
				$sql = "SELECT county FROM $table GROUP BY county ORDER BY county";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				if (isset($data)) {
			  		return $data;
				}
				else{
					$error = "No Data";
					return $error;
				}
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		/*** function to read all data from a table without a condition ****/
		public function readTopdata($table){
			try{
				$sql = "SELECT * FROM $table LIMIT 100";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				return $data;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		/**** function to read data from specific columns without a condition ***/
		public function readSpecificdata($table,$tabledata){
			try{
				$prefix = "";
				$tablelist = "";
				foreach($tabledata as $value){
					$listvalues = $prefix."".$value;
					$prefix = ",";
					$tablelist = $tablelist."".$listvalues;
				}

				$sql = "SELECT $tablelist FROM $table";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				return $data;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		/**** function to read all data from a table with a WHERE condition ***/
		public function readAlldatawhere($table, $tabledata){
			try{
				$data = [];
				foreach($tabledata as $col=>$value){
					$col = $col;
					$colvalue = $value;
				}
				$sql = "SELECT * FROM $table WHERE $col = '$colvalue'";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				return $data;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}
		/*** function to read data from specific columns with a WHERE condition ****/

		/*** function to count rows in a table ***/
		public function countAlldata($table){
			try{
				$sql = "SELECT count(*) AS Total FROM $table ";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				return $data;
			}
			catch(PDOException $e){
				//echo 'Error: ' . $e->getMessage();
				echo '';
			}
		}

		//count report active records
		public function countreportactiverecords($table,$reportingperiod){
			try{
				$sql = "SELECT count(*) AS Total FROM $table where reportingperiod = '$reportingperiod' and voided = 0";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
				}
				return $data;
			}
			catch(PDOException $e){
				//echo 'Error: ' . $e->getMessage();
				echo '';
			}
		}

		//age gender distribution
		public function agegenderdistribution($reportingperiod,$reportname){
			$sql = 'CALL spagegenderdistribution(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		//facility distribution
		public function facilitydistribution($reportingperiod,$reportname){
			$sql = 'CALL spfacilitydistribution(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		//drug distribution
		public function drugdistribution($reportingperiod,$reportname){
			$sql = 'CALL spdrugdistribution(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		//drug distribution
		public function mmddistribution($reportingperiod,$reportname){
			$sql = 'CALL spmmddistribution(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}
		
		public function countartgender($reportingperiod,$reportname){
			$sql = 'CALL spcountdata(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function groupdata($reportingperiod,$reportname){
			$sql = 'CALL spcountdata(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		//group patient sources
		public function grouppatientsources($reportingperiod){
			try{
        		$data = [];
				$sql = "SELECT patientsource,count(*) total from(
					select pbi.patientsource,tx.personid from 
					(select * from patienttxnew where voided = 0 and reportingperiod = '$reportingperiod') tx 
					left join 
					(select * from patientbaselineinfo) pbi
					on tx.personid = pbi.personid and tx.facilityname = pbi.facilityname
				)patientsource group by patientsource order by count(*) desc";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
					//prnt_r($r);
				}
				return $data;
				//$r=$q->fetch(PDO::FETCH_ASSOC);
				//return $r;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		public function groupdeathcauses($reportingperiod){
			try{
        		$data = [];
				$sql = "SELECT causesofdeath,count(*) total from patientdeaths where voided = 0 and reportingperiod =  '$reportingperiod' group by causesofdeath
				order by count(*) desc";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
					//prnt_r($r);
				}
				return $data;
				//$r=$q->fetch(PDO::FETCH_ASSOC);
				//return $r;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		public function groupspecificdeathcauses($reportingperiod,$causesofdeath){
			try{
        		$data = [];
				$sql = "SELECT specificcausesofdeath,count(*) total from patientdeaths 
				where causesofdeath = '$causesofdeath' and voided = 0 and reportingperiod =  '$reportingperiod'
				group by specificcausesofdeath";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
					//prnt_r($r);
				}
				return $data;
				//$r=$q->fetch(PDO::FETCH_ASSOC);
				//return $r;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}


		public function countartagegroups($reportingtbl){
			try{
        		$data = [];
				$sql = "SELECT 
				SUM(CASE WHEN cast(AgeAtLastVisit AS Decimal)<15 THEN 1 ELSE 0 END) AS 'children',
				SUM(CASE WHEN cast(AgeAtLastVisit AS Decimal)>=15 THEN 1 ELSE 0 END) AS 'adult',
				SUM(CASE WHEN cast(AgeAtLastVisit AS Decimal)>=10 and cast(AgeAtLastVisit AS Decimal)<20 THEN 1 ELSE 0 END) AS 'adolescents'
				FROM $reportingtbl";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
					//prnt_r($r);
				}
				return $data;
				//$r=$q->fetch(PDO::FETCH_ASSOC);
				//return $r;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		public function countnewagegroups($reportingtbl){
			try{
        		$data = [];
				$sql = "SELECT 
				SUM(CASE WHEN cast(AgeAtArtStart AS Decimal)<15 THEN 1 ELSE 0 END) AS 'children',
				SUM(CASE WHEN cast(AgeAtArtStart AS Decimal)>=15 THEN 1 ELSE 0 END) AS 'adult',
				SUM(CASE WHEN cast(AgeAtArtStart AS Decimal)>=10 and cast(AgeAtArtStart AS Decimal)<20 THEN 1 ELSE 0 END) AS 'adolescents'
				FROM $reportingtbl";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
					//prnt_r($r);
				}
				return $data;
				//$r=$q->fetch(PDO::FETCH_ASSOC);
				//return $r;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		public function classifyvls($reportingtbl,$lastreportingdate){
			try{
        		$data = [];
				$sql = "SELECT
				SUM(CASE WHEN LastVLDate IS NOT NULL and TIMESTAMPDIFF(MONTH, cast(LastVLDate AS date), cast('$lastreportingdate' AS date)) <= 12 and 
				cast(LastVLResult as Decimal) < 1000 THEN 1 ELSE 0 END) AS 'suppressed',
				SUM(CASE WHEN LastVLDate IS NOT NULL and TIMESTAMPDIFF(MONTH, cast(LastVLDate AS date), cast('$lastreportingdate' AS date)) <= 12 and 
				cast(LastVLResult as Decimal) >= 1000 THEN 1 ELSE 0 END) AS 'unsuppressed',
				SUM(CASE WHEN LastVLDate IS NOT NULL and TIMESTAMPDIFF(MONTH, cast(LastVLDate AS date), cast('$lastreportingdate' AS date)) <= 12 THEN 1 ELSE 0 END) AS 'validvls',
				SUM(CASE WHEN LastVLDate IS NOT NULL and TIMESTAMPDIFF(MONTH, cast(LastVLDate AS date), cast('$lastreportingdate' AS date)) > 12 THEN 1 ELSE 0 END) AS 'outdatedvls',
				SUM(CASE WHEN LastVLDate IS NULL THEN 1 ELSE 0 END) AS 'unorderedvls'
				FROM $reportingtbl";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
					//prnt_r($r);
				}
				return $data;
				//$r=$q->fetch(PDO::FETCH_ASSOC);
				//return $r;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		public function groupendofperiodoutcomes($reportingtbl){
			try{
        		$data = [];
				$sql = "SELECT
				SUM(CASE WHEN ExitReason OR ExitReason LIKE '%other%' IS NULL THEN 1 ELSE 0 END) AS 'active',
				SUM(CASE WHEN ExitReason = 'Died' THEN 1 ELSE 0 END) AS 'death',
				SUM(CASE WHEN ExitReason LIKE '%lost%' THEN 1 ELSE 0 END) AS 'ltfu',
				SUM(CASE WHEN ExitReason LIKE '%transfer%' THEN 1 ELSE 0 END) AS 'to'
				FROM $reportingtbl";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
					//prnt_r($r);
				}
				return $data;
				//$r=$q->fetch(PDO::FETCH_ASSOC);
				//return $r;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		public function restoredatabase($databasepath,$databasename){
			$conn = new mysqli($this->host, $this->user, $this->pass);
			// Check connection
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error);
			}

			// Create database
			$sql = 'CREATE DATABASE '.$databasename;
			if ($conn->query($sql) === TRUE) {
			  $conn->close();
				//echo "<br>Created Database Success";

				//echo "processing";
				$command='mysql -h' .$this->host .' -u' .$this->user .' -p' .$this->pass  .' ' .$databasename .' < ' .$databasepath;
				$output = null;
				$result = '';
				exec($command,$output,$worked);
				switch($worked){
				case 0:
					//$tablecol = array("parentpage"=>$parentpage,"pagetitle"=>$pagetitle,"pageslug"=>$pageslug,"pagecontent"=>$pagecontent,"pagebanner"=>$pagebanner,"pagefunctions"=>$pagefunctions);
					//$where = array("pageid"=>$pageid);
					//$pageupdateresult = $obj->updateDatawhere("pages_tbl",$tablecol,$where);
					$result = $databasename;
				break;
				case 1:
					$result = 'An error occurred during the import. Please check if the file is in the same folder as this script. Also check the following data again:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$this->host .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$this->user .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$this->host .'</b></td></tr><tr><td>MySQL Import Dateiname:</td><td><b>' .$databasepath .'</b></td></tr></table>';
					 
				break;
				}
			} else {
				$result = "Error creating database: " . $conn->error; 
			}
			return $result;
		}

		public function getdbfacilitydetails($dbname){
			$sql = 'CALL spgetdatabasedetails(:dbname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':dbname', $dbname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function deletedatawhere($table, $tabledata){
			try{
				foreach($tabledata as $col=>$value){
					$col = $col;
					$colvalue = $value;
				}
				$stmt = $this->conn->prepare( "DELETE FROM $table WHERE $col = '$colvalue'" );
        		$stmt->bindParam(':id', $id);
        		$result = $stmt->execute();
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		public function dropformerdbs($dbname){
			$connection = new PDO("mysql:host=localhost", $this->user, $this->pass);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$stmt = $connection->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =:dbname");
			$stmt->execute(array(":dbname"=>$dbname));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
			    $statement = $connection->exec("DROP DATABASE IF EXISTS " . $dbname);
			}
		}

		public function filterlocations($facilityname,$mflcode,$countyname,$subcountyname,$regionname){
			$sql = 'CALL spfilterlocation(:facilityname,:mflcode,:countyname,:subcountyname,:regionname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':facilityname', $facilityname, PDO::PARAM_STR, 100);
			$stmt->bindParam(':mflcode', $mflcode, PDO::PARAM_STR, 100);
			$stmt->bindParam(':countyname', $countyname, PDO::PARAM_STR, 100);
			$stmt->bindParam(':subcountyname', $subcountyname, PDO::PARAM_STR, 100);
			$stmt->bindParam(':regionname', $regionname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function refreshalldata($reportingtimespan,$reportingperiod,$reportenddate){
			$sql = 'CALL sprefreshalldata(:reportingtimespan,:reportingperiod,:reportenddate)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingtimespan', $reportingtimespan, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportenddate', $reportenddate, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function getselectedreportdatacount($reportingperiod){
			$sql = 'CALL spcountselectedreportdata(:reportingperiod)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function getsuppressionrates($reportingperiod,$reportingtimespan){
			$sql = 'CALL spsuppressionrates(:reportingperiod,:reportingtimespan)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportingtimespan', $reportingtimespan, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function getmissedrates($reportingperiod,$reportingtimespan){
			$sql = 'CALL spmissedrates(:reportingperiod,:reportingtimespan)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportingtimespan', $reportingtimespan, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spreportmalescount($reportingperiod,$reportname){
			$sql = 'CALL spcountmales(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spreportfemalescount($reportingperiod,$reportname){
			$sql = 'CALL spcountfemales(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spreportadultscount($reportingperiod,$reportname){
			$sql = 'CALL spcountadults(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spreportpaedscount($reportingperiod,$reportname){
			$sql = 'CALL spcountpaeds(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spreportadolescentscount($reportingperiod,$reportname){
			$sql = 'CALL spcountadolescents(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spreportvalidvlscount($reportingperiod,$reportname){
			$sql = 'CALL spcountvalidvls(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spreportoutdatedvlscount($reportingperiod,$reportname){
			$sql = 'CALL spcountoutdatedvls(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spreportunorderedvlscount($reportingperiod,$reportname){
			$sql = 'CALL spcountunorderedvls(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spreportsuppressedcount($reportingperiod,$reportname){
			$sql = 'CALL spcountsuppressed(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spreportunsuppressedcount($reportingperiod,$reportname){
			$sql = 'CALL spcountunsuppressed(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spreportovccount($reportingperiod,$reportname){
			$sql = 'CALL spcountovc(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll();
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spgetsimplereport($reportingperiod,$reportname){
			$sql = 'CALL spsimplereport(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spgetintermediatereport($reportingperiod,$reportname){
			$sql = 'CALL spintermediatereport(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spgetadvancedreport($reportingperiod,$reportname){
			$sql = 'CALL spadvancedreport(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spdatimtxcurrdata($reportingperiod,$reportname){
			$sql = 'CALL spdatimtxcurrdata(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spdatimtxnewdata($reportingperiod,$reportname){
			$sql = 'CALL spdatimtxnewdata(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spdatimtxrttdata($reportingperiod,$reportname){
			$sql = 'CALL spdatimtxrttdata(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spdatimtxmldata($reportingperiod,$reportname){
			$sql = 'CALL spdatimtxmldata(:reportingperiod,:reportname)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->bindParam(':reportname', $reportname, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spfilteralllocations(){
			$sql = 'CALL spfilteralllocations(:filtervalues)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':filtervalues', $filtervalues, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spfiltercounties(){
			$filtervalues = "where regionname in (";
			$i = 0;
			foreach (unserialize($_COOKIE['selectedregion']) as $county) {
				if($i == 0){
					$filtervalues = $filtervalues.'"'.$county.'"';
				}else{
					$filtervalues = $filtervalues.',"'.$county.'"';
				}
				$i=$i+1;
			}
			$filtervalues = $filtervalues.")";
			$sql = 'CALL spfiltercounties(:filtervalues)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':filtervalues', $filtervalues, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spfiltersubcounties(){
			$filtervalues = "where regionname in (";
			$i = 0;
			foreach (unserialize($_COOKIE['selectedregion']) as $region) {
				if($i == 0){
					$filtervalues = $filtervalues.'"'.$region.'"';
				}else{
					$filtervalues = $filtervalues.',"'.$region.'"';
				}
				$i=$i+1;
			}
			$filtervalues = $filtervalues.")";

			$n=0;
			$filtercountyvalues = " and countyname in (";
			foreach (unserialize($_COOKIE['selectedcounty']) as $county) {
				if($n == 0){
					$filtercountyvalues= $filtercountyvalues.'"'.$county.'"';
				}else{
					$filtercountyvalues = $filtercountyvalues.',"'.$county.'"';
				}
				$n=$n+1;
			}
			$filtercountyvalues = $filtercountyvalues.")";
			$filterallvalues = $filtervalues.$filtercountyvalues;
			
			$sql = 'CALL spfiltersubcounties(:filtervalues)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':filtervalues', $filterallvalues, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		public function spfilterfacilities(){
			$filtervalues = "where regionname in (";
			$i = 0;
			foreach (unserialize($_COOKIE['selectedregion']) as $region) {
				if($i == 0){
					$filtervalues = $filtervalues.'"'.$region.'"';
				}else{
					$filtervalues = $filtervalues.',"'.$region.'"';
				}
				$i=$i+1;
			}
			$filtervalues = $filtervalues.")";

			$n=0;
			$filtercountyvalues = " and countyname in (";
			foreach (unserialize($_COOKIE['selectedcounty']) as $county) {
				if($n == 0){
					$filtercountyvalues= $filtercountyvalues.'"'.$county.'"';
				}else{
					$filtercountyvalues = $filtercountyvalues.',"'.$county.'"';
				}
				$n=$n+1;
			}
			$filtercountyvalues = $filtercountyvalues.")";

			$x=0;
			$filtersubcountyvalues = " and subcountyname in (";
			foreach (unserialize($_COOKIE['selectedsubcounty']) as $subcounty) {
				if($x == 0){
					$filtersubcountyvalues= $filtersubcountyvalues.'"'.$subcounty.'"';
				}else{
					$filtersubcountyvalues = $filtersubcountyvalues.',"'.$subcounty.'"';
				}
				$x=$x+1;
			}
			$filtersubcountyvalues = $filtersubcountyvalues.")";

			$filterallvalues = $filtervalues.$filtercountyvalues.$filtersubcountyvalues;
			
			$sql = 'CALL spfilterfacilities(:filtervalues)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':filtervalues', $filterallvalues, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}

		/*** function to generate password ***/
		function generateStrongPassword()
		{
			$length = 9;
			$add_dashes = false;
			$available_sets = 'luds';
			$sets = array();
			if(strpos($available_sets, 'l') !== false)
				$sets[] = 'abcdefghjkmnpqrstuvwxyz';
			if(strpos($available_sets, 'u') !== false)
				$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
			if(strpos($available_sets, 'd') !== false)
				$sets[] = '23456789';
			if(strpos($available_sets, 's') !== false)
				$sets[] = '!@#$%&*?';
			$all = '';
			$password = '';
			foreach($sets as $set)
			{
				$password .= $set[array_rand(str_split($set))];
				$all .= $set;
			}
			$all = str_split($all);
			for($i = 0; $i < $length - count($sets); $i++)
				$password .= $all[array_rand($all)];
			$password = str_shuffle($password);
			if(!$add_dashes)
				return $password;
			$dash_len = floor(sqrt($length));
			$dash_str = '';
			while(strlen($password) > $dash_len)
			{
				$dash_str .= substr($password, 0, $dash_len) . '-';
				$password = substr($password, $dash_len);
			}
			$dash_str .= $password;
			return $dash_str;
		}
		/*** function to generate password manganese ***/

		public function generateHash($password){
			/*** generate the password salt ***/
			$salt = substr(strtr(base64_encode(openssl_random_pseudo_bytes(22)), '+', '.'), 0, 22);
			/*** generate password hash ***/
			$hash = crypt($password, '$2y$12$' . $salt);
			$hasharray = array("salt"=>"".$salt."","password"=>"".$hash."");
			return $hasharray;
		}

		/*** hash paswword with manganese ****/
		public function hashPassword($password,$manganese){
			$hash = crypt($password, '$2y$12$' . $manganese);
			return $hash;
		}

		/*** function to update records in a table ***/
		public function updateDatawhere($table,$tablecol,$where){
			try{
				$joinarray = array_merge($tablecol,$where);
				$prefix = "";
				$tablelist = "";
				foreach($tablecol as $col=>$value){
					$listvalues = $prefix."".$col."=:".$col;
					$prefix = ",";
					$tablelist = $tablelist."".$listvalues;
				}

				$whereprefix = "";
				$wherelist = "";
				foreach($where as $colwhere=>$valuewhere){
					$wherelistvalues = $whereprefix."".$colwhere."=:".$colwhere;
					$whereprefix = ",";
					$wherelist = $wherelist."".$wherelistvalues;
				}

				$sql = "UPDATE $table SET ".$tablelist." WHERE ".$wherelist."";
				$q = $this->conn->prepare($sql);
				$q->execute($joinarray);
				return true;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		/*** get server databases ***/
		public function getserverdatabases(){
			try{
        		$data = [];
				$sql = "show databases;";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
					//prnt_r($r);
				}
				return $data;
				//$r=$q->fetch(PDO::FETCH_ASSOC);
				//return $r;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		public function getdatabasetables($databasename){
			try{
        		$data = [];
				$sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '$databasename';";
				$q = $this->conn->query($sql);
				while($r=$q->fetch(PDO::FETCH_ASSOC)){
					$data[]=$r;
					//prnt_r($r);
				}
				return $data;
				//$r=$q->fetch(PDO::FETCH_ASSOC);
				//return $r;
			}
			catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
			}
		}

		public function spcoviddata($reportingperiod){
			$sql = 'CALL spcovideffects(:reportingperiod)';
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':reportingperiod', $reportingperiod, PDO::PARAM_STR, 100);
			$stmt->execute();
	        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $stmt->nextRowset();
		    $stmt->closeCursor();
        	return $res;
		}
	}
?>