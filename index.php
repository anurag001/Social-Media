<?php
	include_once('class.php');
	ob_start();
	$val = $ob->loggedin();
	
	if($val == false)
	{
		echo '<script type="text/javascript">window.location.href="main.php";</script>';
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
		<title>Q4all | Home</title>
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
		<!-- edit credentials -->

		<div id="overlay">
			<div class="container">
				<div class="row">
					<div class="col-lg-2">
					</div>
					<div class="col-lg-8">
						<div class="panel panel-default" id="edit-profile">
							<div class="panel-heading">
								<span style="font-family:robob;font-size:1.7em;">Edit your profile</span>
								<strong><span class="glyphicon glyphicon-remove" id="close" style="cursor:pointer;"></span></strong>
							</div>
							<div class="panel-body">
								<form action="" method="post" id="edit-profile-form" class="form-horizontal">
									<div class="form-group">
										<label for="profile_status" class="col-sm-3 control-label"><b>Status</b></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="user_status" maxlength="50" value="<?php if(!empty($ob->getfield('status',$user_id))){echo $ob->getfield('status',$user_id);}?>" name="user_status" title="Your Status">
										</div>
									</div>
									<div class="form-group">
										<label for="user_email" class="col-sm-3 control-label"><b>Email</b></label>
										<div class="col-sm-9">
											<input type="email" class="form-control" id="user_email" value="<?php if(!empty($ob->getfield('email',$user_id))){echo $ob->getfield('email',$user_id);}?>" name="user_email" title="Your Email id">
										</div>
									</div>
									<div class="form-group">
										<label for="user_school" class="col-sm-3 control-label"><b>School</b></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="user_school" value="<?php if(!empty($ob->getfield('school',$user_id))){echo $ob->getfield('school',$user_id);}?>" name="user_school" title="School">
										</div>
									</div>
									<div class="form-group">
										<label for="user_organization" class="col-sm-3 control-label"><b>Working/Organization</b></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="user_organization" value="<?php if(!empty($ob->getfield('organization',$user_id))){echo $ob->getfield('organization',$user_id);}?>" name="user_organization" title="Organization/Working in">
										</div>
									</div>
									<div class="form-group">
										<label for="user_hobbies" class="col-sm-3 control-label"><b>Hobbies</b></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="user_hobbies" value="<?php if(!empty($ob->getfield('hobbies',$user_id))){echo $ob->getfield('hobbies',$user_id);}?>" name="user_hobbies" title="Hobbies">
										</div>
									</div>
									<div class="form-group">
										<label for="user_education" class="col-sm-3 control-label"><b>Education</b></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="user_education" value="<?php if(!empty($ob->getfield('highest_degree',$user_id))){echo $ob->getfield('highest_degree',$user_id);}?>" name="user_education" title="Education/Higher Studies">
										</div>
									</div>
									<div class="form-group">
										<label for="lives_in" class="col-sm-3 control-label"><b>Lives in</b></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="lives_in" value="<?php if(!empty($ob->getfield('lives_in',$user_id))){echo $ob->getfield('lives_in',$user_id);}?>" name="lives_in" title="Currently living in">
										</div>
									</div>
									<div class="form-group">
										<label for="hometown" class="col-sm-3 control-label"><b>Home Town</b></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="user_hometown" value="<?php if(!empty($ob->getfield('hometown',$user_id))){echo $ob->getfield('hometown',$user_id);}?>" name="user_hometown" title="Your Home Town">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-3"></div>
										<button type="submit" value="Save" class="col-sm-3 btn btn-info" id="btnSave">Save</button>
										<div class="col-sm-6"></div>
									</div>    
									<br>
									<div class="form-group">
										<div class="col-sm-5"></div>
										<div class="col-sm-7"><div id="edit-result"></div></div>
										<div class="col-sm-4"></div>
									</div>									
								</form>
							</div>
							<div class="panel-footer" style="height:50px;">
								<button class="btn btn-warning" id="closebtn" style="float:right;">Close</button>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
					</div>
				</div>
			</div>
		</div>		
		<!-- end here edit-profile -->
		
		
		<!-- upload profile pic -->
		<div id="overlaypic">
			<div class="container">
				<div class="row">
					<div class="col-lg-2">
					</div>
					<div class="col-lg-8">
						<div class="panel panel-default" id="edit-profile-pic">
							<div class="panel-heading">
								<span style="font-family:robob;font-size:1.7em;">Edit your Profile Picture</span>
								<strong><span class="glyphicon glyphicon-remove" id="close2" style="cursor:pointer;"></span></strong>
							</div>
							<div class="panel-body">
								<div id="image_prof_preview">
									<img src="" id="prof_image"/>
								</div>
								<form action="" method="post" id="edit-profile-pic-form" enctype="multipart/form-data" class="form-horizontal">
									<div class="form-group">
										<label id="upload-prof-chooser">
											Pick a picture for your profile
											<input type="file" id="prof-pic" name="file" accept="image/*" style="display: none;" required="required">
										</label>
										<button type="submit" value="Upload Profile Picture" id="btn-img-upload" name="submit" class="btn btn-success btn-block">
											<span class="glyphicon glyphicon-open"></span>
											Upload Your Image 
										</button>
									</div>
								</form>
								<div id="upload-result"></div>
							</div>
							<div class="panel-footer" style="height:50px;">
								<button class="btn btn-warning" id="closebtn2" style="float:right;">Close</button>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
					</div>
				</div>
			</div>
		</div>
		<!-- end here -->
		
		<!--   UPLOAD COVER-PHOTO HERE   -->
		<div id="overlaycoverpic">
			<div class="container">
				<div class="row">
					<div class="col-lg-2">
					</div>
					<div class="col-lg-8">
						<div class="panel panel-default" id="edit-cover-pic">
							<div class="panel-heading">
								<span style="font-family:robob;font-size:1.7em;">Edit your Cover Picture</span>
								<strong><span class="glyphicon glyphicon-remove" id="close3" style="cursor:pointer;"></span></strong>
							</div>
							<div class="panel-body">
								<div id="cover_image_preview">
									<img src="" id="cover_image"/>
								</div>
								<form action="" method="post" id="edit-cover-pic-form" enctype="multipart/form-data" class="form-horizontal">
									<div class="form-group">
										<label id="upload-prof-chooser">
											Pick a picture for your Profile-Cover
											<input type="file" id="cover-pic" name="file" accept="image/*" style="display: none;" required="required">
										</label>
										<button type="submit" value="Upload Cover Picture" id="btn-img-upload" name="submit" class="btn btn-success btn-block">
											<span class="glyphicon glyphicon-open"></span>
											Upload Your Image 
										</button>
									</div>
								</form>
								<div id="upload-cover-result"></div>
							</div>
							<div class="panel-footer" style="height:50px;">
								<button class="btn btn-warning" id="closebtn3" style="float:right;">Close</button>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
					</div>
				</div>
			</div>
		</div>
		<!-- end here -->
		
		
		<!-- CREATE topic REGISTRATION -->
		<div id="overlaytopic">
			<div class="container" id="reg_topic">
				<div class="row">
					<div class="col-lg-2">
					</div>
					<div class="col-lg-8">
						<div class="panel panel-primary" style="margin-top:20px;">
							<div class="panel-heading">
								<span style="font-family:robob;font-size:1.7em;">Create Topic</span>
								<strong><span class="glyphicon glyphicon-remove" id="close4" style="cursor:pointer;"></span></strong>
							</div>
							<div class="panel-body" style="margin:10px;">
								<form  method="post" id="topic_form" class="form-horizontal" enctype="multipart/form-data">
									<div class="form-group">
									
										<label for="topic_name" class="col-sm-3">Topic Name&nbsp;</label>
										<div class="col-sm-9">
											<input type="text" id="topic_name"  onkeyup="autosuggest_topic(this.value)" name="topic_name" class="form-control" maxlength="100" placeholder="Name of your topic" required>
											<div class="dropdown" id="suggest-box" style="margin-left:5px;">
												<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel"  style="width:320px;max-height:400px;overflow-x:hidden;overflow-y:auto;" id="suggest-topic">

												</ul>
											</div>
										</div>
										
									</div>
									<div class="form-group">
										<label for="topic_pic" class="col-sm-3">Topic Pic</label>
										<div class="col-sm-9">
											<input type="file" id="topic_pic" name="topic_pic" class="form-control" accept="image/*" required>
										</div>
									</div>
									<div class="form-group">
										<label for="topic_description" class="col-sm-3">Description </label>
										<div class="col-sm-9">
											<textarea id="topic_desc" name="topic_desc" style="height:10%;width:100%;" maxlength="200" placeholder="Description about your topic" required></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-3">
										</div>
										<div class="col-sm-4">
											<button type="submit" id="topic_submit" name="topic_submit" class="btn btn-primary btn-block">
												Save Topic
											</button>
										</div>
										<div class="col-sm-5">
										</div>
									</div>
								</form>
								</br>
								<div class="form-group">
									<div class="col-sm-3"></div>
									<div class="col-sm-9">
										<div id="topic-result"></div>
									</div>
								</div>
							</div>
							<div class="panel-footer" style="height:50px;">
								<button class="btn btn-warning" id="closebtn4" style="float:right;">Close</button>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
					</div>
				</div>
			</div>
		</div>
		<!-- END topic REGISTRATION -->
		
		
	<!--   NAVBAR HERE... CALLING FROM FUNCTION NAVBAR() IN CLASS.PHP -->
		<?php $ob->navbar();?>
	<!-- END NAVBAR HERE -->
		
		</br>
		
	<!--  COVER-PHOTO PART  -->
		<section id="cover-photo">
	<!--   END COVER-PHOTO PART  -->
			<div class="container">
				<div class="row">
					<div  id="profile_picture">
					
	<!--      profile picture here              -->
					
					</div>
				</div>
			</div>
		</section>
		
		</br></br></br>
		
		<section id="pioneercard-display">
			<div class="container">
				<div class="row">
					<div class="col-lg-3" id="user-profile-details">
					
				<!-- USER PROFILE DETAILS -->
					
					</div>
					<div class="col-lg-2">
						<div class="table table-hover">
							<tr>
								<a href="followings.php" style="text-decoration:none;color:#ff8d00;">Followings</a>		
								<span style="color:#939393;">
								<?php 
									echo $ob->count_followings($user_id);
								?>
								</span>
							</tr>
						</div>
						<div class="table table-hover">
							<tr>
								<a href="followers.php" style="text-decoration:none;color:#ff8d00;">Followers</a>
								<span style="color:#939393;">
								<?php 
									echo $ob->count_followers($user_id);
								?>
								</span>
							</tr>
						</div>
						<div class="table table-hover">
							<tr>
								<a href="questions.php" style="text-decoration:none;color:#ff8d00;">Questions</a>
								<span style="color:#939393;">
								<?php 
									echo $ob->question_count($user_id,1);
								?>
								</span>
							</tr>
						</div>
						<div class="table table-hover">
							<tr>
								<a href="#" style="text-decoration:none;color:#ff8d00;">Salutes</a>
								<span style="color:#939393;">
								<?php 
									echo $ob->getfield('salute',$user_id);
								?>
								</span>
							</tr>
						</div>
						<div class="table table-hover">
							<tr>
								<a href="show_my_topic.php" style="text-decoration:none;color:#ff8d00;">Topic</a>
								<span style="color:#939393;">
								<?php 
									echo $ob->getfield('topic',$user_id);
								?>
								</span>
							</tr>
						</div>
						
					</div>
					<div class="col-lg-5">
					  <div class="row">
						<div style="overflow-x:auto;overflow-y:ellipses;max-height:260px;word-wrap:break-word;color:#666;font-size:0.9em;">
							
					<?php
						$strid = trim($ob->getfield('whatilike',$user_id));
						$mylike=array();
						//do checking for empty spaces
						if(!empty($strid))
						{
							$modstr = str_replace(" ",'+',$strid);
							$array = explode('+',$modstr);
							for($i = 0;$i < count($array);$i++)
							{
								
								$query = $pdo->prepare("select * from topic where topic_id=?");
								$query->bindParam(1,$array[$i]);
								$query->execute();
								$row = $query->fetch(PDO::FETCH_OBJ);
								if(!in_array($row->topic_name, $mylike))
								{
									$mylike[$i]=$row->topic_name;
								}
															
							}
						}
						else
						{
							echo 'Search for your favourite topics and suscribe them.';
						}
						
								if(!empty($strid))
								{
									$two=2;
									for($i = 0;$i < count($mylike);$i++)
									{
										$key = strtolower($mylike[$i]);
										$quest = $pdo->prepare("select distinct post_id,post_data from post where post_data like '%$key%' and flag=? order by post_id desc");
										$quest->bindParam(1,$two);
										$quest->execute();
										while($row = $quest->fetch(PDO::FETCH_OBJ))
										{
								?>
											<span style="text-decoration:none;font-size:1.1em;" class="disp"><a href="view_question.php?qid=<?php echo $row->post_id;?>"><?php echo htmlspecialchars($row->post_data);?></a></span></br>
								<?php
										}
									}
								}
							?>
						</div>
					  </div>
					</div>
					<div class="col-lg-2">
							<div class="table text-center">
									<tr>
										<button class="btn btn-default btn-block text-center"style="font-family:robom;" id="cover-photo-upload"><span style="color:#ff8d00;"class="glyphicon glyphicon-camera"></span>Cover Photo</button>
										<button id="edit-btn" style="font-family:robom;" class="btn btn-default btn-block text-center"><span class="glyphicon glyphicon-pencil" style="color:#ff8d00;"></span>Edit Profile</button>
										<button id="create-topic-btn" style="font-family:robom;" class="btn btn-default btn-block text-center"><span class="glyphicon glyphicon-blackboard" style="color:#ff8d00;"></span>Create topic </button>
										<a href = "./questions.php" class="btn btn-default btn-block text-center"><span class="glyphicon glyphicon-plus" style="color:#ff8d00;"></span>Questions</a>
										
									</tr>
							</div>
					</div>
				</div>
			</div>
		</section>
		
		<section id="newsfeed-display">
			<div class="container">
				<div class="row">
					<div class="col-lg-3">
								
					</div>
					<div class="col-lg-6">
						<div class="row">
							<!------POSTVIEW-------->
			
								<div class="postview">
					
								</div>
							
							<!-------------->
						</div>	
					</div>
					<div class="col-lg-3">
					
								
					</div>
				</div>
			</div>
		</section>		
		<!-- end here -->
		
		
		<script type="text/javascript" src="./js/pioneersearch.js"></script>
		<script>
			
			function pullPost()
			{
				$.ajax({
					url: 'postview.php',
					method: "POST",
					data:'id='+<?php echo $user_id;?>,
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
		
			$("#del").click(function(e){
				var val = $("#del").attr('contextmenu');
				e.preventDefault();
				if (confirm("Do you want to delete your post?") == true)
				{
					$.ajax({
						url:'delete_question.php',
						method:"post",
						data:'qid='+val,
						success:function(resp)
						{
							$(this).fadeOut();
						}
					});
				} 
				
			});
		//-----------------------edit form---------------------------
			
	
			$("#btnSave").click(function(e){
				e.preventDefault();
				var data = $("#edit-profile-form").serialize();
				$.ajax({
					url:'update_profile.php',
					method:"post",
					data:data,
					success:function(resp)
					{
						$("#edit-result").html(resp);
						setTimeout(function() {
							$("#edit-result").fadeOut();
						}, 3000);
					},
					error: function() {
						$("#edit-result").html('There is some error occured').fadeIn();
					},
					complete:function(){
						update_profile_view();
					}
				});
			});
			
			$("#closebtn").click(function(){
				$("#overlay").fadeOut();
				$("#overlaypic").fadeOut();
			});
			$("#close").click(function(){
				$("#overlay").fadeOut();
				$("#overlaypic").fadeOut();
			});
			$("#closebtn2").click(function(){
				$("#overlaypic").fadeOut();
			});
			$("#close2").click(function(){
				$("#overlaypic").fadeOut();
			});
			$("#closebtn3").click(function(){
				$("#overlaycoverpic").fadeOut();
			});
			$("#close3").click(function(){
				$("#overlaycoverpic").fadeOut();
			});
			$("#closebtn4").click(function(){
				$("#overlaytopic").fadeOut();
			});
			$("#close4").click(function(){
				$("#overlaytopic").fadeOut();
			});
			$("#edit-btn").click(function(){
				$("#overlay").fadeIn('fast');
			});
			
			$("#profile_picture").click(function(){
				$("#overlaypic").fadeIn('fast');								
			});
			
			$("#edit-profile-pic-form").on('submit',function(e){
					e.preventDefault();		
					var formData = new FormData(this);
					
				$.ajax({
						url:'upload_prof_pic.php',
						type:"POST",
						data:formData,
						contentType:false,
						cache:false,
						processData:false,
					beforeSend:function()
					{
						$("#upload-result").html("Uploading...");
					},
					success:function(resp)
					{
						$("#upload-result").html(resp);						
					},
					error:function()
					{
						
					},
					complete:function(){
						pull_profile_pic();
					}
				});
			});
			
	//-------------DISPLAY PROF PIC------------------
		$(function(){
				$("#prof-pic").change(function(){
				
				var file = this.files[0];
				var imagefile = file.type;
				var match = ["image/jpeg","image/png","image/jpg"];
				
				if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
				{
					$("#upload-result").html('Select valid extension');
					return false;
				}
				else
				{
					var reader = new FileReader();
					reader.onload = imageIsLoaded;
					reader.readAsDataURL(this.files[0]);
				}
			});
		});
		
		function imageIsLoaded(e)
		{
			$("#prof-pic").css("color","green");
			$("#image_prof_preview").css("display","block");
			$("#prof_image").attr('src',e.target.result);
			$("#prof_image").attr("width","250px");
			$("#prof_image").attr("width","230px");
		}
			
	//-----------------------------------
					
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
			
			
			
//---------------------------- ---    COVER PIC       ----------------------------

			$("#cover-photo-upload").click(function(e){
					$("#overlaycoverpic").fadeIn();
			});			

			$("#edit-cover-pic-form").on('submit',function(e){
					e.preventDefault();		
					var formData = new FormData(this);
					
				$.ajax({
						url:'upload_cover_pic.php',
						type:"POST",
						data:formData,
						contentType:false,
						cache:false,
						processData:false,
					beforeSend:function()
					{
						$("#upload-cover-result").html("Uploading...");
					},
					success:function(resp)
					{
						$("#upload-cover-result").html(resp);					
					},
					error:function()
					{
						
					},
					complete:function(){
						pull_cover_pic();
					}
				});
			});
			
					$(function(){
						
						$("#cover-pic").change(function(){
							var file = this.files[0];
							var imagefile = file.type;
							var match = ["image/jpeg","image/png","image/jpg"];
				
							if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
							{
								$("#upload-cover-result").html('<span style="color:red">Select valid image extension in jpg/jpeg/png</span>');
								return false;
							}
							else
							{
								var reader = new FileReader();
								reader.onload = imageIsLoaded;
								reader.readAsDataURL(this.files[0]);
							}
						});
					});
					
			function imageIsLoaded(e)
			{
				$("#cover-pic").css("color","green");
				$("#cover_image_preview").css("display","block");
				$("#cover_image").attr('src',e.target.result);
				$("#cover_image").attr("width","250px");
				$("#cover_image").attr("width","230px");
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
			
			$("#create-topic-btn").click(function(){
				$("#overlaytopic").fadeIn();
			});
			
		$("#topic_form").on('submit',function(e){
				e.preventDefault();
				var name = $("#topic_name").val();
				var desc = $("#topic_desc").val();
                console.log(desc);
				var formData = new FormData(this);
				formData.append("name",name);
				formData.append("desc",desc);
				
				$.ajax({
					url:'submit_topic.php',
					type:"post",
					data:formData,
					contentType:false,
					cache:false,
					processData:false,
					success:function(resp)
					{
						$("#topic-result").html(resp);
						$("#topic_name").val('');
						$("#topic_desc").val('');
						setTimeout(function() {
							$("#topic-result").fadeOut();
						}, 3000);
					},
					complete:function(){
						
					}
				});
			});
			
			function autosuggest_topic(str)
			{
				$.ajax({
					url:'autosuggest_topic.php',
					type:"post",
					data:'str='+str,
					success:function(resp)
					{
						$("#suggest-topic").slideDown();
						$("#suggest-topic").html(resp);
					},
					complete: function() 
					{
							document.onclick = function() {
								$('#suggest-topic').slideUp(600);	
							}

					}
				});
			}
		//--------------------- ONLOAD -----------------------------------
			window.onload = function() {
				pullPost();
				pull_profile_pic();
				update_profile_view();
				pull_cover_pic();
			};
		</script>
	</body>
</html>
<?php ob_end_flush();?>