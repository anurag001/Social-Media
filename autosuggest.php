<?php
	include_once('class.php');
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
	$keywords = preg_split("/[\s,]+/", $str);
		for($i=0;$i<count($keywords);$i++)
		{
			if (preg_match("/@/", $keywords[$i])) 
			{
				$pid = $keywords[$i];
				$pid = substr($pid,1);
				$sugg = $pdo->prepare("select * from user where username like '%$pid%'");
				if($sugg->execute())
				{
					while($row = $sugg->fetch(PDO::FETCH_OBJ))
					{
							$location='./uploads/'.$row->user_id.'/';
							echo '<li style="border:1px solid #EAEDED;"><div class="row"><span class="col-xs-3"><img src='.$location.$row->profile_pic.' height="42" width="42"/></span><span style="color:#8899a6; class="col-xs-9">@'.$row->username.'</br><span style="color:#454545;">'.$row->firstname.' '.$row->lastname.'</span></span></div></li>';
					}
				}
				
			}
		}

?>