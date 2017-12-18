<?php
	include('class.php');
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$id = $_SESSION['user_id'];
	}
	
	$us_id = $_POST['id'];
	$location='./uploads/'.$us_id.'/';
	$ob->pull_cover_pic($us_id);
?>