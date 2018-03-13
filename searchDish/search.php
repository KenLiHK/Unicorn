<?php
	header("Content-type:text/html;charset=GB2312");
	include_once("../common/database.php");		

	//20180310 ���������˵�
    function loadCategory(){
        $con = mysqli_connect('localhost', 'root', '', 'unicorn');	//�������ݿ�

        $sql= "select distinct food_category from food";
        $query = mysqli_query($con, $sql);

        while($row=mysqli_fetch_array($query)){
            $arr[] = $row['food_category'];
            echo "<option value=\"".$row['food_category']."\">";
            echo $row['food_category'];
            echo "</option>";
        }
        mysqli_close($con);
    }

    //20180310 ��������Զ����
    function autofill(){
        $con = mysqli_connect('localhost', 'root', '', 'unicorn');	//�������ݿ�

        $sqlFood= "select food_name from food";
        $queryFood = mysqli_query($con, $sqlFood);

        $sqlTag= "select tag_des from food_tag";
        $queryTag = mysqli_query($con, $sqlTag);

        while($row=mysqli_fetch_array($queryFood)){
            $food[] = $row['food_name'];
            echo "<li>".$row['food_name']."</li>";
        }
        while($row=mysqli_fetch_array($queryTag)){
            $tag[] = $row['tag_des'];
            echo "<li>".$row['tag_des']."</li>";
        }
        mysqli_close($con);
    }

    //20180310 ����
    function search($category, $food){
        $con = mysqli_connect('localhost', 'root', '', 'unicorn');	//�������ݿ�

        $sql= "select food_id from food where food_category=".$category." and food_name=".$food;
        $query = mysqli_query($con, $sql);

        while($row=mysqli_fetch_array($query)){
            $arr[] = $row['food_name'];
            echo "<li>".$row['food_name']."</li>";
        }

        mysqli_close($con);
    }
?>


<html>
<head>
    <title>This is a SearchBox</title>
    <meta charset="utf-8" http-equiv="X-UA-Compatible" content="IE-edge"> <!--������������������-->
    <link type="text/css" rel="stylesheet" href="search.css" media="all"/>
</head>

<body>

    <!--20180310 ����������̬���ֿ�ʼ-->
    <div class="search_container">

        <form id="search_category" action="search.php" method="POST">
            <!--20180310 �����б� categories ���ݿ����-->
            <div id="sb_list" class="search_list">
                    <select class="search_list">
                        <option value="all" selected>ALL</option>
                        <?php
                            print_r(loadCategory());
                        ?>
                    </select>
            </div>

            <!--20180228 ������Ͱ�ť-->
            <div style="float:left">
                <input class="search_text" id="search_input" type="text"
                        name="search_text" value="" onkeypress="autofill()">
<!--                --><?php
//                    $search = input.text();
//
//                ?>
                <input class="search_button" type="submit" value="" onkeypress="search()">
            </div>
        </form>
        <!--20180228 ������ʾ�˵���ʾ??��̬-->
        <div class="suggest" id="search_suggest">
            <ul id="search_result">
                <?php
                    print_r(autofill());
                ?>
            </ul>
        </div>
    </div>
    <!--20180310 ����������̬���ֽ���-->

    <!--20180228 js����-->
    <script src="http://code.jquery.com/jquery-1.10.2.min.js">
    </script>

    <!--20180228 -->
    <script>

        /* category listѡ�� */
        /*  */
        /* ͨ��DOM��ȡԪ�� */
        var getDOM = function(id){
            return document.getElementById(id);
        }

        /* ��Ԫ���¼� */
        var addEvent = function(id, event, fn){
            var el = getDOM(id)||document;
            if(el.addEventListener){
                el.addEventListener(event, fn, false);
            }else if(el.attachEvent){
                el.attachEvent('on'+event, fn);
            }
        }

        addEvent('sb_list', 'mouseover', function(){
            this.className ='search_list trigger_hover';
        });

        /* ������ʾ�˵���ʾ??��̬ */
        /*
            ����1����������ַ��searchText.get
            ����2���������Զ�ƥ��
        */
        $('#search_input').bind('keyup', function(){
            var searchText = $('#search_input').val();
            $.get('../recommend/recommend.php?category='+searchText+'&&food='+, function(d){

                var d = d.AS.Results[0].Suggests;
                var html='';
                for (var i=0;i<d.length;i++){
                    html+='<li>'+d[i].Txt+'<li>';
                }
                $('#search_suggest').html(html);
                $('#search_suggest').show().css({
                    top:$('#search_form').offset().top+$('#search_form').height()+10,
                    left:$('search_form').offset().left,
                    position:'absolute'
                })
            }, 'json');
        });

        //���ҳ������λ��ʱ����̬��������ʧ
        $(document).bind('click', function(){
            $('#search_suggest').hide();
        });

        //�¼�����������һ������(�������н��������ҳ��)
        $(document).delegate('li','click',function(){
            var keyword = $(this).text();
            location.href="http://cn.bing.com/search?q="+keyword;
        })
    </script>




</body>
</html>
