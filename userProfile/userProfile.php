<?php

include_once("../common/functions.php");

healthCheckDB();
healthCheckDBTables();
checkLogon();
check_session_timeout();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_SESSION['login_user_id'])){
	$userID_In_Session = $_SESSION['login_user_id'];
}

$_successMsg= htmlspecialchars(isset($_GET["successMsg"]) ? $_GET["successMsg"] : "");

$imgPath 		= "../resources/userProfileImg/default.jpg";
$sex 			= "";
$engSurname		= "";
$engMidName 	= "";
$engName		= "";
$email			= "";
$tel 			= "";
$address1		= "";
$address2		= "";
$address3		= "";
$address4		= "";

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
$userID = isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : "";

$userInDB = select_user_all_info_by_UserID($userID);
if(isset($userInDB)){
    if(isset($userInDB['img_path'])){
        $imgPath 		= $userInDB['img_path'];
    }
	$sex 			= $userInDB['sex'];
	$engSurname		= $userInDB['eng_surname'];
	$engMidName 	= $userInDB['eng_middle_name'];
	$engName		= $userInDB['eng_name'];
	$email			= $userInDB['email'];
	$tel 			= $userInDB['tel'];
	$address1		= $userInDB['address_1'];
	$address2		= $userInDB['address_2'];
	$address3		= $userInDB['address_3'];
	$address4		= $userInDB['address_4'];
}
?>

<html>
	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant - User Profile</title>
		
		<?php include_once("../import.php");?>
		
		<link rel="stylesheet" href="../unicorn.css" type="text/css">
		<link rel="stylesheet" href="./userProfile.css" type="text/css">
		<script type="text/javascript" src="../unicorn.js"></script>
		<script type="text/javascript" src="./userProfile.js"></script>    			
	</head>

	<body>	
		<form name="userProfileForm">
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
									<?php 
									if(isset($_successMsg) && !empty($_successMsg)){
											echo "$_successMsg";
										}else{
											if(isset($userID_In_Session )){
												echo "<span class='badge badge-pill badge-success'>Welcome ".$userID_In_Session."</span> We promise to deliver the freshest foods to you as soon as possible.";
											}else{
												echo "We promise to deliver the freshest foods to you as soon as possible.";
											}
									 	}
									?>							
								</div>
								<!-- ******** [END] Alert Message Display ******** -->
								
								
								
								
								
								
								<!-- ******** [START] User Profile Division ******** -->
								<h5>Profile</h5>
								<hr>
									<div class="profile_info">
										<div class="user_profile_label"><label>User ID : </label></div>
										<div class="user_profile_label2"><label><?php if(isset($userID)){echo $userID;} ?></label></div><br>
										
										<div class="user_profile_label"><label>Email : </label></div>
										<div class="user_profile_label2"><label><?php if(isset($email)){echo $email;} ?></label></div><br>
										
										<div class="user_profile_label"><label>English Surname : </label></div>
										<div class="user_profile_label2"><label><?php if(isset($engSurname)){echo $engSurname;} ?></label></div><br>
										
										<div class="user_profile_label"><label>English Middle Name : </label></div>
										<div class="user_profile_label2"><label><?php if(isset($engMidName)){echo $engMidName;} ?></label></div><br>
										
										<div class="user_profile_label"><label>English Name : </label></div>
										<div class="user_profile_label2"><label><?php if(isset($engName)){echo $engName;} ?></label></div><br>
										<div class="user_profile_label"><label>Gender : </label></div>
										<div class="user_profile_label2">
											<input class="profile_radio" type="radio" name="sex" value="M" <?php if (isset($sex) && $sex=="M") echo "checked";?> disabled />Male
											<input class="profile_radio" type="radio" name="sex" value="F" <?php if (isset($sex) && $sex=="F") echo "checked";?> disabled />Female
										</div><br>
										
										<div class="user_profile_label"><label>Contact Phone No. : </label></div>
										<div class="user_profile_label2"><label><?php if(isset($tel)){echo $tel;} ?></label></div><br>
										
										<div class="user_profile_label"><label>Delivery Address : </label></div>
										<div class="user_profile_label2"><label><?php if(isset($address1)){echo $address1;} ?></label></div><br>
										<div class="user_profile_label"></div>
										<div class="user_profile_label2"><label><?php if(isset($address2)){echo $address2;} ?></label></div><br>
										<div class="user_profile_label"></div>
										<div class="user_profile_label2"><label><?php if(isset($address3)){echo $address3;} ?></label></div><br>
										<div class="user_profile_label"></div>
										<div class="user_profile_label2"><label><?php if(isset($address4)){echo $address4;} ?></label></div><br>													
									</div>									
									<div class="profile_photo">
										<?php if(isset($imgPath) && $imgPath != ""){ ?>
										<img class="profileIcon" src="<?php echo UNICORN_ROOT . $imgPath; ?>" alt="User Profile Icon">
										<?php }else { $imgPath = "../resources/userProfileImg/default.jpg";?>
										<img class="profileIcon" src="../resources/userProfileImg/default.jpg" alt="User Profile Icon">
										<?php } ?>
									</div>	
									
									<div class="stop_floating_alignment"></div>
									<hr>
									<div class="button_alignment">
										<input class="profile_button" type="button" name="updateProfile" value="Go to Update Profile" onclick="goToUpdateUserProfile();">				
									</div>
								<!-- ******** [END] User Profile Division ******** -->
								
								
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