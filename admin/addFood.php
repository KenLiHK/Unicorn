<?php

include_once("../common/functions.php");

checkLogon();

check_session_timeout();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_SESSION['login_user_id'])){
	$userID_In_Session = $_SESSION['login_user_id'];
}

$isFormDataValid = true;

$userID			= "";
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

//define server side error message variables and set to empty values
$adminMsg_php = "";
$adminImgInfoMsg_php = "";
$adminImgMsg_php = "";

$emailMsg_php = "";
$emailInfoMsg_php = "";

$engSurnameMsg_php = "";
$engMidNameMsg_php = "";
$engNameMsg_php = "";

$sexMsg_php = "";
$telMsg_php = "";

$address1Msg_php = "";
$address2Msg_php = "";
$address3Msg_php = "";
$address4Msg_php = "";


if (!empty($_POST["addFood"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
	$userID			= optimizateInput($_POST["userID"]);
	$email 			= optimizateInput($_POST["email"]);
	$engSurname 	= optimizateInput($_POST["engSurname"]);
	$engMidName 	= optimizateInput($_POST["engMidName"]);
	$engName 		= optimizateInput($_POST["engName"]);
	$sex 			= optimizateInput($_POST["sex"]);
	$tel 			= optimizateInput($_POST["tel"]);
	$address1 		= optimizateInput($_POST["address1"]);
	$address2 		= optimizateInput($_POST["address2"]);
	$address3 		= optimizateInput($_POST["address3"]);
	$address4 		= optimizateInput($_POST["address4"]);	
	
	// ******** [START] Email validation ********
	if(empty($email)) {
		$emailMsg_php = "[E701] Email must be input!";
	}
	
	if($emailMsg_php == ""){
		$_email = db_select_user_by_Email($email);
		if(!isset($_email))
		{
			$emailInfoMsg_php = "[I701] Email is acceptable!"; //NOT found Email in DB
		}
		else
		{
			$emailMsg_php = "[E711] Email is already registered, please register by other email!"; //Found Email in DB
		}
	}
	
	//Validate email address pattern
	if ($emailMsg_php == "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailMsg_php = "[E702] Invalid Email!";
	}
	
	if($emailMsg_php != ""){
		$isFormDataValid = false;
	}
	// ******** [END] Email validation ********
	
	
	
	if(empty($engSurname)) {
		$engSurnameMsg_php = "[E703] English Surname must be input!";
		$isFormDataValid = false;
	}
	
	if(empty($engMidName)) {
		$engMidNameMsg_php = "[E704] English Middle Name must be input!";
		$isFormDataValid = false;
	}
	

	
	// ******** [START] Contact phone number validation ********
	if(empty($tel)) {
		$telMsg_php = "[E705] Contact Phone No. must be input!";
	}
	
	//Contact phone number must be numeric
	if($telMsg_php == "" && !empty($tel)) {
		if (!is_numeric($tel)) {
			$telMsg_php = "[E706] Contact Phone No. must be numeric!";
		}
	}
	
	if($telMsg_php != ""){
		$isFormDataValid = false;
	}
	// ******** [END] Contact phone number validation ********
	
	if(empty($address1)) {
		$address1Msg_php = "[E707] Flat and floor no. must be input!";
		$isFormDataValid = false;
	}
	
	if(empty($address2)) {
		$address2Msg_php = "[E708] Name of building must be input!";
		$isFormDataValid = false;
	}
	
	if(empty($address3)) {
		$address3Msg_php = "[E709] Building no. and name of street must be input!";
		$isFormDataValid = false;
	}
	
	if(empty($address4)) {
		$address4Msg_php = "[E710] District must be input!";
		$isFormDataValid = false;
	}
	
	// ******** [START] Upload file ********
	if(isset($_FILES["foodImg"])){
		$target_dir = UNICORN_DOC_ROOT."/resources/userProfileImg/";
		$baseFileName = basename($_FILES["foodImg"]["name"]);
		$target_file = $target_dir . $baseFileName;	
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$save_file = $target_dir . $userID . "." . $imageFileType;
		$imgPath = "/resources/userProfileImg/" . $userID . "." . $imageFileType;
		
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["profileImg"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$profileImgMsg_php = "[E712] Invalid file!";
				$uploadOk = 0;
			}
		}
	
		// Check file size (1MB)
		if ($_FILES["foodImg"]["size"] > 1000000) {
			if($profileImgMsg_php == ""){
				$profileImgMsg_php = "[E713] File size must be equal to or less than 1MB!";
			}
			$uploadOk = 0;
		}
		
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
		{
					if($profileImgMsg_php == "")
					{
						$profileImgMsg_php = "[E714] Only JPG, JPEG, PNG and GIF files are allowed!";
					}
					$uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) 
		{
			$isFormDataValid = false;
		} else {
			// Remove existing file if already exists
			if (file_exists($save_file)) 
			{
				chmod($save_file,0755); //Change the file permissions if allowed
				unlink($save_file); //remove the file
			}
			
			if (move_uploaded_file($_FILES["foodImg"]["tmp_name"], $save_file)) {
				if($profileImgInfoMsg_php == ""){
					$profileImgInfoMsg_php = "[I703] The file ". basename( $_FILES["foodImg"]["name"]). " has been uploaded!";
				}
			} else {
				if($profileImgMsg_php == ""){
					$profileImgMsg_php = "[E715] File upload error, please try again later!";
				}
				$isFormDataValid = false;
			}
		}
	}
	// ******** [END] Upload file ********
			
	if($isFormDataValid)
	{		
		//new an user object to keep form post information for passing to db_insert_user function in database.php
		$user = new User($userID, $imgPath, $sex, $engSurname, $engMidName,
				$engName, $email, $tel, $address1, $address2,
				$address3, $address4, "", "");
		
		$result = db_update_user_profile($user); //insert new user account information into database

		if(isset($result) && $result > 0) {
			$successMsg= "[I702] Update user profile successfully!";
			header('Location: ./userProfile.php?successMsg='.$successMsg);
			exit;
		} else {
			$userProfileMsg_php = "[E712] Update user profile failed, please try again later!";
		}
	}
}else{
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
}
?>

<html>
	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant - Add Food</title>
		
		<?php include_once("../import.php");?>
		
		<link rel="stylesheet" href="../unicorn.css" type="text/css">
		<link rel="stylesheet" href="./admin.css"type="text/css">
		<script type="text/javascript" src="../unicorn.js"></script>
		<script type="text/javascript" src="./admin.js"></script>
    		
	</head>

	<body>	
		<form name="addFoodForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" onsubmit="return formSubmit()">
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
											if(isset($userID_In_Session )){
												echo "<span class='badge badge-pill badge-success'>Welcome ".$userID_In_Session."</span> We promise to deliver the freshest foods to you as soon as possible.";
											}else{
												echo "We promise to deliver the freshest foods to you as soon as possible.";
											} 	
								?>	
								</div>
								<!-- ******** [END] Alert Message Display ******** -->
								
								
								
								
								
								
								<!-- ******** [START] Add Food Division ******** -->
								<div class="container">
									<h5>Add Food</h5>
									<hr>
										<div>
											<label class="admin_label">Food Image : </label>
											<label class="admin_label3">
												<?php if(isset($imgPath) && $imgPath != ""){ ?>
												<img class="foodImage" src="<?php echo UNICORN_ROOT . $imgPath; ?>" alt="Food Image">
												<?php }else { $imgPath = "../resources/userProfileImg/default.jpg";?>
												<img class="foodImage" src="../resources/userProfileImg/default.jpg" alt="Food Image">
												<?php } ?>
												<input type="file" id="foodImg" name="foodImg" />
											</label>
											<!--<input type="button" id="profileImgUpload" name="profileImgUpload" value="Upload" onclick="uploadProfileImg();" />-->
											<span class="admin_info" id="adminImgInfoMsg" ><?php if(isset($adminImgInfoMsg_php)){echo $adminImgInfoMsg_php;} ?></span>								
											<span class="admin_err" id="adminImgMsg" ><?php if(isset($adminImgMsg_php)){echo $adminImgMsg_php;} ?></span>
											<br>											
										</div>	
										<hr>
										<label class="mandatory_field">* Mandatory field</label><br>
										<div>
											<label class="admin_label">Food Category : </label> 										
											<label class="admin_label3"><?php if(isset($userID)){echo $userID;} ?></label>
								       		<select id="id_selectedOrder" name="selectedOrder" style="width:150px;">
                                				<?php
                                				for ($row = 0; $row < count($userOrdered); $row++) {
                                					$orderID = $userOrdered[$row]["ORDER_ID"];
                                					echo "<option value=" . $orderID . ">" . $orderID . "</option>";
                                				}                                						                                						
                                				?>                  
                                    		</select>
											<span class="admin_info" id="userIDInfoMsg" ><?php if(isset($userIDInfoMsg_php)){echo $userIDInfoMsg_php;} ?></span>								
											<span class="admin_err" id="userIDMsg" ><?php if(isset($userIDMsg_php)){echo $userIDMsg_php;} ?></span>
										<div>
										
										<div>
											<label class="admin_label">Food Name<label class="mandatory_field">*</label> : </label>
											<input type="hidden" id="currentEmail", name="currentEmail" value="<?php if(isset($email)){echo $email;} ?>">  
											<input class="admin_input" type="email" id="email" name="email" maxlength="100" value="<?php if(isset($email)){echo $email;} ?>" >
											<span class="admin_info" id="emailInfoMsg" ><?php if(isset($emailInfoMsg_php)){echo $emailInfoMsg_php;} ?></span>										
											<span class="admin_err" id="emailMsg" ><?php if(isset($emailMsg_php)){echo $emailMsg_php;} ?></span>
										<div>
						
										<div>
											<label class="admin_label">Available<label class="mandatory_field">*</label> : </label> 
											<select id="id_selectedOrder" name="selectedOrder" style="width:150px;">
												<option value="Y"> Y </option>
												<option value="N"> N </option>
											</select>
											<span class="admin_err" id="engSurnameMsg" ><?php if(isset($engSurnameMsg_php)){echo $engSurnameMsg_php;} ?></span>
										<div>									
										
										<div>
											<label class="admin_label">Price<label class="mandatory_field">*</label> : </label> 
											<input class="admin_input" type="text" id="engMidName" name="engMidName" maxlength="50" value="<?php if(isset($engMidName)){echo $engMidName;} ?>" >
											<span class="admin_err" id="engMidNameMsg" ><?php if(isset($engMidNameMsg_php)){echo $engMidNameMsg_php;} ?></span>
										<div>
	
										<div>
											<label class="admin_label">Discount percentage : </label>
											<input class="admin_input" type="text" id="engName" name="engName" maxlength="50" value="<?php if(isset($engName)){echo $engName;} ?>">
											<span class="admin_err" id="engNameMsg" ><?php if(isset($engNameMsg_php)){echo $engNameMsg_php;} ?></span>
										<div>
										
										<div>
											<label class="admin_label">Discount effective date : </label> 
											<input class="admin_radio" type="radio" name="sex" value="M" <?php if (isset($sex) && $sex=="M") echo "checked";?> />Male
											<input class="admin_radio" type="radio" name="sex" value="F" <?php if (isset($sex) && $sex=="F") echo "checked";?> />Female
											<span class="admin_err" id="sexMsg" ><?php if(isset($sexMsg_php)){echo $sexMsg_php;} ?></span>
										<div>
	
										<hr>
										
										<div>
											<label class="admin_label">Remarks<label class="mandatory_field">*</label> : </label> 
											<textarea id="id_commentDetail" name="commentDetail" placeholder="Your opinion ... " maxlength="1000" value=""></textarea>
											<span class="admin_err" id="telMsg" ><?php if(isset($telMsg_php)){echo $telMsg_php;} ?></span>
										<div>
	
										<div>
											<label class="admin_label">Tags<label class="mandatory_field">*</label> : </label> 
											<textarea id="id_commentDetail" name="commentDetail" placeholder="Your opinion ... " maxlength="1000" value=""></textarea>
											<span class="admin_err" id="telMsg" ><?php if(isset($telMsg_php)){echo $telMsg_php;} ?></span>
										<div>
										
										<hr>
										<div class="button_alignment">
											<input class="admin_button" type="submit" name="addFood" value="Add Food">
											<input class="admin_button" type="reset" name="reset" value="Reset">				
										</div>
									</div>
								<!-- ******** [END] Add Food Division ******** -->
								
								
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