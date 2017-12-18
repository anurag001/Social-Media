<?php
if(isset($_POST['email']) and !empty($_POST['email']))
{
	include('class.php');
	
	$email=$_POST['email'];
	
	$ob->check_email($email);
}

?>