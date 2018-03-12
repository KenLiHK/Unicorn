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
        echo $sql . "<br>" . $e->getMessage();
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


        //return results
        return $results;

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
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

            return $results;

        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
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
            $stmt = $dbconnection->prepare("SELECT `food_id`,`img_path`, `food_name`, `price`, `discount` FROM `food`
                    WHERE `food_category` = :cate AND `available` = 'Y'");
            $stmt->bindParam(":cate", $cate);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }

        $dbconnection = null;
    }

}

function db_select_allAvailCategories()
{
    try {
        $dbconnection = db_connect();
        $stmt = $dbconnection->prepare("SELECT DISTINCT `food_category` FROM `food` WHERE `available` = 'Y'");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;

    } catch (PDOException $e) {
        echo $stmt . "<br>" . $e->getMessage();
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
            $stmt = $dbconnection->prepare("SELECT DISTINCT `food`.`food_category` FROM `order_detail` LEFT JOIN `food` ON `food`.`food_id` = `order_detail`.`food_id` WHERE `order_detail`.`order_id` = :orderId ORDER BY `food`.`food_id` DESC");
            $stmt->bindParam(":orderId", $orderId);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
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
            $stmt = $dbconnection->prepare("SELECT `food`.`food_id`, `food`.`img_path`, `food`.`food_name`,`food`.`price`, `food`.`discount`, `food_tag`.`update_date` FROM `food` LEFT JOIN `food_tag` ON `food`.`food_id` = `food_tag`.`food_id` WHERE `food_tag`.`tag_des` = :tagName ORDER BY `food_tag`.`update_date` DESC");
            $stmt->bindParam(":tagName", $tagName);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }

        $dbconnection = null;
    }

}

?>