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
	$apid = $_POST['apid'];
	global $pdo;
	$query = $pdo->prepare("delete from academy_post where apid = ?");
	$query->bindParam(1,$apid);
	$query->execute();
	

?>