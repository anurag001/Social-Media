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
	$qid = $_POST['qid'];
	$data = $_POST['data'];
	
	global $pdo;
	$query = $pdo->prepare("update post set post_data = ? where post_id = ?");
	$query->bindParam(1,$data);
	$query->bindParam(2,$qid);
	if($query->execute())
	{
		echo '<span class="alert alert-success">Successfully updated</span>';
	}
	else
	{
		echo '<span class="alert alert-danger">Problem in updation</span>';
	}
	
	
	
?>
