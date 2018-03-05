<?php

	include_once("../common/database.php");	

	function loadCategory(){

		try{
			$dbconnection = db_connect();
			
			$sql= "select distinct food_category from food";
			$stmt = $dbconnection->prepare($sql);
			$fetch = $stmt->fetch();

			$column_arr = array();
			$column_arr[] = $fetch['food_category'];

			return $column_arr;

		}catch(PDOException $e){
			echo "<br>".$e->getMessage();
		}

		$dbconnection = null;
	}

	function search($category, $searchText){

		try{
			$dbconnection = db_connect();

			$sql = "select * from food where food_category=:category, food=:searchText";
			$stmt = $dbconnection->prepare($sql);
			$param = 
			
			$stmt->bindParam(':searchText', getSearchText());

		}catch(PDOException $e){
			echo "<br>".$e->getMessage();
		}
		
		$dbconnection = null;
	}

/*	function search($category, $searchText){
		
		var searchText=document.getElementById("search_input").value;

		window.location="?keywords="+searchText;
	}
*/

?>