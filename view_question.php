<?php
	include('class.php');
	include_once('dbcon.php');
	$val = $ob->loggedin();
	
	if($val == false)
	{
		header('location:main.php');
	}
	else
	{
		$user_id = $_SESSION['user_id'];
	}
	$qid = $_GET['qid'];
?>
<!DOCTYPE HTML>
<html lang="eng">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<title>MyQuora | ViewQ</title>
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
		
	<!------------------------------        END NAVBAR HERE     ------------------ ---------------------------------------------------->
	<br>
<?php
	if(is_numeric($qid) and $ob->check_valid_post($qid))
	{		
		global $pdo;
		$query = $pdo->prepare("select * from post where post_id = ?");
		$query->bindParam(1,$qid);
		$query->execute();
		
		$data = $query->fetch(PDO::FETCH_OBJ);
		
?>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
			<!---- STARTING QUESTION BOX ---->
					<div class="tabel" style="margin-top:60px;" id="<?php echo $data->post_id; ?>">
						
						<?php
							$location='./uploads/'.$data->send_from_id.'/';
							if(empty($ob->getfield('profile_pic',$data->send_from_id)))
							{
						?>
								<a style="text-decoration:none;" href="profile.php?id=<?php echo $data->send_from_id;?>"><img src="./images/profile.jpg" id="profile-pic-small" class="img-responsive"></a>
						<?php
							}
							else
							{
						?>
								<a style="text-decoration:none;" href="profile.php?id=<?php echo $data->send_from_id;?>"><img src="<?php echo $location.$ob->getfield('profile_pic',$data->send_from_id).'_ldp';?>" id="profile-pic-small" class="img-responsive" alt="<?php echo $ob->getfield('firstname',$data->send_from_id);?>"></a>
						<?php
							}
						?>
						
							<a style="text-decoration:none;" href="profile.php?id=<?php echo $data->send_from_id;?>"><span style="font-family:robom;font-size:1.0em;"><?php echo $ob->getfield('firstname',$data->send_from_id).' '.$ob->getfield('lastname',$data->send_from_id);?></span></a>
							&nbsp;<span style="color:#8899a6;font-size:1.0em;" class="glyphicon glyphicon-send"></span>&nbsp;
							</br>
							<span style="color:#8899a6;font-size:0.9em;">
								<?php $time = $data->time;?> 
								<abbr class="timeago" title="<?php echo date('c',$time); ?>"></abbr>
							</span>
						
							<strong>
								<h3>														
									<span class="disp"><?php echo htmlspecialchars(stripslashes($data->post_data));?></pspan>
								</h3>
							</strong>
							</br>
							<?php
								if(!empty($data->post_pic))
								{
									$location = 'uploads/'.$data->send_from_id.'/';
							?>
									<img src="<?php echo $location.$data->post_pic;?>" id="lg_post_pic" class="img-responsive"/>
							<?php
								}
							?>			
							</br>			
							<form class="form-horizontal form-inline">
								<div class="input-group">
									<span class="input-group-addon">Ans</span>
									<textarea type="text" id="reply" name="reply" class="form-control" rows="8" cols="60" placeholder="Reply to this question here.."></textarea>
								</div>
								</br></br>
								<input type="submit" id="submit" value="Submit my answer" class="btn btn-info"/>
								</br></br>
								<div id="reply-result" style="padding-bottom:5px;">
								</div>
							</form>
														
					</div>
			<!-- ENDING QUESTION BOX -->
										
					<div class="row">
						<div class="col-xs-12">
							<div class="replyview">
							</div>	
						</div>
					</div>
				</div>
				
			<!---- LEAVE 4 COL GRIDS FOR SUGGESTION---->
				<div class="col-lg-4">
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
								<div class="panel-body" style="margin-top:60px;">
									<h2><strong>This is invalid id!Please use correct one</strong></h2>
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
		<script>
				$(".timeago").timeago(); // Calling Timeago Funtion 
				
				$("#submit").click(function(e){
					e.preventDefault();
					reply = $.trim(reply);
					var reply = $("#reply").val();
					if(reply == '')
					{
						$("#reply-result").html('<span style="color:red;">Please fill in the Reply-Box</span>');
					}
					else
					{
						$.ajax({
							url:'answer.php',
							method:'post',
							data:'reply='+reply+'&qid='+<?php echo $qid;?>+'&replyby='+<?php echo $user_id;?>+'&replyto='+<?php echo $data->send_from_id;?>,
							success:function(resp)
							{
								$("#reply-result").html(resp);
								$("#reply").val('');
								setTimeout(function(){
									$("#reply-result").fadeOut();
								}, 3000);
							},
							error:function(){
								$("#reply-result").html('Some error occurs');
							},
							complete:function(){
								pullPost();
							}
						});
					}
					
				});
				
			function pullPost()
			{
				$.ajax({
					url: 'answer_view.php',
					method: "POST",
					data:'qid='+<?php echo $qid;?>,
					success: function(data) {
						
						$('.replyview').html(data);
					},
					error: function() {
						$(".replyview").html('There is some error occured').fadeIn();
					}
				});
			}
			window.onload = function() {
				pullPost();
			};

		</script>
	</body>
</html>