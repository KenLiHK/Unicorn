<?php

include_once("../common/functions.php");

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$_isLogon = checkUserLogon();
$privilege = isset($_SESSION['login_user_privilege']) ? $_SESSION['login_user_privilege'] : "";	

?>

<!-- ******** [START] Left panel ******** -->
					<aside id="left-panel" class="left-panel">
						<nav class="navbar navbar-expand-lg">
						
							<!-- ******** [START] Logo ******** -->
							<div class="navbar-header">
								<a href="../recommend/recom_home.php" class="navbar-brand">
									<img src="../resources/systemImg/cs5281unicorn2_6.png" alt="Logo" class="float-left">
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
											<i class="menu-icon fa fa-search fa-1x"></i>
											<span class="menu-title-text"> Search Dish </span>
										</a>
									</li>				
									
									<li class="nav-item mt-auto">
										<a href="../placeOrder/cart.php">
											<i class="menu-icon fa fa-shopping-cart fa-1x"></i>
											<span class="menu-title-text"> Place Order </span>
										</a>
									</li>
									
									<li class="nav-item mt-auto">
										<a href="../comment/comment_section.php">
											<i class="menu-icon fa fa-comments fa-1x"></i>
											<span class="menu-title-text"> Comment </span>
										</a>
									</li>
									
									<?php if($_isLogon) {?>
									<li class="nav-item mt-auto">
										<a href="../notification/notification.php">
											<i class="menu-icon fa fa-envelope fa-1x"></i>
											<span class="menu-title-text"> Notification </span>
										</a>
									</li>	
									
									<li class="nav-item mt-auto">
										<a href="../userProfile/userProfile.php">
											<i class="menu-icon fa fa-user fa-1x"></i>
											<span class="menu-title-text"> User Profile </span>
										</a>
									</li>
									<?php }?>
									
									<?php if(!$_isLogon) {?>											
									<li class="nav-item">
										<a href="../login/login.php">
											<i class="menu-icon fa fa-sign-in fa-1x"></i>
											<span class="menu-title-text">Login</span>
										</a>
									</li>
	
									<li class="nav-item">
										<a href="../registration/registerForm.php">
											<i class="menu-icon fa fa-user-plus fa-1x"></i>
											<span class="menu-title-text">Sign Up</span>
										</a>
									</li>
									<?php }?>
									
									<li class="nav-item">
										<a href="../contactUs/contactUs.php">
											<i class="menu-icon fa fa-globe fa-1x"></i>
											<span class="menu-title-text">Contact Us</span>
										</a>
									</li>

									
									<?php if ($_isLogon && $privilege != "" && $privilege == "A") {?>
									<h3 class="menu-title"> Administration </h3>

									<li class="nav-item mt-auto">
										<a href="../admin/addFood.php">
											<i class="menu-icon fa fa-gear fa-1x"></i>
											<span class="menu-title-text"> Add Food </span>
										</a>
									</li>
																																			
									<?php }?>									
								</ul>
							</div>
							<!-- ******** [END] Left function menul ******** -->
							

							
							
						</nav>
						
						<div></div>
					</aside>
					<!-- ******** [END] Left panel ******** -->

