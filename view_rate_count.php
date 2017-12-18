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
	
		$rid = $_POST['reply_id'];
		$query = $pdo->prepare("select * from reply where reply_id =?");
		$query->bindParam(1,$rid);
		$query->execute();
		$row = $query->fetch(PDO::FETCH_OBJ);
		if($row->rating>0)
		{
			echo $row->rating;
		}
		
	
?>