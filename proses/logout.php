<?php
	session_start();
	$destroy=session_destroy();
	setcookie('username', '', 0, '/');
	if($destroy=true){
		header("location: ../index.php");
	}
?>