<?php
include( '../header.php' );
$mode = $_POST['mode'];
$id = $_POST['id'];
$question = $_POST['question'];
$video = $_POST['video'];

if ($mode == 1) {
        $sql = "INSERT 
            INTO user_guide (
                question,
                video
            ) 
            VALUES (
                '$question',
                '$video'
            )";
        $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        if($runSql){
            echo "Data successfully added";
        }else{
            echo "Failed to add data";
        }
}
else if ($mode == 2){
        $query="UPDATE user_guide 
                SET     
                    question = '$question',  
                    video = '$video'               
                WHERE id  = '$id' ";
        $sql = mysqli_query($conn,$query );
        if($sql){
            echo "Data successfully updated";
        }else{
            echo "Failed to update data";
        }
}
?>
