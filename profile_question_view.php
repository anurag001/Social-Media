<?php
	include('class.php');
	
	$id = $_POST['id'];
	$userid = $_POST['userid'];
	$ob->postview_question($id,$userid,1,2);
?>