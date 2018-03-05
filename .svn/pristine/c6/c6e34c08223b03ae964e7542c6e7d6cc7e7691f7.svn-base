/**
 * Created by pcc on 27/02/2018.
 */

$(document).ready(function(){
    document.getElementById('recList').innerHTML='';
    loadCateFood();
});

function loadCateFood(){

    $.ajax(
        {
            type:'post',
            url:'recommendService.php',
            data:{
                cate2Load:'MIN' //to be replaced by variable
            },
            dataType:'json',
            success:function(result){
                //console.log(result["data"][0].food_id);
                var li_cont = "";
                $.each(result["data"],function(i,n){
                    var disPrice = n["discount"] * n["price"];
                    var oriPrice = n["price"];

                    //console.log(n["food_id"]);
                    //a += "<li>" + n["food_id"] + "</li>";
                    li_cont+= '<div class="card">'+
                        '<img src="'+ n["img_path"] +'" alt="img broken">'+
                        '<div class="dish-title">'+ n["food_name"] +'</div>'+
                        '<div class="card-btm-1">' +
                        '<div class="i-addchart">'+'</div>'+
                        '<div class="price-sec">';
                    if(disPrice < oriPrice){
                        li_cont += '<span class="ori-price">' + oriPrice +'</span>'+
                            '<span class="dis-price">' + eval(disPrice) +'</span>';
                    }
                    else {
                        li_cont += '<span class="ori-price">' + oriPrice + '</span>';
                    }
                    li_cont += '</div>'+
                        '</div>'+
                        '</div>';
                });
                //a += "</ul>";

                $('#recList').append(li_cont);
            }
        }
    )

}