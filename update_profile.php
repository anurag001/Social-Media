<?php


?><?php
	include('class.php');
	
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$user_id = $_SESSION['user_id'];
	}
	
	$status = $_POST['user_status'];
	$email = $_POST['user_email'];
	$school = $_POST['user_school'];
	$organization = $_POST['user_organization'];
	$hobbies = $_POST['user_hobbies'];
	$education = $_POST['user_education'];
	$hometown = $_POST['user_hometown'];
	$livesin = $_POST['lives_in'];
	
	$ob->update_profile($status,$email,$school,$organization,$hobbies,$education,$hometown,$livesin,$user_id);
	

?>