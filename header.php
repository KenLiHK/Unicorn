<?php

include_once("../common/functions.php");

check_session_timeout();

$_isLogon = checkUserLogon();

?>

<!-- ******** [START] Navigation Header Bar ******** -->
<noscript>
    <div class="noscriptmsg">
    <meta http-equiv="refresh" content="1; URL=../exception/noJavaScriptException.php">
    </div>
</noscript>
<script type="text/javascript">

    function countFoodFromCart($foodID)
    {
    	if($foodID == undefined || $foodID == null || $foodID == ""){
    		return;
    	}
    	
    	var _foodData = {"foodID":$foodID}; //if foodID == "ALL", then sum all food's quantity
    	$.ajax(
    		{
    			type: 'post',
    			url: '../recommend/cartAjaxService.php',
    			
    			data: {
    				foodID2Count:_foodData
    			},
    			
    			success: function (qty) 
    			{
    				return qty;
    			}
    		}
    	);
    }
    
    function countFoodFromCartInSync($foodID)
    {
    	if($foodID == undefined || $foodID == null || $foodID == ""){
    		return;
    	}
    	
    	var _foodData = {"foodID":$foodID}; //if foodID == "ALL", then sum all food's quantity
    	$.extend({
    		countResponse: function() 
    	    {
    			var result = null;
    			$.ajax(
    				{
    					type: 'post',
    					url: '../recommend/cartAjaxService.php',
    					
    					async: false,
    					
    					data: {
    						foodID2Count:_foodData
    					},
    					
    					success: function (qty) 
    					{
    						result = qty;
    					}
    				}
    			);
    			return result;
    	    }
    	});
    	
    	return $.countResponse();
    }

    function countNotificationInSync()
    {        
    	$.extend({
    		countResponse: function() 
    	    {
    			var result = null;
    			$.ajax(
    				{
    					type: 'post',
    					url: '../notification/notificationService.php',

    					async: false,
    					    					
    					data: {
    						notification2Count:true
    					},
    					
    					success: function (qty) 
    					{
    						result = qty;
    					}
    				}
    			);
    			return result;
    	    }
    	});
    	
    	return $.countResponse();
    }
    
	function showItemCount(){
	    var itemCount = countFoodFromCartInSync("ALL");

	    if(itemCount == undefined || itemCount == null || itemCount == '0'){
	    	$('#itemCount').html(itemCount).css('display', 'none');
	    }else{
	    	$('#itemCount').html(itemCount).css('display', '');
	    	$('#itemCount').html(itemCount);
	    }

	    var notiCount = countNotificationInSync();

	    if(notiCount == undefined || notiCount == null || notiCount == '0'){
	    	$('#notiItemCount').html(notiCount).css('display', 'none');
	    }else{
	    	$('#notiItemCount').html(notiCount).css('display', '');
	    	$('#notiItemCount').html(notiCount);
	    }	    	    
	}
</script>

<script type="text/javascript">
	function showProgress() {
	  document.getElementById("app").style.display = "none";
	  document.getElementById("loading").style.display = "";
	  
	  setTimeout(function() {
		  document.getElementById("loading").style.display = "none";
		  document.getElementById("app").style.display = "";
		}, 100);
	}

	function hideProgress() {
	  document.getElementById("loading").style.display = "none";
	  document.getElementById("app").style.display = "";
	}

	$(document).ready(function(){
		showProgress();
		showItemCount();
	});
</script>

<style>
    /* Center the loader */
    #loading {
      position: absolute;
      left: 50%;
      top: 50%;
      z-index: 1;
      width: 150px;
      height: 150px;
      margin: -75px 0 0 -75px;
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #ff5733;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
    }
    
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
</style>
        
<style type="text/css">
    #itemCount{
      border-radius: 100%;
      background: red;
      color: white;
      font-weight: 900;
      vertical-align : top;
      text-align: center;
      font-size:15px;
    }
    
     #notiItemCount{
      border-radius: 100%;
      background: red;
      color: white;
      font-weight: 900;
      vertical-align : top;
      text-align: center;
      font-size:15px;
    }
</style>

<header id="header" class="header">
	<div>							
		<div class="header-right">
			<div>
					<a href="../placeOrder/cart.php"><span id="itemCount"></span><span class="fa fa-shopping-cart fa-2x"></span></a> <span>&nbsp;</span>
				<?php if($_isLogon) {
				        $_userID = $_SESSION['login_user_id'];
				    ?>		
					<a href="../notification/notification.php"><span id="notiItemCount"></span><i class="fa fa-envelope fa-2x"></i> </a> <span>&nbsp;</span>
					<a href="../userProfile/userProfile.php"><i class="fa fa-profile fa-1x"></i><span style="font-size:20px;"><?php echo $_userID;?></span></a> <span>&nbsp;</span>
					<a href="../login/logout.php"><i class="fa fa-sign-out fa-1x"></i> Logout </a> <span>&nbsp;</span>
				<?php 	}else{ ?>					
					<a href="../login/login.php"><i class="fa fa-sign-in fa-1x"> Login </i></a> <span>&nbsp;</span>
					<a href="../registration/registerForm.php"><i class="fa fa-user-plus fa-1x"> Sign-up </i></a> <span>&nbsp;</span>
				<?php	} ?>
    			
			</div>								
		</div>						
	</div>
</header>
<!-- ******** [START] Navigation Header Bar ******** -->
						
						
						