<?php
	include('class.php');
	ob_start();
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$user_id = $_SESSION['user_id'];
	}
	$id=$_POST['id'];
	$aid=$_POST['aid'];
	$ob->pull_class_pic($id,$aid);
?>
