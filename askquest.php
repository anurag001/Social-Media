<?php
	include_once('class.php');
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$id = $_SESSION['user_id'];
	}
	
	$quest = $_POST['quest'];
	$location='./uploads/'.$id.'/';
	if(isset($_FILES["file"]["name"]) and !empty($_FILES["file"]["name"]))
	{
		$valid_extension = array("jpeg","png","jpg");
		$temp = explode(".",$_FILES["file"]["name"]);
		$file_extension = end($temp);
		
		if((($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/jpg")) && ($_FILES["file"]["size"] < 2000000))
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
					echo '<span style="color:red">'.$_FILES["file"]["name"]." already exists</span>";
				}
				else
				{
					$name = md5(time());
					$source = $_FILES["file"]["tmp_name"];
					$target = $location.$name;
					move_uploaded_file($source,$target);
					
					$ob->ask_to_pioneer_with_pic($id,$quest,$target);

					//---------------------------------------------
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
	//if($height>=430)
	$newheight = 400;
	$newwidth = round($newheight*$ratio);
}
else{
	//if($width>=500)
	$newwidth = 500;
	$newheight = round($newwidth/$ratio);
}


$tmp=imagecreatetruecolor($newwidth,$newheight);


imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);


/*$to_crop_array = array('x' =>0 , 'y' => 0, 'width' => $newwidth, 'height'=> $newheight);
$thumb_im = imagecrop($src, $to_crop_array);
*/

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
			echo '<span style="color:red;" class="alert">Only jpeg/jpg files are allowed and size should be less than 2 Mb</span>';
		}
	}
	else
	{
			$ob->ask_to_pioneer($id,$quest);
	}

?>