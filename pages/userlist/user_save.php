<?php
include('../header.php');

$mode =              $_REQUEST['mode'];
session_start();
$SUserID = $_SESSION['SUserID'];
$Scomp_id= $_SESSION['comp_id'];

$user_id=$_REQUEST['user_id'];
$status=$_REQUEST['status'];
$user_name=$_REQUEST['user_name'];
$user_pass=$_REQUEST['user_pass'];
$user_email=$_REQUEST['user_email'];
$user_profile_id=$_REQUEST['user_profile_id'];
$user_status_id=$_REQUEST['user_status_id'];
//$comp_id=$_REQUEST['comp_id'];
$mobile=$_REQUEST['mobile'];
$business_type_id=$_REQUEST['business_type_id'];


$company_name=$_REQUEST['company_name'];
$real_name=$_REQUEST['real_name'];
$trade_license=$_REQUEST['trade_license'];
$membership_no=$_REQUEST['membership_no'];
$comp_address=$_REQUEST['comp_address'];



$get_user=pick("users","user_id","user_name='$user_name'");
if($get_user>0 && $mode == 1){
    echo "User Name Already Exist enter a New User name";
    exit;
}
if($user_profile_id=='4'){
    $get_gentcomm=pick("tbl_office","agent_comrate","office_id='1'");
}else{
    $get_gentcomm=0;
}
if($user_profile_id=='5'){
    $get_onucomm=pick("tbl_office","onu_comrate","office_id='1'");
}else{
    $get_onucomm=0;
}





if ($mode == 1)
{
    $Asql = "INSERT INTO users (	user_name,
											user_pass,
											user_email,
											status,
											user_profile_id,
											user_status_id,										
											business_type_id,
											agent_comrate,
											onu_comrate,
											company_name,
											real_name,
											trade_license,
											membership_no,
											comp_address,
											mobile,
											entry_date
											) VALUES (
											'$user_name',
											'$user_pass',
											'$user_email',
											'$status',
											'$user_profile_id',
											'$user_status_id',
											'$business_type_id',
											'$get_gentcomm',	
											'$get_onucomm',
											'$company_name',
											'$real_name',
											'$trade_license',
											'$membership_no',
											'$comp_address',
											'$mobile',
											NOW()
											)";
    mysqli_query($conn,$Asql) or die(mysqli_error());
    $last_id = mysqli_insert_id($conn);
    if($user_profile_id=='5' || $user_profile_id=='2'){
        mysqli_query($conn, "update users set comp_id=$last_id where user_id=$last_id") or die(mysqli_error());
    }


    if($Asql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }

}else if ($mode == 2){

    $Usql = mysqli_query($conn, "UPDATE users 
								SET 	user_name = '$user_name',
										user_pass = '$user_pass',
										user_email = '$user_email', 
										status = '$status', 
										user_profile_id = '$user_profile_id',
										user_status_id='$user_status_id',
										business_type_id='$business_type_id',
										agent_comrate='$agent_comrate',
										onu_comrate='$onu_comrate',
										company_name='$company_name',
										real_name='$real_name',
										trade_license='$trade_license',
										membership_no='$membership_no',
										comp_address='$comp_address',
										mobile='$mobile',
										update_by = '$SUserID',
										update_date = NOW() 										
								WHERE user_id  = '$user_id' ");


    if($Usql){
        echo "Data successfully updated";
    }else{
        echo "Failed to update data";
    }


}
?>