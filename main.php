<?php
	include('class.php');
	$val=$ob->loggedin();
	if($val == true)
	{
		header('location:index.php');
	}
	

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
		<script src="js/jquery-1.9.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="mynav">
			<div class="container">
				<div class="navbar-brand text-center">
					<span id="brand-title">Q4all</span>
				</div>
			</div>
		</nav>
		</br>
		<!-- section start -->
		<section id="sign-section">
			<div class="container text-center">
			<!-- Navbar Titles  -->
				<div class="row">
					<div class="col-lg-2">
					</div>
					<div class="col-lg-8">
						<ul class="nav nav-tabs navbar-right" id="sign-nav">
							<li><a href="#" id="signin">Sign In</a></li>
							<li><a href="#" id="signup">Sign Up</a></li>
							<li><a href="#" id="aboutus">About Us</a></li>
						</ul>
					</div>
					<div class="col-lg-2">
					</div>
				</div><!-- end here -->
				
				<div class="row"><!-- Row -->
					<div class="col-lg-3">
					</div>
					
					<!-- Sign Up -->
					<div class="col-lg-6" id="sign-up">	
						<div class="well">
							<h2 class="cover-heading">Register Here</h2>
							<form class="form-horizontal" method="post" id="reg-form">
								<div class="form-group">
									<input type="email" class="form-control" id="email" name="email" onblur="check_email()" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="Email" autocomplete="off" required>
									<span id="email-info"></span>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" id="firstname" maxlength="25" name="firstname" onblur="check_firstname()" placeholder="First Name" value="<?php if(isset($_POST['firstname'])) echo $_POST['firstname']; ?>" autocomplete="on" required>
									<span id="firstname-info"></span>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" id="lastname" maxlength="25" name="lastname" onblur="check_lastname()" placeholder="Last Name" value="<?php if(isset($_POST['lastname'])) echo $_POST['lastname']; ?>" autocomplete="on" required>
									<span id="lastname-info"></span>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" id="username" maxlength="30" name="username" onblur="check_username()" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" placeholder="Username" autocomplete="on" required>
									<span id="username-info"></span>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="password" maxlength="30" name="password" placeholder="Password" onblur="check_password()" autocomplete="off" required>
									<span id="password-info"></span>
								</div>
								<button type="submit" class="btn btn-default" style="font-size:1.5em;" id="register">Sign Up</button>
							</form>
						</div>
					</div><!-- end -->
					
					<!-- Sign In -->
					<div class="col-lg-6" id="sign-in">	
						<div class="well">
							<h2 class="cover-heading">Login Here</h2>
							<form class="form-horizontal" method="post" id="login-form">
								<div class="form-group">
									<input type="text" class="form-control" id="loguser" name="loguser" placeholder="Username" autocomplete="on" required>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="logpass" name="logpass" placeholder="Password" autocomplete="off" required>
									<span id="login-info"></span>
								</div>
	
								<button type="submit" class="btn btn-default" style="font-size:1.5em;" id="login">Sign In</button>
							</form>
						</div>
					</div><!-- end -->
					
					<!-- About Us -->
					<div class="col-lg-6" id="about-us">	
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<h2>About Us</h2>
							</div>
							<div class="panel-body">
								<p class="panel-text text-center" style="font-family:robol;font-size:1.5em;">Q4all provides you two sided platform where you can learn from anyone and teach anyone.You can ask question and share your talents with any one.No body comes genius in this world,some people understands quickly and some takes more than 2 hours.One thing is common in all of us and that is we are here to learn this world.<br>Welcome to the learning platform of Q4all.</p>
							</div>
						</div>
					</div>
					<!-- end -->
					
					<!-- success on signup-->
					<div class="col-lg-6">	
						<div class="panel panel-primary" id="success">
							<div class="panel-body text-center">
							</div>
						</div>
					</div><!--- end panel -->
					
					<div class="col-lg-3">
					</div>
					
				</div>
			</div>
		</section><!-- section end here -->
		
		<section id="features">
			<div class="container">
				<div class="row">
					<div class="col-lg-4">
						<div class="panel panel-default text-center">
							<div class="panel-body">
								<h3>This is text heading</h3>
								<p>Very often you can hear people using FICA in their terminology. FICA stands for the Federal Insurance Contributions Act and the FICA tax consists of both Social Security and Medicare taxes.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="panel panel-default text-center">
							<div class="panel-body">
								<h3>This is text heading</h3>
								<p>Very often you can hear people using FICA in their terminology. FICA stands for the Federal Insurance Contributions Act and the FICA tax consists of both Social Security and Medicare taxes.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="panel panel-default text-center">
							<div class="panel-body">
								<h3>This is text heading</h3>
								<p>Very often you can hear people using FICA in their terminology. FICA stands for the Federal Insurance Contributions Act and the FICA tax consists of both Social Security and Medicare taxes.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<footer class="footer">
			<div class="container text-center">
				<em>Founder of Q4all: Anurag Kumar</em>
			</div>
		</footer>
		<script type="text/javascript" src="./js/signform.js"></script>
		<script>
			$(document).ready(function(){			
				$("#signin").click(function(){
					$("#sign-up").hide();
					$("#about-us").hide();
					$("#success").hide();
					$("#sign-in").slideToggle("slow");
				});
				
				$("#signup").click(function(){
					$("#sign-in").hide();
					$("#about-us").hide();
					$("#success").hide();
					$("#sign-up").slideToggle("slow");
				});
				
				$("#aboutus").click(function(){
					$("#sign-up").hide();
					$("#sign-in").hide();
					$("#success").hide();
					$("#about-us").slideToggle("slow");
				});
			});
			
			
		</script>
	</body>
</html>
