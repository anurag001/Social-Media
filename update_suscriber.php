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
	global $pdo;
	$tid = $_POST['tid'];
	$count = $pdo->prepare("select suscriber from topic where topic_id = ?");
	$count->bindParam(1,$tid);
	$count->execute();
	$row = $count->fetch(PDO::FETCH_OBJ);
	$count = $row->suscriber;
	$count=$count+1;
	$query = $pdo->prepare("update topic set suscriber=? where topic_id=?");
	$query->bindParam(1,$count);
	$query->bindParam(2,$tid);
	if($query->execute()==true)
	{
		echo $count;
	}
	else
	{
		echo $count;
	}
?>