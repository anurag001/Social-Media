<?php
	include_once('class.php');
	include_once('dbcon.php');
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$user_id = $_SESSION['user_id'];
	}
	$qid = $_POST['qid'];
	$ob->answer_view($qid,$user_id);
?>