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

?>
<!DOCTYPE HTML>
<html lang="eng">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<title>Q4all | Questions</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/font.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<style>
			.postview1{
				display:none;
			}
			textarea{
				resize: none;
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
		<section>
		<div class="container">
			<div class="row">
				
				<div class="col-lg-6">
					
						<div class="panel-body" style="margin-top:60px;">
							<div class="form-group">
								<form class="form-horizontal" id="question-form">
									<textarea class="form-control" id="askdata" placeholder="Ask questions to anyone" autocomplete="off" required/></textarea>
									</br>
									<input type="file" class="form-control" id="post_pic" name="file" area="hidden">
									</br>
									<input type="submit" class="btn btn-md btn-info btn-block" id="submitask" value="Ask"/>
									<div id="ask-result"></div>
								</form>
							</div>
						</div>
				</div>
				<div class="col-lg-6">
					<div style="margin-top:60px;">
				
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				
				<div class="col-lg-6">
					<div class="postview1">
					</div>
					<div class="postview2">
					</div>
				</div>
				<div class="col-lg-6">
				<?php
						$strid = trim($ob->getfield('whatilike',$user_id));
						$mylike=array();
						if(!empty($strid))
						{
							$modstr = str_replace(" ",'+',$strid);
							$array = explode('+',$modstr);
							for($i = 1;$i < count($array);$i++)
							{
								
								$query = $pdo->prepare("select * from topic where topic_id=?");
								$query->bindParam(1,$array[$i]);
								$query->execute();
								$row = $query->fetch(PDO::FETCH_OBJ);
								$mylike[$i]=$row->topic_name;
																
							}
							$two=2;
									for($i = 1;$i < count($mylike);$i++)
									{
										$key = $mylike[$i];
										$quest = $pdo->prepare("select * from post where post_data like '%$key%' and flag=? order by post_id desc");
										$quest->bindParam(1,$two);
										$quest->execute();
										while($row = $quest->fetch(PDO::FETCH_OBJ))
										{
								?>
											<span style="text-decoration:none;font-size:1.1em;" class="disp"><a href="view_question.php?qid=<?php echo $row->post_id;?>"><?php echo htmlspecialchars(stripslashes($row->post_data));?></a></span>
											<br></br>
								<?php
										}
									}
						}
						
			?>
				</div>
			</div>
		</div>
		</section>
		<script type="text/javascript" src="./js/pioneersearch.js"></script>
		<script>
			$("#qbtn1").click(function(){
				$(".postview1").fadeIn();
				$(".postview2").hide();
			});
			
			
			$("#question-form").on('submit',function(e){
				
				e.preventDefault();
				var quest = $("#askdata").val();
				
				quest = $.trim(quest);
				
			if(quest == '')
			{
				$("#ask-result").html('<div style="color:red">Please fill both fields</div>');
			}
			else
			{
					var formData = new FormData(this);
					formData.append("quest",quest);
				
				$.ajax({
						url:'askquest.php',
						type:"POST",
						data:formData,
						contentType:false,
						cache:false,
						processData:false,
					success:function(resp)
					{
						$("#ask-result").html(resp);
						setTimeout(function() {
							$("#ask-result").fadeOut();
						}, 60000);
						$("#askdata").val('');
					},
					error:function()
					{
						
					},
					complete:function(){
						pullPostA();
					}
				});
			}
				
			});
			
					$(function(){
						
						$("#post_pic").change(function(){
							var file = this.files[0];
							var imagefile = file.type;
							var match = ["image/jpeg","image/png","image/jpg"];
				
							if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
							{
								$("#post-result").html('<span style="color:red">Select valid image extension in jpg/jpeg/png</span>');
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
				$("#file").css("color","green");
			}
			
			function pullPostA() {
				$.ajax({
					url: 'postview_question.php',
					method: "POST",
					data:'id='+<?php echo $user_id;?>+'&postflag='+2,
					success: function(data) {
						
						$('.postview1').show().html(data);
						$('.postview2').hide();
					},
					error: function() {
						$(".postview1").html('There is some error occured').fadeIn();
					}
				});
			}
			
			
			window.onload = function() {
				pullPostA();
			};

		</script>
		<script src="js/livequery.js"></script>
		<script src="js/timeago.js"></script>
	</body>
</html>