<?php
	include_once("../common/database.php");

	function initComment(){
		echo "I AM RUNNING <br>";
	}
	
	
	/** Returns last order ID for the user
	 !!! should I check here whether the user is logged in ? whether there is outstanding order ?
	 * @param ID of currently logged user
	 * @return oredrID of the last order
	*/
	function getOrderIDWithUserID($user_id)
	{
		try {
			// connect
			$dbconnection = db_connect();
			// query
			$sql = "SELECT order_id FROM order_table WHERE user_id='$user_id' ORDER BY order_id DESC LIMIT 1";
			$stmt = $dbconnection->query($sql);

			// result
			$OrderIDfetch = $stmt->fetch();
		
			// disconnect
			$dbconnection = null;
		
			// return value
			return $OrderIDfetch['order_id'];

	    }catch(PDOException $e){
			return -1;
	        go_to_exception_page("testComment() -> set data -> ".$e);
	    }
	}
	
	
	/** Returns array of 5 latest items according to orderID
	 * @param ID of order to be
	 * @return array of FoodIDs (up to 5) of items in current order
	*/
	function getFoodIDWithOrderID($order_id)
	{
		try {
			// connect
			$dbconnection = db_connect();
			// query
			$sql = "SELECT food_id FROM order_detail WHERE order_id='$order_id' LIMIT 5";
			$stmt = $dbconnection->query($sql);
			
			// return Array initialization
			$out['0'] = -1;
			$out['1'] = -1;
			$out['2'] = -1;
			$out['3'] = -1;
			$out['4'] = -1;
			// local variable
			$x = 0;
			
			// fill in return Array
			while ($row = $stmt->fetch())
			{
				$out[$x] = $row['food_id'];
				
				//echo "out = " . $out[$x] . "<br>";
				
				// prevent overflow (I am so sorry for this kind of lazy programming :(, but it is very easy to handle )
				$x = $x + 1;
				if( $x == 4){
					break;
				}
			}
			
			// disconnect
			$dbconnection = null;

			
			return $out;
			
	    }catch(PDOException $e){
	        go_to_exception_page("testComment() -> set data -> ".$e);
	    }

		return -1;
	}
	
	/** Returns Food Name according to its foodID
	 * @param foodID of the item
	 * @return name of the food
	*/
	function getFoodNameWithFoodID($food_id)
	{
		try {
			// connect
			$dbconnection = db_connect();
			// query
			$sql = "SELECT food_name FROM food WHERE food_id='$food_id' LIMIT 1";
			$stmt = $dbconnection->query($sql);
			
			// fetch value
			$food_name = $stmt->fetch();

			// disconnect
			$dbconnection = null;

			return $food_name['food_name'];
			
	    }catch(PDOException $e){
	        go_to_exception_page("testComment() -> set data -> ".$e);
	    }

		return -1;
	}
	
	/** Store comment posted by user
	 * @param ID of user sending the comment
	 * @param order ID of the users current order
	 * @param rating (number of stars)
	 * @param content of the comment
	 * @return success/failure
	*/
	function addComment($user_id, $order_id, $rating, $content, $create_date){
		
		try {
			// connect
	        $dbconnection = db_connect();
			
	        //prepared SQL statement
			$sql = "INSERT INTO comment (USER_ID, ORDER_ID, RATING, CONTENT, CREATE_DATE)
			VALUES ('$user_id', '$order_id', '$rating', '$content', '$create_date')";
	        $stmt = $dbconnection->prepare($sql);
			// execute 
			if ( $stmt->execute() === TRUE) {
				echo "New record created successfully"  . "<br>";
			} else {
				echo "Error: " . $sql . "<br>";
			}
	    }catch(PDOException $e){
	        go_to_exception_page("testComment() -> set data -> ".$e);
	    }
		
		// disconnect
		$dbconnection = null;
	}
	
	
	function fetchComments(&$user_id, &$order_id, &$rating, &$content, &$create_date, $number_of_comments){
		
		try {
			// connect
	        $dbconnection = db_connect();
			
			
			// query
			$sql = "SELECT user_id, order_id, rating, content, create_date FROM comment ORDER BY comment_id DESC LIMIT $number_of_comments";
			$stmt = $dbconnection->query($sql);
			
			// number of fetched rows
			$num_of_rows = $stmt->rowCount();
			
			// get the values
			for($x = 0; $x <= ($num_of_rows - 1); $x++){
				$row = $stmt->fetch();
				$user_id[$x]     = $row['user_id'];
				$order_id[$x]     = $row['order_id'];
				$rating[$x]      = $row['rating'];
				$content[$x]     = $row['content'];
				$create_date[$x] = $row['create_date'];
				
				// checking
				//echo 'uesr_id : ' . $user_id[$x] . '<br>';
				//echo 'rating : '  . $rating[$x] . '<br>';
				//echo 'content : ' . $content[$x] . '<br>';
			}
			
			// clean the rest
			for($y = $num_of_rows; $y <= ($number_of_comments - 1); $y++){
				$row = $stmt->fetch();
				$user_id[$y]     = 'DB out of data';
				$order_id[$x]    = 'DB out of data';
				$rating[$y]      = 'DB out of data';
				$content[$y]     = 'DB out of data';
				$create_date[$y] = 'DB out of data';
				
				echo 'Not enough data in databace' . '<br>';
			}
			
			// fetch value
			$food_name = $stmt->fetch();
			

	    }catch(PDOException $e){
	        go_to_exception_page("testComment() -> set data -> ".$e);
	    }
		
		// disconnect
		$dbconnection = null;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//////////////////////////////////////////////// TO BE DELETED
	
	function testComment()
	{
		// Store to DB
	    try {
	        $dbconnection = db_connect();
	        //Prepared SQL statement
			$sql = "INSERT INTO comment (USER_ID, RATING, CONTENT)
			VALUES ('1', '3', 'this is some text written by user')";
	        $stmt = $dbconnection->prepare($sql);
			// Execute 
			if ( $stmt->execute() === TRUE) {
				echo "New record created successfully"  . "<br>";
			} else {
				echo "Error: " . $sql . "<br>";
			}
	    }catch(PDOException $e){
	        //echo "<br>" . $e->getMessage();
	        go_to_exception_page("testComment() -> set data -> ".$e);
	    }
		
		// Query DB
	    try {
			$dbconnection = db_connect();
			
			// select last New
			/*
			$sql = "SELECT TOP(5) COMMENT_ID, USER_ID, RATING, CONTENT 
					FROM comment WHERE COMMENT_ID=5 
					Order By OrderDate DESC";
					*/
			/*$sql = "SELECT TOP 1 * FROM comment
					ORDER BY COMMENT_ID DESC";*/
			// select with simple condition
			$sql = "SELECT COMMENT_ID, USER_ID, RATING, CONTENT FROM comment order by comment_id desc";
			//$sql = "SELECT MAX(COMMENT_ID) FROM comment";
			// select all
			//$sql = "SELECT * FROM comment";
			$stmt = $dbconnection->query($sql);
			
			// get result
			while ($row = $stmt->fetch())
			{
				echo $row['COMMENT_ID'] . "<br>";
				/*
				if( $row['COMMENT_ID'] == 2){
					echo " distinguish this entry <br>";
					echo $row['COMMENT_ID'] . "   " . $row['USER_ID'] . "   " . $row['RATING'] . "   " . $row['CONTENT'] . "   "  . "<br>";
				}else{
					echo $row['COMMENT_ID'] . "   " . $row['USER_ID'] . "   " . $row['RATING'] . "   " . $row['CONTENT'] . "   "  . "<br>";
				}*/
			}
			echo "CHECKPOINT" . "<br>";
			
			/*
			if ($result->num_rows > 0) {
				// output data of each row
				while ($row = $stmt->fetch())
				{
					echo $row['USER_ID'] . "\n";
				}
			} else {
				echo "0 results";
			}*/
	    }catch(PDOException $e){
	        //echo "<br>" . $e->getMessage();
	        go_to_exception_page("testComment() -> get data -> ".$e);
	    }

	    // Close DB connection
	    $dbconnection = null;	
	}

?>