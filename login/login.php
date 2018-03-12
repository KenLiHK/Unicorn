<?php

include_once("../common/functions.php");

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_SESSION['login_user_id'])){
	$userID_In_Session = $_SESSION['login_user_id'];
}

$isFormDataValid = true;

//define input field variables to keep user input value and show on the page when server side validation failure
$userIDEmail = "";
$pass = "";


//define server side error message variables and set to empty values
$userIDEmailMsg_php = "";
$passMsg_php = "";
$serverErrMsg_php = "<div class='alert mt-4 alert-success'><span></span></div>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$userIDEmail = optimizateInput($_POST["userIDEmail"]);	
	$pass = optimizateInput($_POST["pass"]);	//No need to display password when server side validation is failed
	
	// ******** [START] User ID / Email validation ********
	if(empty($userIDEmail)) {
		$userIDEmailMsg_php = "[E601] User ID / Email must be input!";
	}
	
	if($userIDEmailMsg_php != ""){
		$isFormDataValid = false;
	}
	// ******** [END] User ID / Email validation ********
	
	// ******** [START] Password validation ********
	if(empty($pass)) {
		$passMsg_php = "[E602] Password must be input!";	
	}

	/*
		Check password format and character combination
		rule 1 : Password length must be 8 - 20 characters
		rule 2 : Password must contain at least 2 upper case characters
		rule 3 : Password must contain at least 2 lower case characters
		rule 4 : Password must contain at least 2 numeric characters
		rule 5 : Password must contain at least 2 special characters
	*/
	if($passMsg_php == "" && !empty($pass)) {
		$anUpperCase = "#[A-Z]#";
		$aLowerCase = "#[a-z]#"; 
		$aNumber = "#[0-9]#";
		$aSpecial =  "#(?=\S*[\W])#"; //"#[!|@|#|$|%|^|&|*|(|)|-|_]#";
		
		if (strlen($pass) < 8 || strlen($pass) > 20) {
			$passMsg_php = "[E603] Password length must be 8 - 20 characters!";
		}
		else if (!preg_match($anUpperCase, $pass)) {
			$passMsg_php = "[E604] Password must contain at least 2 upper case characters!";
		}
		else if (!preg_match($aLowerCase, $pass)) {
			$passMsg_php = "[E605] Password must contain at least 2 lower case characters!";
		}
		else if (!preg_match($aNumber, $pass)) {
			$passMsg_php = "[E606] Password must contain at least 2 numeric characters!";
		}
		else if (!preg_match($aSpecial, $pass)) {
			$passMsg_php = "[E607] Password must contain at least 2 special characters!";
		}    
	}
	
	if($passMsg_php != ""){
		$isFormDataValid = false;
	}
	// ******** [END] Password validation ********
		
	if($isFormDataValid)
	{
		$result = login_by_userId_or_email_password($userIDEmail, $pass);
		
		if($result == "true") {
			//login successfully
			//reset form data in the post request
			unset($_POST);
			
			//go to home page
			header('Location: ../recommend/recom_home.php');
			exit;
		} else {
			//login failed
			$serverErrMsg_php = "<div class='alert mt-4 alert-danger'><span>[E608] Login failed, please try again!</span></div>";
		}
	}
}

?>

<html>
	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant - Login</title>
		
		<!-- Using Icon library and refer to https://www.w3schools.com/w3css/w3css_icons.asp -->
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../unicorn.css">
		<link rel="stylesheet" href="./login.css">
		<!-- include jQuery for Ajax call -->
		<script type="text/javascript" src="../jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="./login.js"></script>
	</head>

	<body>	
		<form name="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return formSubmit()">
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
										<a href="../searchDish/search.php">
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
													'<a href="../registration/registerForm.php"><i class="fa fa-user-plus"> Sign-up </i></a> <span>&nbsp;</span>';
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
								<div><?php if(isset($serverErrMsg_php)){echo $serverErrMsg_php;} ?></div>
								<!-- ******** [END] Alert Message Display ******** -->
								
								
								<!-- ******** [START] Login Division ******** -->
								<div class="container">
									<h5>Login</h5>
									<hr>
									<label class="mandatory_field">* Mandatory field</label><br>
									<div>
										<label class="login_label">User ID / Email : </label><label class="mandatory_field">*</label> 
										<input class="login_input" type="text" id="userIDEmail" name="userIDEmail" maxlength="50" value="<?php if(isset($userIDEmail)){echo $userIDEmail;} ?>" >								
										<span class="login_err" id="userIDEmailMsg" ><?php if(isset($userIDEmailMsg_php)){echo $userIDEmailMsg_php;} ?></span>
									<div>
									
									<div>
										<label class="login_label">Password : </label><label class="mandatory_field">*</label> 
										<input class="login_input" type="password" id="pass" name="pass" maxlength="100" >
										<span class="login_err" id="passMsg" ><?php if(isset($passMsg_php)){echo $passMsg_php;} ?></span>
									<div>
									<br><br>
									<div>
									  <input class="login_input4" type="reset" name="Reset" value="Reset" onclick="resetErrMsg();">
									  <input class="login_input5" type="submit" name="login" value="Login">
									</div>
								</div>
								<!-- ******** [END] Login Division ******** -->
								
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