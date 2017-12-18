<?php
	include('class.php');
	$val = $ob->loggedin();
	if($val == true)
	{
		$query = $_GET['query'];
		$ob->pioneer_search($query);
	}
	else
	{
		header('location:main.php');
	}		
	
	
?>