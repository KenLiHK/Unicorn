<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_SESSION['login_user_id'])){
	$userID_In_Session = $_SESSION['login_user_id'];
}

$_emailValidateUrl= isset($_SESSION['emailValidateUrl']) ? $_SESSION['emailValidateUrl'] : "";
unset($_SESSION['emailValidateUrl']);

?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="10; URL=../recommend/recom_home.php">
		
		<title>Unicorn Restaurant</title>
		
		<!-- Using Icon library and refer to https://www.w3schools.com/w3css/w3css_icons.asp -->
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../unicorn.css">
		<link rel="stylesheet" href="./registration.css">		
		<script type="text/javascript" src="../unicorn.js"></script>
		<script type="text/javascript" src="./registration.js"></script>
	</head>


	<body>
		<form name="regForm" method="post" action="" onsubmit="">
			<div id="app">
				<div>
				
					<!-- ******** [START] Left panel ******** -->
					<aside id="left-panel" class="left-panel">
						<nav class="navbar navbar-expand-lg">
						
							<!-- ******** [START] Logo ******** -->
							<div class="navbar-header">
								<a href="../recommend/recom_home.php" class="navbar-brand">
									<img src="../resources/cs5281unicorn2_6.png" alt="Logo" class="float-left">
								</a> 
							</div>
							<!-- ******** [END] Logo ******** -->
							
							
							<!-- ******** [START] Left function menu ******** -->
							<div id="main-menu" class="navbar-collapse">
								<ul class="navbar-nav">
									<a href="../recommend/recom_home.php">
										<h3 class="menu-title"> Unicorn Restaurant </h3>
									</a>
									
									<li class="nav-item">
										<a href="../recommend/recom_home.php">
											<i class="menu-icon fa fa-search"></i>
											<span class="menu-title-text"> Search Dish </span>
										</a>
									</li>				
		
									<li class="nav-item mt-auto">
										<a href="../placeOrder/cart.php">
											<i class="menu-icon fa fa-shopping-cart"></i>
											<span class="menu-title-text"> Place Order </span>
										</a>
									</li>
											
									<li class="nav-item mt-auto">
										<a href="../comment/comment_section.php">
											<i class="menu-icon fa fa-comments"></i>
											<span class="menu-title-text"> Comment </span>
										</a>
									</li>															
									
									<li class="nav-item mt-auto">
										<a href="../userProfile/userProfile.php">
											<i class="menu-icon fa fa-user"></i>
											<span class="menu-title-text"> User Profile </span>
										</a>
									</li>
									
																			
									<li class="nav-item">
										<a href="../login/login.php">
											<i class="menu-icon fa fa-sign-in"></i>
											<span class="menu-title-text">Login</span>
										</a>
									</li>
	
									<li class="nav-item">
										<a href="../registration/registerForm.php">
											<i class="menu-icon fa fa-user-plus"></i>
											<span class="menu-title-text">Sign Up</span>
										</a>
									</li>
									
									<li class="nav-item">
										<a href="../contactUs/contactUs.php">
											<i class="menu-icon fa fa-globe"></i>
											<span class="menu-title-text">Contact Us</span>
										</a>
									</li>
									
								</ul>
							</div>
							<!-- ******** [END] Left function menul ******** -->
							
							
							
						</nav>
						
						<div></div>
					</aside>
					<!-- ******** [END] Left panel ******** -->
					
					
					
					<!-- ******** [START] Right panel ******** -->
					<div id="right-panel" class="right-panel">
						
						
						
						<!-- ******** [START] Navigation Header Bar ******** -->			
						<header id="header" class="header">
							<div>							
								<div class="header-right">
									<div>
										<?php
											if(isset($userID_In_Session )){
												echo
													'<a href="../notification/notification.php"><i class="fa fa-envelope"></i> </a> <span>&nbsp;</span>
											 		 <a href="../userProfile/userProfile.php"><i class="fa fa-profile"></i>' .@$userID_In_Session . '</a> <span>&nbsp;</span>
											 		 <a href="../login/logout.php"><i class="fa fa-sign-out"></i> Logout </a> <span>&nbsp;</span>';
											}else{
												echo
													'<a href="../login/login.php"><i class="fa fa-sign-in"> Login </i></a> <span>&nbsp;</span>
			            					 		 <a href="../registration/registerForm.php"><i class="fa fa-user-plus"> Sign-up </i></a> <span>&nbsp;</span>';
											}
					        			?>
									</div>								
								</div>						
							</div>
						</header>
						<!-- ******** [START] Navigation Header Bar ******** -->
						
						
						
						
						<!-- ******** [START] Navigation Body ******** -->
						<div>
							<div>
							
								<!-- ******** [START] Alert Message Display ******** -->
								<div class="alert mt-4 alert-success">
									<span></span>
								</div>
								<!-- ******** [END] Alert Message Display ******** -->
								
								
								
								<!-- ******** [START] User Registration Division ******** -->
								<div class="container">
									<h5 class="reg_success">An activation email is sent to your email, please login your email and complete the activation process.</h5>
									<span style="color:white"><?php if(isset($_emailValidateUrl)){echo $_emailValidateUrl;} ?></span>
									<hr>
									
								</div>	
								<!-- ******** [END] User Registration Division ******** -->
								
								<!-- ******** [START] Footer ******** -->						
									<div class="col-md-12">
										<div class="card">						
											<div class="card-footer">
												<ul>									
													<li>
														<div class="text-muted">Email</div>
														<strong>cs5281unicorn@unicorn.com</strong>											
													</li>
													<li class="hidden-sm-down">
														<div class="text-muted">Tel</div>
														<strong>+852 5281-2018</strong>
													</li>
													<li class="hidden-sm-down">
														<div class="text-muted">Fax</div>
														<strong>+852 5281-2019</strong>
													</li>												
												</ul>
												
											</div>
											
											<div class="card-footer">										
												<ul>
													<li>
														<div class="text-muted">Service Hour</div>
														<strong>Monday - Sunday 09:00-23:00</strong>
													</li>										
													<li>
														<div class="text-muted">Address</div>
														<strong>Li Dak Sum Yip Yio Chin A Bldg 5606, Hong Kong</strong>
													</li>
												</ul>										
											</div>
											
											
										</div>
									</div>
								<!-- ******** [END] Footer ******** -->
								
								
								
							</div>
						</div>
						<!-- ******** [END] Navigation Body ******** -->
						
						
						
					</div>
					<!-- ******** [END] Right panel ******** -->
					
					
				</div>
			</div>
		</form>
	</body>
</html>