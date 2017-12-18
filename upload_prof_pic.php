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
		$valext = array("jpeg","jpg");
		$temp = explode(".",$_FILES["file"]["name"]);
		$file_ext = end($temp);
		
		if((($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 2000000))
		{
			$ext = $_FILES["file"]["type"];
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
					
					$query = $pdo->prepare("update user set profile_pic = ? where user_id = ?");
					$query->bindParam(1,$name);
					$query->bindParam(2,$id);
					if($query->execute() and move_uploaded_file($source,$target))
					{
						echo '<center><span class="alert alert-success">Uploaded successfully</span></center>';
				
				//-----------------------  RESCALING PICTURE  ----------------------
						//Setting header
						if($ext == "image/jpeg" || $ext == "image/jpg")
						{
							header('Content-type: image/jpeg');
						}
						else if($ext == "image/png")
						{
							header('Content-type: image/gif');
						}

						//Required
						$filename = $target;
						$percent = 0.5;
						list($width,$height)=getimagesize($filename);

						// Get new sizes
						$newwidth = $width * $percent;
						$newheight = $height * $percent;

						// Load
						$thumb = imagecreatetruecolor($newwidth, $newheight);
						if($ext == "image/jpeg" || $ext == "image/jpg")
						{
							$src = imagecreatefromjpeg($filename);
						}
						else if($ext == "image/png")
						{
							$src = imagecreatefrompng($filename);
						}
					
						// Resize
						imagecopyresized($thumb, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

						// Output and saving
						imagejpeg($thumb, $filename);
						imagejpeg($thumb, $filename.'_mdp.jpg');

						//Small size LDP image

						// Get new sizes
						list($width, $height) = getimagesize($filename);
						$percent = 0.3;
						$newwidth = $width * $percent;
						$newheight = $height * $percent;

						// Load
						$thumb = imagecreatetruecolor($newwidth, $newheight);
						if($ext == "image/jpeg" || $ext == "image/jpg")
						{
							$src = imagecreatefromjpeg($filename);
						}
						else if($ext == "image/png")
						{
							$src = imagecreatefrompng($filename);
						}
					
						// Resize
						imagecopyresized($thumb, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

						//Output and saving
						imagejpeg($thumb, $filename.'_ldp');

						imagedestroy($src);

		//---------------------------------------------

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
			echo '<span style="color:red;" class="alert">Only jpeg/jpg files are allowed and size should be less than 2 Mb</span>';
		}
	}
?>