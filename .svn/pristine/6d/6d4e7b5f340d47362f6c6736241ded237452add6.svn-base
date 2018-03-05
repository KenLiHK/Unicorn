<?php

include_once("../common/functions.php");

//Receive Ajax call with parameter foodData2Add and add the food to selectedFoodMap in user login session.
if(isset($_POST['foodData2Add']))
{
    $foodData2Add = $_POST['foodData2Add'];
    addToSelectedFoodMap($foodData2Add);
	exit();
}

function addToSelectedFoodMap($foodData2Add)
{
    //javascript object {foodID:$foodID, qty:$qty}
    $foodData2Add_array = json_decode($foodData2Add);
    $addFoodID = $foodData2Add_array[0];
    $addQty = $foodData2Add_array[1];
    
    
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if(isset($_SESSION['selected_food_map'])){
        $_selectedFoodMap_in_session = $_SESSION['selected_food_map'];
        
        for ($row = 0; $row < count($_selectedFoodMap_in_session); $row++) {
            $foodID = $_selectedFoodMap_in_session[$row]["foodID"];
            $qty = $_selectedFoodMap_in_session[$row]["qty"];
            
            if($foodID == $addFoodID){
                $qty = $qty + $addQty;
            }else{
                
            }            
        }
        
    }else{        
        $selectedFood = array("foodID" => $addFoodID, "qty" => $addQty);
        $_selectedFoodMap = array();
        array_push($_selectedFoodMap, $selectedFood);
        $_SESSION['selected_food_map'] = $_selectedFoodMap;
        echo $addQty; //Return total food quantity for the added food ID.
    }  
}

//Receive Ajax call with parameter foodData2Remove and remove the food from selectedFoodMap in user login session.
if(isset($_POST['foodData2Remove']))
{
    $foodData2Remove = $_POST['foodData2Remove'];
    removeFromSelectedFoodMap($foodData2Remove);
    exit();
}

function removeFromSelectedFoodMap($foodData2Remove)
{
    //javascript object {foodID:$foodID, qty:$qty}
    $selectedFood1 = array("foodID" => "1", "qty" => "2");
    $selectedFood2 = array("foodID" => "2", "qty" => "4");
    $selectedFood3 = array("foodID" => "3", "qty" => "3");
    
    $_selectedFoodMap = array($selectedFood1, $selectedFood2, $selectedFood3);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['selected_food_map'] = $_selectedFoodMap;
    
    
    $_userID = db_select_user_by_UserID($userID);
    if(isset($_userID))
    {
        echo "Y"; //Found UserID in DB
    }
    else
    {
        echo "N"; //NOT found UserID in DB
    }
}

?>