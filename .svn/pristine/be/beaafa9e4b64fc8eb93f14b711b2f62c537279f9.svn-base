/******** [START] Place order JavaScript ********/
$("button").click(function(){
	var num;
	if($(this).text() == "-"){
		var $num = $(this).next();
		num = parseInt($num.text());
		num--;
		if(num <= 0){
			$num.text(0);
		}else{
			$num.text(num);
		}
	}else{
		var $num = $(this).prev();
		num = parseInt($num.text());
		num++;
		$num.text(num);
	}

	var price = parseInt($(this).parent().prev().children("span").text());
	$(this).parent().next().children("span").text(price*num);

	var $span = $("tbody>tr>td:last-child>span");
	var totalNum = 0;
	for(var i=0;i<$span.length;i++){
		var total = parseInt($($span[i]).text());
		totalNum += total;
	}
	$("tfoot>tr>td:last>span").text(totalNum);
});
/******** [END] Place order JavaScript ********/

