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
	$likes = $_POST['str'];
	$query = $pdo->prepare("update user set whatilike=? where user_id=?");
	$query->bindParam(1,$likes);
	$query->bindParam(2,$user_id);
	if($query->execute())
	{
		echo '<strong><span style="color:green;margin-top:15px;">Saved successfully</span></strong>';
	}
	else
	{
		echo '<strong><span style="color:red;margin-top:15px;">Sorry! try again</span></strong>';
	}
?>