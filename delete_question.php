<?php
	include('class.php');
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$id = $_SESSION['user_id'];
	}
	
	$qid = $_POST['qid'];
	
	if($ob->confirm_post_owner($qid,$id))
	{
		$ob->delete_question($qid);
	}
	else
	{
		echo '<span style="color:red;">You don\'t have permission to delete this post</span>';
	}
	
	
?>
		