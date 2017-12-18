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
	$location='./uploads/'.$id.'/';

	if(!empty($_POST['name']) && !empty($_FILES["topic_pic"]["name"]) && !empty($_POST['desc']))
	{
		$topicname = $_POST['name'];
		$desc = $_POST['desc'];
		
		if((($_FILES["topic_pic"]["type"] == "image/jpeg") || ($_FILES["topic_pic"]["type"] == "image/png") || ($_FILES["topic_pic"]["type"] == "image/jpg")) && ($_FILES["topic_pic"]["size"] < 2000000))
		{
			$ext = $_FILES["topic_pic"]["type"];
			if($_FILES["topic_pic"]["error"]>0)
			{
				echo "Return Code: ".$_FILES["topic_pic"]["error"]."<br/><br/>";
			}
			else
			{
				if(file_exists($location.$_FILES["topic_pic"]["name"]))
				{
					echo '<span style="color:red">'.$_FILES["topic_pic"]["name"]." already exists</span>";
				}
				else
				{
					$source = $_FILES["topic_pic"]["tmp_name"];
					$name = md5(time());
					$code = md5($id);
					$name = $name.$code;
					$target = $location.$name;
					move_uploaded_file($source,$target);
					
					global $pdo;
					$query = $pdo->prepare("insert into topic(topic_name,topic_pic,topic_desc,created_by) values(?,?,?,?)");
					$query->bindParam(1,$topicname);
					$query->bindParam(2,$name);
					$query->bindParam(3,$desc);
					$query->bindParam(4,$id);
					if($query->execute())
					{
						$count = $ob->getfield('topic',$id);
						$count=$count+1;
						$update = $pdo->prepare("update user set topic = ? where user_id = ?");
						$update->bindParam(1,$count);
						$update->bindParam(2,$id);
						$update->execute();
						echo '<span class="alert alert-success">Topic is added.</span>';
					}
					else
					{
						echo '<span class="alert alert-warning">Please try again.</span>';
					}
				

			//--------------------------Scaling------------------------------
			
				if($ext == "image/jpeg" || $ext == "image/jpg"){
					$src = imagecreatefromjpeg($target);
				}
				else if($ext == "image/png"){
					$src = imagecreatefrompng($target);
				}

					
					list($width,$height)=getimagesize($target);
					$newwidth="";
					$newheight="";
					$ratio = $width/$height;
					if($width/$height > 1.163)
					{
	
						$newheight = 370;
						$newwidth = round($newheight*$ratio);
					}
					else{
	
						$newwidth = 450;
						$newheight = round($newwidth/$ratio);
					}

					$tmp=imagecreatetruecolor($newwidth,$newheight);
					imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);

					$filename = $target;

					imagejpeg($tmp,$filename,100);

					imagedestroy($src);	
					imagedestroy($tmp);

			//---------------------------------------------

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
			echo '<span class="alert alert-danger">Please fill all the fields.</span>';
	}
	
?>