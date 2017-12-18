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
	$qid=$_POST['qid'];
	$count = $ob->count_quiz_question($qid);
	echo '<strong>'.$count.' questions saved</strong>';
?>