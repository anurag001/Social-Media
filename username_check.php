<?php
if(isset($_POST['username']) and !empty($_POST['username']))
{
	include('class.php');
	
	$email=$_POST['username'];
	
	$ob->check_username($email);
}

?>