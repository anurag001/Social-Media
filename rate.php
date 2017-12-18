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
			
			
			$ins_query = $pdo->prepare("insert into rate(reply_id,rate_by,rate_to) values(?,?,?)");
			$ins_query->bindParam(1,$rid);
			$ins_query->bindParam(2,$rep_by);
			$ins_query->bindParam(3,$rep_to);
			$ins_query->execute();
			$sel_query = $pdo->prepare("select rating from reply where reply_id=?");
			$sel_query->bindParam(1,$rid);
			$sel_query->execute();
			$raw_data = $sel_query->fetch(PDO::FETCH_OBJ);
			$c =$raw_data->rating;
			$c=$c+1;
			$update_query = $pdo->prepare("update reply set rating = ? where reply_id = ?");
			$update_query->bindParam(1,$c);
			$update_query->bindParam(2,$rid);
			$update_query->execute();
			
?>