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
	$rid = $_POST['rep_id'];
	$rep_by = $_POST['rep_by'];
	$rep_to = $_POST['rep_to'];
	
	global $pdo;
			
			$del_query = $pdo->prepare("delete from rate where reply_id = ? and rate_by = ? and rate_to = ?");
			$del_query->bindParam(1,$rid);
			$del_query->bindParam(2,$rep_by);
			$del_query->bindParam(3,$rep_to);
			$del_query->execute();
			$sel_query = $pdo->prepare("select rating from reply where reply_id=?");
			$sel_query->bindParam(1,$rid);
			$sel_query->execute();
			$raw_data = $sel_query->fetch(PDO::FETCH_OBJ);
			$c =$raw_data->rating;
			$c=$c-1;
			$update_query = $pdo->prepare("update reply set rating = ? where reply_id = ?");
			$update_query->bindParam(1,$c);
			$update_query->bindParam(2,$rid);
			$update_query->execute();
			
?>