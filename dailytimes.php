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
		<title>MyQuora | DailyTimes</title>
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
	<!---------------------------   NAVBAR HERE... CALLING FROM FUNCTION NAVBAR() IN CLASS.PHP -------------------------------->
		
		<?php $ob->navbar();?>
		
	<!------------------------------        END NAVBAR HERE     ------------------ ---------------------------------------------------->
		<br>
		
	<section>
		<div class="container">
			<div class="row">
				<div class="col-lg-2">
				</div>
				<div class="col-lg-7" style="margin-top:50px;">
				<?php
					global $pdo;
					$query = $pdo->prepare("select * from post order by post_id desc");
					$query->execute();
						
		while($row = $query->fetch(PDO::FETCH_OBJ))
		{
			$follower_id = $row->send_from_id;
			if($ob->is_follower_following($user_id,$follower_id))
			{
	?>
			<div class="panel" style="border:1px solid #e1e8ed;" id="<?php echo $row->post_id; ?>">
				<div class="row">
					<div class="col-xs-3">
						<?php
							$location='./uploads/'.$row->send_from_id.'/';
							if(!empty($ob->getfield('profile_pic',$row->send_from_id)))
							{
						?>
								<a style="text-decoration:none;" href="profile.php?id=<?php echo $row->send_from_id; ?>"><img src="<?php echo $location.$ob->getfield('profile_pic',$row->send_from_id).'_ldp';?>" id="profile-pic-small" class="img-responsive" alt="<?php echo $ob->getfield('firstname',$row->send_from_id);?>"></a>
						<?php
							}
							else
							{
								echo '<a style="text-decoration:none;" href="profile.php?id='.$row->send_from_id.'"><img src="./images/profile.jpg" id="xs_prof_pic" class="img-responsive"  alt='.$ob->getfield('firstname',$id).'/></a>';
							}
						?>
					</div>
					<div class="col-xs-9">
					
							<a style="text-decoration:none;" href="profile.php?id=<?php echo $row->send_from_id; ?>"><span style="font-family:robom;font-size:1.0em;"><?php echo $ob->getfield('firstname',$row->send_from_id).' '.$ob->getfield('lastname',$row->send_from_id);?></span></a>
							&nbsp;<span style="color:#8899a6;font-sizze:1.0em;" class="glyphicon glyphicon-send"></span>&nbsp;
							<br>
							<span style="color:#8899a6;font-size:0.9em;">
								<?php $time = $row->time;?> 
								<abbr class="timeago" title="<?php echo date('c',$time); ?>"></abbr>
							</span>
						
					</div>
				</div>
				</br>
				<div class="row">
					<div class="col-xs-1">
					</div>
					<div class="col-xs-11">
					<strong>
					Question:<br>
		<!--     VARIOUS CHANGES ACCORDING TO POST FLAG AND CHECKING       -->
				<?php
					if($row->flag == 2)
					{
				?>
						<span class="disp"><?php echo htmlspecialchars($row->post_data);?></span>
				<?php
					}
					else
					{
				?>
						<span class="disp"><?php echo htmlspecialchars($row->post_data);?></span>
				<?php
					}
				?>
		<!-- POST FLAG CHECKING END HERE          -->
					</strong>
					</div>
				</div>
				
			<?php
				if(!empty($row->post_pic))
				{
					$location = 'uploads/'.$row->send_from_id.'/';
			?>
				<div class="row">
					<div class="col-xs-1">
					</div>
					<div class="col-xs-11">
						<img src="<?php echo $location.$row->post_pic;?>" id="lg_post_pic" class="img-responsive"/>
					</div>
				</div>
				</br>
			<?php
				}
			?>
			
			
	<!--     VARIOUS CHANGES ACCORDING TO POST FLAG AND CHECKING       -->
			<?php
				if($row->flag == 2)
				{
			?>
		
				<div class="row">
					<div class="col-xs-1">
					</div>
					<div class="col-xs-10">
						<div class="panel-footer">
											
								<a href="view_question.php?qid=<?php echo $row->post_id;?>"><span style="cursor:pointer;" class="glyphicon glyphicon-pencil"  title="Reply this question"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
								<span class="glyphicon glyphicon-comment" style="color:#2e6da4;cursor:pointer;" title="Replies to this question" id="reply-box<?php echo $row->post_id; ?>" ><?php if($row->reply_count>0){echo $row->reply_count;}?></span>&nbsp;&nbsp;
							
						</div>
					</div>
					<div class="col-xs-1">
					</div>
				</div>
				</br>
				<?php 
				}
				?>
	<!-- POST FLAG CHECKING END HERE         -->	
				
				<!--  Viewing reply box and click on see more -->
				<div class="row" id="drop-reply-box<?php echo $row->post_id; ?>" style="display:none;">
					<div class="col-lg-1"></div>
					<div class="col-lg-11">
					
				<?php
					$rep = $pdo->prepare("select * from reply where question_id = ? order by reply_id desc limit 2");
					$rep->bindParam(1,$row->post_id);
					$rep->execute();
				if($rep->rowCount() > 0)
				{
					while($reply = $rep->fetch(PDO::FETCH_OBJ))
					{
				?>
					<div class="panel panel-default panel-body">
						<?php
							$reply_location='./uploads/'.$reply->reply_by.'/';
							if(!empty($ob->getfield('profile_pic',$reply->reply_by)))
							{
						?>
								<a style="text-decoration:none;" href="profile.php?id=<?php echo $reply->reply_by; ?>"><img src="<?php echo $reply_location.$ob->getfield('profile_pic',$reply->reply_by).'_ldp';?>" id="profile-pic-small" class="img-responsive" alt="<?php echo $ob->getfield('firstname',$reply->reply_by);?>"></a>
						<?php
							}
							else
							{
								echo '<a style="text-decoration:none;" href="profile.php?id='.$reply->reply_by.'"><img src="./images/profile.jpg" id="xs_prof_pic" class="img-responsive"  alt='.$ob->getfield('firstname',$reply->reply_by).'/></a>';
							}
						?>
						<a style="text-decoration:none;" href="profile.php?id=<?php echo $reply->reply_by; ?>"><span style="font-family:robom;font-size:1.0em;"><?php echo $ob->getfield('firstname',$reply->reply_by).' '.$ob->getfield('lastname',$reply->reply_by);?></span></a>
						&nbsp;&nbsp;<a style="text-decoration:none;" href="profile.php?id=<?php echo $reply->reply_to; ?>"><span style="font-family:robol;font-size:1.0em;color:#8899a6;"><span class="glyphicon glyphicon-hand-right" style="color:#8899a6;"></span><?php echo '@'.$ob->getfield('username',$reply->reply_to);?></span></a>
						<br>
						<span style="font-size:0.9em;" class="disp"><?php echo htmlspecialchars($reply->reply); ?></span>
					</div>
				<?php
					}
				?>
					<span class="text-center" id="see-more"><a href="view_question.php?qid=<?php echo $row->post_id;?>">See More</a></span>
				
				<?php
				}
				else
				{
				?>
					
					<span style="font-size:0.9em;">No replies yet&nbsp;&nbsp;<a href="view_question.php?qid=<?php echo $row->post_id;?>">Reply Here</a></span>
				
				<?php
				}
				?>
					</div>	
				</div>
				<script>
						$("#reply-box"+<?php echo $row->post_id; ?>).click(function(e){
							$("#drop-reply-box"+<?php echo $row->post_id; ?>).slideToggle();
						});
				</script>
			</div>
	<?php
			}
		}
	?>
				</div>
				<div class="col-lg-2">
				</div>
			</div>
		</div>
	</section>
	<script type="text/javascript" src="./js/pioneersearch.js"></script>
	<script>
			$(".timeago").timeago(); // Calling Timeago Funtion 

	</script>
	</body>
</html>
		