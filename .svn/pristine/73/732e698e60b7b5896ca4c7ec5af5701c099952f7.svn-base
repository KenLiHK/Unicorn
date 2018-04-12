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
$userIDEmail = "";
$pass = "";


//define server side error message variables and set to empty values
$userIDEmailMsg_php = "";
$passMsg_php = "";
$serverErrMsg_php = "<div class='alert mt-4 alert-success'><span></span></div>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$userIDEmail = optimizateInput($_POST["userIDEmail"]);	
	$pass = optimizateInput($_POST["pass"]);	//No need to display password when server side validation is failed
	
	
	if(true)
	{
		$result = login_by_userId_or_email_passwordFake($userIDEmail, $pass);
		
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
		
		<?php include_once("../import.php");?>
		
		<link rel="stylesheet" href="../unicorn.css" type="text/css">
		<link rel="stylesheet" href="./login.css" type="text/css">
		<script type="text/javascript" src="./login.js"></script>
    		
	</head>

	<body>	
		<form name="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return true">
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
								<div><?php if(isset($serverErrMsg_php)){echo $serverErrMsg_php;} ?></div>
								<!-- ******** [END] Alert Message Display ******** -->
								
								
								<!-- ******** [START] Login Division ******** -->
								<div class="container">
									<h3>Login</h3>
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