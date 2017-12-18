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
	$replyby = $_POST['replyby'];
	$replyto = $_POST['replyto'];
	//$reply = str_replace('  ', ' &nbsp;', $_POST['reply']);  
	//$reply = strip_tags($reply);
	$reply=$_POST['reply'];

	//$reply = $_POST['reply'];
	$one = 1;
	$ob->reply_count($qid,$one);	
	$ob->answer_to_question($reply,$qid,$replyby,$replyto);
?>
