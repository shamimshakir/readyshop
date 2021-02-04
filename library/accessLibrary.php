<?php 

function getUserinfofromAccess($accessdb,$dbhost,$dbname,$dbuser,$dbpass)
  {
	$db = $accessdb;
	if(!file_exists($db)){
	 die('Error finding access database');
	}
	$host=$dbhost;
	$mydatabase=$dbname;
	$username=$dbuser;
	$password=$dbpass;
	
	try { 
	  # OPEN BOTH DATABASE CONNECTIONS
	  $conn = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=".$db.";Uid=; Pwd=;");
	
	  $myConn = new PDO("mysql:host=$host;dbname=".$mydatabase."",$username,$password); 
	  $myConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	   $sql = "SELECT * FROM USERINFO";
	 $result = $conn->query($sql);
	  $result->setFetchMode(PDO::FETCH_ASSOC); 
	
	  // FETCH ROWS FROM MS ACCESS
	  while($row = $result->fetch()) { 
	  
	
		$stmt = $myConn->prepare('INSERT INTO userinfo (userid, badgenumber, defaultdeptid, name) ' . 
					'VALUES(:userid, :badgenumber, :defaultdeptid, :name)' .
					'ON DUPLICATE KEY UPDATE badgenumber=VALUES(badgenumber), defaultdeptid=VALUES(defaultdeptid), name=VALUES(name)');
		$stmt->bindParam(':userid', $row['USERID']);  
		$stmt->bindParam(':badgenumber', $row['Badgenumber'], PDO::PARAM_STR);
		$stmt->bindParam(':defaultdeptid', $row['SSN'], PDO::PARAM_STR);
		$stmt->bindParam(':name', $row['Name'], PDO::PARAM_STR);       
	   if($stmt->execute()){
		  // $OutResult="New records created successfully";
		//return $OutResult;
	   }else{
		//  $OutResult="fail";
		//return $OutResult;
		   }
	  }
	} 
	catch(PDOException $e) {         
		//$OutResult=$e->getMessage()."\n";
		//return $OutResult;
	    exit; 
	}
	
	// CLOSE CONNECTIONS
	$accConn = null;
	$myConn = null;
	  }

function getCheckinoutfromAccess($accessdb1,$dbhost1,$dbname1,$dbuser1,$dbpass1)
  {	  
	  
$db = $accessdb1;
if(!file_exists($db)){
 die('Error finding access database');
}
$host=$dbhost1;
$mydatabase=$dbname1;
$username=$dbuser1;
$password=$dbpass1;

try { 
  # OPEN BOTH DATABASE CONNECTIONS
  $conn = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=".$db.";Uid=; Pwd=;");

  $myConn = new PDO("mysql:host=$host;dbname=".$mydatabase."",$username,$password); 
  $myConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$maxclockid=0;
	$msql="Select Max(id) as maxcid FROM `checkinout`";
	$mresult = $myConn->query($msql);
	while($data = $mresult->fetch( PDO::FETCH_ASSOC )){ 
	$maxclockid=$data['maxcid']; 
	}
if($maxclockid!=NULL){
	$maxcond="WHERE (((CHECKINOUT.id)>".$maxclockid."))";
	}

   $sql = "SELECT * FROM CHECKINOUT ".$maxcond."";
 $result = $conn->query($sql);
  $result->setFetchMode(PDO::FETCH_ASSOC); 

  // FETCH ROWS FROM MS ACCESS
  while($row = $result->fetch()) { 
  

	$stmt = $myConn->prepare('INSERT INTO checkinout (id, userid, checktime, checktype, verifycode, SN, sensorid, WorkCode, Reserved) ' . 
                'VALUES(:id, :userid, :checktime, :checktype, :verifycode, :SN, :sensorid, :WorkCode, :Reserved)' .
                'ON DUPLICATE KEY UPDATE userid=VALUES(userid), checktime=VALUES(checktime), checktype=VALUES(checktype), verifycode=VALUES(verifycode), sensorid=VALUES(sensorid), WorkCode=VALUES(WorkCode), WorkCode=VALUES(WorkCode), SN=VALUES(SN), Reserved=VALUES(Reserved)');
				
    $stmt->bindParam(':id', $row['id']);  
    $stmt->bindParam(':userid', $row['USERID'], PDO::PARAM_STR);
    $stmt->bindParam(':checktime', $row['CHECKTIME'], PDO::PARAM_STR);
	$stmt->bindParam(':checktype', $row['CHECKTYPE'], PDO::PARAM_STR);
	$stmt->bindParam(':verifycode', $row['VERIFYCODE'], PDO::PARAM_STR); 
	$stmt->bindParam(':sensorid', $row['SENSORID'], PDO::PARAM_STR);  
	$stmt->bindParam(':WorkCode', $row['WorkCode'], PDO::PARAM_STR);  
	$stmt->bindParam(':SN', $row['sn'], PDO::PARAM_STR);
	$stmt->bindParam(':Reserved', $row['UserExtFmt'], PDO::PARAM_STR);    
   if($stmt->execute()){
		//   $OutResult1="New records created successfully";
		//return $OutResult1;
	   }else{
		 // $OutResult1="fail";
		//return $OutResult1;
		   }
	  }
	} 
	catch(PDOException $e) {         
		//$OutResult1=$e->getMessage()."\n";
		//return $OutResult1;
	    exit; 
	}

// CLOSE CONNECTIONS
$accConn = null;
$myConn = null;	 
  }
?>