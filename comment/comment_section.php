<?php

include_once("../common/functions.php");

// logic variables
$userLogged=false;
$userOrdered=false;

// comment variables
$userNames=array("0" => "","1" => "","2" => "");
$orders=array(	// 3 orders
	array("0" => "","1" => "","2" => "","3" => "","4" => ""),	// 5 items per order
	array("0" => "","1" => "","2" => "","3" => "","4" => ""),
	array("0" => "","1" => "","2" => "","3" => "","4" => "")
);
$comments=array("0" => "","1" => "","2" => "");
$ratings=array("0" => "","1" => "","2" => "");
$dates = array("0" => "","1" => "","2" => "");


// echo $value->format('Y-m-d H:i:s');

// CHECK whether the use is LOGGED IN
$userLogged=false;
// CHECK whether the user has UNCOMMENTED ORDER
$userOrdered=false;



// LOAD the data from database
// testing "userNames"
$userNames[0] = "Username_0";
$userNames[1] = "Username_1";
$userNames[2] = "Username_2";
// testing "comments"
$comments[0] = "some relatively long stringg dsfgvdshvsdthstdvhsthsthvfnasgfxbasgfgersfgaxfgnyrgfxykregfberxygferfngxkfrfxxgbfxgetfxgerfngksetr";
$comments[1] = "short comment";
$comments[2] = "fine";
// testing "dates"
$start = new DateTime('01-01-2017');
$end = new DateTime('03-01-2017');
do {
	var_dump($start);
	array_push($dates, clone $start);
	$start->add(DateInterval::createFromDateString('1 day'));
} while(false);



?>

<html>

	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant</title>
		
		<!-- Using Icon library and refer to https://www.w3schools.com/w3css/w3css_icons.asp -->
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../unicorn.css">
		<link rel="stylesheet" href="./css/comment.css">
	</head>


	<body>
		<div id="app">
			<div>
			
				<!-- ******** [START] Left panel ******** -->
				<aside id="left-panel" class="left-panel">
					<nav class="navbar navbar-expand-lg">
					
						<!-- ******** [START] Logo ******** -->
						<div class="navbar-header">
							<a href="#/" class="navbar-brand">
								<img src="./resources/cs5281unicorn2_6.png" alt="Logo" class="float-left">
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
										
								<li class="nav-item mt-auto">
									<a>
										<i class="menu-icon fa fa-comment"></i>
										<span class="menu-title-text"> Let Us Know </span>
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
									<a href="#"><i class="fa fa-envelope"></i> </a> <span>&nbsp;</span>									
									<a href="#"><i class="fa fa-user"></i> Ken </a> <span>&nbsp;</span>
									<a href="#"><i class="fa fa-power-off"></i> Logout </a> <span>&nbsp;</span>
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
								<span class="badge badge-pill badge-success">Welcome Ken!!</span> We promise to deliver the freshest foods to you as soon as possible. 							
							</div>
							<!-- ******** [END] Alert Message Display ******** -->
							
							
                            <!-- ******** [START] Food Comment Section ******** -->
							<div class="comment-section">
								<!-- ******** Comment 0 ******** -->
								<div class="comment-container">
									<!--order + name + stars-->
									<div class="comment-init">
										<!--order-->
										<div class="comment-order">
											<p id="text-order">Previous order</p>
										</div>
										<!--name-->
										<div class="comment-name">
											<p id="text-name"><?php echo $userNames[0] ?></p>
										</div>
										<!--stars-->
										<div class="comment-star">
											<div class="star-rating">
												<input id="star-5" type="radio" name="rating" value="star-5">
												<label for="star-5" title="5 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-4" type="radio" name="rating" value="star-4">
												<label for="star-4" title="4 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-3" type="radio" name="rating" value="star-3">
												<label for="star-3" title="3 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-2" type="radio" name="rating" value="star-2">
												<label for="star-2" title="2 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-1" type="radio" name="rating" value="star-1">
												<label for="star-1" title="1 star">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
											</div>
										</div>
									</div>
									<!-- order contant + comment input -->
									<div class="comment-body">
										<!-- order contant -->
										<div class="comment-order-list">
											<ul>
												<li id="order-item-0">Noodles</li>
												<li id="order-item-1">Donut</li>
												<li id="order-item-2">Meal with very long name ... soooooo long, extremely long, th longest in the menu</li>
												<li id="order-item-3">Cup of coffe</li>
												<li id="order-item-4">Milk</li>
												<li id="order-item-5"></li>
											</ul>				
										</div>

										<div class="comment-input"> 
											<p id="prev-comment-0">text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text </p>
										</div>
									</div>

									<div class="comment-footer">
										<div class="time">
											<p id="text-time">11/02/2018</p>
										</div>
									</div>
								</div>

								<!-- ******** Comment 1 ******** -->
								<div class="comment-container">
									<!--order + name + stars-->
									<div class="comment-init">
										<!--order-->
										<div class="comment-order">
											<p id="text-order">Previous order</p>
										</div>
										<!--name-->
										<div class="comment-name">
											<p id="text-name">Name-from-DB</p>
										</div>
										<!--stars-->
										<div class="comment-star">
											<div class="star-rating">
												<input id="star-5" type="radio" name="rating" value="star-5">
												<label for="star-5" title="5 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-4" type="radio" name="rating" value="star-4">
												<label for="star-4" title="4 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-3" type="radio" name="rating" value="star-3">
												<label for="star-3" title="3 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-2" type="radio" name="rating" value="star-2">
												<label for="star-2" title="2 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-1" type="radio" name="rating" value="star-1">
												<label for="star-1" title="1 star">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
											</div>
										</div>
									</div>
									<!-- order contant + comment input -->
									<div class="comment-body">
										<!-- order contant -->
										<div class="comment-order-list">
											<ul>
												<li id="order-item-0">Noodles</li>
												<li id="order-item-1">Donut</li>
												<li id="order-item-2">Meal with very long name ... soooooo long, extremely long, th longest in the menu</li>
												<li id="order-item-3">Cup of coffe</li>
												<li id="order-item-4">Milk</li>
												<li id="order-item-5"></li>
											</ul>				
										</div>

										<div class="comment-input"> 
											<p id="prev-comment-0">text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text </p>
										</div>
									</div>

									<div class="comment-footer">
										<div class="time">
											<p id="text-time">11/02/2018</p>
										</div>
									</div>
								</div>

								<!-- ******** Comment 2 ******** -->
								<div class="comment-container">
									<!--order + name + stars-->
									<div class="comment-init">
										<!--order-->
										<div class="comment-order">
											<p id="text-order">Previous order</p>
										</div>
										<!--name-->
										<div class="comment-name">
											<p id="text-name">Name-from-DB</p>
										</div>
										<!--stars-->
										<div class="comment-star">
											<div class="star-rating">
												<input id="star-5" type="radio" name="rating" value="star-5">
												<label for="star-5" title="5 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-4" type="radio" name="rating" value="star-4">
												<label for="star-4" title="4 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-3" type="radio" name="rating" value="star-3">
												<label for="star-3" title="3 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-2" type="radio" name="rating" value="star-2">
												<label for="star-2" title="2 stars">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
												<input id="star-1" type="radio" name="rating" value="star-1">
												<label for="star-1" title="1 star">
														<i class="active fa fa-star" aria-hidden="true"></i>
												</label>
											</div>
										</div>
									</div>
									<!-- order contant + comment input -->
									<div class="comment-body">
										<!-- order contant -->
										<div class="comment-order-list">
											<ul>
												<li id="order-item-0">Noodles</li>
												<li id="order-item-1">Donut</li>
												<li id="order-item-2">Meal with very long name ... soooooo long, extremely long, th longest in the menu</li>
												<li id="order-item-3">Cup of coffe</li>
												<li id="order-item-4">Milk</li>
												<li id="order-item-5"></li>
											</ul>				
										</div>
										<div class="comment-input"> 
											<p id="prev-comment-0">text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text </p>
										</div>
									</div>

									<div class="comment-footer">
										<div class="time">
											<p id="text-time">11/02/2018</p>
										</div>
									</div>
								</div>
								<!-- ******** [END] Food Comment Section ******** -->	

                            
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