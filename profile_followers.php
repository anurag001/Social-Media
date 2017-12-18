<?php
	include('class.php');
	
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$user_id = $_SESSION['user_id'];
		$id = $_GET['id'];
		if($id == $_SESSION['user_id'])
		{
			header('location:index.php');
		}
	}
				
	$location='./uploads/'.$id.'/';
?>
<!DOCTYPE HTML>
<html lang="eng">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<title>Q4all | Followers</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/font.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<style>
			
		</style>
		<script src="js/jquery-1.9.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
	<!---------------------------   NAVBAR HERE... CALLING FROM FUNCTION NAVBAR() IN CLASS.PHP -------------------------------->
		
		<?php $ob->navbar();?>
		
	<!------------------------------        END NAVBAR HERE     ------------------ --------------------------------------------->
	</br>
	
		<?php
			if($ob->profile_exist($id))
			{
			
		?>		
	
	
		<!------------------------   COVER-PHOTO PART  ---------------------------------->
		<section id="cover-photo">
		
	<?php
		if(!empty($ob->getfield('cover_pic',$id)))
		{
	?>
		<style>
			#cover-photo
			{
				background-image: url("<?php echo $location.$ob->getfield('cover_pic',$id); ?>");
			}
		</style>
	<?php
		}
		else
		{
	?>
		<style>
			#cover-photo
			{
				background-image: url("./images/cover.jpg");
			}
		</style>
	<?php
		}
	?>
	<!------------------------   END COVER-PHOTO PART  ---------------------------------->
	
			
			
			<div class="container">
				<div class="row">
				
					<div class="col-lg-3" id="profile_picture">
					<?php
						if(empty($ob->getfield('profile_pic',$id)))
						{
					?>
							<img src="./images/profile.jpg" id="profile-pic" class="img-thumbnail img-responsive">
					<?php
						}
						else
						{
					?>
							<img src="<?php echo $location.$ob->getfield('profile_pic',$id);?>" id="profile-pic" class="img-thumbnail img-responsive" alt="<?php echo $ob->getfield('firstname',$id);?>">
					<?php
						}
					?>
					</div>
				</div>
			</div>
		</section>
		</br></br></br>
		
		<section id="pioneer-card">
			<div class="container">
				<div class="row">
					<div class="col-lg-3">
						<div class="tabel" id="show-profile-details">
							<div class="panel-body">
								<span class="text-left" style="font-family:robom;font-size:20px;"><strong><?php echo $ob->fullname($id); ?></strong></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b>Q4all</b>&nbsp;&nbsp;<?php echo '@'.$ob->getfield('username',$id);?></span><br><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><?php echo $ob->getfield('email',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-calendar"></span></b>&nbsp;&nbsp;<?php $time = $ob->getfield('since',$id);echo date('d M Y',$time);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;<?php echo $ob->getfield('organization',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-education"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('highest_degree',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-map-marker"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('lives_in',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-blackboard"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('school',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-certificate"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('hobbies',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-home"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('hometown',$id);?></span>
							</div>
						</div>
					</div>
					<div class="col-lg-9">
				<!---       FOLLOWERS          --->
							<div class="row" id="show-followers">
								
							</div>
				<!----     END FOLLOWERS       --->
					</div>
				</div>
			</div>
		</section>
<?php
	}
	else
	{
		?>
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel">
								<div class="panel-body" style="margin-top:50px;">
									<h2><strong>There is no such id in our record</strong><br>Don't try false id randomly<br>Please use valid one and go through them.</h2>
								</div>
							</div>
						</div>
					</div>
				</div>
		<?php
		
	}
?>
		<script type="text/javascript" src="./js/pioneersearch.js"></script>
		<script>
			function show_followers()
			{
				$.ajax({
					url: 'view_followers.php',
					method: "POST",
					data:'id='+<?php echo $id;?>,
					success: function(data) {
						
						$('#show-followers').html(data);
					},
					error: function() {
						
						$("#show-followers").html('There is some error occured');
					}
				});
			}
			
			window.onload = function() {
				
				show_followers();
			};
		</script>
	</body>
</html>