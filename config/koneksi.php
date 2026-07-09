<?php
	session_start();
	error_reporting(E_ERROR || E_PARSE);
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$servername="localhost";
	$username="root";
	$password="";

	$conn=mysqli_connect($servername,$username,$password); 
?>