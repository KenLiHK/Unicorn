<?php

include_once("../common/functions.php");

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
	$imgPath 		= $userInDB['img_path'];
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
		
		<!-- Using Icon library and refer to https://www.w3schools.com/w3css/w3css_icons.asp -->
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../unicorn.css">
		<link rel="stylesheet" href="./userProfile.css">
		
		<!-- include jQuery for Ajax call -->
		<script type="text/javascript" src="../jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="../unicorn.js"></script>
		<script type="text/javascript" src="./userProfile.js"></script>
	</head>

	<body>	
		<form name="userProfileForm">
			<div id="app">
				<div>
				
					<!-- ******** [START] Left panel ******** -->
					<aside id="left-panel" class="left-panel">
						<nav class="navbar navbar-expand-lg">
						
							<!-- ******** [START] Logo ******** -->
							<div class="navbar-header">
								<a href="#/" class="navbar-brand">
									<img src="../resources/cs5281unicorn2_6.png" alt="Logo" class="float-left">
								</a> 
							</div>
							<!-- ******** [END] Logo ******** -->
							
							
							<!-- ******** [START] Left function menu ******** -->
							<div id="main-menu" class="navbar-collapse">
								<ul class="navbar-nav">
									<h3 class="menu-title"> Unicorn Restaurant </h3>
									
									<li class="nav-item">
										<a href="#/components/tables" class="">
											<i class="menu-icon fa fa-search"></i>
											<span class="menu-title-text"> Search Dish </span>
										</a>
									</li>				
		
									<li class="nav-item mt-auto">
										<a>
											<i class="menu-icon fa fa-shopping-cart"></i>
											<span class="menu-title-text"> Place Order </span>
										</a>
									</li>
											
									<li class="nav-item">
										<a href="#/components/icons" class="">
											<i class="menu-icon fa fa-star"></i>
											<span class="menu-title-text">Map</span>
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
					            			if(isset($userID)){ 
					            				echo 
														'<a href="#"><i class="fa fa-envelope"></i> </a> <span>&nbsp;</span>
														 <a href="#"><i class="fa fa-user"></i>' .@$userID. '</a> <span>&nbsp;</span>
														 <a href="useraction.php?act=logout"><i class="fa fa-power-off"></i> Logout </a> <span>&nbsp;</span>';
					            			}else{
					            				echo '<a href="login.php">login</a>';
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
									<?php 
									if(isset($_successMsg) && !empty($_successMsg)){
											echo "$_successMsg";
										}else{
											echo "<span class='badge badge-pill badge-success'>Welcome ".$userID."</span> We promise to deliver the freshest foods to you as soon as possible.";
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
										<img class="profileIcon" src="<?php if(isset($imgPath)){echo UNICORN_ROOT.$imgPath;} ?>" alt="User Profile Icon">
									</div>	
									
									<div class="stop_floating_alignment"></div>
									<hr>
									<div class="button_alignment">
										<input class="profile_button" type="button" name="updateProfile" value="Update Profile" onclick="goToUpdateUserProfile();">				
									</div>
								<!-- ******** [END] User Profile Division ******** -->
								
								
								
								
								
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