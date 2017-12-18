<?php
	
	include('class.php');
	$from = $_POST['from'];
	$to = $_POST['to'];
	$ob->unfollow($from,$to);

?>