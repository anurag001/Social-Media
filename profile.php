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
		<title>Q4all | Profile</title>
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
				
					<div id="profile_picture">
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
		
		<section id="pioneercard-display">
			<div class="container">
			
				<div class="row">
					<div class="col-lg-3">
						<!------------ USER PROFILE DETAILS ----------------->
						<div class="tabel" id="show-profile-details">
							<div class="panel-body">
								<span class="text-left" style="font-family:robom;font-size:20px;"><strong><?php echo $ob->getfield('firstname',$id).' '.$ob->getfield('lastname',$id); ?></strong></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b>MyQuora</b>&nbsp;&nbsp;<?php echo '@'.$ob->getfield('username',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;" title="Eamil id"><b><span class="glyphicon glyphicon-envelope"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('email',$id);?></span><br></br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span class="glyphicon glyphicon-calendar"></span></b>&nbsp;&nbsp;<?php $time = $ob->getfield('since',$id);echo date('d M Y',$time);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;" title="Working/Institute/Profession"><b><span class="glyphicon glyphicon-briefcase"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('organization',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;" title="Education/Highest Degree"><b><span class="glyphicon glyphicon-education"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('highest_degree',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;" title="Lives In"><b><span class="glyphicon glyphicon-map-marker"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('lives_in',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;" title="School"><b><span class="glyphicon glyphicon-blackboard"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('school',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;" title="Hobbies/Extra Achievements/Certificate"><b><span class="glyphicon glyphicon-certificate"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('hobbies',$id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;" title="Home Town"><b><span class="glyphicon glyphicon-home"></span></b>&nbsp;&nbsp;<?php echo $ob->getfield('hometown',$id);?></span>
							</div>
						</div>
					</div>
					<!------------ ENDING ----------------->
					
					<!------------ PIONEER RANKING CARD----------------->
					<div class="col-lg-2">
						<div class="table table-hover">
							<tr>
								<a href="profile_followings.php?id=<?php echo $id;?>" style="text-decoration:none;color:#ff8d00;">Fllowings</a>		
								<span style="color:#939393;">
								<?php 
									echo $ob->count_followings($id);
								?>
								</span>
							</tr>
						</div>
						<div class="table table-hover">
							<tr>
								<a href="profile_followers.php?id=<?php echo $id;?>" style="text-decoration:none;color:#ff8d00;">Followers</a>
								<span style="color:#939393;">
								<?php 
									echo $ob->count_followers($id);
								?>
								</span>
							</tr>
						</div>
						<div class="table table-hover">
							<tr>
								<a href="profile_questions.php?id=<?php echo $id;?>" style="text-decoration:none;color:#ff8d00;">Questions</a>
								<span style="color:#939393;">
								<?php 
									echo $ob->question_count($id,1);
								?>
								</span>
							</tr>
						</div>
						<div class="table table-hover">
							<tr>
								<a href="#" style="text-decoration:none;color:#ff8d00;">Salutes</a>
								<span style="color:#939393;">
								<?php 
									echo $ob->getfield('salute',$id);
								?>
								</span>
							</tr>
						</div>
						<div class="table table-hover">
							<tr>
								<a href="#" style="text-decoration:none;color:#ff8d00;">Topic</a>
								<span style="color:#939393;">
								<?php 
									echo $ob->getfield('topic',$id);
								?>
								</span>
							</tr>
						</div>
						
					</div>
					<!---------- ENDING PIONEER RANKING CARD ------------->
					
					<!--EMPTY SPACE-->
					<div class="col-lg-4">
					
					</div>
					
					<!-- ----- FOLLOW BOX ------>
					<div class="col-lg-3">
							<div class="tabel text-center">
									<div class="panel-body" id="pioneer-follow">
								<?php 
									$flag = $ob->request_check($user_id,$id);
									if($flag == 1)
									{
								?>
										<button class="btn btn-warning btn-block text-center"  style="font-family:robob;font-size:1.3em;" id="unfollow"><span class="glyphicon glyphicon-user" style="color:#fff;"></span><span class="glyphicon glyphicon-minus-sign" style="color:#fff;"></span>Unfollow</button>
										<button class="btn btn-info btn-block text-center" style="font-family:robob;display:none;font-size:1.3em;" id="fake-follow"><span class="glyphicon glyphicon-user" style="color:#fff;"></span><span class="glyphicon glyphicon-plus-sign" style="color:#fff;"></span>Follow</button>
										<button class="btn btn-warning btn-block text-center" style="font-family:robob;display:none;font-size:1.3em;" id="fake-unfollow"><span class="glyphicon glyphicon-user" style="color:#fff;"></span><span class="glyphicon glyphicon-minus-sign" style="color:#fff;"></span>Unfollow</button>
								<?php
									}
									else
									{
								?>
										<button class="btn btn-info btn-block text-center" style="font-family:robob;font-size:1.3em;" id="follow"><span class="glyphicon glyphicon-user" style="color:#fff"></span><span class="glyphicon glyphicon-plus-sign" style="color:#fff"></span>Follow</button>
										<button class="btn btn-warning btn-block text-center" style="font-family:robob;display:none;font-size:1.3em;" id="fake-unfollow"><span class="glyphicon glyphicon-user" style="color:#fff;"></span><span class="glyphicon glyphicon-minus-sign" style="color:#fff;"></span>Unfollow</button>
										<button class="btn btn-info btn-block text-center" style="font-family:robob;display:none;font-size:1.3em;" id="fake-follow"><span class="glyphicon glyphicon-user" style="color:#fff;"></span><span class="glyphicon glyphicon-plus-sign" style="color:#fff;"></span>Follow</button>
								<?php
									}
									
								?>
									</div>
									<div class="panel-body" id="punish-block">
									<?php 
									$punish_flag = $ob->punish_check($user_id,$id);
									if($flag == 1)
									{
								?>
										<button class="btn btn-danger btn-block text-center" style="font-family:robob;font-size:1.3em;" id="punish"><span class="glyphicon glyphicon-user" style="color:#fff"></span><span class="glyphicon glyphicon-ban-circle" style="color:#fff"></span>Punish</button>
								<?php
									}
									else
									{
								?>
										<button class="btn btn-success btn-block text-center" style="font-family:robob;font-size:1.3em;" id="unpunish"><span class="glyphicon glyphicon-user" style="color:#fff"></span><span class="glyphicon glyphicon-ok-circle" style="color:#fff"></span>Unpunish</button>
								<?php
									}
									
								?>
									</div>
							</div>
					</div>			
				</div>
				<!--END FIRST ROW-->
				<!-- SECOND ROW -->
				<div class="row">
							<div class="col-lg-8">
								<div class="table">
									<div class="panel-body" style="display:block;">
										<div class="row">
											<form class="form-horizontal" id="timeline-post">
												<div class="col-sm-9">
													<input type="text" class="form-control" id="qitem" placeholder="Ask anybody<?php echo $ob->getfield('firstname',$id); ?>" autocomplete="off" required/>
												</div>
												<div class="col-sm-3">
													<input type="submit" class="btn btn-md btn-info" id="asktopioneer" value="Ask anybody"/>
												</div>
												<div id="timeline-result"></div>
											</form>	
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								
							</div>
					</div>
			</div>
		</section>
		
		
		<section>
			<div class="container">
				<div class="row">
					<div class="col-lg-3">
					</div>
					<div class="col-lg-6">
						<div class="postview">
						</div>
					</div>	
					<div class="col-lg-3">
					</div>					
				</div>
			</div>
		</section>
		<script type="text/javascript" src="./js/pioneersearch.js"></script>
		<script>
			
			$("#asktopioneer").click(function(e){
				e.preventDefault();
				var text =$("#qitem").val();
				text=$.trim(text);
				if(text == '')
				{
					$("#timeline-result").html('<span style="color:red;">Please enter something</span>');
				}
				else
				{
					e.preventDefault();
					$.ajax({
						url:'./asktopioneer.php',
						method:"post",
						data:'from='+<?php echo $user_id;?>+'&to='+<?php echo $id;?>+'&text='+text,
						success:function(response)
						{
							$("#qitem").val('');
							$("#timeline-result").html(response);
							setTimeout(function() {
							$("#timeline-result").fadeOut();
							}, 3000);
							
						},
						error:function()
						{
							$("#timeline-result").html('Some error occurs,try again');
						},
						complete:function()
						{
						
						}
					});
				}
								
			});
			
			
			$("#follow").click(function(e){
				e.preventDefault();
				$.ajax({
					url:'./follow.php',
					method:"post",
					data:'from='+<?php echo $user_id;?>+'&to='+<?php echo $id;?>,
					success:function(response)
					{
						$("#follow").hide();
						$("#fake-unfollow").fadeIn();
					},
					error:function()
					{
						
					},
					complete:function()
					{
						
					}
				});
			});
			
			$("#fake-follow").click(function(e){
				e.preventDefault();
				$.ajax({
					url:'./follow.php',
					method:"post",
					data:'from='+<?php echo $user_id;?>+'&to='+<?php echo $id;?>,
					success:function(response)
					{
						$("#fake-follow").hide();
						$("#fake-unfollow").fadeIn();
						$("#follow").hide();
						$("#unfollow").hide();
					},
					error:function()
					{
						
					},
					complete:function()
					{
						
					}
				});
			});
			
			$("#fake-unfollow").click(function(e){
				e.preventDefault();
				$.ajax({
					url:'./unfollow.php',
					method:"post",
					data:'from='+<?php echo $user_id;?>+'&to='+<?php echo $id;?>,
					success:function(response)
					{
						$("#fake-unfollow").hide();
						$("#fake-follow").fadeIn();
					},
					error:function()
					{
						
					},
					complete:function()
					{
						
					}
				});
			});
			
			
			$("#unfollow").click(function(e){
				e.preventDefault();
				$.ajax({
					url:'./unfollow.php',
					method:"post",
					data:'from='+<?php echo $user_id;?>+'&to='+<?php echo $id;?>,
					success:function(response)
					{
						$("#fake-follow").fadeIn();
						$("#fake-unfollow").hide();
						$("#follow").hide();
						$("#unfollow").hide();
					},
					error:function()
					{
					},
					complete:function()
					{
					}
				});
	
			});
			
			
			function pullPost() {
				$.ajax({
					url: 'postview.php',
					method: "POST",
					data:'id='+<?php echo $id;?>+'&userid='+<?php echo $user_id;?>+'&questflag='+1+'&postflag='+0,
					success: function(data) {
						
						$('.postview').html(data);
					},
					error: function() {
						$(".postview").html('There is some error occured').fadeIn();
					}
				});
			}
			
			
			//--------------------- ONLOAD -----------------------------------
			
			window.onload = function() {
				
				pullPost();
			};
		</script>
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
		<script src="js/livequery.js"></script>
		<script src="js/timeago.js"></script>
		
	</body>
</html>

