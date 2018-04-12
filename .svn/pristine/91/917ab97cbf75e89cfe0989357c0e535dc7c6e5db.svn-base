<?php

include_once("../common/functions.php");

healthCheckDB();
healthCheckDBTables();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

logout();

$_logoutMsg = "";

if(isset($_GET["logoutMsg"])){
    $_logoutMsg = htmlspecialchars($_GET["logoutMsg"]);
}

?>

<html>
	<head>
		<meta charset="utf-8">		
		<title>Unicorn Restaurant - Logout</title>
		
		<?php include_once("../import.php");?>

		<link rel="stylesheet" href="../unicorn.css" type="text/css">
		<link rel="stylesheet" href="./login.css" type="text/css">
		<script type="text/javascript" src="./login.js"></script>
	</head>

	<body>	
		<form name="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return formSubmit()">
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
									We promise to deliver the freshest foods to you as soon as possible. 							
								</div>
								<!-- ******** [END] Alert Message Display ******** -->
								
								
								<!-- ******** [START] Logout Division ******** -->
								<?php if(isset($_logoutMsg) && $_logoutMsg!= ""){?>
								<label><span style="color:red"><?php echo $_logoutMsg;?></span></label>
								<?php }else {?>
								<br><br>
								<label><h1>Logout successfully!</h1></label>
								<p style="margin-bottom: 10em;>
								<?php }?>									
								<!-- ******** [END] Logout Division ******** -->
								
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