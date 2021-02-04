<?php

     function drawCompanyInformation($ReportName,$ReporDetail=null)
      {
		   global $conn;
        $query="SELECT company_name FROM tbl_company WHERE company_id = 1";
        $ResultSet= mysqli_query($conn, $query) or die("Invalid query: " . mysqli_error());
        while ($row=mysqli_fetch_array($ResultSet))
        {
          if (isset($row['company_name']) && $row['company_name'] != '') {
            $company_name = $row['company_name'];
          }
          else {
            $company_name = "Nextech Ltd.";
          }

        }

        echo "<table class='chidden' align='center' border='0' cellspacing='0' cennpadding='0'>";
        echo "<tr><td align='center'><font size='4px'><b>$company_name</b><font></td></tr>";
        echo " <tr><td align='center'><font size='3px'><b>$ReportName</b><font></td></tr>";
        echo " <tr><td align='center'><font size='2px'><b>$ReporDetail</b><font></td></tr>";
        echo "</table>";
        echo "<br>";
      }
	
	function drawCompanyInformationDiv($ReportName,$ReporDetail=null)
      {
		   global $conn;
        $query="SELECT company_name FROM tbl_company WHERE company_id = 1";
        $ResultSet= mysqli_query($conn, $query) or die("Invalid query: " . mysqli_error());
        while ($row=mysqli_fetch_array($ResultSet))
        {
          if (isset($row['company_name']) && $row['company_name'] != '') {
            $company_name = $row['company_name'];
          }
          else {
            $company_name = "Nextech Ltd.";
          }

        }

        echo "<div style='text-align:center; margin-bottom:10px'>";
        echo "<font size='4px'><b>$company_name</b><font></br>";
        echo "<font size='3px'><b>$ReportName</b><font></br>";
        echo "<font size='2px'><b>$ReporDetail</b><font></br>";
        echo "</div>";
        
      }
      function drawMassage($Massage,$Event)
      {
		   global $conn;
            if($Event=="")
                $Event="onClick='javascript:history.go(-1);'";
            echo "<br><br><br>".
                 "<table border='0' align='center' top='500' cellpadding='0' cellspacing='0' width='41%' height='94' style=\"border: 1px solid #000000\">".
                 "    <tr><td width='100%' align='center' valign='middle' height='67'><p>&nbsp;$Massage</td></tr>".
                 "    <tr><td class='Button_cell' width='100%' height='26' align='center'><input class='forms_Button' type='button' value='Back' name='B3' $Event></td></tr>".
                 "</table>";
      }
      function drawBack($Massage,$Event)
      {
		   global $conn;
            if($Event=="")
                $Event="onClick='javascript:history.go(-1);'";
            echo "<br><br><br>".
                 "<table border='0' align='center' cellpadding='0' cellspacing='0'>".
                 "    <tr><td><input class='Minput' type='button' value='Back' name='B3' style='float: right' $Event></td></tr>".
                 "</table>";
      }
      function drawNormalMassage($Massage)
      {
		   global $conn;
            echo "<br><br><br>".
                 "<table border='1' align='center' top='500' cellpadding='0' cellspacing='0' width='41%' height='94'>".
                 "    <tr><td width='100%' align='center' valign='middle' height='67'><p>&nbsp;$Massage</td></tr>".
                 "</table>";
      }
      function creatCombo($ComboName,$TableName,$ID,$Name)
      {
		   global $conn;
                $query=" select
                                $ID as ID,
                                $Name as Name
                         FROM
                                $TableName ";

                //echo    "$query";
                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

                print("<option>Select a $ComboName</option>\n");
                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
                        $ID=$qry_row["ID"];
                        $Name=$qry_row["Name"];
                        print("<option value='$ID'>$Name</option>\n");
                }
      }
      function createCombo($ComboName,$TableName,$ID,$Name,$Condition,$selectedValue)
      {
		   global $conn;
               $query=" select
                                $ID as ID,
                                $Name as Name
                         FROM
                                $TableName ".$Condition;

                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

                print("<option value=''>Select a $ComboName</option>\n");
                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
                        $ID=$qry_row["ID"];
                        $Name=$qry_row["Name"];
                        if($ID==$selectedValue)

                              print("<option value='$ID' selected>$Name</option>\n");
                        else
                              print("<option value='$ID'>$Name</option>\n");
                }
      }
      function createClientCombo($ComboName,$TableName,$ID,$Name,$Condition,$selectedValue)
      {
		   global $conn;
                $query=" select
                                $ID as ID,
                                $Name as Name,
                                ip_number
                         FROM
                                $TableName ".$Condition;

                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

                print("<option value=''>Select a $ComboName</option>\n");
                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
                        $ID=$qry_row["ID"];
                        $Name=$qry_row["Name"];
                        $ip_number=$qry_row["ip_number"];
                        if($ID==$selectedValue)
                              print("<option value='$ID' selected>$Name -> $ip_number</option>\n");
                        else
                              print("<option value='$ID'>$Name -> $ip_number</option>\n");
                }
      }

	  function createSubTechCombo($ComboName,$TableName,$ID,$Name,$Condition,$selectedValue)
      {
	    global $conn;
		        echo  $query=" select
                                $ID as ID,
                                $Name as Name,
                           mas_designation.designation
						FROM
						  ".$TableName. $Condition;

                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

                print("<option value=''>Select a $ComboName</option>\n");
                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
                        $ID=$qry_row["ID"];
                        $Name=$qry_row["Name"];
                        $designation=$qry_row["designation"];
                        if($ID==$selectedValue)
                              print("<option value='$ID' selected>$Name ( $designation )</option>\n");
                        else
                              print("<option value='$ID'>$Name ( $designation )</option>\n");
                }
      }

      function creatQueryCombo($query,$ComboName)
      {
		   global $conn;
            $ResultSet= mysqli_query($conn, $query)
                or die("Invalid query: " . mysqli_error());

            print("<option>Select a $ComboName</option>\n");

            while ($qry_row=mysqli_fetch_array($ResultSet))
            {
                $ID=$qry_row["ID"];
                $Name=$qry_row["Name"];
                print("<option value='$ID'>$Name</option>\n");
            }
      }
      function GetRandomPassword()
      {
		   global $conn;
            $keychars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#$";
            $length = 7;
            $randkey = "";
            $max=strlen($keychars)-1;

            for ($i=0;$i<=$length;$i++)
            {
                  $randkey .= substr($keychars, rand(0, $max), 1);
            }
            return  $randkey;
      }
      function SendMail($UserName,$Password,$To)
      {
		   global $conn;
            $to = $To;
            $subject ="Transcom Online Registration Confirmation Mail";
            $message ="Your Username and Password \r\n
                       Username: $UserName \r\n
                       Password: $Password \r\n
                       currently your account is disabled to make your account active please click here \r\n
                       http://192.168.0.75/Transcom/AccountActivation.php?UserName=$UserName&Password=$Password";

            $headers ="From: transcom@bangladesh.bd \r\n
                       Reply-To: transcom@bangladesh.bd \r\n
                       X-Mailer: PHP/". phpversion();

            if(mail($to,$subject,$message,$headers))
                return true;
      }

        function comboSecond($CurDate)
        {
			 global $conn;
                $i=0;
                if($CurDate=="" || $CurDate==null)
                        $CurDate=date("s");

                if($CurDate==-1)
                        echo "<option value='' selected>s</option>";
                while($i!=60)
                {
                        echo "<option value='$i'"; if($i==intval($CurDate)) echo "selected";echo ">$i</option>";
                        $i++ ;
                }
        }
        function comboMinute($CurDate)
        {
			 global $conn;
                $i=0;
                if($CurDate=="" || $CurDate==null)
                        $CurDate=date("i");

                if($CurDate==-1)
                        echo "<option value='' selected>m</option>";
                while($i!=60)
                {
                        echo "<option value='$i'"; if($i==intval($CurDate)) echo "selected";echo ">$i</option>";
                        $i++ ;
                }
        }
        function comboHour($CurDate)
        {
			 global $conn;
                $i=0;
                if($CurDate=="" || $CurDate==null)
                        $CurDate=date("G");

                if($CurDate==-1)
                        echo "<option value='' selected>H</option>";
                while($i!=24)
                {
                        echo "<option value='$i'"; if($i==intval($CurDate)) echo "selected";echo ">$i</option>";
                        $i++ ;
                }
        }
       /*
                Use nothing for today selected.
                Use 1....31 for that day selected.
                use -1 for empty selection.
       */
        function comboDay($CurDate)
        {
			 global $conn;
                $i=1;
                if($CurDate=="" || $CurDate==null)
                        $CurDate=date("d");

                if($CurDate==-1)
                        echo "<option value='' selected>D</option>";
                while($i!=32)
                {
                        echo "<option value='$i'"; if($i==$CurDate) echo "selected";echo ">$i</option>";
                        $i++ ;
                }
        }
       /*
                Use nothing for today selected.
                Use 1....12 for that month selected.
                use -1 for empty selection.
       */
        function comboMonth($CurMon)
        {
			 global $conn;
                if($CurMon=="" || $CurMon==null)
                        $CurMon=date("m");

                if($CurMon==-1)
                        echo "<option value='' selected>M</option>";
                echo "<option value='1'"; if($CurMon==1) echo "selected";echo ">January</option>";
                echo "<option value='2'"; if($CurMon==2) echo "selected";echo ">February</option>";
                echo "<option value='3'"; if($CurMon==3) echo "selected";echo ">March</option>";
                echo "<option value='4'"; if($CurMon==4) echo "selected";echo ">April</option>";
                echo "<option value='5'"; if($CurMon==5) echo "selected";echo ">May</option>";
                echo "<option value='6'"; if($CurMon==6) echo "selected";echo ">June</option>";
                echo "<option value='7'"; if($CurMon==7) echo "selected";echo ">July</option>";
                echo "<option value='8'"; if($CurMon==8) echo "selected";echo ">August</option>";
                echo "<option value='9'"; if($CurMon==9) echo "selected";echo ">September</option>";
                echo "<option value='10'"; if($CurMon==10) echo "selected";echo ">October</option>";
                echo "<option value='11'"; if($CurMon==11) echo "selected";echo ">November</option>";
                echo "<option value='12'"; if($CurMon==12) echo "selected";echo ">December</option>";
        }
       /*
                ** Use nothing for today selected and the start year will be
                   5 years less than present year and the end year will be the 5 years
                   more than present year.

                ** Use All parameter (start,end,selected) and the last parameter will
                   be used for year selection.

                ** use only -1 for empty selection.
       */
        function comboYear($Startyear,$EndYear,$CurYear)
        {
			 global $conn;
                if($CurYear=="" || $CurYear==null)
                        $CurYear=date("Y");

                if($Startyear=="" || $Startyear==null || $EndYear=="" || $EndYear==null )
                {
                        $Startyear=date("Y")-15;
                        $EndYear=date("Y")+5;
                }
                if($CurYear==-1)
                        echo "<option value='' selected>Y</option>";
                while($Startyear!=$EndYear+1)
                {
                        echo "<option value='$Startyear'"; if($Startyear==$CurYear) echo "selected";echo ">$Startyear</option>";
                        $Startyear++;
                }
        }
        /*
                ** By this function you can lock tables.
                ** Write the query that will lock the tables and pass it as the parameter.
                ** Example:  lockTables("LOCK TABLES onlinecustomer WRITE")
                ** On Success it returns true else returns false.
        */
        function lockTables($query)
        {
			 global $conn;
                echo "<!--";
                $ResultSet= mysqli_query($conn, $query);
                echo "-->";
                if($ResultSet)
                        return true;
                return false;
        }
        /*
               ** It will unlock all the tables that were locked.
               ** On Success it returns true else returns false.
        */
        function unlockTables()
        {
			 global $conn;
                if($ResultSet= mysqli_query($conn, "UNLOCK TABLES"))
                        return true;
                return false;
        }



   function pick($table,$field,$cond)
   {
	    global $conn;
	   $tt='';
         if($cond==null){
            $query="Select $field from $table";
            }else{
            $query="Select $field from $table where $cond";

            }
// 			echo $query;
                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error($conn));

                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
         if($tt==null){
            $tt=$qry_row[0];
            }else{
            $tt=$tt.'<BR>'.$qry_row[0];
            }
                }
      //$tt="Select $field from $table where $cond";
        return $tt;
   }


   function dsum($table,$field,$cond)
   {
	    global $conn;
         if($cond==null){
            $query="Select sum($field) from $table";
            }else{
            $query="Select sum($field) from $table where $cond";
            }
                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
            $tt=$qry_row[0];
                }
      //$tt="Select $field from $table where $cond";
        return $tt;
   }



   function dcount($table,$field,$cond)
   {
	    global $conn;
         if($cond==null){
            $query="Select $field from $table";
            }else{
            $query="Select $field from $table where $cond";

            }

                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

      $tt = mysqli_num_rows($ResultSet);
        return $tt;
   }


   function dcolumn($tcol)
      {
		   global $conn;
         for ($i=1;$i<=$tcol;$i++)
            {
               $tt=$tt."<td align='center' class='Header_Cell'><b>Del. Date</b></td>
                  <td align='center' class='Header_Cell'><b>Del. Qty.</b></td>";
            }
        return $tt;
      }
 function crtCombo($ComboName,$TableName,$ID,$Name,$Condition,$selectedValue)
      {
		   global $conn;
                $query=" select
                                $ID as ID,
                                $Name as Name
                         FROM
                                $TableName ".$Condition;

                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

                print("<option value=''>Select a $ComboName</option>\n");
                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
                        $ID=$qry_row["ID"];
                        $Name=$qry_row["Name"];
                        if($ID==$selectedValue)
                              print("<option value='$ID' selected>[$ID][$Name]</option>\n");
                        else
                              print("<option value='$ID'>[$ID][$Name]</option>\n");
                }
      }






function pickdata($table,$field,$cond,$tdtype,$tcl)
   {
	    global $conn;
         if($cond==null){
            $query="Select $field from $table";
            }else{
            $query="Select $field from $table where $cond";
            }
                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());
            $ttt = mysqli_num_rows($ResultSet);

                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
                   $tt=$tt."<td align='center' class='$tdtype'><b> $qry_row[0] </b></td>
                       <td align='center' class='$tdtype'><b> $qry_row[1] </b></td>";

             }

         $tcol=$tcl-$ttt;

         if($tcol>=1){
         for ($i=1;$i<=$tcol;$i++)
            {
               $tt=$tt."<td align='center' class='$tdtype'><b>&nbsp;</b></td>
                  <td align='center' class='$tdtype'><b>&nbsp;</b></td>";
            }
            }
      //$tt="Select $field from $table where $cond";
        return $tt;
   }

      function getEventImagePath()
      {
            return "../../Event_Images/";
      }
      function getArticleImagePath()
      {
            return "../../Article_Images/";
      }

      function getQLDYCImagePath()
      {
            return "../../../QL_DYC_Images/";
      }

      function getExtFileEngPath()
      {
            return "../../../MenuExternalFilesEng/";
      }
      function getExtFileBngPath()
      {
            return "../../../MenuExternalFilesBng/";
      }
      function getQLExtFileEngPath()
      {
            return "../../../QLExternalFilesEng/";
      }
      function getQLExtFileBngPath()
      {
            return "../../../QLExternalFilesBng/";
      }



      function formatMysqlVarChar($strInput)
        {
                $strInput=str_replace("\\","\\\\",$strInput);
                return str_replace("'","''",$strInput);
        }

		function sendSms($phone,$message){

			$ch =curl_init("https://bmpws.robi.com.bd/ApacheGearWS/SendTextMessage?Username=nextech&Password=Next@123&From=8801847169984&To=".$phone."&Message=".$message."");

				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				if(curl_exec($ch) === false)
				{
					//echo 'Curl error: ' . curl_error($ch);
				}
				else
				{
					//echo 'Operation completed without any errors';
				}
		}

    function createQueryCombo($ComboName,$query,$FirstOption,$selectedValue)
      {
		   global $conn;
            $ResultSet= mysqli_query($conn, $query) or die("Invalid query: " . mysqli_error());

            print("<option value='$FirstOption'>Select a $ComboName</option>\n");

            while ($qry_row=mysqli_fetch_array($ResultSet))
            {
                  $ID=$qry_row[0];
                  $Name=$qry_row[1];

                  if($ID==$selectedValue)
                        print("<option value='$ID' selected>$Name</option>\n");
                  else
                        print("<option value='$ID'>$Name</option>\n");
            }
      }

    function getMonth($m){
    if($m==1){
        return "January";
    }else if($m==2){
        return "February";
    }else if($m==3){
        return "March";
    }else if($m==4){
        return "April";
    }else if($m==5){
        return "May";
    }else if($m==6){
        return "June";
    }else if($m==7){
        return "July";
    }else if($m==8){
        return "August";
    }else if($m==9){
        return "September";
    }else if($m==10){
        return "October";
    }else if($m==11){
        return "November";
    }else if($m==12){
        return "December";
    }
}

// create journal
function createJournal($journal,$journalType)
{
	 global $conn;
   if(!is_array($journal) && count($journal)>0){
     return false;
   } else {
     //insert into mas_journal
     $sql = "";
     foreach ($journal['mas_journal'] as $key => $value) {
       if($sql==''){
         $sql .= "insert into mas_journal set ".$key." = '".$value."'";
       } else{
         $sql .= ", ".$key." = '".$value."'";
       }
     }
     //echo $sql."<br />";
     mysqli_query($conn, $sql);
    $journalId= mysqli_insert_id($conn);

     // update latest journal number
     mysqli_query($conn, "update mas_latestjournalnumber set ".$journalType."=(".$journalType."+1)");
     foreach ($journal['trn_journal'] as $trnsectionRow) {
       $sqltrn='';
       foreach ($trnsectionRow as $key => $value) {
         if($sqltrn==''){
           $sqltrn .= "insert into trn_journal set journalid='".$journalId."', ".$key." = '".$value."'";
         } else{
           $sqltrn .= ", ".$key." = '".$value."'";
         }
       }
	   //echo $sqltrn;
       mysqli_query($conn, $sqltrn);

     }
     return $journalId;
   }
}


function LogSave($sql,$userId){
	 global $conn;
		$task="insert into tbl_log (
					task,
					user_id,
					task_time
					) VALUES (
					'".mysqli_real_escape_string($conn,$sql)."',
					'".mysqli_real_escape_string($conn,$userId)."',
					NOW()
					 )";
				//echo $task;
				mysqli_query($conn, $task) or die(mysqli_error($conn));
	} 




function bulkCollectionSave($invoice)
{
	 global $conn;
   if(!is_array($invoice) && count($invoice)>0){
     return false;
   } else {
     //insert into mas_collection
     $sql = "";
     foreach ($invoice['mas_collection'] as $key => $value) {
       if($sql==''){
         $sql .= "insert into mas_collection set ".$key." = '".$value."'";
       } else{
         $sql .= ", ".$key." = '".$value."'";
       }
     }
     //echo $sql."<br />";
     mysqli_query($conn, $sql);
    $collection_id= mysqli_insert_id($conn);
   
	 //insert into trn collection
	 
     foreach ($invoice['trn_collection'] as $trnsectionRow) {
       $sqltrn='';
       foreach ($trnsectionRow as $key => $value) {
         if($sqltrn==''){
           $sqltrn .= "insert into trn_collection set collection_id='".$collection_id."', ".$key." = '".$value."'";
         } else{
           $sqltrn .= ", ".$key." = '".$value."'";
         }
       }
	   //echo $sqltrn;
       mysqli_query($conn, $sqltrn);

     }
     return $collection_id;
   }
}

function PermissionVerification($user,$uid,$types){
	 global $conn;
      $query="SELECT
				  `perm_id`,
				  `user_id`,
				  `id`,
				  `addp`,
				  `editp`,
				  `deletep`,
				  accessall,
				  `pid`
				FROM
				  `_user_permission`
				WHERE
				  `user_id`=".$user." AND `id`=".$uid."";
        $ResultSet= mysqli_query($conn, $query) or die("Invalid query: " . mysqli_error($conn));

        while ($row=mysqli_fetch_array($ResultSet))
        {	
			if($types=='add'){
			return $row['addp'];
			}elseif($types=='edit'){
			return $row['editp'];
			}elseif($types=='delete'){
			return $row['deletep'];
			}elseif($types=='accessall'){
			return $row['accessall'];
			}
			
		}
}

function pickArray($table,$field,$cond)
   {
	    global $conn;
		$tt=array();
         if($cond==null){
            $query="Select $field from $table";
            }else{
            $query="Select $field from $table where $cond";

            }
                $ResultSet= mysqli_query($conn, $query)
                        or die("Invalid query: " . mysqli_error());

                while ($qry_row=mysqli_fetch_array($ResultSet))
                {
        		 array_push($tt,$qry_row[0]);
          
                }
      //$tt="Select $field from $table where $cond";
        return $tt;
   }

function UploadImage($file,$table,$field,$ids,$id,$location){
        
        global $conn;
        $fileinfo = @getimagesize($file['tmp_name']);
       
        // $width = $fileinfo[0];
        // $height = $fileinfo[1];
        
        $allowed_image_extension = array(
                "png",
                "jpg",
                "jpeg"
        );
            // Get image file extension
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Validate file input to check if is not empty
        if (empty($file)) {           
                $response = array(
                        "type" => "error",
                        "message" => "Choose image file to upload."
                );
        }    // Validate file input to check if is with valid extension
        else if (! in_array($file_extension, $allowed_image_extension)) {
                $response = array(
                        "type" => "error",
                        "message" => "Upload valiid images. Only PNG and JPEG are allowed."
                );
        }    // Validate image file size
        else if (($file['size'] > 2000000)) {
                $response = array(
                        "type" => "error",
                        "message" => "Image size exceeds 2MB"
                );
        }    // Validate image file dimension
        /*else if ($width > "300" || $height > "200") {
                $response = array(
                        "type" => "error",
                        "message" => "Image dimension should be within 300X200"
                );
        }*/
        else {
               

                
               $target = $location . basename($file['name']);
               $new_filename=$file['name'];

                if (move_uploaded_file($file['tmp_name'], $target)) {

                   $Usql="UPDATE ".$table." SET
                        ".$field." ='".mysqli_real_escape_string($conn,$new_filename)."'
                        WHERE  ".$ids."='$id'";

                        mysqli_query($conn,$Usql) or die(mysqli_error($conn));
                        
                        $response = array(
                                "type" => "success",
                                "message" => "Image uploaded successfully."
                        );
                } else {
                        $response = array(
                                "type" => "error",
                                "message" => "Problem in uploading image files."
                        );
                }
        }

        //return $response;
        
}





/*
	Copy an image to a destination file. The destination
	image size will be $w X $h pixels
*/
function copyImage($srcFile, $destFile, $w, $h, $quality = 75)
{
    $tmpSrc     = pathinfo(strtolower($srcFile));
    $tmpDest    = pathinfo(strtolower($destFile));
    $size       = getimagesize($srcFile);

    if ($tmpDest['extension'] == "gif" || $tmpDest['extension'] == "jpg")
    {
       $destFile  = substr_replace($destFile, 'jpg', -3);
       $dest      = imagecreatetruecolor($w, $h);
       imageantialias($dest, TRUE);
    } elseif ($tmpDest['extension'] == "png") {
       $dest = imagecreatetruecolor($w, $h);
       imageantialias($dest, TRUE);
    } else {
      return false;
    }

    switch($size[2])
    {
       case 1:       //GIF
           $src = imagecreatefromgif($srcFile);
           break;
       case 2:       //JPEG
           $src = imagecreatefromjpeg($srcFile);
           break;
       case 3:       //PNG
           $src = imagecreatefrompng($srcFile);
           break;
       default:
           return false;
           break;
    }

    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);

    switch($size[2])
    {
       case 1:
       case 2:
           imagejpeg($dest,$destFile, $quality);
           break;
       case 3:
           imagepng($dest,$destFile);
    }
    return $destFile;

}

/*
	Create the paging links
*/


function convertImageToWebP( $source, $destination, $quality = 50 ) {
  $extension = pathinfo( $source, PATHINFO_EXTENSION );

  if ( $extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' )
    $image = imagecreatefromjpeg( $source );
  elseif ( $extension == 'gif' )
    $image = imagecreatefromgif( $source );
  elseif ( $extension == 'png' )
    $image = imagecreatefrompng( $source );

  return imagewebp( $image, $destination, $quality );

}

function productImagsUpload( $location, $category, $productName, $file, $table, $pro_id ) {
  global $conn;
	$w=720;
	$h=660;
	$quality=80;
  $general = $location . '/' . $category . '/' . $productName . '/general';
  $comm = $location . '/' . $category . '/' . $productName . '/comm';
  $mobile = "{$location}/{$category}/{$productName}/mobile";
  $tab = "{$location}/{$category}/{$productName}/tab";
  if ( !file_exists( $general ) ) {
    mkdir( $general, 0777, true );
  }
  if ( !file_exists( $comm ) ) {
    mkdir( $comm, 0777, true );
  }
  if ( !file_exists( $mobile ) ) {
    mkdir( $mobile, 0777, true );
  }
  if ( !file_exists( $tab ) ) {
    mkdir( $tab, 0777, true );
  }

  $total = count( $file[ 'name' ] );
  for ( $i = 0; $i < $total; $i++ ) {
    $tmpFilePath = $file[ 'tmp_name' ][ $i ];
    if ( $tmpFilePath != "" ) {

      $filename = $file[ 'name' ][ $i ];
      $extension = end( explode( ".", $filename ) );
      $newfilename = md5(rand() * time()) . "." . $extension;
      $newFilePath_general = $general . "/" . $newfilename;
      $newFilePath = $comm . "/" . $newfilename;
      $newFilePath_mobile = $mobile . "/" . $newfilename;
      $newFilePath_tab = $tab . "/" . $newfilename;
      if ( copy( $tmpFilePath, $newFilePath_general ) ) {}
	  copyImage($newFilePath_general, $newFilePath_general, $w, $h, $quality);
      convertImageToWebP( $newFilePath_general, $newFilePath, $quality = 60 );
      convertImageToWebP( $newFilePath_general, $newFilePath_mobile, $quality = 40 );
      convertImageToWebP( $newFilePath_general, $newFilePath_tab, $quality = 50 );
      
      $sql = "INSERT 
                    INTO {$table} (
                            product_id,
                            pro_img_name
                    ) 
                    VALUES (
                            '$pro_id',
                            '$newfilename'
                    )";
      $runSql = mysqli_query( $conn, $sql )or die( mysqli_error( $conn ) );
    }
  }
}
   
        
?>
