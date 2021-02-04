<?php
include( '../header.php' );


$mode = $_POST['mode'];
$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$address = $_POST['address'];
$business_type = $_POST['business_type'];
$domain = $_POST['domain'];
$req_date = $_POST['req_date'];
$sub_domain = $_POST['sub_domain'];

if ($mode == 1) {
    if(!empty($sub_domain)){
        $result = mysqli_query($conn, "SELECT * FROM tbl_shop_user WHERE sub_domain = '$sub_domain' ");
        if(mysqli_num_rows($result) > 0){
            echo '3';
            exit();
        }
    }

    if(!empty($domain)){
        $result = mysqli_query($conn, "SELECT * FROM tbl_shop_user WHERE domain = '$domain' ");
        if(mysqli_num_rows($result) > 0){
            echo '4';
            exit();
        }
    }

    if(empty($domain) && empty($sub_domain)){
        echo '2';
        exit();
    }

    
    $sql = "INSERT 
        INTO tbl_shop_user (
            name,
            email,
            mobile,
            address,
            business_type,
            domain,
            req_date,
            sub_domain
        ) 
        VALUES (
            '$name',
            '$email',
            '$mobile',
            '$address',
            '$business_type',
            '$domain',
            '$req_date',
            '$sub_domain'
        )";
    $runSql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($runSql){
        echo "Data successfully added";
    }else{
        echo "Failed to add data";
    }
}
// else if ($mode == 2){
//     echo $sql = mysqli_query($conn, "UPDATE tbl_shop_user 
//         SET     
//             firstname = '$firstname',                           
//             lastname = '$lastname',                           
//             cl_code = '$cl_code',     
//             street = '$street',           
//             city = '$city',             
//             country = '$country',             
//             phone = '$phone',              
//             email = '$email',              
//             user_regdate = '$user_regdate',              
//             varified_status = '$varified_status',              
//             business_type = '$business_type',              
//             domain = '$domain',              
//             req_date = '$req_date',              
//             sub_domain = '$sub_domain',                         
//             address = '$address'              
//         WHERE cl_id  = '$cl_id' ");

//     if($sql){
//         echo "Data successfully updated";
//     }else{
//         echo "Failed to update data";
//     }
// }
?>