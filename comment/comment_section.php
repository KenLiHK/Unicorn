<?php

include_once("../common/database.php");
include_once("../common/functions.php");
// custom functions
include_once("./comment_function.php");



// parameters
/* this decides how many entries from database will be fetched*/
$num_of_comment_sections = 5;
/* decides how many food entries will be shown in the list*/
$num_of_food_entries = 5;


// logic variables
$userLogged;
$userOrdered;
// variables
$array_user_id = array();
$array_order_id = array();
$array_content = array();
$array_ratings  = array();
$array_dates    = array();
/*
/////////////////////////// TESTING
// add comments
// addComment($user_id, $order_id, $rating, $content, $create_date)
addComment('Martin', 1, 5, 'first comment', date("Y-m-d H:i:s"));
addComment('Nikol', 2, 4, 'I like this shop', date("Y-m-d H:i:s"));
addComment('kenli', 3, 4, 'I cannot stop', date("Y-m-d H:i:s"));
addComment('kenli', 2, 5, 'fI literarly cannot stop', date("Y-m-d H:i:s"));
/////////////////////////// TESTING (end)
*/

// 1) check whether the user is logged in
$userLogged=checkUserLogon();
// 2) check outstanding order

// REMOVE THIS LOGIC
// ADD javascript saying your comment was uploaded
// ALLOW user to keep adding COMMENTS
// FINISH "SUBMIT" button logic
$userOrdered=checkOutstandingOrderInSession();
// 3) PRE-fetch the values from database
fetchComments($array_user_id, $array_order_id, $array_ratings, $array_content, $array_dates, $num_of_comment_sections);

/*
for ($x = 0; $x <= ($num_of_comment_sections-1); $x++) {
	echo 'array_user_id[' . $x . ']    : '  . $array_user_id[$x] . '<br>';
	echo 'array_order_id[' . $x . ']   : '  . $array_order_id[$x] . '<br>';
	echo 'array_content[' . $x . ']    : '  . $array_content[$x] . '<br>';
	echo 'array_ratings[' . $x . ']    : '  . $array_ratings[$x] . '<br>';
	echo '----------next entry' . '<br>';
} 
*/

//$userLogged=true;
//$userOrdered=true;
/// LOGIC
// user is logged in and can comment on recent order
if($userLogged && $userOrdered){
	// fetch user id
	$thisUserName = isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : "";
	// display the user id
	$userNames[0] = $thisUserName;
	// fetch order details
	$orderID = getOrderIDWithUserID($thisUserName);
	// fetch food list
	$foodIDList=getFoodIDWithOrderID($orderID);
	// fill in the 'orders' values
	for ($x = 0; $x <= ($num_of_food_entries-1); $x++) {
		if($foodIDList[$x] != -1 ){
			$orders[0][$x] = getFoodNameWithFoodID($foodIDList[$x]);
		}else{
			$orders[0][$x] = '';
		}
	} 
	// current date
	$dates[0] = date("Y-m-d H:i:s");
	
	// parse previous orders, by other users
	for ($x = 1; $x <= ($num_of_comment_sections-1); $x++) {
		// extract the values
		$userNames[$x] = $array_user_id[$x-1];
		$comments[$x] = $array_content[$x-1];
		$ratings[$x] = $array_ratings[$x-1];
		$dates[$x] = $array_dates[$x-1];
		
		// fetch foodID List/Array for specific order ID
		$foodIDList=getFoodIDWithOrderID($array_order_id[$x-1]);
		// parse foodID names
		for ($y = 0; $y <= ($num_of_food_entries-1); $y++) {
			if($foodIDList[$y] != -1 ){
				$orders[$x][$y] = getFoodNameWithFoodID($foodIDList[$y]);
			}else{
				$orders[$x][$y] = '';
			}
		}
	} 
	
	
// user is logged in, but cannot comment (no order in process)
/*}elseif($userLogged) {
	$thisUserName = $_SESSION['login_user_id'];
	$userNames[0] = $thisUserName;
	
	// parse previous orders, by other users
	for ($x = 0; $x <= ($num_of_comment_sections-1); $x++) {
		// extract the values
		$userNames[$x] = $array_user_id[$x];
		$comments[$x] = $array_content[$x];
		$ratings[$x] = $array_ratings[$x];
		$dates[$x] = $array_dates[$x];
		
		// fetch foodID List for specific order ID
		$foodIDList=getFoodIDWithOrderID($array_order_id[$x]);
		// parse foodID names
		for ($y = 0; $y <= ($num_of_food_entries-1); $y++) {
			if($foodIDList[$y] != -1 ){
				$orders[$x][$y] = getFoodNameWithFoodID($foodIDList[$x]);
			}else{
				$orders[$x][$y] = '';
			}
		}
	} 
	
// for any other non-logged guest*/
}else{
	
	// parse previous orders, by other users
	for ($x = 0; $x <= ($num_of_comment_sections-1); $x++) {
		// extract the values
		$userNames[$x] = $array_user_id[$x];
		$comments[$x] = $array_content[$x];
		$ratings[$x] = $array_ratings[$x];
		$dates[$x] = $array_dates[$x];
		
		// fetch foodID List for specific order ID
		$foodIDList=getFoodIDWithOrderID($array_order_id[$x]);
		// parse foodID names
		for ($y = 0; $y <= ($num_of_food_entries-1); $y++) {
			if($foodIDList[$y] != -1 ){
				$orders[$x][$y] = getFoodNameWithFoodID($foodIDList[$y]);
			}else{
				$orders[$x][$y] = '';
			}
		}
	} 
	
	// change name if user is logged in
	if($userLogged){
		$thisUserName = $_SESSION['login_user_id'];
		$userNames[0] = $thisUserName;
	}
}


?>

<html>

	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant</title>
		
		<!-- Using Icon library and refer to https://www.w3schools.com/w3css/w3css_icons.asp -->
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../unicorn.css">
		<link rel="stylesheet" href="./comment.css">
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
						
<!-- ******** CUSTOMIZED PART OF WEB PAGE ******** -->
						
						
						
						
							<!-- ******** [START] Alert Message Display ******** -->
							<?php if(!$userLogged): ?>
								<div class="alert mt-4 alert-info">
									<span class="badge badge-pill badge-info">Welcome!!</span> Please, log in and place an order to be able to post comment.							
								</div>
							<?php elseif(!$userOrdered) : ?>
								<div class="alert mt-4 alert-info">
									<span class="badge badge-pill badge-info">Welcome <?php echo $thisUserName ?> !!</span> Please, place an order to be able to post comment.							
								</div>
							<?php else: ?>
								<div class="alert mt-4 alert-success">
									<span class="badge badge-pill badge-success">Welcome <?php echo $thisUserName ?> !!</span> Let us know what you think about your last order.						
								</div>
							<?php endif; ?>
							<!-- ******** [END] Alert Message Display ******** -->
							

                            <!-- ******** [START] Food Comment Section ******** -->
							<div class="comment-section">
								<!-- ******** User Logged In & New Order ******** -->
								<?php if($userLogged && $userOrdered): ?>
	<!-- ******** COMMENT 0 - INPUT ******** -->
									<form action="http://www.goole.com/" method="POST" name="comment">
										<!--comment section-->
										<div class="comment-container">
											<!--order + name + stars-->
											<div class="comment-init">
												<!--order-->
												<div class="comment-order">
													<p id="text-order">Your order</p>
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
														<li id="order-item-0"><?php echo $orders[0][0] ?></li>
														<li id="order-item-1"><?php echo $orders[0][1] ?></li>
														<li id="order-item-2"><?php echo $orders[0][2] ?></li>
														<li id="order-item-3"><?php echo $orders[0][3] ?></li>
														<li id="order-item-4"><?php echo $orders[0][4] ?></li>
													</ul>				
												</div>

												<div class="comment-input"> 
													<textarea name="comment" placeholder="Your opinion ... " maxlength="1000"></textarea>

												</div>
											</div>

											<div class="comment-footer">
											<!--submit button-->
												<div class="button">
													<input type="submit" value="Submit">
												</div>

												<div class="time">
													<p id="text-time"><?php echo $dates[0] ?></p>
												</div>
											</div>
										</div>
									</form>
								<?php else: ?>
								
		<!-- ******** COMMENT 0 ******** -->
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
												<div class="star-static">
													<?php if($ratings[0] >= 1 ): ?>
														<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
													<?php else: ?>
														<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
													<?php endif; ?>
													<?php if($ratings[0] >= 2 ): ?>
														<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
													<?php else: ?>
														<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
													<?php endif; ?>
													<?php if($ratings[0] >= 3 ): ?>
														<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
													<?php else: ?>
														<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
													<?php endif; ?>
													<?php if($ratings[0] >= 4 ): ?>
														<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
													<?php else: ?>
														<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
													<?php endif; ?>
													<?php if($ratings[0] >= 5 ): ?>
														<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
													<?php else: ?>
														<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
													<?php endif; ?>
												</div>
											</div>
										</div>
										<!-- order contant + comment input -->
										<div class="comment-body">
											<!-- order contant -->
											<div class="comment-order-list">
												<ul>
													<li id="order-item-0"><?php echo $orders[0][0] ?></li>
													<li id="order-item-1"><?php echo $orders[0][1] ?></li>
													<li id="order-item-2"><?php echo $orders[0][2] ?></li>
													<li id="order-item-3"><?php echo $orders[0][3] ?></li>
													<li id="order-item-4"><?php echo $orders[0][4] ?></li>
												</ul>				
											</div>

											<div class="comment-input"> 
												<p id="prev-comment-0"><?php echo $comments[0] ?></p>
											</div>
										</div>

										<div class="comment-footer">
											<div class="time">
												<p id="text-time"><?php echo $dates[0] ?></p>
											</div>
										</div>
									</div>
								<?php endif; ?>
								
	<!-- ******** COMMENT 1 ******** -->
								<div class="comment-container">
									<!--order + name + stars-->
									<div class="comment-init">
										<!--order-->
										<div class="comment-order">
											<p id="text-order">Previous order</p>
										</div>
										<!--name-->
										<div class="comment-name">
											<p id="text-name"><?php echo $userNames[1] ?></p>
										</div>
										<!--stars-->
										<div class="comment-star">
											<div class="star-static">
												<?php if($ratings[1] >= 1 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[1] >= 2 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[1] >= 3 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[1] >= 4 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[1] >= 5 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
											</div>
										</div>
									</div>
									<!-- order contant + comment input -->
									<div class="comment-body">
										<!-- order contant -->
										<div class="comment-order-list">
											<ul>
													<li id="order-item-0"><?php echo $orders[1][0] ?></li>
													<li id="order-item-1"><?php echo $orders[1][1] ?></li>
													<li id="order-item-2"><?php echo $orders[1][2] ?></li>
													<li id="order-item-3"><?php echo $orders[1][3] ?></li>
													<li id="order-item-4"><?php echo $orders[1][4] ?></li>
											</ul>				
										</div>

										<div class="comment-input"> 
											<p id="prev-comment-0"><?php echo $comments[1] ?> </p>
										</div>
									</div>

									<div class="comment-footer">
										<div class="time">
											<p id="text-time"><?php echo $dates[1] ?></p>
										</div>
									</div>
								</div>

	<!-- ******** COMMENT 2 ******** -->
								<div class="comment-container">
									<!--order + name + stars-->
									<div class="comment-init">
										<!--order-->
										<div class="comment-order">
											<p id="text-order">Previous order</p>
										</div>
										<!--name-->
										<div class="comment-name">
											<p id="text-name"><?php echo $userNames[2] ?></p>
										</div>
										<!--stars-->
										<div class="comment-star">
											<div class="star-static">
												<?php if($ratings[2] >= 1 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[2] >= 2 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[2] >= 3 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[2] >= 4 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[2] >= 5 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
											</div>
										</div>
									</div>
									<!-- order contant + comment input -->
									<div class="comment-body">
										<!-- order contant -->
										<div class="comment-order-list">
											<ul>
												<li id="order-item-0"><?php echo $orders[2][0] ?></li>
												<li id="order-item-1"><?php echo $orders[2][1] ?></li>
												<li id="order-item-2"><?php echo $orders[2][2] ?></li>
												<li id="order-item-3"><?php echo $orders[2][3] ?></li>
												<li id="order-item-4"><?php echo $orders[2][4] ?></li>
											</ul>				
										</div>
										<div class="comment-input"> 
											<p id="prev-comment-0"><?php echo $comments[2] ?> </p>
										</div>
									</div>

									<div class="comment-footer">
										<div class="time">
											<p id="text-time"><?php echo $dates[2] ?></p>
										</div>
									</div>
								</div>
								<!-- ******** [END] Food Comment Section ******** -->	

								
	<!-- ******** COMMENT 3 ******** -->
								<div class="comment-container">
									<!--order + name + stars-->
									<div class="comment-init">
										<!--order-->
										<div class="comment-order">
											<p id="text-order">Previous order</p>
										</div>
										<!--name-->
										<div class="comment-name">
											<p id="text-name"><?php echo $userNames[3] ?></p>
										</div>
										<!--stars-->
										<div class="comment-star">
											<div class="star-static">
												<?php if($ratings[3] >= 1 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[3] >= 2 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[3] >= 3 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[3] >= 4 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
												<?php if($ratings[3] >= 5 ): ?>
													<i class="active fa fa-star" style='color:f2b600;' aria-hidden="true"></i>
												<?php else: ?>
													<i class="active fa fa-star" style='color:bbb;'id="checked" aria-hidden="true"></i>
												<?php endif; ?>
											</div>
										</div>
									</div>
									<!-- order contant + comment input -->
									<div class="comment-body">
										<!-- order contant -->
										<div class="comment-order-list">
											<ul>
												<li id="order-item-0"><?php echo $orders[3][0] ?></li>
												<li id="order-item-1"><?php echo $orders[3][1] ?></li>
												<li id="order-item-2"><?php echo $orders[3][2] ?></li>
												<li id="order-item-3"><?php echo $orders[3][3] ?></li>
												<li id="order-item-4"><?php echo $orders[3][4] ?></li>
											</ul>				
										</div>
										<div class="comment-input"> 
											<p id="prev-comment-0"><?php echo $comments[3] ?> </p>
										</div>
									</div>

									<div class="comment-footer">
										<div class="time">
											<p id="text-time"><?php echo $dates[3] ?></p>
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