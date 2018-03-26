<?php
/**
 * Created by PhpStorm.
 * User: pcc
 * Date: 11/02/2018
 * Time: 17:00
 */


//Start of recommendation DB part
function db_insert($sql)
{
    try {
        $dbconnection = db_connect();

        //execute sql to insert record
        $dbconnection->exec($sql);

        //echo "New record created successfully";
    } catch (PDOException $e) {
    	go_to_exception_page("db_insert() -> ".$e);
    }

    //close db connection to release memory
    $dbconnection = null;
}

// Add by PCC for sql query
function db_query($sql)
{
    try {
        $dbconnection = db_connect();

        //execute sql to query
        $stmt = $dbconnection->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dbconnection = null;
        //return results
        return $results;

    } catch (PDOException $e) {
    	go_to_exception_page("db_query() -> ".$e);
    }

    //close db connection to release memory
    $dbconnection = null;
}

function db_select_latestOrderId_byUserId($userId)
{
    if (empty($userId)) {
        return $results = 'userId is not given!';
    } else {
        try {
            //connect DB
            $dbconnection = db_connect();

            //prepare SQL statement
            $stmt = $dbconnection->prepare("SELECT `order_id` FROM `order` WHERE `user_id`= :userId
                        AND `status` = 'OS31' ORDER BY `order_id` DESC LIMIT 1");
            $stmt->bindParam(":userId", $userId);
            //execute statement
            $stmt->execute();
            //return the results
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $dbconnection = null;
            return $results;

        } catch (PDOException $e) {
        	go_to_exception_page("db_select_latestOrderId_byUserId() -> ".$e);
        }

        $dbconnection = null;
    }

}

function db_select_food_list_byCateName($cate)
{
    if (empty($cate)) {
        return $results='The category cannot be empty!';
    } else {
        try {
            $dbconnection = db_connect();
            $stmt = $dbconnection->prepare("SELECT * FROM `food`
                    WHERE `food_category` = :cate AND `available` = 'Y'");
            $stmt->bindParam(":cate", $cate);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $dbconnection = null;
            return $results;

        } catch (PDOException $e) {
        	go_to_exception_page("db_select_food_list_byCateName() -> ".$e);
        }

        $dbconnection = null;
    }

}

function db_select_allAvailCategories()
{
    try {
        $dbconnection = db_connect();
        $stmt = $dbconnection->prepare("SELECT * FROM `food` WHERE `available` = 'Y' group by food_category, food_name order by food_category asc");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dbconnection = null;
        return $results;

    } catch (PDOException $e) {
    	go_to_exception_page("db_select_allAvailCategories() -> ".$e);
    }

    $dbconnection = null;

}


function db_select_orderFoodCateList_byOrderId($orderId)
{
    if(empty($orderId) || (!is_numeric($orderId))){
        return $results="orderId is invalid!";
    }
    else{
        try {
            $dbconnection = db_connect();
            $stmt = $dbconnection->prepare("SELECT DISTINCT `food`.`food_category` FROM `order_detail` 
											LEFT JOIN `food` ON `food`.`food_id` = `order_detail`.`food_id` 
											WHERE `order_detail`.`order_id` = :orderId 
											ORDER BY `food`.`food_id` DESC");
            $stmt->bindParam(":orderId", $orderId);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $dbconnection = null;
            return $results;

        } catch (PDOException $e) {
        	go_to_exception_page("db_select_orderFoodCateList_byOrderId() -> ".$e);
        }
    }

    $dbconnection = null;

}

function db_select_food_list_byTagName($tagName)
{
    if (empty($tagName)) {
        return $results='The tagName cannot be empty!';
    } else {
        try {
            $dbconnection = db_connect();
            $stmt = $dbconnection->prepare("SELECT fd.* 
											FROM `food` fd LEFT JOIN `food_tag`ft ON fd.`food_id` = ft.`food_id` 
											WHERE ft.`tag_des` = :tagName and fd.`available` = 'Y' ORDER BY ft.`update_date` DESC LIMIT 4");
            $stmt->bindParam(":tagName", $tagName);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $dbconnection = null;
            return $results;

        } catch (PDOException $e) {
        	go_to_exception_page("db_select_food_list_byTagName() -> ".$e);
        }

        $dbconnection = null;
    }

}

function db_select_highest_Price_food_list()
{
	try {
		$dbconnection = db_connect();
		$stmt = $dbconnection->prepare("SELECT * FROM `food` fd where fd.`available` = 'Y' ORDER BY fd.`price` DESC LIMIT 10");
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$dbconnection = null;
		return $results;
		
	} catch (PDOException $e) {
		go_to_exception_page("db_select_highest_Price_food_list() -> ".$e);
	}
	
	$dbconnection = null;
}

function db_select_all_food_category_name()
{
	try {
		$dbconnection = db_connect();
		$stmt = $dbconnection->prepare("SELECT distinct `food_category` FROM `food` where `available` = 'Y'");
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$dbconnection = null;
		return $results;
		
	} catch (PDOException $e) {
		go_to_exception_page("db_select_all_food_category_name() -> ".$e);
	}
		
	$dbconnection = null;
}

function db_select_all_food_name_tag()
{
	try {
		$dbconnection = db_connect();
		$stmt = $dbconnection->prepare("select distinct `food_name` as `food_des` from `food` where `available` = 'Y' 
										union all 
										select distinct `tag_des` as `food_des` from `food_tag`");
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$dbconnection = null;
		return $results;
		
	} catch (PDOException $e) {
		go_to_exception_page("db_select_all_food_name_tag() -> ".$e);
	}
	
	$dbconnection = null;
}

function db_select_all_food_cat($cat)
{
	try {
		$dbconnection = db_connect();
		$stmt = $dbconnection->prepare("select distinct `food_name` as `food_des` from `food` where `food_category` = :cat and `available` = 'Y'");
		$stmt->bindParam(":cat", $cat);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$dbconnection = null;
		return $results;
		
	} catch (PDOException $e) {
		go_to_exception_page("db_select_all_food_cat() -> ".$e);
	}
	
	$dbconnection = null;
}

function db_select_food_by_food_category_name($foodCate, $foodName)
{
	try {
		$dbconnection = db_connect();
		$stmt = $dbconnection->prepare("select * from `food` where `food_category` like :cat and `food_name` like :name and `available` = 'Y'");
		$paramArray = array(":cat" => "%" . $foodCate . "%", ":name" => "%" . $foodName. "%");
		$stmt->execute($paramArray);
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$dbconnection = null;
		return $results;
		
	} catch (PDOException $e) {
		go_to_exception_page("db_select_food_by_food_category_name() -> ".$e);
	}
	
	$dbconnection = null;
}



?>