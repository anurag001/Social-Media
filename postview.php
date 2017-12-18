<?php
	include('class.php');
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$userid = $_SESSION['user_id'];
	}
	$id = $_POST['id'];
	
	$ob->postview($id,$userid);
?>