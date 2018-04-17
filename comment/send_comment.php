<?php

include_once("../common/database.php");
include_once("../common/functions.php");
// custom functions
include_once("./comment_function.php");


// prevent hacking
echo htmlspecialchars($_SERVER["PHP_SELF"]);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// check the data
  $userID = test_data($_POST["userID"]);
  $orderID = test_data($_POST["orderID"]);
  $rating = test_data($_POST["rating"]);
  $comment = test_data($_POST["comment"]);
  $createDate = test_data($_POST["createDate"]);
  
  // insert the data to db
  addComment($userID, $orderID, $rating, $comment, $createDate);
  
  // java script answer
  echo "
	<script type=\"text/javascript\">
		window.alert('Thank you for your opinion !');
	</script>
";
}

// redirect back to comment section (comments get updated automatically)
//header("Location: comment_section.php"); // this line prevents javascript pop-up to appear
header("refresh:0; url=comment_section.php"); // javascript pop-up works fine
exit();

?>