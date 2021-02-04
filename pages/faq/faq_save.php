<?php
include "../../library/dbconnect.php";

$mode =              $_REQUEST['mode'];
$id =       $_REQUEST['id'];
$faq_question =       $_REQUEST['faq_question'];
$faq_answer =               $_REQUEST['faq_answer'];
$status=$_REQUEST['status'];

if ($mode == 1) {
    $sql = "INSERT 
                INTO tbl_faq (
                    faq_question,
                    faq_answer,
                    active_status
                ) 
                VALUES (
                    '$faq_question',
                    '$faq_answer',
                    $status
                )";

    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}else if ($mode == 2){
    $sql = mysqli_query($conn, "UPDATE tbl_faq
            SET
                faq_question = '$faq_question',
                faq_answer = '$faq_answer',
                active_status='$status'
            WHERE id  = '$id' ");
    if($sql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }
}
?>