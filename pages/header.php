<?php
include "../../library/dbconnect.php";
include "../../library/library.php";
session_start();
if (!isset($_SESSION) || empty($_SESSION)){
    header("Location: login.php");
    exit();
}