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
    }catch(PDOException $e){
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

    }catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }

    //close db connection to release memory
    $dbconnection = null;
}

function db_select_desOrderId_byUserId($order){
    if(empty($order->getUserId())){
        echo 'No UserId assigned!';
    }
    else{
        try{
            //connect DB
            $dbconnection = db_connect();

            //prepare SQL statement
            $stmt = $dbconnection->prepare("SELECT `order_id` FROM `order` WHERE `user_id`= :userId
                        AND `status` = 'OS31' ORDER BY `order_id` DESC");
            $stmt->bindParam(":userId", $order->getUserId());
            //execute statement
            $stmt->execute();
            //return the results
            $results = $stmt->fetchAll();

            return $results;

        }catch(PDOException $e){
            echo $stmt . "<br>" . $e->getMessage();
        }

        $dbconnection = null;
    }

}

function db_query_food_list_byCateName($cate){
    if(empty($cate)){
        echo 'The category cannot be empty!';
    }
    else{
        try{
            $dbconnection = db_connect();
            $stmt = $dbconnection->prepare("SELECT `food_id`,`img_path`, `food_name`, `price`, `discount` FROM `food`
                    WHERE `food_category` = :cate AND `available` = 'Y'");
            $stmt->bindParam(":cate", $cate);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        }catch(PDOException $e){
            echo $stmt . "<br>" . $e->getMessage();
        }

        $dbconnection = null;
    }

}

function db_select_allFoodCateIsAval(){
    try{
        $dbconnection = db_connect();
        $stmt = $dbconnection->prepare("SELECT DISTINCT `food_category` FROM `food` WHERE `available` = 'Y'");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;

    }catch(PDOException $e){
        echo $stmt . "<br>" . $e->getMessage();
    }

    $dbconnection = null;

}

?>