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
	}
	$location='./uploads/'.$user_id.'/';
?>
<!DOCTYPE HTML>
<html lang="eng">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<title>Followers</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/font.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<style>
			
		</style>
		<script src="js/jquery-1.9.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/livequery.js"></script>
		<script src="js/timeago.js"></script>
		<script src="js/form.min.js"></script>


	</head>
	<body>
	
	<!---------------------------   NAVBAR HERE... CALLING FROM FUNCTION NAVBAR() IN CLASS.PHP --------------------------->
		<?php $ob->navbar();?>
	<!------------------------------END NAVBAR HERE                 ---------------------------------------------------->
		</br>
		
		
	<!------------------------   COVER-PHOTO PART  ---------------------------------->
		<section id="cover-photo">
	<?php
		if(!empty($ob->getfield('cover_pic',$user_id)))
		{
	?>
		<style>
			#cover-photo
			{
				background-image: url("<?php echo $location.$ob->getfield('cover_pic',$user_id); ?>");
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
					<div id="profile_picture">
						
	<!-------------------------      profile picture here             --------------------------------->
					
					</div>
				</div>
			</div>
		</section>
		</br></br>
		
		<section id="pioneer-card">
			<div class="container">
				<div class="row">
					<!-- start of about details -->
					<div class="col-lg-3" id="user-profile-details">
					
		<!-- ------------------view user profile details--------------------------------  -->
		
					</div>
					<!-- end of about details -->
					
					
					<div class="col-lg-9">			
				<!---       FOLLOWERS          --->
							<div class="row" id="show-followers">
								
							</div>
				<!----     END FOLLOWERS       --->	
					</div>
				</div>
			</div>
		</section>
		<!-------   end of ranking card ----------->
						
						
		<!-- end here -->
		<script type="text/javascript" src="./js/pioneersearch.js"></script>
		<script>
			
			
			function pull_profile_pic()
			{
				$.ajax({
					url: 'view_profile_pic.php',
					method: "POST",
					data:'id='+<?php echo $user_id;?>,
					success: function(data) {
						
						$('#profile_picture').html(data);
						
					},
					error: function() {
						$("#profile_picture").html('There is some error occured').fadeIn();
					}
				});
			}
			
			
			
			function pull_cover_pic()
			{
				$.ajax({
					url: 'view_cover_pic.php',
					method: "POST",
					data:'id='+<?php echo $user_id;?>,
					success: function(data) {
						
						$('#cover-pic').html(data);
						
					},
					error: function() {
						$("#cover-pic").html('There is some error occured').fadeIn();
					}
				});
			}
			
			function update_profile_view()
			{
				$.ajax({
					url: 'view_profile_details.php',
					method: "POST",
					data:'id='+<?php echo $user_id;?>,
					success: function(data) {
						
						$('#user-profile-details').html(data);
					},
					error: function() {
						$("#user-profile-details").html('There is some error occured').fadeIn();
					}
				});
			}
			
		//--------------------- ONLOAD -----------------------------------
			window.onload = function() {
				
				pull_profile_pic();
				
				pull_cover_pic();
				
				update_profile_view();
				
				show_followers();
			};
			
			function show_followers()
			{
				$.ajax({
					url: 'view_followers.php',
					method: "POST",
					data:'id='+<?php echo $user_id;?>,
					success: function(data) {
						
						$('#show-followers').html(data);
					},
					error: function() {
						$("#show-followers").html('There is some error occured');
					}
				});
			}
		</script>
	</body>
</html>
