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
	
	global $pdo;
	$key=$_POST['key'];
	$query=$pdo->prepare("select * from topic where topic_name like '%$key%' ");
	$query->execute();
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
									$location='./uploads/'.$row->created_by.'/';
									
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
									Suscribe&nbsp;<input type="checkbox" onclick="get(this.value)" id="<?php echo $row->topic_id; ?>" value="<?php echo $row->topic_id; ?>">
								</div>
								<div class="col-lg-6">
									Suscribers&nbsp;<?php echo $row->suscriber; ?>
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
	
	}
	else
	{
		echo 'Sorry! No suggestion found.';
	}
?>
<script>
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