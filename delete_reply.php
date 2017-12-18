<?php
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
	$rid = $_POST['rid'];
	$qid = $_POST['qid'];
	global $pdo;
	$query = $pdo->prepare("delete from reply where reply_id = ?");
	$query->bindParam(1,$rid);
	$query->execute();
	$two = 2;
	$ob->reply_count($qid,$two);	

?>