<?php
	include_once('class.php');
	$val = $ob->loggedin();
	
	if($val == true)
	{
		session_destroy();
	}
	echo '<script>window.location.href = "./main.php";</script>';
?>