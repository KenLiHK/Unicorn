var data = {
  "recommendList": [
    {
      "foodId": "d001",
      "foodImg": "../resources/food1_256x256.jpg",
      "foodName": "Marinated Vegetarian Snacks",
      "originPrice": "36.0",
      "discountPrice": "30.0",
      "isAvailable": "Y"
    },
    {
      "foodId": "d001",
      "foodImg": "http://img.dongqiudi.com/uploads/avatar/2014/10/20/8MCTb0WBFG_thumb_1413805282863.jpg",
      "foodName": "Spicy Veggie Chicken Slices",
      "originPrice": "90.0",
      "discountPrice": "80.0",
      "isAvailable": "Y"
    },
    {
      "foodId": "d001",
      "foodImg": "http://img.dongqiudi.com/uploads/avatar/2014/10/20/8MCTb0WBFG_thumb_1413805282863.jpg",
      "foodName": "Baked Curry Chicken Rice",
      "originPrice": "56.0",
      "discountPrice": "48.0",
      "isAvailable": "Y"
    },
    {
      "foodId": "d001",
      "foodImg": "http://img.dongqiudi.com/uploads/avatar/2014/10/20/8MCTb0WBFG_thumb_1413805282863.jpg",
      "foodName": "Baked Curry Chicken Rice",
      "originPrice": "56.0",
      "discountPrice": "48.0",
      "isAvailable": "Y"
    },
    {
      "foodId": "d001",
      "foodImg": "../resources/food1_256x256.jpg",
      "foodName": "Marinated Vegetarian Snacks",
      "originPrice": "36.0",
      "discountPrice": "30.0",
      "isAvailable": "Y"
    },
    {
      "foodId": "d001",
      "foodImg": "../resources/food1_256x256.jpg",
      "foodName": "Marinated Vegetarian Snacks",
      "originPrice": "36.0",
      "discountPrice": "30.0",
      "isAvailable": "Y"
    }
  ]
};

//var li_cont = '';
//var recList = data.recommendList;
//
//for(var i=0,dLen=recList.length;i<dLen;i++) {
//	li_cont+= '<div class="card">'+
//                '<img src="'+ recList[i].foodImg +'" alt="img broken">'+
//                '<div class="dish-title">'+ recList[i].foodName +'</div>'+
//                  '<div class="card-btm-1">' +
//                  '<div class="i-addchart">'+'</div>'+
//                  '<div class="price-sec">'+
//                    '<span class="ori-price">' + recList[i].originPrice +'</span>'+
//                    '<span class="dis-price">' + recList[i].discountPrice +'</span>'+
//                  '</div>'+
//                '</div>'+
//  			 '</div>';
//}
//
//var ulist = document.getElementById("recList");
//ulist.innerHTML = li_cont;

$(document).ready(function(){
  document.getElementById('recList').innerHTML='';
  loadCateFood();
});

function loadCateFood(){

  $.ajax(
      {
        url:'recommendService.php',
        dataType:'json',
        success:function(result){
          //console.log(result["data"][0].food_id);
          var li_cont = "";
          $.each(result["data"],function(i,n){
            var disPrice = n["discount"] * n["price"];
            var oriPrice = n["price"];

            console.log(n["food_id"]);
            li_cont+= '<div class="card">'+
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

          $('#recList').append(li_cont);
        }
      }
  )

}


