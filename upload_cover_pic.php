<?php
	include('class.php');
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$id = $_SESSION['user_id'];
	}
	global $pdo;
	$location='./uploads/'.$id.'/';
	if(isset($_FILES["file"]["name"]) and !empty($_FILES["file"]["name"]))
	{
		$valext = array("jpeg","png","jpg");
		$temp = explode(".",$_FILES["file"]["name"]);
		$file_ext = end($temp);
		
		if((($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png")) && ($_FILES["file"]["size"] < 2000000))
		{
			if($_FILES["file"]["error"]>0)
			{
				echo "Return Code: ".$_FILES["file"]["error"]."<br/><br/>";
			}
			else
			{
				if(file_exists($location.$_FILES["file"]["name"]))
				{
					echo $_FILES["file"]["name"]." already exists";
				}
				else{
					$source = $_FILES["file"]["tmp_name"];
					
					$name = time();
					$code = md5($id);
					$name = $name.$code;
					$target = $location.$name;
					
					$query = $pdo->prepare("update user set cover_pic = ? where user_id = ?");
					$query->bindParam(1,$name);
					$query->bindParam(2,$id);
					if($query->execute() and move_uploaded_file($source,$target))
					{
						echo '<center><span class="alert alert-success">Uploaded successfully</span></center>';
					}
					else
					{
						echo '<center><span class="alert alert-danger text-center">Some problems are facing while uploading.Please try again.</span></center>';
					}
					
					
				}
			}
		}
		else
		{
			echo '<span class="alert alert-danger">Invalid file size or type,See file must be less than 2 Mb</span>';
		}
	}
?>