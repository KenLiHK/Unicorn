<?php

include_once("../common/functions.php");
// custom functions
//include_once("./comment_function.php");

healthCheckDB();
healthCheckDBTables();
checkLogon();
check_session_timeout();

$commentMsg_php 			= "";
$commentInfoMsg_php 		= "";
$num_of_comment_sections 	= 5;
$userID 					= isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : "";
$userLogged 				= checkUserLogon();
$commentID 					= "";
$userOrdered				= get_order_list_by_userID($userID);

/*
$rating             		= "";
$selectedOrder      		= "";
$comment            		= "";
$isFormDataValid 			= "";
$commentObj 				= "";

if (!empty($_POST["submitCom"]) && $_SERVER["REQUEST_METHOD"] == "POST") {    
    $rating             = optimizateInput($_POST["rating"]);
    $selectedOrder      = optimizateInput($_POST["selectedOrder"]);
    $comment            = "";

    $commentMsg_php 			= "";
    $commentInfoMsg_php 		= "";
    
    if(!isset($_POST['commentDetail']) || $_POST['commentDetail'] == ""){
        $commentMsg_php = 										"[E801] Comment must be input!";
        $isFormDataValid = false;        
    }else{
    	$comment = optimizateInput($_POST["commentDetail"]);
    	$isFormDataValid = true;
    }
    
    if($isFormDataValid){
        $now = date("Y-m-d h:i:sa");
        
        $commentObj = new Comment(NULL, $userID, $selectedOrder, $rating, $comment, $now, $now);
        $commentID = save_comment($commentObj);
        $commentInfoMsg_php = 									"[I801] Submit comment successfully!";
    } 
    $_POST = array();
    $isFormDataValid 			= "";
}
*/
?>

<html>

	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant - Comment</title>
		
		<?php include_once("../import.php");?>
		
		<link rel="stylesheet" href="../unicorn.css" type="text/css">
		<link rel="stylesheet" href="./comment.css" type="text/css">
		
		<script type="text/javascript" src="../unicorn.js"></script>
		<script type="text/javascript" src="../jq_plugins.js"></script>
		<script type="text/javascript" src="./comment.js"></script>			
	</head>


	<body>
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
							<?php if(!$userLogged){ ?>
								<div class="alert mt-4 alert-success">
									<span class="badge badge-pill badge-success">Welcome!!</span> Please, log in and place an order to be able to post comment.							
								</div>
							<?php }else if(!isset($userOrdered) || count($userOrdered) == 0) { ?>
								<div class="alert mt-4 alert-success">
									<span class="badge badge-pill badge-success">Welcome <?php echo $userID ?> !!</span> Please, place an order to be able to post comment.							
								</div>
							<?php }else if($commentMsg_php != "") { ?>
								<div class="alert mt-4 alert-success">																											
									<span class="comment_err"><?php if(isset($commentMsg_php)){echo $commentMsg_php;} ?></span>							
								</div>
							<?php }else if($commentInfoMsg_php != "") { ?>
								<div class="alert mt-4 alert-success">
									<span class="comment_info" ><?php if(isset($commentInfoMsg_php)){echo $commentInfoMsg_php;} ?></span>								
								</div>																
							<?php }else{ ?>
								<div class="alert mt-4 alert-success">
									<span class="badge badge-pill badge-success">Welcome <?php echo $userID ?> !!</span> Let us know what you think about your last order.						
								</div>
							<?php } ?>
							
							<!-- ******** [END] Alert Message Display ******** -->
							

                            <!-- ******** [START] Food Comment Section ******** -->
							<div class="comment-section">
							
								<!-- ******** User Logged In & New Order ******** -->
								<?php if(isset($userOrdered) && count($userOrdered) > 0){ ?>
	                        <!-- ******** COMMENT 0 - INPUT ******** -->
									<form name="commentForm">
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
													<p id="text-name"></p>
												</div>
												<!--stars-->
												<div class="comment-star">
													<div class="star-rating">
														<input id="star-5" type="radio" name="rating" value="5">
														<label for="star-5" title="5 stars">
																<i class="active fa fa-star" aria-hidden="true"></i>
														</label>
														<input id="star-4" type="radio" name="rating" value="4">
														<label for="star-4" title="4 stars">
																<i class="active fa fa-star" aria-hidden="true"></i>
														</label>
														<input id="star-3" type="radio" name="rating" value="3" checked>
														<label for="star-3" title="3 stars">
																<i class="active fa fa-star" aria-hidden="true"></i>
														</label>
														<input id="star-2" type="radio" name="rating" value="2">
														<label for="star-2" title="2 stars">
																<i class="active fa fa-star" aria-hidden="true"></i>
														</label>
														<input id="star-1" type="radio" name="rating" value="1">
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
												Order ID:
                                					<select id="id_selectedOrder" name="selectedOrder" style="width:150px;">
                                						<?php
                                						for ($row = 0; $row < count($userOrdered); $row++) {
                                						    $orderID = $userOrdered[$row]["order_id"];
                                						    echo "<option value=" . $orderID . ">" . $orderID . "</option>";
                                						}                                						                                						
                                						?>                  
                                    				</select> 			
												</div>

												<div class="comment-input"> 
													<textarea id="id_commentDetail" name="commentDetail" placeholder="Your opinion ... " maxlength="1000" value=""></textarea>
													<span class="comment_err" id="commentMsg" ><?php if(isset($commentMsg_php)){echo $commentMsg_php;} ?></span>
												</div>
											</div>

											<div class="comment-footer">
											<!--submit button-->
												<div>
													<input type="button" class="comment_button" id="id_submitCom" name="submitCom" value="Submit" onclick="addComment()">
													<span class="comment_info" id="commentInfoMsg" ></span>
													<span class="comment_err" id="commentMsg" ></span>
												</div>
											</div>
										</div>
									</form>
								<?php } ?>
								

								<div id="commentDetail-section"></div>
								<!-- ******** [END] Food Comment Section ******** -->	
								

							<?php include_once("../footer.php");?>
							
							
							
						</div>
					</div>
					<!-- ******** [END] Navigation Body ******** -->
					
					
					
				</div>
				<!-- ******** [END] Right panel ******** -->
				
				
			</div>
		</div>
	
	</body>
</html>