<?php
include_once("../common/functions.php");

check_session_timeout();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_SESSION['login_user_id'])){
	$userID = $_SESSION['login_user_id'];
}


?>
<html>

<head>
	<meta charset="utf-8">

	<title>Unicorn Restaurant - Home</title>
<style>
******** [START] Recommend page style definition ********/
#itemCount {
  position: absolute;
  display: none;
  top: -10px;
  left: -10px;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: red;
  color: white;
  text-align: center;
}

#cart-container {
  float: right;
  width: 210px;
  position: relative;
}
******** [END] Recommend page style definition ********/
</style>
	<?php include_once("../import.php");?>
	
	<link rel="stylesheet" href="../unicorn.css" type="text/css">
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
					<div class="alert mt-4 alert-success">
				<?php 
					if(isset($_successMsg) && !empty($_successMsg)){
						echo "$_successMsg";
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



					<!-- ******** [START] Food Navigation Division ******** -->
					<div id="search-section"></div>
					<fieldset><legend><h4>Search Result</h4></legend>
						<div id="search-result"></div>
					</fieldset><br>
					<div id="recom-list"></div>
                    <div id="cate-cont"> </div>
                    <script type="text/javascript" src="recommend.js"></script>
					<!-- ******** [END] Food Navigation Division ******** -->

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