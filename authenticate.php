<?php
session_start();
include "library/dbconnect.php";
include 'library/library.php';

if(isset($_POST['user_email'])&& $_POST['user_email']!="" || isset($_POST['user_pass']) && $_POST['user_pass']!=""){
    $email = $_POST['user_email'];
	$pass = $_POST['user_pass'];
        $member_query=" SELECT *
			FROM users
			WHERE users.user_email='".$email."'";     
        $rset = mysqli_query($conn, $member_query) or die(mysqli_error($conn));
		$row = mysqli_fetch_array($rset);

        if(!$row) {
            header("Location: login.php");
            exit;
        }else{
			extract($row);
			if(($user_email==$email) && ($user_pass==$pass) && ($status == 1) ) {
				ini_set('session.gc_maxlifetime', 7200);
				$_SESSION['SUserID']= $user_id;
				$_SESSION['SUserEmail']= $user_email;
				$_SESSION['comp_id']= $comp_id;
				$_SESSION['user_profile_id']=$user_profile_id;
				
				if(isset($_POST['remember'])) {
					setcookie('user_email',$title, time() + (60*60*24*30)); //30 days
					setcookie('user_pass',$user_pass, time() + (60*60*24*30)); //30 days
				}
				header("Location: index");
				exit;
			}else{
				header("Location: login.php");
        		exit;
			}
        }
    }else{
		header("Location: login.php");
        exit;	
	}
?>
