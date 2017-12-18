<?php
	include('class.php');
	
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$id = $_GET['id'];
		$user_id = $_SESSION['user_id'];
	}

?>
<!DOCTYPE HTML>
<html lang="eng">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<title>Q4all | ProfileQ</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/font.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<style>
			.postview1{
				display:none;
			}
		</style>
		<script src="js/jquery-1.9.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
	<!---------------------------   NAVBAR HERE... CALLING FROM FUNCTION NAVBAR() IN CLASS.PHP -------------------------------->
		
		<?php $ob->navbar();?>
		
	<!------------------------------        END NAVBAR HERE     ------------------ ---------------------------------------------------->
		</br>
		<?php
			if($ob->profile_exist($id))
			{
		?>
			<section>
					<div class="row">
						<div class="col-lg-3">
						</div>
						<div class="col-lg-6">
							<div class="postview" style="margin-top:60px;">
							
							</div>
						</div>
						<div class="col-lg-3">
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
		<script>
			function pullPost() {
				$.ajax({
					url: 'profile_question_view.php',
					method: "POST",
					data:'id='+<?php echo $id;?>+'&userid='+<?php echo $user_id ;?>,
					success: function(data) {
						
						$('.postview').html(data);
					},
					error: function() {
						$(".postview").html('There is some error occured').fadeIn();
					}
				});
			}
			window.onload = function() {
				pullPost();
			};
		</script>
		<script type="text/javascript" src="./js/pioneersearch.js"></script>
		<script src="js/livequery.js"></script>
		<script src="js/timeago.js"></script>
	</body>
</html>
