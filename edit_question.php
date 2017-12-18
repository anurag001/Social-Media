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
		<title>Pioneer</title>
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
	</br>
<?php
	if(is_numeric($qid) and $ob->confirm_post_owner($qid,$user_id))
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
				<div class="col-lg-2">
				</div>
				<div class="col-lg-7">
			
					<div class="panel" style="border:1px solid #e1e8ed;margin-top:50px;" id="<?php echo $data->post_id; ?>">
						<div class="row">
							<div class="col-xs-3">
						<?php
							if(!empty($ob->getfield('profile_pic',$data->send_from_id)))
							{
								$location='./uploads/'.$data->send_from_id.'/';
								echo '<img src='.$location.$ob->getfield('profile_pic',$data->send_from_id).' id="xs_prof_pic" class="img-responsive"  alt='.$ob->getfield('firstname',$data->send_from_id).'/>';
							}
							else
							{
								echo '<img src="./images/profile.jpg" id="xs_prof_pic" class="img-responsive"  alt='.$ob->getfield('firstname',$data->send_from_id).'/>';
							}
						?>
							</div>
							<div class="col-xs-9">
					
								<span style="font-family:robom;font-size:1.3em;"><?php echo $ob->getfield('firstname',$data->send_from_id).' '.$ob->getfield('lastname',$data->send_from_id);?></span>
								&nbsp;&nbsp;
								</br>
								<code>
									<?php $time = $data->time;?> 
									<abbr class="timeago" title="<?php echo date('c',$time); ?>"></abbr>
								</code>
							
							</div>
						</div>
						</br>
						<div class="row">
							<div class="col-xs-1">
							</div>
							<div class="col-xs-11">
								<div class="form-group">
								<form class="form-horizontal">
									<label for="edit post data">Edit your Question/Post&nbsp;&nbsp;<label>
									<textarea class="form-control" id="edit-text" ><?php echo htmlspecialchars($data->post_data);?></textarea>
								</form>
								</div>	
							</div>
						</div>
			<?php
				if(!empty($data->post_pic))
				{
					$location = 'uploads/'.$data->send_from_id.'/';
			?>
					<div class="row">
						<div class="col-xs-1">
						</div>
						<div class="col-xs-11">
							<img src="<?php echo $location.$data->post_pic;?>" id="lg_post_pic" class="img-responsive"/>
						</div>
					</div>
					</br>
			
			<?php
				}
			?>
						<div class="row">
							<div class="col-xs-1">
							</div>
							<div class="col-xs-4">
								<button onclick="update()" class="btn btn-info" id="submit">Save changes</button>
							</div>
							<div class="col-xs-7">
								<div id="response" style="padding-top:12px;">
								</div>
							</div>
						</div>
						</br>
						
					</div>
				</div>
				<div class="col-lg-3">
				
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
									<h2><strong>You don't have permission to edit someone's post!</strong><br>This id may not exist.</h2>
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
				function update(){
					var data = $("#edit-text").val();
					$.ajax({
						url:'update_question.php',
						method:'post',
						data:'data='+data+'&qid='+<?php echo $qid;?>,
						success:function(resp)
						{
							$("#response").html(resp);
						}
					});
				}

		</script>
	</body>
</html>