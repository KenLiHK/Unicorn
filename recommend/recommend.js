/**
 * Created by pcc on 06/03/2018.
 */

document.write("<script language='javascript' src='../unicorn.js'></script>");
document.write("<script language='javascript' src='jq_plugins.js'></script>");


$(document).ready(function(){
    //document.getElementById("food-cont").innerHTML="";
    loadAllCateFood();
    loadRecomFood();

});

$(window).on('load',function(){
    //a 3rd jquery plgin for reg validation
    $(':regex(id,^add_)').click(
        function addToCart(){
            var food_id = this.id.substring(4);
            //add food to cart
             if(addFoodToCart(food_id, 1)){
                 alert('Successfully add 1 unit!');
             }
            else
                 alert("Fail adding, please try again!");
    });
    $(':regex(id,^del_)').click(
        function delFromCart(){
            var food_id = this.id.substring(4);
            //add food to cart
            if(substractFoodFromCart(food_id, 1)){
                alert("Successfully delete 1 unit!")
            }
            else
                alert('Fail deleting, please try again!'); //need to add logic, display different msg depending on returnValue
        });

});

//Call a service to get all available categories and display them
function loadAllCateFood(){
    var html = "";

    $.ajax(
        {
            type:'post',
            url:'recommendService.php',
            data:{
                displayCate:true
            },
            dataType:'json',
            success:function(result){
                if(result["code"]!==0){
                    //If the results of query is abnormal, display error msg given by backend.
                    html = result["message"];
                }
                else{
                    $.each(result["data"],function(i,n){
                        var cateName = n["food_category"];

                        html+= '<div class="sale-charts">'+
                            '<div class="category-title">'+
                            '<span class="cate-name">' + cateName + '</span>' +
                            '</div>'+
                            '<div class="foodList">'+ loadCateFood(cateName) +
                            '</div></div>';

                    });
                }

                $('#cate-cont').append(html);
            }
        }
    )

}

//Call service to get food details by a specific categoryName and load the food details
//This currrent method requires 1 network request for each category, it can be refined by selecting ALL food one time and load food from the result food array without ask for more network request
function loadCateFood(cateName){
    var li_cont = "";

    $.ajax(
        {
            type:'post',
            url:'recommendService.php',
            cache: true,
            async: false,
            data:{
                cate2Load:cateName
            },
            dataType:'json',
            success:function(result){
                //If the results of query is abnormal, display error msg given by backend.
                if(result["code"]!==0){
                    li_cont = result["message"];
                }
                else{
                    $.each(result["data"],function(i,n){
                        var disPrice = n["discount"] * n["price"];
                        var oriPrice = n["price"];

                        //console.log(n["food_id"]);
                        li_cont += '<div class="card">'+
                            '<img src="'+ n["img_path"] +'" alt="img broken">'+
                                //store food_id in coresponding id of addcart icon
                            '<div class="dish-title">'+ n["food_name"] +'</div>'+
                            '<div class="card-btm-1">' +
                                '<div class="card-btm-b">' +
                                    '<div class="i-addchart" id='+'add_'+n["food_id"] + '></div>'+
                                    '<div class="i-deletechart" id='+'del_'+n["food_id"] + '></div>'+
                                '</div>'+
                                    '<div class="price-sec">';
                        //Display discount price only when it's less than origin price
                        if(disPrice < oriPrice){
                            li_cont += '<span class="ori-price">' + oriPrice +'</span>'+
                                '<span class="dis-price">' + disPrice +'</span>';
                        }
                        else {
                            li_cont += '<span class="ori-price">' + oriPrice + '</span>';
                        }
                        li_cont += '</div>'+ '</div>'+ '</div>';
                    });
                }

            }
        }
    );
    return li_cont;

}


function loadRecomFood(){

    var li_cont = "";

    $.ajax(
        {
            //type:'post',
            type:'get',
            url:'recommendService.php',
            cache: true,
            async: false,
            data:{
                logonCheck:true
            },
            dataType:'json',
            success:function(result){
                //console.log(result["data"]);
                if(result["code"]!==0){
                    li_cont = result["message"];
                }
                else{
                    $.each(result["data"],function(i,n){
                        var disPrice = n["discount"] * n["price"];
                        var oriPrice = n["price"];

                        //console.log(n["food_id"]);
                        li_cont += '<div class="card">'+
                            '<img src="'+ n["img_path"] +'" alt="img broken">'+
                                //store food_id in coresponding id of addcart icon
                            '<div class="dish-title">'+ n["food_name"] +'</div>'+
                            '<div class="card-btm-1">' +
                            '<div class="card-btm-b">' +
                            '<div class="i-addchart" id='+'add_'+n["food_id"] + '></div>'+
                            '<div class="i-deletechart" id='+'del_'+n["food_id"] + '></div>'+
                            '</div>'+
                            '<div class="price-sec">';
                        //Display discount price only when it's less than origin price
                        if(disPrice < oriPrice){
                            li_cont += '<span class="ori-price">' + oriPrice +'</span>'+
                                '<span class="dis-price">' + disPrice +'</span>';
                        }
                        else {
                            li_cont += '<span class="ori-price">' + oriPrice + '</span>';
                        }
                        li_cont += '</div>'+
                            '</div>'+
                            '</div>';
                    });
                }
                $('#recom-list').append(li_cont);

            }
        }
    );
    return li_cont;

}