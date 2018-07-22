<!DOCTYPE html>
<html>
<head>
    <title>测试pdf</title>

    <style>
        @font-face {
            font-family: 'msyh';
            font-style: normal;
            font-weight: normal;
            src: url(http://www.blog.com/public/fonts/mysh.ttf) format('truetype');
        }
        html, body {  height: 100%;  }
        body {  margin: 0;  padding: 0;  width: 100%;
            /*display: table;  */
            font-weight: 100;  font-family: 'msyh';  }
        .container {  text-align: center;
            /*display: table-cell; */
            vertical-align: middle;  }
        .content {  text-align: center;  display: inline-block;  }
        .title {  font-size: 96px;  }
    </style>
    <script src="echarts.min.js"></script>
    <script src="jquery-3.2.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">{{$name}}</div>
    </div>


    <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
    <div id="main" style="width: 600px;height:400px;"></div>
    <img id="t1" src="" alt="">
    <script type="text/javascript">
        var pic;
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));
        // 指定图表的配置项和数据
        var option = {
            title: {
                text: 'ECharts 入门示例'
            },
            tooltip: {},
            legend: {
                data:['销量']
            },
            xAxis: {
                data: ["衬衫2","羊毛衫1","雪纺衫1","裤子1","高跟鞋1","袜子1"]
            },
            yAxis: {},
            series: [{
                name: '销量',
                type: 'bar',
                data: [5, 20, 36, 10, 10, 20]
            }]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        var picInfo = myChart.getDataURL();
        //alert(picInfo);
        if(picInfo){

            $.ajax({

                type: "post",

                data: {

                    baseimg: picInfo,
                    _token:$('meta[name="csrf-token"]').attr('content')

                },
                url: '/savePic?action=save',

                async: false,

                dataType:'json',

                success: function(data) {
                    console.log(data)
                    //$("img").attr("src",'http://www.blog.com/public/echarts/' +data.info);
                    //console.log(picInfo);
                    pic=data.info;
                    console.log(pic)
                },
                error: function(err){
                    //alert(err.info)
                    console.log('图片保存失败');

                    alert('图片保存失败');

                }
            });

        }
        $(function(){
            console.log(pic+'1231')
            $("img").attr("src",'http://www.blog.com/public/echarts/'+pic);
        });
    </script>


</div>
</body>
</html>