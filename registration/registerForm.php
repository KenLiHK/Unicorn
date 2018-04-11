<?php

include_once("../common/functions.php");

healthCheckDB();
healthCheckDBTables();
check_session_timeout();

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
		}else if(strlen($tel) < 8){
		    $telMsg_php = "[E026] Contact Phone No. must be at least 8 digits!";
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
		
		<title>Unicorn Restaurant - Registration</title>
		
		<?php include_once("../import.php");?>

		<link rel="stylesheet" href="../unicorn.css" type="text/css">
		<link rel="stylesheet" href="./registration.css" type="text/css">
		<script type="text/javascript" src="../unicorn.js"></script>
		<script type="text/javascript" src="./registration.js"></script>
    		
	</head>

	<body>	
		<form name="regForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return formSubmit()">
			<div id="loading"></div>
			<div id="app"  style="display:none;" >			
				<div>
				
					<?php include_once("../leftPanel.php");?>
					
					
					
					<!-- ******** [START] Right panel ******** -->
					<div id="right-panel" class="right-panel">
						
						<?php include_once("../header.php");?>	

						
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
									<h3>Sign Up</h3>
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
								
								<?php include_once("../footer.php");?>			
								
								
								
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