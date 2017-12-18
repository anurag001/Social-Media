<?php
include('dbcon.php');
	global $pdo;
		
		if(isset($_POST['loguser']) and isset($_POST['logpass']))
		{
			if(!empty($_POST['loguser']) and !empty($_POST['logpass']))
			{
				$user = $_POST['loguser'];
				$pass = $_POST['logpass'];
				$query = $pdo->prepare("select user_id from user where username= ? and password = ?");
				$query->bindParam(1,$user);
				$query->bindParam(2,$pass);
				$query->execute();
				if($query->rowCount()>0)
				{
					$row = $query->fetch(PDO::FETCH_OBJ);
					session_start();
					$_SESSION['user_id'] = $row->user_id;
                
					?><script>window.location.href = "./index.php";</script><?php
				
                    
				}
				else
				{
					echo '<span style="color:red; padding:2px;">Invalid Username/Password.Try Again.</span>';
				}
			}
			else
			{
				echo '<span style="color:red; padding:2px;">Please provide both fields.</span>';
			}
		}
?>