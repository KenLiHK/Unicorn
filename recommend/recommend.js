/**
 * Created by pcc on 06/03/2018.
 */

$(document).ready(function(){
    document.getElementById("food-cont").innerHTML="";
    setCateName();
});

function setCateName(){
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
                $.each(result["data"],function(i,n){
                    var cateName = n["food_category"];

                    html+= '<div class="sale-charts">'+
                        '<div class="category-title">'+
                        '<span class="cate-name">' + cateName + '</span>' +
                        '</div>'+
                        '<div id="recList">'+ loadCateFood(cateName) +
                        '</div></div>';

                });

                $('#food-cont').append(html);
            }
        }
    )

}

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
                //console.log(cateName);
                $.each(result["data"],function(i,n){
                    var disPrice = n["discount"] * n["price"];
                    var oriPrice = n["price"];

                    console.log(n["food_id"]);
                    li_cont += '<div class="card">'+
                        '<img src="'+ n["img_path"] +'" alt="img broken">'+
                        '<div class="dish-title">'+ n["food_name"] +'</div>'+
                        '<div class="card-btm-1">' +
                        '<div class="i-addchart">'+'</div>'+
                        '<div class="price-sec">';
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
        }
    );
    return li_cont;

}