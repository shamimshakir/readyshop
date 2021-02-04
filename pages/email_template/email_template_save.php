<?php
include "../../library/dbconnect.php";

$mode =              $_REQUEST['mode'];
$id =          $_REQUEST['id'];
$title =          $_REQUEST['title'];
$subject =          $_REQUEST['subject'];
 $page_content =     $_POST['page_content'];


if ($mode == 1) {
    $sql = "INSERT INTO email_template ( title, subject,body) VALUES ( '$title', '$subject','".mysqli_real_escape_string($conn,$page_content)."'		)";

    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
      $sql = "UPDATE email_template 
            SET 	
            title = '$title',
            subject= '$subject',							
            body = '".mysqli_real_escape_string($conn,$page_content)."'					
            WHERE email_template_id  = '$id' ";
    $res = mysqli_query($conn, $sql);
    if($res){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>