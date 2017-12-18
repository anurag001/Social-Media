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
	
	$postdata = $_POST['postdata'];
	$location='./uploads/'.$id.'/';
	
	if(isset($_FILES["file"]["name"]) and !empty($_FILES["file"]["name"]))
	{
		$valid_extension = array("jpeg","png","jpg");
		$temp = explode(".",$_FILES["file"]["name"]);
		$file_extension = end($temp);
		
		if((($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg")) && ($_FILES["file"]["size"] < 2000000))
		{
			if($_FILES["file"]["error"]>0)
			{
				echo "Return Code: ".$_FILES["file"]["error"]."<br/><br/>";
			}
			else
			{
				if(file_exists($location.$_FILES["file"]["name"]))
				{
					echo '<span style="color:red">'.$_FILES["file"]["name"]." already exists</span>";
				}
				else{
					$source = $_FILES["file"]["tmp_name"];
					$target = $location.$_FILES["file"]["name"];
					move_uploaded_file($source,$target);
					
					$ob->self_post_pic($id,$postdata,$_FILES["file"]["name"]);
				}
			}
		}
		else
		{
			echo '<span style="color:red">Invalid file size/extension!See file must be jpg/jpeg/png and less than 2Mb</span>';
		}
	}
	else
	{
		$ob->self_post($id,$postdata);
	}

?>