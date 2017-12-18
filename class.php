<?php
include('dbcon.php');
class PioneerFunctions
{
		public function check_email($email)
		{
			$email = trim($email);
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);
			$regex = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^";
            if ( preg_match( $regex, $email ))
			{
				$this->is_email_exist($email);
            }
            else 
			{
				echo '<span style="color:red;">'.$email . " is an invalid email. Please try again.".'</span>';
				return false;
			}

		}
		
	public function is_email_exist($email)
    {
		global $pdo;
		$query=$pdo->prepare("select user_id from user where email = ?");
        $query->bindParam(1,$email);
        $query->execute();
        if($query->rowCount()>0)
        {
            echo '<span style="color:red;">' .$email . " already exists.</span>";
            return true;
        }
        else{
             echo '<span class="text-primary">Email is fine.</span>';
            return false;
        }
    }
	
	public function check_username($username)
	{
		global $pdo;
		$query=$pdo->prepare("select user_id from user where username = ?");
		$query->bindParam(1,$username);
		$query->execute();
		if($query->rowCount()>0)
		{
			echo '<span style="color:red">'.$username.' username already exist,try another one.</span>';
			return true;
		}
		else
		{
			echo '<span class="text-primary">Username is fine.</span>';
			return false;
		}
	}
	
	public function signup()
	{
		global $pdo;
		$email = trim($_POST['email']);
		$username=trim($_POST['username']);
        if(!($this->is_email_exist($email)) and !($this->check_username($username)))
        {
                $fname = htmlspecialchars(ucwords(strtolower(trim($_POST['firstname']))));
                $lname = htmlspecialchars(ucwords(strtolower(trim($_POST['lastname']))));
				$email = htmlspecialchars($email);
				$username = htmlspecialchars($username);
                $password = htmlspecialchars($_POST['password']);
                $query = $pdo->prepare("insert into user(firstname,lastname,email,username,password,since) values(?,?,?,?,?,?)");
                $query->bindParam(1, $fname);
                $query->bindParam(2, $lname);
                $query->bindParam(3, $email);
                $query->bindParam(4, $username);
                $query->bindParam(5, $password);
                $time = time();
                $query->bindParam(6, $time);

					if($query->execute())
                    {       $user_id_may_be=$pdo->lastInsertId();
                            echo '<p class="text-info">Welcome '.$fname.' You have been successfully signed up. Please Log In now.</p>'.' <button onclick="login()" class="btn btn-primary">Click here to login.</button>';
                            $path = "./uploads/$user_id_may_be";
                            mkdir($path);
                    }
                    else
                    {
                        echo "Sorry there is some problem.";
                    }
        }
        else
        {
            echo '<h3 style="color:red;">Try again. <a href="main.php" class="btn btn-danger">Reload</a></h3>';
        }
	}
	
	
	public function loggedin()
	{
		session_start();

		if(isset($_SESSION['user_id']) and !empty($_SESSION['user_id']))
		{
			return true;
		}
		else{
			
			return false;
		}
	}
	
	public function getfield($field,$id)
	{
		global $pdo;
		$query = $pdo->prepare("select $field from user where user_id= ?");
		$query->bindParam(1,$id);
		if($query->execute())
		{
			$row = $query->fetch(PDO::FETCH_OBJ);
			return $row->$field;
		}

	}
	
	public function pioneer_search($key)
	{
		global $pdo;
		$key=trim($key); 
		$query = $pdo->prepare("select * from user where firstname like '%$key%' or username = '%$key%'");
		
		if($query->execute())
		{
			while($row = $query->fetch(PDO::FETCH_OBJ))
			{
				$location='./uploads/'.$row->user_id.'/'.$row->profile_pic;
				if(empty($row->profile_pic))
				{
					$location = "./images/profile.JPG";
				}
				echo '<li style="border:1px solid #F2F3F4;"><a href="profile.php?id='.$row->user_id.'"><div class="row"><span class="col-xs-3"><img src='.$location.' height="40" width="40"/></span><span style="color:#8899a6; class="col-xs-9">@'.$row->username.'</br><span style="color:#454545;">'.$row->firstname.' '.$row->lastname.'</span></span></div></a></li>';
			}
		}
		else
		{
			echo '<a class="bg-danger">Sorry! Nothing Found</a>';
		}
	}
	
	public function profile_exist($id)
	{
		global $pdo;
		if(is_numeric($id))
		{
			$query=$pdo->prepare("select user_id from user where user_id = ?");
			$query->bindParam(1,$id);
			$query->execute();
			if($query->rowCount())
			{
				return true;
			}
			else{
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}
		
	public function update_profile($status,$email,$school,$organization,$hobbies,$education,$hometown,$lives_in,$user_id)
	{
		global $pdo;
		$query = $pdo->prepare("update user set status = ?,email = ?,school = ?,organization = ?,hobbies = ?,highest_degree = ?,hometown = ?,lives_in = ? where user_id = ?");
		$query->bindParam(1,$status);
		$query->bindParam(2,$email);
		$query->bindParam(3,$school);
		$query->bindParam(4,$organization);
		$query->bindParam(5,$hobbies);
		$query->bindParam(6,$education);
		$query->bindParam(7,$hometown);
		$query->bindParam(8,$lives_in);
		$query->bindParam(9,$user_id);
		if($query->execute())
		{
			echo '<span class="alert alert-success">Updated successfully</span>';
		}
		else
		{
			echo '<span class="alert alert-warning">Error in updation</span>';
		}
	}
		
	public function follow($from,$to)
	{
		global $pdo;
		
			$query = $pdo->prepare("insert into request(sent_from_id,sent_to_id,flag) values(?,?,?)");
			$query->bindParam(1,$from);
			$query->bindParam(2,$to);
			$one=1;
			$query->bindParam(3,$one);
			$query->execute();				
	}
	
	public function request_check($from,$to)
	{
		global $pdo;
		$query = $pdo->prepare("select flag from request where sent_from_id=? and sent_to_id=?");
		$query->bindParam(1,$from);
		$query->bindParam(2,$to);
		if($query->execute())
		{
			$row = $query->fetch();
			//return $row['flag'];
			if($row['flag'] == 1)
			{
				//echo '<button class="btn btn-warning text-center" id="unfollow">Unfollow</button>';
				return true;
			}
			else
			{
				//echo '<button class="btn btn-info text-center" id="follow">Follow</button>';
				return false;
			}
		}
		else
		{	
			//echo '<button class="btn btn-info text-center" id="follow">Follow</button>';
			return false;
		}
		
	}
	
	public function punish_check($from,$to)
	{
		global $pdo;
		$query = $pdo->prepare("select punish-flag from request where sent_from_id=? and sent_to_id=?");
		$query->bindParam(1,$from);
		$query->bindParam(2,$to);
		if($query->execute())
		{
			$row = $query->fetch();
			//return $row['flag'];
			if($row['punish_flag'] == 1)
			{
				//echo '<button class="btn btn-warning text-center" id="unfollow">Unfollow</button>';
				return true;
			}
			else
			{
				//echo '<button class="btn btn-info text-center" id="follow">Follow</button>';
				return false;
			}
		}
		else
		{	
			//echo '<button class="btn btn-info text-center" id="follow">Follow</button>';
			return false;
		}
		
	}
	
	public function unfollow($from,$to)
	{
		global $pdo;
		
			$query = $pdo->prepare("delete from request where sent_from_id = ? and sent_to_id=?");
			$query->bindParam(1,$from);
			$query->bindParam(2,$to);
			if($query->execute())
			{
				echo '<button class="btn btn-info btn-block text-center" id="follow">Follow</button>';
			}
			else
			{
				echo '<button class="btn btn-warning btn-block text-center" id="unfollow">Unfollow</button>';
			}
		
				
	}
	
	public function ask_to_pioneer($from,$text)
	{
		global $pdo;
		
			$query = $pdo->prepare("insert into post(send_from_id,post_data,flag,time) values(?,?,?,?)");
			$query->bindParam(1,$from);
			$query->bindParam(2,$text);
			$two = 2;
			$query->bindParam(3,$two);
			$time = time();
			$query->bindParam(4,$time);
			if($query->execute())
			{
				echo '<div class="alert alert-success" style="overflow:auto;">Question is submitted</div>';
			}
			else
			{
				echo '<div class="alert alert-warning">Please try again.</div>';
			}
	
	}
	
	public function ask_to_pioneer_with_pic($from,$text,$picname)
	{
		global $pdo;
		
			$query = $pdo->prepare("insert into post(send_from_id,post_data,flag,time,post_pic) values(?,?,?,?,?)");
			$query->bindParam(1,$from);
			$query->bindParam(2,$text);
			$two = 2;
			$query->bindParam(3,$two);
			$time = time();
			$query->bindParam(4,$time);
			$query->bindParam(5,$picname);
			if($query->execute())
			{
				echo '<div class="alert alert-success" style="overflow:auto;">Question is submitted</div>';
			}
			else
			{
				echo '<div class="alert alert-warning">Please try again.</div>';
			}
	
	}
	
	
	
	public function navbar()
	{
	?>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="mynav">
			<div class="container">
			
				<!--navbar header -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>					
					</button>
					<span class="navbar-brand" id="nav-pioneer">Q4all&nbsp;&nbsp;<small><?php echo $this->getfield('firstname',$_SESSION['user_id']); ?></small></span>		
				</div>
				<!---end navbar header--->
				
				<!-- navbar fields -->
				<div class="collapse navbar-collapse" id="navbar-collapse">
					<ul class="nav navbar-nav" id="glyph">
						<li role="presentation"><a href="index.php" style="color:#fff;"><span class="glyphicon glyphicon-user"></span></a></li>
						<li role="presentation"><a href="questions.php" style="color:#fff;"><span class="glyphicon glyphicon-question-sign"></span></a></li>
						<li role="presentation"><a href="dailytimes.php" style="color:#fff;"><span class="glyphicon glyphicon-dashboard"></span></a></li>
						<li role="presentation"><a href="notifications"  style="color:#fff;"><span class="glyphicon glyphicon-bell"></span></a></li>
                   </ul>
				   
				   
				   <ul class="nav navbar-nav navbar-right" id="glyph">	
						<!-- nav search -->
						<li>
							<form class="navbar-form navbar-right" role="search">
								<div class="form-group">
									<input type="text" class="form-control" onkeyup="showHint(this.value)" id="pioneer-search" name="pioneer-search" style="width:250px;overflow:auto;"placeholder="Search Here.." autocomplete="off">
									<div class="dropdown">
										<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" style="width:250px;"id="searchResult">

										</ul>
									</div>
								</div>								
							</form>
						</li>
						<!--end nav search -->
						
						<!-- dropdown -->
						<li class="dropdown">
							<a style="color:#fff" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Followings</a></li>
								<li><a href="#">Followers</a></li>
								<li><a href="#">Classroom</a></li>
								<li><a href="#">Quizes</a></li>
								<li><a href="#">Settings</a></li>
								<li><a href="signout.php">Sign Out</a></li>
							</ul>
						</li>
						<!-- end last ul -->
				  </ul>
				</div>
				<!-- End navbar-fields here -->
	
				
			</div>
		</nav>
		<script type="text/javascript" src="./js/pioneersearch.js"></script>
	<?php
	}
	
	
	
	/*public function self_post($id,$text)
	{
		global $pdo;
		
			$query = $pdo->prepare("insert into post(post_data,send_from_id,send_to_id,flag,time) values(?,?,?,?,?)");
			$one=1;
			$query->bindParam(1,$text);
			$query->bindParam(2,$id);
			$query->bindParam(3,$id);
			$query->bindParam(4,$one);
			$time = time();
			$query->bindParam(5,$time);
			if($query->execute())
			{
				echo '<div class="alert alert-success">Successfully posted</div>';
			}
			else
			{
				echo '<div class="alert alert-warning">Some problem occurs</div>';
			}
		
	}*/
	
	
	/*public function self_post_pic($id,$text,$pic)
	{
		global $pdo;
		
		
			$query = $pdo->prepare("insert into post(post_data,send_from_id,send_to_id,flag,time,post_pic) values(?,?,?,?,?,?)");
			$one=1;
			$query->bindParam(1,$text);
			$query->bindParam(2,$id);
			$query->bindParam(3,$id);
			$query->bindParam(4,$one);
			$time = time();
			$query->bindParam(5,$time);
			$query->bindParam(6,$pic);
			if($query->execute())
			{
				echo '<div class="alert alert-success">Successfully posted</div>';
			}
			else
			{
				echo '<div class="alert alert-warning">Some problem occurs</div>';
			}
		
	}*/
	
	public function check_username_pioneer($username)
	{
		global $pdo;
		$query=$pdo->prepare("select user_id from user where username = ?");
		$query->bindParam(1,$username);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
		
	public function postview_question($id,$userid,$post_flag)
	{
		global $pdo;
		
		$query = $pdo->prepare("select * from post where send_from_id = ? and flag =? order by post_id desc");
		
		$query->bindParam(1,$id);
		$query->bindParam(2,$post_flag);
		
		
		$query->execute();
		while($row = $query->fetch(PDO::FETCH_OBJ))
		{
?>
			<div class="panel" style="border:1px solid #e1e8ed;" id="<?php echo $row->post_id; ?>">
				<div class="row">
					<div class="col-xs-3">
						<?php
							$location='./uploads/'.$row->send_from_id.'/';
							if(!empty($this->getfield('profile_pic',$row->send_from_id)))
							{
						?>
								<a style="text-decoration:none;" href="profile.php?id=<?php echo $row->send_from_id; ?>"><img src="<?php echo $location.$this->getfield('profile_pic',$row->send_from_id).'_ldp';?>" id="profile-pic-small" class="img-responsive" alt="<?php echo $this->getfield('firstname',$row->send_from_id);?>"></a>
						<?php
							}
							else
							{
								echo '<a style="text-decoration:none;" href="profile.php?id='.$row->send_from_id.'"><img src="./images/profile.JPG" id="xs_prof_pic" class="img-responsive"  alt='.$this->getfield('firstname',$id).'/></a>';
							}
						?>
					</div>
					<div class="col-xs-9">
					
							<a style="text-decoration:none;" href="profile.php?id=<?php echo $row->send_from_id; ?>"><span style="font-family:robom;font-size:1.0em;"><?php echo $this->fullname($row->send_from_id);?></span></a>
							&nbsp;<span style="color:#8899a6;font-sizze:1.0em;" class="glyphicon glyphicon-question-sign"></span>&nbsp;
							<br>
							<div style="color:#8899a6;font-size:0.9em;">
								<?php $time = $row->time;?> 
								<abbr class="timeago" title="<?php echo date('c',$time); ?>"></abbr>
							</div>
						
					</div>
				</div>
				</br>
				<div class="row">
					<div class="col-xs-1">
					</div>
					<div class="col-xs-11">
						<span class="disp"><strong>Question:<br><?php echo htmlspecialchars($row->post_data);?></strong></span>
					</div>
				</div>
				</br>
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
				<div class="row">
					<div class="col-xs-1">
					</div>
					<div class="col-xs-11">
						<div class="panel-footer">
						<?php 
							if($row->send_from_id == $userid)
							{
						?>
								<a href="edit_question.php?qid=<?php echo $row->post_id;?>"><span  style="cursor:pointer;" class="glyphicon glyphicon-edit" title="Edit your question"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span id="delq" onclick="del_post(<?php echo $row->post_id;?>)" style="cursor:pointer;color:#2e6da4;" class="glyphicon glyphicon-remove" title="Delete your question"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="view_question.php?qid=<?php echo $row->post_id;?>"><span  style="cursor:pointer;" class="glyphicon glyphicon-pencil" title="Reply to your question"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span class="glyphicon glyphicon-comment" id="reply-box<?php echo $row->post_id; ?>" style="color:#2e6da4;cursor:pointer;"title="Replies to your question"><?php if($row->reply_count>0){echo $row->reply_count;}?></span>
								
						<?php
							}
							else
							{
						?>								
								<a href="view_question.php?qid=<?php echo $row->post_id;?>"><span style="cursor:pointer;" class="glyphicon glyphicon-pencil" title="Reply this question"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								
								<span class="glyphicon glyphicon-comment" id="reply-box<?php echo $row->post_id; ?>" style="color:#2e6da4;cursor:pointer;" title="Replies to this question"><?php if($row->reply_count>0){echo $row->reply_count;}?></span>&nbsp;&nbsp;
							
						<?php
							}
						?>
							
						</div>
					</div>
				</div>
				</br>
				
				
		<!------------   Viewing reply box and click on see more ------------->
				<div class="row" id="drop-reply-box<?php echo $row->post_id; ?>" style="display:none;">
					<div class="col-lg-1"></div>
					<div class="col-lg-11">
					
				<?php
					$rep = $pdo->prepare("select * from reply where question_id = ? order by rating desc limit 2");
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
							if(!empty($this->getfield('profile_pic',$reply->reply_by)))
							{
					?>
								<a style="text-decoration:none;" href="profile.php?id=<?php echo $reply->reply_by; ?>"><img src="<?php echo $reply_location.$this->getfield('profile_pic',$reply->reply_by).'_ldp';?>" id="profile-pic-small" class="img-responsive" alt="<?php echo $this->getfield('firstname',$reply->reply_by);?>"></a>
					<?php
							}
							else
							{
								echo '<a style="text-decoration:none;" href="profile.php?id='.$reply->reply_by.'"><img src="./images/profile.JPG" id="xs_prof_pic" class="img-responsive"  alt='.$this->getfield('firstname',$reply->reply_by).'/></a>';
							}
					?>
						<a style="text-decoration:none;" href="profile.php?id=<?php echo $reply->reply_by; ?>"><span style="font-family:robom;font-size:1.0em;"><?php echo $this->getfield('firstname',$reply->reply_by).' '.$this->getfield('lastname',$reply->reply_by);?></span></a>
						&nbsp;&nbsp;<a style="text-decoration:none;" href="profile.php?id=<?php echo $reply->reply_to; ?>"><span style="font-family:robol;font-size:1.0em;color:#8899a6;"><span class="glyphicon glyphicon-hand-right" style="color:#8899a6;"></span><?php echo '@'.$this->getfield('username',$reply->reply_to);?></span></a>
						<br>
						<span style="font-size:0.9em;"><?php echo '<pre>'.htmlspecialchars($reply->reply).'</pre>'; ?></span>
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
	
	public function postview($id,$userid)
	{
		global $pdo;
		
		$query = $pdo->prepare("select * from post where send_from_id = ? order by post_id desc");
		$query->bindParam(1,$id);		
		$query->execute();
		while($row = $query->fetch(PDO::FETCH_OBJ))
		{
	?>
			<div style="border-bottom:1px solid #d3d3d3;" id="<?php echo $row->post_id; ?>">
						<?php
							$location='./uploads/'.$row->send_from_id.'/';
							if(!empty($this->getfield('profile_pic',$row->send_from_id)))
							{
						?>
								<a style="text-decoration:none;" href="profile.php?id=<?php echo $row->send_from_id; ?>"><img src="<?php echo $location.$this->getfield('profile_pic',$row->send_from_id).'_ldp';?>" id="profile-pic-small" class="img-responsive" alt="<?php echo $this->getfield('firstname',$row->send_from_id);?>"></a>
						<?php
							}
							else
							{
								echo '<a style="text-decoration:none;" href="profile.php?id='.$row->send_from_id.'"><img src="./images/profile.JPG" id="xs_prof_pic" class="img-responsive"  alt='.$this->getfield('firstname',$id).'/></a>';
							}
						?>
							<a style="text-decoration:none;" href="profile.php?id=<?php echo $row->send_from_id; ?>"><span style="font-family:robom;font-size:1.0em;"><?php echo $this->fullname($row->send_from_id);?></span></a>
							<?php
							if($row->flag!=4)
							{
							?>
							<br>
							<span style="color:#8899a6;font-size:0.9em;">
								<?php $time = $row->time;?> 
								<abbr class="timeago" title="<?php echo date('c',$time); ?>"></abbr>
							</span>
							<?php
							}
							else
							{
								echo '<span style="color:#8899a6;font-sizze:1.0em;">Quiz?</span>';
							}
							?>
						</br></br>
	
		<!-- ------------ VARIOUS CHANGES ACCORDING TO POST FLAG AND CHECKING -------->

				<?php
					if($row->flag == 2)
					{
				?>
						<strong>Question:
						<span class="disp"><?php echo htmlspecialchars($row->post_data);?></span>
						</strong>
				<?php
					}
					else if($row->flag==4)
					{
						echo '<strong><span class="glyphicon glyphicon-th-list"></span></strong>';
						echo htmlspecialchars($row->post_data);
					}
					else
					{
				?>
						<span class="disp"><?php echo htmlspecialchars($row->post_data);?></span>
				<?php
					}
				?>
		<!--- ------------- POST FLAG CHECKING END HERE   --------------->
			
				</br>
			<?php
				if(!empty($row->post_pic))
				{
					$location = 'uploads/'.$row->send_from_id.'/';
			?>
				
						<img src="<?php echo $location.$row->post_pic;?>" id="lg_post_pic" class="img-responsive"/>
					
				</br>
				<?php
				}
			?>
			
	<!--     VARIOUS CHANGES ACCORDING TO POST FLAG AND CHECKING       --->
			<?php
				if($row->send_from_id == $userid)
				{
			?>
				
						<?php 
							if($row->flag == 2)
							{
						?>
								<a href="edit_question.php?qid=<?php echo $row->post_id;?>"><span  style="cursor:pointer;" class="glyphicon glyphicon-edit"  title="Edit your question"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span id="delq" onclick="del_post(<?php echo $row->post_id;?>)" style="cursor:pointer;color:#2e6da4;" class="glyphicon glyphicon-remove" title="Delete your question"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="view_question.php?qid=<?php echo $row->post_id;?>"><span  style="cursor:pointer;" class="glyphicon glyphicon-pencil" title="Reply to your question"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span class="glyphicon glyphicon-comment" style="color:#2e6da4;cursor:pointer;" title="Replies to your question" id="reply-box<?php echo $row->post_id; ?>"><?php echo $row->reply_count;?></span>&nbsp;&nbsp;
								</br>
						<?php
							}
							else if($row->flag ==4)
							{
						?>
								<span id="delq" onclick="del_post(<?php echo $row->post_id;?>)" style="cursor:pointer;color:#2e6da4;" class="glyphicon glyphicon-remove" title="Remove quiz from wall"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="give_quiz.php?qid=<?php echo $row->action; ?>"><span class="glyphicon glyphicon-log-in" title="Take a Challenge"></span></a>
								</br>
						<?php
							}
							else
							{
						?>
								<span id="delq" onclick="del_post(<?php echo $row->post_id;?>)" style="cursor:pointer;color:#2e6da4;" class="glyphicon glyphicon-remove" title="Remove quiz from wall"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</br>
						<?php
							}
						?>
						
			<?php
				}
				else
				{
			?>
				
						<?php 
							if($row->flag == 2)
							{
						?>
								<a href="view_question.php?qid=<?php echo $row->post_id;?>"><span style="cursor:pointer;" class="glyphicon glyphicon-pencil"  title="Reply this question"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
								<span class="glyphicon glyphicon-comment" style="color:#2e6da4;cursor:pointer;" title="Replies to this question" id="reply-box<?php echo $row->post_id; ?>" ><?php echo $row->reply_count;?></span>&nbsp;&nbsp;
								</br>
							
						<?php
							}
							else if($row->flag == 4)
							{
						?>
								<a href="give_quiz.php?qid=<?php echo $row->action; ?>"><span class="glyphicon glyphicon-log-in" title="Take a Challenge"></span></a>
						<?php
							}
							else
							{
						?>
						<?php
							}
						?>
						
			<?php
				}
			?>
			</br>
			
			
	<!---  ---------------Viewing reply box and click on see more------------ --->
				<div class="table" id="drop-reply-box<?php echo $row->post_id; ?>" style="display:none;">
					
					
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
							if(!empty($this->getfield('profile_pic',$reply->reply_by)))
							{
						?>
								<a style="text-decoration:none;" href="profile.php?id=<?php echo $reply->reply_by; ?>"><img src="<?php echo $reply_location.$this->getfield('profile_pic',$reply->reply_by).'_ldp';?>" id="profile-pic-small" class="img-responsive" alt="<?php echo $this->getfield('firstname',$reply->reply_by);?>"></a>
						<?php
							}
							else
							{
								echo '<a style="text-decoration:none;" href="profile.php?id='.$reply->reply_by.'"><img src="./images/profile.JPG" id="xs_prof_pic" class="img-responsive"  alt='.$this->getfield('firstname',$reply->reply_by).'/></a>';
							}
						?>
						<a style="text-decoration:none;" href="profile.php?id=<?php echo $reply->reply_by; ?>"><span style="font-family:robom;font-size:1.0em;"><?php echo $this->getfield('firstname',$reply->reply_by).' '.$this->getfield('lastname',$reply->reply_by);?></span></a>
						&nbsp;&nbsp;<a style="text-decoration:none;" href="profile.php?id=<?php echo $reply->reply_to; ?>"><span style="font-family:robol;font-size:1.0em;color:#8899a6;"><span class="glyphicon glyphicon-hand-right" style="color:#8899a6;"></span><?php echo '@'.$this->getfield('username',$reply->reply_to);?></span></a>
						<br>
						<span style="font-size:0.9em;"><?php echo '<pre>'.htmlspecialchars($reply->reply).'</pre>'; ?></span>
					</div>
				<?php
					}
				?>
					<span class="text-center" id="see-more"><a href="view_question.php?qid=<?php echo $row->post_id;?>">See More</a></span>
					</br>
				<?php
				}
				else
				{
				?>
					
					<span style="font-size:0.9em;">No replies yet&nbsp;&nbsp;<a href="view_question.php?qid=<?php echo $row->post_id;?>">Reply Here</a></span>
					</br>
				<?php
				}
				?>
				</div>
				<script>
						$("#reply-box"+<?php echo $row->post_id; ?>).click(function(e){
							$("#drop-reply-box"+<?php echo $row->post_id; ?>).slideToggle();
						});
				</script>
			</div>
			</br>
	<?php
		}
	
	}
	
	
	
	public function confirm_post_owner($qid,$uid)
	{
		global $pdo;
		$z=0;
		$step =$pdo->prepare("select post_id from post where send_from_id = ?");
		$step->bindParam(1,$uid);
		$step->execute();
		while($data = $step->fetch(PDO::FETCH_OBJ))
		{
			if($data->post_id == $qid)
			{
				$z=1;
				break;
			}
		}
		
		if($z == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function check_valid_post($qid)
	{
		global $pdo;
		$step =$pdo->prepare("select * from post where post_id = ?");
		$step->bindParam(1,$qid);
		$step->execute();
		if($step->rowCount())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function delete_question($qid)
	{
		global $pdo;
		$query = $pdo->prepare("delete from post where post_id = ?");
		$query->bindParam(1,$qid);
		$query->execute();
		$del_reply = $pdo->prepare("delete from reply where question_id = ?");
		$del_reply->bindParam(1,$qid);
		$del_reply->execute();
		
	}
	
	public function reply_count($qid,$flag)
	{
		global $pdo;
		$query = $pdo->prepare("select * from post where post_id = ?");
		$query->bindParam(1,$qid);
		$query->execute();
		
		$data = $query->fetch(PDO::FETCH_OBJ);
		$count = $data->reply_count;
		if($flag == 1)
		{
			$count = $count+1;
		}
		else
		{
			$count = $count-1;
		}
		$query = $pdo->prepare("update post set reply_count = ? where post_id = ?");
		$query->bindParam(1,$count);
		$query->bindParam(2,$qid);
		$query->execute();

		
	}
	
	public function question_count($id,$from_to)
	{
		global $pdo;
		if($from_to = 1)
		{
			$query = $pdo->prepare("select post_id from post where send_from_id = ? and flag = ?");
		}
		else
		{
			$query = $pdo->prepare("select post_id from post where send_to_id = ? and flag = ?");
		}
		$two = 2;
		$query->bindParam(1,$id);
		$query->bindParam(2,$two);
		$query->execute();		                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
		return $query->rowCount();
		
	}
	
	
	public function answer_to_question($reply,$qid,$replyby,$replyto)
	{
		global $pdo;
		$time = time();
		$query = $pdo->prepare("insert into reply(reply_by,reply_to,reply,question_id,reply_time) values(?,?,?,?,?)");
		$query->bindParam(1,$replyby);
		$query->bindParam(2,$replyto);
		$query->bindParam(3,$reply);
		$query->bindParam(4,$qid);
		$query->bindParam(5,$time);
		if($query->execute())
		{
			echo '<span class="alert alert-success">Replied successfully</span>';
		}
		else
		{
			echo '<span class="alert alert-warning">Some error occurs,Please try again</span>';
		}
	}
	
	public function answer_view($qid,$userid)
	{
		global $pdo;
		$query = $pdo->prepare("select * from reply where question_id = ? order by rating desc");
		$query->bindParam(1,$qid);
		$query->execute();
		$count = $query->rowCount();
		echo '<strong>'.$count.' Answers</strong><hr>';
		while($row = $query->fetch(PDO::FETCH_OBJ))
		{
	?>
			<div style="border:1px dashed #e0e0e0;" class="tabel" id="reply<?php echo $row->reply_id; ?>">
						<?php
							$location='./uploads/'.$row->reply_by.'/';
							if(empty($this->getfield('profile_pic',$row->reply_by)))
							{
						?>
								<a href="profile.php?id=<?php echo $row->reply_by;?>"><img src="./images/profile.JPG" id="profile-pic-small" class="img-responsive"></a>
						<?php
							}
							else
							{
						?>
								<a href="profile.php?id=<?php echo $row->reply_by;?>"><img src="<?php echo $location.$this->getfield('profile_pic',$row->reply_by).'_ldp';?>" id="profile-pic-small" class="img-responsive" alt="<?php echo $this->getfield('firstname',$row->reply_by);?>"></a>
						<?php
							}
						?>
					
							<a style="text-decoration:none;" href="profile.php?id=<?php echo $row->reply_by;?>"><span style="font-family:robom;font-size:1.0em;"><?php echo $this->getfield('firstname',$row->reply_by).' '.$this->getfield('lastname',$row->reply_by);?></span></a>
							&nbsp;<span style="color:#8899a6;font-sizze:1.0em;" class="glyphicon glyphicon-hand-right"></span>&nbsp;
							<a style="text-decoration:none;" href="profile.php?id=<?php echo $row->reply_to;?>"><span style="font-family:robol;font-size:1.0em;color:#8899a6;"><?php echo '@'.$this->getfield('username',$row->reply_to);?></span></a>
							<br>
							<small style="color:#8899a6;font-size:0.9em;">
								<?php $time = $row->reply_time;?> 
								<abbr class="timeago" title="<?php echo date('c',$time); ?>"></abbr>
							</small>
							</br>
							</br>
							<?php echo '<pre>'.htmlspecialchars($row->reply).'</pre>';?>
						</br>
				<?php
					if($row->reply_by == $userid)
					{
				?>
						<span style="color:#055D9A;cursor:pointer;" onclick="del_reply(<?php echo $row->reply_id;?>,<?php echo $row->question_id;?>)" title="Delete your reply" class="glyphicon glyphicon-remove-circle"></span>&nbsp;&nbsp;
						<span style="color:gray;cursor:pointer;" title="Can't rate your own answer" class="glyphicon glyphicon-star"></span>
						&nbsp;<span style="color:#055D9A;" id="fake_rate_count<?php echo $row->reply_id;?>"><?php if($row->rating >0){echo $row->rating; }?></span>
				<?php
					}
					else
					{
				
							if($this->rater_exist($row->reply_id,$row->reply_by,$row->reply_to) == true)
							{
						?>
								<span id="rate<?php echo $row->reply_id; ?>" style="color:#055D9A;cursor:pointer;display:none;" onclick="rate(<?php echo $row->reply_id; ?>,<?php echo $row->reply_by; ?>,<?php echo $row->reply_to; ?>)" class="glyphicon glyphicon-star">Rate</span>
								<span id="unrate<?php echo $row->reply_id; ?>" style="color:red;cursor:pointer;" onclick="unrate(<?php echo $row->reply_id; ?>,<?php echo $row->reply_by; ?>,<?php echo $row->reply_to; ?>)" class="glyphicon glyphicon-star-empty">Unrate</span>
							
							<!-- FAKE RATING DISPLAY PROBLEM WITH ONLOAD.WINDOW IN CASE OF FUNCTION RATE_COUNT_VIEW -->
								&nbsp;<span style="color:#055D9A;" id="fake_rate_count<?php echo $row->reply_id;?>"><?php echo $row->rating; ?></span>
							<!--END HERE-->
							
								&nbsp;<span style="color:#055D9A;" id="rate_count<?php echo $row->reply_id;?>"></span>
						<?php	
							}
							else
							{
						?>
								<span id="rate<?php echo $row->reply_id; ?>" style="color:#055D9A;cursor:pointer;" onclick="rate(<?php echo $row->reply_id; ?>,<?php echo $row->reply_by; ?>,<?php echo $row->reply_to; ?>)" class="glyphicon glyphicon-star">Rate</span>
								<span id="unrate<?php echo $row->reply_id; ?>" style="color:red;cursor:pointer;display:none;" onclick="unrate(<?php echo $row->reply_id; ?>,<?php echo $row->reply_by; ?>,<?php echo $row->reply_to; ?>)" class="glyphicon glyphicon-star-empty">Unrate</span>
							
							<!-- FAKE RATING DISPLAY PROBLEM WITH ONLOAD.WINDOW IN CASE OF FUNCTION RATE_COUNT_VIEW -->
								&nbsp;<span style="color:#055D9A;" id="fake_rate_count<?php echo $row->reply_id;?>"></span>
							<!--END HERE-->
							
								&nbsp;<span style="color:#055D9A;" id="rate_count<?php echo $row->reply_id;?>"><?php echo $row->rating; ?></span>
						<?php
							}
					}
				?>
					<!-- --PROBLEM IN ONLOAD SCRIPT FUNCTION rate_count_view() IS NOT WORKING IN ONLOAD.WINDOW COND-->		
							<script>
								window.onload = function(){
									rate_count_view(<?php echo $row->reply_id;?>);
								};
							</script>
					<!--SCRIPT ENDING HERE-->	
						
			</div>
			
		<?php
		}
	}
	
	public function pull_profile_pic($id)
	{
			$location='./uploads/'.$id.'/';

		
						if(empty($this->getfield('profile_pic',$id)))
						{
					?>
							<img src="./images/profile.JPG" id="profile-pic" class="img-thumbnail img-responsive">
					<?php
						}
						else
						{
					?>
							<img src="<?php echo $location.$this->getfield('profile_pic',$id);?>" id="profile-pic" class="img-thumbnail img-responsive" alt="<?php echo $this->getfield('firstname',$id);?>">
					<?php
						}
	
	}
	
	
	public function pull_cover_pic($user_id)
	{
		$location='./uploads/'.$user_id.'/';
		
		if(!empty($this->getfield('cover_pic',$user_id)))
		{
	?>
		<style>
			#cover-photo
			{
				background-image: url("<?php echo $location.$this->getfield('cover_pic',$user_id); ?>");
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
				background-image: url("./images/cover.JPG");
			}
		</style>
	<?php
		}
	}
	
	
	public function pull_edit_profile($user_id)
	{
		?>
						<div class="tabel" id="show-profile-details">
							<div class="panel-body">
								<span class="text-left" style="font-family:robom;font-size:20px;"><strong><?php echo $this->fullname($user_id); ?></strong></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b>Q4all</b>&nbsp;&nbsp;<?php echo '@'.$this->getfield('username',$user_id);?></span><br><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><?php echo $this->getfield('email',$user_id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-calendar"></span></b>&nbsp;&nbsp;<?php $time = $this->getfield('since',$user_id);echo date('d M Y',$time);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;<?php echo $this->getfield('organization',$user_id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-education"></span></b>&nbsp;&nbsp;<?php echo $this->getfield('highest_degree',$user_id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-map-marker"></span></b>&nbsp;&nbsp;<?php echo $this->getfield('lives_in',$user_id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-blackboard"></span></b>&nbsp;&nbsp;<?php echo $this->getfield('school',$user_id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-certificate"></span></b>&nbsp;&nbsp;<?php echo $this->getfield('hobbies',$user_id);?></span><br>
								<span class="text-left" style="font-family:robol;font-size:14px;color:#777;"><b><span style="color:#ff8d00;" class="glyphicon glyphicon-home"></span></b>&nbsp;&nbsp;<?php echo $this->getfield('hometown',$user_id);?></span>
							</div>
						</div>
		<?php
	}
	
	public function is_follower_following($user_id,$id)
	{
		global $pdo;
		$query = $pdo->prepare("select request_id from request where sent_from_id = ? and sent_to_id = ?");
		$query->bindParam(1,$user_id);
		$query->bindParam(2,$id);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	public function count_followings($id)
	{
		global $pdo;
		$query = $pdo->prepare("select sent_to_id from request where sent_from_id = ? and flag =?");
		$query->bindParam(1,$id);
		$one =1;
		$query->bindParam(2,$one);
		$query->execute();
		
		return $query->rowCount();
		
	}
	
	public function count_followers($id)
	{
		global $pdo;
		$query = $pdo->prepare("select sent_from_id from request where sent_to_id = ? and flag =?");
		$query->bindParam(1,$id);
		$one =1;
		$query->bindParam(2,$one);
		$query->execute();
		
		return $query->rowCount();
		
	}

	
	public function show_followings($id)
	{
		global $pdo;
		$query = $pdo->prepare("select * from request where sent_from_id = ? and flag =?");
		$query->bindParam(1,$id);
		$one =1;
		$query->bindParam(2,$one);
		$query->execute();
		while($row = $query->fetch(PDO::FETCH_OBJ))
		{
			$location='./uploads/'.$row->sent_to_id.'/';
	?>
			
							<div class="col-lg-3" style="border-radius:5px;">
								<div class="panel text-center" style="box-shadow:0px 0px 5px #707070;border-radius:5px;">
									<div class="panel-heading" style="padding:5px;">
										<div class="row">
											<div class="col-xs-12">
												<a href="profile.php?id=<?php echo $row->sent_to_id;?>">
													<?php		
														echo $this->getfield('firstname',$row->sent_to_id).' '.$this->getfield('lastname',$row->sent_to_id);
													?>
												</a>
											</div>
										</div>
									</div>
									<div class="panel-body" style="padding:0px;background:#fff; border:0px;">
										<div class="row">
											<div class="col-xs-12">
									<?php
										if(empty($this->getfield('profile_pic',$row->sent_to_id)))
										{
									?>
											
											<a href="profile.php?id=<?php echo $row->sent_to_id;?>">
												<img src="./images/profile.JPG" id="followings-profile-pic" class="img-responsive">
											</a>
									<?php
										}
										else
										{
									?>
										
											<a href="profile.php?id=<?php echo $row->sent_to_id;?>">
												<img src="<?php echo $location.$this->getfield('profile_pic',$row->sent_to_id);?>" id="followings-profile-pic" class="img-responsive" alt="<?php echo $this->getfield('firstname',$row->sent_to_id);?>" style="display:inline-block; margin:auto;";>
											</a>
									<?php
										}
									?>
											</div>
										</div>
									</div>	
									<div class="panel-footer" style="padding:5px;background-color:#fff;height:45px;text-overflow:ellipsis;">
										<a href="profile.php?id=<?php echo $row->sent_to_id;?>" style="color:#808080;">
											<?php		
												echo '@'.$this->getfield('username',$row->sent_to_id);
											?>
										</a>
										<div style="font-size:0.8em;overflow:hidden;text-overflow:ellipsis;max-height:15px;">
											<span style="text-overflow:ellipsis;"><?php echo '<span class="glyphicon glyphicon-heart-empty"></span>&nbsp;'.$this->getfield('status',$row->sent_to_id);?></span>
										</div>
									</div>
								</div>
							</div>
	<?php
		}
		
	}
	
	public function show_followers($id)
	{
		global $pdo;
		$query = $pdo->prepare("select * from request where sent_to_id = ? and flag =?");
		$query->bindParam(1,$id);
		$one =1;
		$query->bindParam(2,$one);
		$query->execute();
		
		while($row = $query->fetch(PDO::FETCH_OBJ))
		{
						$location='./uploads/'.$row->sent_from_id.'/';

	?>
			
							<div class="col-lg-3" style="border-radius:5px;">
								<div class="panel text-center" style="box-shadow:0px 0px 5px #707070;border-radius:5px;">
									<div class="panel-heading" style="padding:5px;">
										<div class="row">
											<div class="col-xs-12">
												<a href="profile.php?id=<?php echo $row->sent_from_id;?>">
													<?php		
														echo $this->getfield('firstname',$row->sent_from_id).' '.$this->getfield('lastname',$row->sent_from_id);
													?>
												</a>
											</div>
										</div>
									</div>
									<div class="panel-body" style="padding:0px;background:#fff; border:0px;">
										<div class="row">
											<div class="col-xs-12">
									<?php
										if(empty($this->getfield('profile_pic',$row->sent_from_id)))
										{
									?>
											
											<a href="profile.php?id=<?php echo $row->sent_from_id;?>">
												<img src="./images/profile.JPG" id="followings-profile-pic" class="img-responsive">
											</a>
									<?php
										}
										else
										{
									?>
										
											<a href="profile.php?id=<?php echo $row->sent_from_id;?>">
												<img src="<?php echo $location.$this->getfield('profile_pic',$row->sent_from_id);?>" id="followings-profile-pic" class="img-responsive" alt="<?php echo $this->getfield('firstname',$row->sent_from_id);?>" style="display:inline-block; margin:auto;";>
											</a>
									<?php
										}
									?>
											</div>
										</div>
									</div>	
									<div class="panel-footer" style="padding:5px;background-color:#fff;">
										<a href="profile.php?id=<?php echo $row->sent_from_id;?>" style="color:#808080;">
											<?php		
												echo '@'.$this->getfield('username',$row->sent_from_id);
											?>
										</a>
										<div style="font-size:0.8em;overflow:hidden;max-height:15px;">
											<?php echo '<span class="glyphicon glyphicon-heart-empty"></span>&nbsp;'.$this->getfield('status',$row->sent_from_id);?>
										</div>
									</div>
								</div>
							</div>
	<?php
		}
	}
		
		
	public function rater_exist($rid,$rep_by,$rep_to)
	{
			global $pdo;
			$query = $pdo->prepare("select rate_id from rate where reply_id =? and rate_by=? and rate_to =?");
			$query->bindParam(1,$rid);
			$query->bindParam(2,$rep_by);
			$query->bindParam(3,$rep_to);
			$query->execute();
			if($query->rowCount()>0)
			{	
				return true;
			}
			else
			{
				return false;
			}
	}
		
		
	
	
	
	
	
	public function fullname($id)
	{
		return $this->getfield('firstname',$id).' '.$this->getfield('lastname',$id);
	}
	
	
	public function pull_class_pic($id,$aid)
	{
		$location='./uploads/'.$id.'/';
		global $pdo;
		$query = $pdo->prepare("select * from academy where academy_id = ?");
		$query->bindParam(1,$aid);
		$query->execute();
		$row = $query->fetch(PDO::FETCH_OBJ);
		if(!empty($row->academy_pic))
		{
	?>
		<style>
			#academy_pic
			{
				background-image: url("<?php echo $location.$row->academy_pic; ?>");
			}
		</style>
	<?php
		}
		else
		{
	?>
		<style>
			#academy_pic
			{
				background-image: url("./images/banner.jpg");
			}
		</style>
	<?php
		}
	}
	
	function pull_clip_board($aid)
	{
		global $pdo;
		$query = $pdo->prepare("select * from academy_post where aid = ? order by apid desc");
		$query->bindParam(1,$aid);
		$query->execute();
		while($row = $query->fetch(PDO::FETCH_OBJ))
		{
				$location='./uploads/'.$row->user_id.'/';

		?>	
			<div class="col-lg-6">
				<div class="panel" style="border:1px solid #e1e8ed;padding:0px;" id="academypost<?php echo $row->apid;?>">
					<div class="panel-body">
						<div class="row" style="padding:6px;padding-top:3px;">
							<div class="col-xs-2">
								<img src="<?php echo $location.$this->getfield('profile_pic',$row->user_id); ?>" style="height:40px;width:40px;display:block;"/>
							</div>
							<div class="col-xs-10">
								<strong><?php echo $this->getfield('firstname',$row->user_id); ?></strong>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-xs-12">
								<?php echo $row->text;?>
							</div>
						</div>
						<br/>
						<div class="row" style="padding-left:5px;padding-top:3px;">
							<div class="col-xs-12">
								<span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;&nbsp;&nbsp;
								<span class="glyphicon glyphicon-remove" onclick="del_acpost(<?php echo $row->apid;?>);"></span>&nbsp;&nbsp;
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	}
	
}

$ob = new PioneerFunctions;

?>
<script>
									function del_reply(reply_id,question_id)
									{
										if (confirm("Do you want to delete your reply?") == true)
										{
											$.ajax({
												url:'delete_reply.php',
												type:"post",
												data:'rid='+reply_id+'&qid='+question_id,
												success:function()
												{
													$('#reply'+reply_id).fadeOut();
												}
											});
										}
										
									}
									
									
									function del_post(vald)
									{
										if (confirm("Do you want to delete your question?") == true)
										{
											$.ajax({
												url:'delete_question.php',
												type:"post",
												data:'qid='+vald,
												success:function()
												{
													$('#'+vald).fadeOut();
												}
											});
										}
									}
				
					//-----TO INCREMENT RATE-------
						function rate(rep_id,rep_by,rep_to)
						{
									$.ajax({
											url:'rate.php',
											type:"post",
											data:'rep_id='+rep_id+'&rep_by='+rep_by+'&rep_to='+rep_to,
											success:function()
											{
												//pull_rate(rep_id,rep_by,rep_to);
												$("#rate"+rep_id).hide();
												$("#unrate"+rep_id).fadeIn();
												$("#fake_rate_count"+rep_id).hide();
											},
											complete:function()
											{
												rate_count_view(rep_id);
											}
										});
						}
						
						
					//-----TO DECCREMENT RATE-------
						function unrate(rep_id,rep_by,rep_to)
						{
									$.ajax({
											url:'unrate.php',
											type:"post",
											data:'rep_id='+rep_id+'&rep_by='+rep_by+'&rep_to='+rep_to,
											success:function()
											{
												//pull_rate(rep_id,rep_by,rep_to);
												$("#rate"+rep_id).fadeIn();
												$("#unrate"+rep_id).hide();
												$("#fake_rate_count"+rep_id).hide();
											},
											complete:function()
											{
												rate_count_view(rep_id);
											}
										});
						}
						
						/*
						NOT WORKING
						function pull_rate(rep_id,rep_by,rep_to)
						{
							$.ajax({
								url: 'view_rate.php',
								method: "POST",
								data:'rep_id='+rep_id+'&rep_by='+rep_by+'&rep_to='+rep_to,
								success: function(data) {
									$('#rater-display'+rep_id).html(data);
								},
								error: function(){
									$('#rater-display'+rep_id).html('Some error occurs');
								},
								complete:function()
								{
									rate_count_view(rep_id);
								}
							});
						}*/
						
						
					//--TO SHOW RUNTIME RATE COUNT-----
						function rate_count_view(rep_id)
						{
							$.ajax({
								url: 'view_rate_count.php',
								method: "POST",
								data:'reply_id='+rep_id,
								success: function(data) {
									$('#rate_count'+rep_id).html(data);
								},
								error: function(){
									$('#rate_count'+rep_id).html('Some error occurs');
								}
							});
						}
						
				function del_acpost(apid)
				{
					if (confirm("Do you want to delete your reply?") == true)
					{

						$.ajax({
							url:'del_acpost.php',
							method:"post",
							data:"apid="+apid,
							success:function(resp)
							{
								$("#academypost"+apid).fadeOut();
							}
						});
					
					}
				}
				
				function attach(qid)
				{
					$.ajax({
						url:'attach_quiz.php',
						method:"post",
						data:"qid="+qid,
						success:function(resp)
						{
							//alert(resp);
							confirm('Attached!');
						}
					});
					
				}
</script>							

<script>
			function login()
			{
					$("#sign-up").hide();
					$("#about-us").hide();
					$("#success").hide();
					$("#sign-in").slideToggle("slow");
			}
	$(".timeago").timeago(); // Calling Timeago Funtion 
</script>
