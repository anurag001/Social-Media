<?php
	include('class.php');
	ob_start();
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
	global $pdo;
?>
<!DOCTYPE HTML>
<html lang="eng">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<title>Q4all</title>
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
		<script>
			var str="";
		</script>

	</head>
	<body>
	<!---------------------------   NAVBAR HERE... CALLING FROM FUNCTION NAVBAR() IN CLASS.PHP --------------------------->
		<?php $ob->navbar();?>
	<!------------------------------END NAVBAR HERE                 ---------------------------------------------------->
	</br>
	<section style="margin-top:50px;" id="searh-bar-box">
		<div class="container">
			<div class="row">
				<div class="form-group">
					<form method="post">
						<div class="col-lg-8">
							<input type="text" class="form-control" onkeyup="suggest_topics(this.value)" id="searh-bar" placeholder="Search different topics here.."/>
						</div>
					</form>
					
						<div class="col-lg-2">
							<button type="submit" onclick="save()" class="btn btn-default"><strong>Save</strong></button>
						</div>
						<div class="col-lg-2" id="result-status">
						</div>
				</div>
			</div>
		</div>
	</section>
	</br>
	<?php
		
		$query = $pdo->prepare("select * from topic where created_by = ?");
		$query->bindParam(1,$user_id);
		$query->execute();
		
	?>
	<section>
		<div class="container">
			<div class="row" id="topic-result">
			<?php
			if($query->rowCount()>0)
			{
				while($row = $query->fetch(PDO::FETCH_OBJ))
				{
				?>
					<div class="col-lg-3">
					
						<div class="panel panel-default" style="overflow:hidden;word-wrap:break-word;">
							<div class="panel-body" style="padding:0px;background:#fff;overflow:hidden; border:0px;height:190px;">
								<div class="row">
									<div class="col-xs-12">
								<?php
									if(!empty($row->topic_pic))
									{
								?>
										<img src="<?php echo $location.$row->topic_pic ;?>" id="topic-pic-show" class="img-responsive" style="height:140px;width:100%;">
								<?php
									}
									else
									{
								?>
										<img src="./images/banner.jpg" id="topic-pic-show" class="img-responsive" style="height:140px;width:100%;">
								<?php
									}
								?>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 text-center">
										<span style="font-family:robob;"><?php echo ucfirst(htmlspecialchars($row->topic_name));?></span>
										
										</br>
										
										<span style="font-family:robol;font-size:0.9em;"><?php echo htmlspecialchars($row->topic_desc);?></span>
									</div>
								</div>
							</div>
							<div class="row panel-footer" style="background:#fff;">
								<div class="col-lg-6">
									Suscribe&nbsp;<input type="checkbox" onclick="get(<?php echo $row->topic_id; ?>)" id="<?php echo $row->topic_id; ?>" value="<?php echo $row->topic_id; ?>">
								</div>
								<div class="col-lg-6">
									Suscriber&nbsp;
									<div id="suscriber<?php echo $row->topic_id;?>" style="display:inline-block;">
											<?php echo $row->suscriber; ?>
									</div>
								</div>
							</div>
						</div>
						<script>
			function get(val)
			{
				var x=$("#"+val).is(":checked");
				console.log(x);
			
				if($("#"+val).is(":checked")==true)
				{
					str=str+'+'+val;
					update_suscriber(val);
				}
				else if($("#"+val).is(":checked")==false)
				{
					str = str.replace(val,'');
				}
				
			}
			
			function update_suscriber(tid)
			{
				$.ajax({
					url:'update_suscriber.php',
					type:"post",
					data:'tid='+tid,
					success:function(result)
					{
						$("#suscriber"+<?php echo $row->topic_id;?>).html(result);
					},
					complete:function(result)
					{
					}
				});
			}
						</script>
					</div>
				<?php
				}
			}
			else
			{
				echo 'You have not created any topic yet, search above.';
			}
			?>
			</div>
		</div>
	</section>
			<?php  
					
					global $pdo;
					$strid = $ob->getfield('whatilike',$user_id);
					if(!empty($strid))
					{
						$modstr = str_replace(" ",'+',$strid);
						$array = explode('+',$modstr);
						for($i = 1;$i < count($array);$i++)
						{
				?>
							<script>
								$("#"+<?php echo $array[$i]; ?>).selected(true);
							</script>
				<?php
						}
					}
					
					$max = $pdo->prepare("select topic_id from topic order by topic_id desc limit 1");
					$max->execute();
					$maxid = $max->fetch(PDO::FETCH_OBJ);
					$maxid = $maxid->topic_id;
	
				?>
	<script>
		function suggest_topics(key)
		{
			$.ajax({
				url:'suggest_topic.php',
				type:"post",
				data:'key='+key,
				success:function(result)
				{
					$("#topic-result").html(result);
				}
			});
		}
		
		//console.log(<?php echo $maxid;?>);
			for(var j=1;j<=<?php echo $maxid;?>;j++)
			{
				if($("#"+j).is(":checked")==true)
				{
					str=str+'+'+j;
				}
				
			}
			
			
			
			function save()
			{
				$.ajax({
					url:'savemylikes.php',
					type:"post",
					data:"str="+str,
					success:function(resp)
					{
						$("#result-status").html(resp);
					}
				});
			}
	</script>
	</body>
</html>