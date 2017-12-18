<?php

	$dir  = './';
	$files1 = scandir($dir);
	foreach ($files1 as $value) 
	{
		if(preg_match('/php*$/', $value))
		{
			$file  = $value;
			file_put_contents($file,str_replace("include_once('class.php')","include_once('class.php')",file_get_contents($file)));

			$handle = fopen($value,'r+');
			$cont = fread($handle,60);
			echo htmlspecialchars($cont)."<br><hr><br>";
			// foreach ($handle as $op) 
			// {
			// 	# code...
			// 	if(preg_match("/include_once('class.php')/", $op))
			// 	{
			// 		echo $op." ".$value."<br>";
			// 	}
			// }

		}
	}


?>