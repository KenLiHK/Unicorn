<?php
include_once("./common/functions.php");

echo 
'
<!DOCTYPE html>

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

';

include_once("leftPanel.php");
include_once("rightPanel.php");

echo 
'
			</div>
		</div>
	
	</body>
</html>
';

?>