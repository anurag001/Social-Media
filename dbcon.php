<?php
	try{
		$pdo=new PDO("mysql:host=localhost;dbname=pioneer",'root','');
	}
	catch(PDOException $ex)
	{
		echo $ex->getMessage();
		die();
	}

?>