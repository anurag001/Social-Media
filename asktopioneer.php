<?php
	
	include_once('class.php');
	$from = $_POST['from'];
	$to = $_POST['to'];
	$text=$_POST['text'];
	$ob->ask_to_pioneer($from,$text);

?>