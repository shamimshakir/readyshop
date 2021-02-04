<?php 
include "../../library/dbconnect.php";
include "../../library/library.php";
include "pages/sms_log/pagination.php";

if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
		$actionfunction = $_REQUEST['actionfunction'];
	$limit=20;
	   call_user_func($actionfunction,$_REQUEST,$con,$limit,$adjacent);
	}
function showData($data,$con,$limit,$adjacent){
	 global $conn;
	//echo $limit;
	  $page = $data['page'];
	  $cond='';
session_start();


$cond='';

if(isset($_REQUEST['txtfromopen_date']) && $_REQUEST['txttoopen_date'] !=NULL){
 	$pieces = explode("/",$_REQUEST['txtfromopen_date']);
 	$txtfromopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
 	$pieces = explode("/",$_REQUEST['txttoopen_date']);
 	$txttoopen_date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
if($cond!=NULL){
	$cond.=" AND (DATE_FORMAT(tbl_sms_log.date_time,'%Y-%m-%d')>='".$txtfromopen_date."' AND DATE_FORMAT(tbl_sms_log.date_time,'%Y-%m-%d')<='".$txttoopen_date."')";
	}else{$cond=" WHERE (DATE_FORMAT(tbl_sms_log.date_time,'%Y-%m-%d')>='".$txtfromopen_date."' AND DATE_FORMAT(tbl_sms_log.date_time,'%Y-%m-%d')<='".$txttoopen_date."')";}
 }

 
	
if($page==1){
	   $start = 0;
	  }
	  else{
	  $start = ($page-1)*$limit;
	  }
	
		$count_query   = mysqli_query($conn, "SELECT COUNT(*) AS numrows FROM  `tbl_sms_log`
							 $cond");
		$row     = mysqli_fetch_array($count_query);
		 $Countrow = $row['numrows'];	
			
				$SeNTlist1="SELECT							  
							  `number`,
							  `sms_body`,
							  `return_message`,
							  `from_api`,
							  `snder_id`,
							  `sms_status`,
							  `date_time`,							 
							  tbl_sms_setup.name as sms_name
							FROM
							  `tbl_sms_log`
							
							
							LEFT JOIN tbl_sms_setup ON tbl_sms_setup.id=tbl_sms_log.from_api
							$cond order by date_time desc LIMIT $start,$limit ";
	//echo $SeNTlist1;
		
      $rSeNTlist1=mysqli_query($conn, $SeNTlist1) or die();
      $numrows=mysqli_num_rows($rSeNTlist1);
      if($numrows>0)
      {
       $i=0;
            echo "
            <table id='result_tbl' border='1' class='table table-bordered '   style=\"width:100%\">
            <tr>
				<th align='center' class='title_cell_e' >Mobile No</th>
				<th align='center' class='title_cell_e'  >Return Message</th>
				<th align='center' class='title_cell_e'  >SMS Status</th>
				<th align='center' class='title_cell_e'  >Send Time</th>
				<th align='center' class='title_cell_e'  >Api name</th>
            </tr>
            ";
            while($rows=mysqli_fetch_array($rSeNTlist1))
            {
            extract($rows);
                   echo"
                       <TR >
						<td class='$class' align='left' >
							<font class='Eoutput'>$number</font>
						</td>
						
						<td class='$class' align='left'  >
							<font class='Eoutput'><code>".$return_message."</code></font>
						</td>
						<td class='$class' align='left'  >
							<font class='Eoutput'>$sms_status</font>
						</td>
						<td class='$class' align='left'  >
							<font class='Eoutput'>$date_time</font>
						</td>
						<td class='$class' align='right'  >
							<font class='Eoutput'> $sms_name</font>
						</td>
						</TR>
                        ";
					  $exinfo='';
					  $i++;
            }
			echo"</table> </div>";
			echo '<div class=\'col-sm-4 pl0 pr0\'>Showing '.number_format($start+1).' to ' .number_format($start+$i-1).  ' of '.number_format($Countrow).' entries </div>';		
	echo "<div class=\"col-sm-8 pl0 pr0\"><nav aria-label=\"Page navigation\">";
   //  pagination($limit,$adjacent,$Countrow,$page);
	 echo "</nav></div><br>";
      }else{
	  echo "<center><b> Data Not Found.....</b>";
	  }
 
	}
	

?>
