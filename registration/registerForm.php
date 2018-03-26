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
$userID = "";
$email = "";

$pass = "";
$repeatPass = "";

$engSurname = "";
$engMidName = "";
$engName = "";

$sex = "M";
$tel = "";

$address1 = "";
$address2 = "";
$address3 = "";
$address4 = "";

$tc = "";

//define server side error message variables and set to empty values
$userIDMsg_php = "";
$userIDInfoMsg_php = "";
$emailMsg_php = "";
$emailInfoMsg_php = "";

$passMsg_php = "";
$repeatPassMsg_php = "";

$engSurnameMsg_php = "";
$engMidNameMsg_php = "";
$engNameMsg_php = "";

$sexMsg_php = "";
$telMsg_php = "";

$address1Msg_php = "";
$address2Msg_php = "";
$address3Msg_php = "";
$address4Msg_php = "";

$tcMsg_php = "";


//if(!empty($_POST["signUp"])) {
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$userID = optimizateInput($_POST["userID"]);
	$email = optimizateInput($_POST["email"]);
	$pass = optimizateInput($_POST["pass"]);
	$repeatPass = optimizateInput($_POST["repeatPass"]);
	$engSurname = optimizateInput($_POST["engSurname"]);
	$engMidName = optimizateInput($_POST["engMidName"]);
	$engName = optimizateInput($_POST["engName"]);
	$sex = optimizateInput($_POST["sex"]);
	$tel = optimizateInput($_POST["tel"]);
	$address1 = optimizateInput($_POST["address1"]);
	$address2 = optimizateInput($_POST["address2"]);
	$address3 = optimizateInput($_POST["address3"]);
	$address4 = optimizateInput($_POST["address4"]);
	$tc = optimizateInput(isset($_POST["tc"]));
	
	// ******** [START] User ID validation ********
	if(empty($userID)) {
		$userIDMsg_php = "[E001] User ID must be input!";
	}
	
	if($userIDMsg_php == ""){
		$_userID = db_select_user_by_UserID($userID);
		if(!isset($_userID))
		{
			$userIDInfoMsg_php = "[I001] User ID is acceptable!"; //NOT found UserID in DB
		}
		else
		{
			$userIDMsg_php = "[E002] The User ID is already in used; please try a different User ID!"; //Found UserID in DB
		}
	}
	
	if($userIDMsg_php == ""){
		if (strlen($userID) < 5 || strlen($userID) > 50) {
			$userIDMsg_php = "[E003] User ID length must be 5 - 50 characters!";
		}
	}
	
	if($userIDMsg_php == ""){
		$startWithEngChar = "#^[A-Za-z]{1}#";		
		if (!preg_match($startWithEngChar, $userID)) {
			$userIDMsg_php = "[E004] The User ID must start with English alphabet!";		
		}
	}

	if($userIDMsg_php == ""){
		$engCharNum = "#[A-Za-z0-9]#";		
		if (!preg_match($engCharNum, $userID)) {
			$userIDMsg_php = "[E005] The User ID must be composed of English alphabets or English alphabets and numbers!";		
		}
	}
	
	if($userIDMsg_php != ""){
		$isFormDataValid = false;
	}
	// ******** [END] User ID validation ********
	
	// ******** [START] Email validation ********
	if(empty($email)) {
		$emailMsg_php = "[E006] Email must be input!";	
	}

	if($emailMsg_php == ""){
		$_email = db_select_user_by_Email($email);
		if(!isset($_email))
		{
			$emailInfoMsg_php = "[I002] Email is acceptable!"; //NOT found Email in DB
		}
		else
		{
			$emailMsg_php = "[E007] Email is already registered, please register by other email!"; //Found Email in DB			
		}
	}
	
	//Validate email address pattern
	if ($emailMsg_php == "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailMsg_php = "[E008] Invalid Email!";	
	}
	
	if($emailMsg_php != ""){
		$isFormDataValid = false;
	}
	// ******** [END] Email validation ********
	
	// ******** [START] Password validation ********
	if(empty($pass)) {
		$passMsg_php = "[E009] Password must be input!";	
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
			$passMsg_php = "[E010] Password length must be 8 - 20 characters!";
		}
		else if (!preg_match($anUpperCase, $pass)) {
			$passMsg_php = "[E011] Password must contain at least 2 upper case characters!";
		}
		else if (!preg_match($aLowerCase, $pass)) {
			$passMsg_php = "[E012] Password must contain at least 2 lower case characters!";
		}
		else if (!preg_match($aNumber, $pass)) {
			$passMsg_php = "[E013] Password must contain at least 2 numeric characters!";
		}
		else if (!preg_match($aSpecial, $pass)) {
			$passMsg_php = "[E014] Password must contain at least 2 special characters!";
		}    
	}
	
	if($passMsg_php != ""){
		$isFormDataValid = false;
	}
	// ******** [END] Password validation ********
	
	// ******** [START] Repeat Password validation ********
	if(empty($repeatPass)) {
		$repeatPassMsg_php = "[E015] Repeat Password must be input!";		
	}
	
	//Check password equal to repeat password
	if($repeatPassMsg_php == "" && !empty($pass) && !empty($repeatPass) && $pass != $repeatPass){ 
		$repeatPassMsg_php = '[E016] Repeat Password must be equal to Password!';
	}
	
	if($repeatPassMsg_php != ""){
		$isFormDataValid = false;
	}
	// ******** [END] Repeat Password validation ********

	if(empty($engSurname)) {
		$engSurnameMsg_php = "[E017] English Surname must be input!";
		$isFormDataValid = false;
	}

	if(empty($engMidName)) {
		$engMidNameMsg_php = "[E018] English Middle Name must be input!";
		$isFormDataValid = false;
	}
	
	//engName is NOT mandatory field
	/*
	if(empty($engName)) {		
		//$engNameMsg_php
	}
	*/
	
	//radio button has default value 'Male'
	/*
	if(empty($sex)) {		
		//4sexMsg_php
	}
	*/
	
	// ******** [START] Contact phone number validation ********
	if(empty($tel)) {
		$telMsg_php = "[E019] Contact Phone No. must be input!";		
	}
	
	//Contact phone number must be numeric
	if($telMsg_php == "" && !empty($tel)) {		
		if (!is_numeric($tel)) {
			$telMsg_php = "[E020] Contact Phone No. must be numeric!";
		}
	}
	
	if($telMsg_php != ""){
		$isFormDataValid = false;
	}
	// ******** [END] Contact phone number validation ********
	
	if(empty($address1)) {
		$address1Msg_php = "[E021] Flat and floor no. must be input!";
		$isFormDataValid = false;
	}
	
	if(empty($address2)) {
		$address2Msg_php = "[E022] Name of building must be input!";	
		$isFormDataValid = false;
	}
	
	if(empty($address3)) {
		$address3Msg_php = "[E023] Building no. and name of street must be input!";
		$isFormDataValid = false;		
	}
	
	if(empty($address4)) {
		$address4Msg_php = "[E024] District must be input!";
		$isFormDataValid = false;
	}

	if(empty($tc)) {
		$tcMsg_php = "[E025] Terms & Conditions must be accepted!";
		$isFormDataValid = false;
	}
	
	if($isFormDataValid)
	{
		$encrypttedPassword = md5($pass);
		$regToken = date("Ymd").hash('sha256', $userID); //current date + userID hash value
		
		//new an user object to keep form post information for passing to db_insert_user function in database.php	
		$user = new User($userID, "", $sex, $engSurname, $engMidName, 
						$engName, $email, $tel, $address1, $address2, 
						$address3, $address4, $encrypttedPassword, $regToken); 

		$result = db_insert_user($user); //insert new user account information into database
		
		if(empty($result)) {		
			$email_receiver = $email;
			$email_subject = "Activate Unicorn Restaurant user account";
			$emailValidateUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") 
								. "://$_SERVER[HTTP_HOST]"."/CS5281Unicorn/registration/activateService.php"
								."?reg_token="."$regToken"."&email=".$email;
			$email_content = "Thank you for signing up!"."\n"."Please click on the following activation link to activate your account,"."\n"."$emailValidateUrl";
			
			//send account activation email to customer
			sendEmail($email_receiver, $email_subject, $email_content);
			
			//reset form data in the post request
			unset($_POST);
			
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			
			$_SESSION['emailValidateUrl'] = $emailValidateUrl;
			
			//go to success page
			header('Location: ./registerSuccess.php');
			exit;
		} else {
			//echo "result message=".$result;
			//echo "Problem in user account registration. Please try again!";
			
			header('Location: ./registerFailure.php');
			exit;
		}
	}
}

?>

<html>
	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant - Account Registration</title>
		
		<!-- Using Icon library and refer to https://www.w3schools.com/w3css/w3css_icons.asp -->
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../unicorn.css">
		<link rel="stylesheet" href="./registration.css">
		<!-- include jQuery for Ajax call -->
		<script type="text/javascript" src="../jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="../unicorn.js"></script>
		<script type="text/javascript" src="./registration.js"></script>
	</head>

	<body>	
		<form name="regForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return formSubmit()">
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
									<h5>Sign Up</h5>
									<hr>
									<label class="mandatory_field">* Mandatory field</label><br>
									<div>
										<label class="reg_label">User ID<label class="mandatory_field">*</label> : </label> 
										<input class="reg_input" type="text" id="userID" name="userID" maxlength="50" value="<?php if(isset($userID)){echo $userID;} ?>" >
										<span class="reg_info" id="userIDInfoMsg" ><?php if(isset($userIDInfoMsg_php)){echo $userIDInfoMsg_php;} ?></span>								
										<span class="reg_err" id="userIDMsg" ><?php if(isset($userIDMsg_php)){echo $userIDMsg_php;} ?></span>
									<div>
									
									<div>
										<label class="reg_label">Email<label class="mandatory_field">*</label> : </label> 
										<input class="reg_input" type="email" id="email" name="email" maxlength="100" value="<?php if(isset($email)){echo $email;} ?>" >
										<span class="reg_info" id="emailInfoMsg" ><?php if(isset($emailInfoMsg_php)){echo $emailInfoMsg_php;} ?></span>										
										<span class="reg_err" id="emailMsg" ><?php if(isset($emailMsg_php)){echo $emailMsg_php;} ?></span>
									<div>
									
									<div>
										<label class="reg_label">Password<label class="mandatory_field">*</label> : </label> 
										<input class="reg_input" type="password" id="pass" name="pass" maxlength="100" value="<?php if(isset($pass)){echo $pass;} ?>" >
										<span class="reg_err" id="passMsg" ><?php if(isset($passMsg_php)){echo $passMsg_php;} ?></span>
									<div>
									
									<div>
										<label class="reg_label">Repeat Password<label class="mandatory_field">*</label> : </label> 
										<input class="reg_input" type="password" id="repeatPass" name="repeatPass" maxlength="100" value="<?php if(isset($repeatPass)){echo $repeatPass;} ?>" >
										<span class="reg_err" id="repeatPassMsg" ><?php if(isset($repeatPassMsg_php)){echo $repeatPassMsg_php;} ?></span>
									<div>
									
									<hr>
									
									<div>
										<label class="reg_label">English Surname<label class="mandatory_field">*</label> : </label> 
										<input class="reg_input" type="text" id="engSurname" name="engSurname" maxlength="50" value="<?php if(isset($engSurname)){echo $engSurname;} ?>" >
										<span class="reg_err" id="engSurnameMsg" ><?php if(isset($engSurnameMsg_php)){echo $engSurnameMsg_php;} ?></span>
									<div>									
									
									<div>
										<label class="reg_label">English Middle Name<label class="mandatory_field">*</label> : </label> 
										<input class="reg_input" type="text" id="engMidName" name="engMidName" maxlength="50" value="<?php if(isset($engMidName)){echo $engMidName;} ?>" >
										<span class="reg_err" id="engMidNameMsg" ><?php if(isset($engMidNameMsg_php)){echo $engMidNameMsg_php;} ?></span>
									<div>

									<div>
										<label class="reg_label">English Name : </label>
										<input class="reg_input" type="text" id="engName" name="engName" maxlength="50" value="<?php if(isset($engName)){echo $engName;} ?>">
										<span class="reg_err" id="engNameMsg" ><?php if(isset($engNameMsg_php)){echo $engNameMsg_php;} ?></span>
									<div>
									
									<div>
										<label class="reg_label">Gender : </label> 
										<input class="reg_radio" type="radio" name="sex" value="M" <?php if (isset($sex) && $sex=="M") echo "checked";?> />Male
										<input class="reg_radio" type="radio" name="sex" value="F" <?php if (isset($sex) && $sex=="F") echo "checked";?> />Female
										<span class="reg_err" id="sexMsg" ><?php if(isset($sexMsg_php)){echo $sexMsg_php;} ?></span>
									<div>

									<hr>
									
									<div>
										<label class="reg_label">Contact Phone No.<label class="mandatory_field">*</label> : </label> 
										<input class="reg_input" type="text" id="tel" name="tel" maxlength="50" value="<?php if(isset($tel)){echo $tel;} ?>" >
										<span class="reg_err" id="telMsg" ><?php if(isset($telMsg_php)){echo $telMsg_php;} ?></span>
									<div>

									<label class="reg_label">Delivery Address<label class="mandatory_field">*</label> : </label>
									<div>										
										<input class="reg_input2" type="text" placeholder="Flat and floor no." id="address1" name="address1" maxlength="100" value="<?php if(isset($address1)){echo $address1;} ?>" >
										<span class="reg_err" id="address1Msg" ><?php if(isset($address1Msg_php)){echo $address1Msg_php;} ?></span>
									<div>

									<div>
										<input class="reg_input2" type="text" placeholder="Name of building" id="address2" name="address2" maxlength="100" value="<?php if(isset($address2)){echo $address2;} ?>" >
										<span class="reg_err" id="address2Msg" ><?php if(isset($address2Msg_php)){echo $address2Msg_php;} ?></span>
									<div>

									<div>
										<input class="reg_input2" type="text" placeholder="Building no. and name of street" id="address3" name="address3" maxlength="100" value="<?php if(isset($address3)){echo $address3;} ?>" >
										<span class="reg_err" id="address3Msg" ><?php if(isset($address3Msg_php)){echo $address3Msg_php;} ?></span>
									<div>
									
									<div>
										<input class="reg_input2" type="text" placeholder="District" id="address4" name="address4" maxlength="100" value="<?php if(isset($address4)){echo $address4;} ?>" >
										<span class="reg_err" id="address4Msg" ><?php if(isset($address4Msg_php)){echo $address4Msg_php;} ?></span>
									<div>
									<br>

									<div>
										<input class="reg_input3" type="checkbox" id="tc" name="tc" value="agree" >
										<label class="reg_label3">By creating an account you agree to our <a href="./registerTerms&Conditions.php" >Terms & Conditions</a>.<label class="mandatory_field">*</label></label>
										<span class="reg_err" id="tcMsg" ><?php if(isset($tcMsg_php)){echo $tcMsg_php;} ?></span>
									<div>
									
									<hr>
									
									<p></p>

									<div>
									  <div class="button_alignment">
									  	<input class="reg_input4" type="reset" name="Reset" value="Reset" onclick="resetErrMsg();">
									  	<input class="reg_input5" type="submit" name="signUp" value="Sign Up">
									  </div>
									  <br><br><label class="reg_label4"><u><b>Password format advices:</b></u></label>
									  <br><label class="reg_label4">Password length must be 8 - 20 characters.</label>
									  <br><label class="reg_label4">Password must contain at least 2 upper case characters.</label>
									  <br><label class="reg_label4">Password must contain at least 2 lower case characters.</label>
									  <br><label class="reg_label4">Password must contain at least 2 numeric characters.</label>
									  <br><label class="reg_label4">Password must contain at least 2 special characters.</label>
									</div>
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