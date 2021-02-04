<?php
	session_start();
	session_unset();
	session_destroy();
//	unset($_COOKIE['username']);
//    unset($_COOKIE['password']);
    setcookie('username', null, time()-3600);
    setcookie('password', null, time()-3600);
    header("Location: login.php");
	exit;
?>
