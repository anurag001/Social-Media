<?php
	include('class.php');
	ob_start();
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$user_id = $_SESSION['user_id'];
	}
	
	global $pdo;
	$str = trim(strtolower($_POST['str']));
	
	$query = $pdo->prepare("select * from topic where topic_name like '%$str%'");
	
	if($query->execute())
	{
					while($row = $query->fetch(PDO::FETCH_OBJ))
					{
							$location='./uploads/'.$row->created_by.'/';
							echo '<li style="border:1px solid #EAEDED;"><div class="row"><span class="col-xs-3"><img src='.$location.$row->topic_pic.' height="42" width="42"/></span><span style="color:#8899a6; class="col-xs-9">suscriber '.$row->suscriber.'</br><span style="color:#454545;">'.ucfirst($row->topic_name).'</span></span></div></li>';
					}
	}
										
?>