<?php
include('../header.php');

$mode=$_REQUEST['mode'];

$user_profile_id=$_REQUEST['user_profile_id'];
$profile_name=$_REQUEST['profile_name'];


if ($mode == 1)
{
    $Asql = "INSERT INTO user_profile (	profile_name
												) VALUES (
												'$profile_name'
												)";
    mysqli_query($conn,$Asql) or die(mysqli_error());


    if($Asql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }

}else if ($mode == 2){

    $Usql = mysqli_query($conn, "UPDATE user_profile 
								SET 	profile_name = '$profile_name'								
								WHERE user_profile_id  = '$user_profile_id' ");


    if($Usql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }


}

?>