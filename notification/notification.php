<?php

include_once("../common/functions.php");

healthCheckDB();
checkLogon();
check_session_timeout();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$notificationMsg_php 			= "";
$notificationInfoMsg_php 		= "";
$userID 					= isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : "";
$userLogged 				= checkUserLogon();
$notificationID 					= "";
//$userOrdered				= get_notification_list_by_userID($userID);

?>

<html>

	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant - Notification</title>
		
		<?php include_once("../import.php");?>
		
		<link rel="stylesheet" href="../unicorn.css" type="text/css">
		<link rel="stylesheet" href="./notification.css" type="text/css">
		
		<script type='text/javascript' src='../unicorn.js'></script>
		<script type='text/javascript' src='../jq_plugins.js'></script>
		<script type="text/javascript" src="./notification.js"></script>			
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
					<div  style="height:600px;">
						<div>
							
						
							<!-- ******** [START] Alert Message Display ******** -->
							<div class="alert mt-4 alert-success">
							<?php 
							if(isset($notificationInfoMsg_php) && !empty($notificationInfoMsg_php)){
								echo "$notificationInfoMsg_php";
							}else{
								if(isset($userID)){
									echo "<span class='badge badge-pill badge-success'>Welcome ".$userID."</span> We promise to deliver the freshest foods to you as soon as possible.";
								}else{
									echo "We promise to deliver the freshest foods to you as soon as possible.";
								}
						 	}
							?>	
							</div>														
							
							<!-- ******** [END] Alert Message Display ******** -->
							

                            <!-- ******** [START] Notification Section ******** -->
							<div id="notification-section"></div>
							<!-- ******** [END] Notification Section ******** -->	
								
							<hr style="margin-bottom: 10em;>
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