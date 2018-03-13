<?php
include_once("./common/functions.php");

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_SESSION['login_user_id'])){
	$userID_In_Session = $_SESSION['login_user_id'];
}

//START: For testing
//$selectedFood1 = array("F1", "2");
//$selectedFood2 = array("F1", "6");
//$selectedFood3 = array("F1", "8");
$selectedFood1 = array("foodID" => "1", "qty" => "2");
$selectedFood2 = array("foodID" => "2", "qty" => "4");
$selectedFood3 = array("foodID" => "3", "qty" => "3");

$_selectedFoodMap = array($selectedFood1, $selectedFood2, $selectedFood3);

//$_SESSION['selected_food_map'] = $_selectedFoodMap;

/*
 echo "<br>a-foodID:".$_selectedFoodMap[0]["foodID"]."\t";
 echo "<br>a-qty:".$_selectedFoodMap[0]["qty"]."\t";
 echo "<br>a-foodID1:".$_selectedFoodMap[1]["foodID"]."\t";
 echo "<br>a-qty1:".$_selectedFoodMap[1]["qty"]."\t";
 echo "<br>a-foodID2:".$_selectedFoodMap[2]["foodID"]."\t";
 echo "<br>a-qty2:".$_selectedFoodMap[2]["qty"]."\t";
 */
//$orderDetail4Display_array = [];
//$orderDetail4Display_array = prepare_order_detail_for_display();


//$_SESSION['login_user_id'] = "kenli";

$food = new Food("1");
$food->setFoodCategory("AABB");

//echo "foodID:" . $food->getFoodID() . " foodCat:" . $food->getFoodCategory() . "<br>";

//echo "path:" . UNICORN_DOC_ROOT;
//echo "url:" . UNICORN_ROOT;

$food2 = new Food("1", "BB", "N1", "Y", "10", "10", NULL, NULL,
		"Path", "test", NULL, NULL);
$food2->setFoodCategory("BBCC");
//echo "2foodID:" . $food2->getFoodID() . " foodCat:" . $food2->getFoodCategory();

//END: For testing

?>
<html>

	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant</title>
		
		<!-- Using Icon library and refer to https://www.w3schools.com/w3css/w3css_icons.asp -->
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="./unicorn.css">
	</head>


	<body>
		<div id="app">
			<div>
			
					<!-- ******** [START] Left panel ******** -->
					<aside id="left-panel" class="left-panel">
						<nav class="navbar navbar-expand-lg">
						
							<!-- ******** [START] Logo ******** -->
							<div class="navbar-header">
								<a href="./recommend/recom_home.php" class="navbar-brand">
									<img src="./resources/cs5281unicorn2_6.png" alt="Logo" class="float-left">
								</a> 
							</div>
							<!-- ******** [END] Logo ******** -->
							
							
							<!-- ******** [START] Left function menu ******** -->
							<div id="main-menu" class="navbar-collapse">
								<ul class="navbar-nav">
									<a href="./recommend/recom_home.php">
										<h3 class="menu-title"> Unicorn Restaurant </h3>
									</a>
									
									<li class="nav-item">
										<a href="./searchDish/search.php">
											<i class="menu-icon fa fa-search"></i>
											<span class="menu-title-text"> Search Dish </span>
										</a>
									</li>				
		
									<li class="nav-item mt-auto">
										<a href="./placeOrder/cart.php">
											<i class="menu-icon fa fa-shopping-cart"></i>
											<span class="menu-title-text"> Place Order </span>
										</a>
									</li>
											
									<li class="nav-item mt-auto">
										<a href="./comment/comment_section.php">
											<i class="menu-icon fa fa-comments"></i>
											<span class="menu-title-text"> Comment </span>
										</a>
									</li>															
									
									<li class="nav-item mt-auto">
										<a href="./userProfile/userProfile.php">
											<i class="menu-icon fa fa-user"></i>
											<span class="menu-title-text"> User Profile </span>
										</a>
									</li>
									
																			
									<li class="nav-item">
										<a href="./login/login.php">
											<i class="menu-icon fa fa-sign-in"></i>
											<span class="menu-title-text">Login</span>
										</a>
									</li>
	
									<li class="nav-item">
										<a href="./registration/registerForm.php">
											<i class="menu-icon fa fa-user-plus"></i>
											<span class="menu-title-text">Sign Up</span>
										</a>
									</li>
									
									<li class="nav-item">
										<a href="./contactUs/contactUs.php">
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
									if(isset($userID_In_Session)){
											echo
												'<a href="./notification/notification.php"><i class="fa fa-envelope"></i> </a> <span>&nbsp;</span>
										 		 <a href="./userProfile/userProfile.php"><i class="fa fa-profile"></i>' .@$userID_In_Session. '</a> <span>&nbsp;</span>
										 		 <a href="./login/logout.php"><i class="fa fa-sign-out"></i> Logout </a> <span>&nbsp;</span>';
										}else{
											echo
												'<a href="./login/login.php"><i class="fa fa-sign-in"> Login </i></a> <span>&nbsp;</span>
		            					 		 <a href="./registration/registerForm.php"><i class="fa fa-user-plus"> Sign-up </i></a> <span>&nbsp;</span>';
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
										if(isset($userID_In_Session )){
											echo "<span class='badge badge-pill badge-success'>Welcome ".$userID_In_Session."</span> We promise to deliver the freshest foods to you as soon as possible.";
										}else{
											echo "We promise to deliver the freshest foods to you as soon as possible.";
										} 	
								?>	 							
							</div>
							<!-- ******** [END] Alert Message Display ******** -->
							
							
							
							<!-- ******** [START] Food Navigation Division ******** -->
							<div class="sale-charts">
								<div class="col-sm-6 col-lg-3">
									<div class="card">
										<div class="card-header text-white bg-flat-color-1">
											<div class="font-weight-bold">
												<img src="./resources/food1_256x256.jpg">
											</div>
										</div>
										<div class="card-body py-0 px-4 b-t-1">
											<div class="row">
												<div class="col-6 b-r-1 py-3">
													<div class="font-weight-bold"><h2>+</h2></div>
												</div>
												<div class="col-6 py-3 text-right">
													<div class="font-weight-bold">$98</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-lg-3">
									<div class="card">
										<div class="card-header text-white bg-flat-color-4">
											<div class="font-weight-bold">
												<img src="./resources/food2_256x256.jpg">
											</div>										
										</div>									
										<div class="card-body py-0 px-4 b-t-1">
											<div class="row">
												<div class="col-6 b-r-1 py-3">
													<div class="font-weight-bold"><h2>+</h2></div>
												</div>
												<div class="col-6 py-3 text-right">
													<div class="font-weight-bold">$87</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-lg-3">
									<div class="card">
										<div class="card-header text-white bg-flat-color-5">
											<div class="font-weight-bold">
												<img src="./resources/food3_256x256.jpg">
											</div>
										</div>	
										<div class="card-body py-0 px-4 b-t-1">
											<div class="row">
												<div class="col-6 b-r-1 py-3">
													<div class="font-weight-bold"><h2>+</h2></div>
												</div>
												<div class="col-6 py-3 text-right">
													<div class="font-weight-bold">$87</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-lg-3">
									<div class="card">
										<div class="card-header text-white bg-warning">
											<div class="font-weight-bold">
												<img src="./resources/food4_256x256.jpg">
											</div>
											
										</div>
										
										<div class="card-body py-0 px-4 b-t-1">
											<div class="row">
												<div class="col-6 b-r-1 py-3">
													<div class="font-weight-bold"><h2>+</h2></div>
												</div>
												<div class="col-6 py-3 text-right">
													<div class="font-weight-bold">$107</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="sale-charts">
								<div class="col-sm-6 col-lg-3">
									<div class="card">
										<div class="card-header text-white bg-flat-color-4">
											<div class="font-weight-bold">
												<img src="./resources/food5_256x256.jpg">
											</div>										
										</div>									
										<div class="card-body py-0 px-4 b-t-1">
											<div class="row">
												<div class="col-6 b-r-1 py-3">
													<div class="font-weight-bold"><h2>+</h2></div>
												</div>
												<div class="col-6 py-3 text-right">
													<div class="font-weight-bold">$87</div>
												</div>
											</div>
										</div>
									</div>
								</div>
	
								<div class="col-sm-6 col-lg-3">
									<div class="card">
										<div class="card-header text-white bg-flat-color-1">
											<div class="font-weight-bold">
												<img src="./resources/food6_256x256.jpg">
											</div>
										</div>
										<div class="card-body py-0 px-4 b-t-1">
											<div class="row">
												<div class="col-6 b-r-1 py-3">
													<div class="font-weight-bold"><h2>+</h2></div>
												</div>
												<div class="col-6 py-3 text-right">
													<div class="font-weight-bold">$98</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-lg-3">
									<div class="card">
										<div class="card-header text-white bg-warning">
											<div class="font-weight-bold">
												<img src="./resources/food7_256x256.jpg">
											</div>
											
										</div>
										
										<div class="card-body py-0 px-4 b-t-1">
											<div class="row">
												<div class="col-6 b-r-1 py-3">
													<div class="font-weight-bold"><h2>+</h2></div>
												</div>
												<div class="col-6 py-3 text-right">
													<div class="font-weight-bold">$107</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6 col-lg-3">
									<div class="card">
										<div class="card-header text-white bg-flat-color-5">
											<div class="font-weight-bold">
												<img src="./resources/food8_256x256.jpg">
											</div>
										</div>	
										<div class="card-body py-0 px-4 b-t-1">
											<div class="row">
												<div class="col-6 b-r-1 py-3">
													<div class="font-weight-bold"><h2>+</h2></div>
												</div>
												<div class="col-6 py-3 text-right">
													<div class="font-weight-bold">$87</div>
												</div>
											</div>
										</div>
									</div>
								</div>							
							</div>
							<!-- ******** [END] Food Navigation Division ******** -->
							
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
	
	</body>
</html>