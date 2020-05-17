<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>开始使用layui</title>
    <link rel="stylesheet" href="/layui/css/layui.css">
</head>
<body>

{{--<form class="layui-form" action="">--}}
    <div class="layui-form-item">
        <label class="layui-form-label">单行输入框</label>
        <div class="layui-input-block">
            <input type="text" id="project" name="title" lay-verify="title" autocomplete="off" placeholder="请输入项目名" class="layui-input">
        </div>
    </div>
    {{--<div class="layui-form-item">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>--}}


{{--</form>--}}

<div class="layui-upload">
    <button type="button" class="layui-btn layui-btn-normal" id="test8">选择文件</button>
    <button type="button" class="layui-btn" id="test9">开始上传</button>
</div>


<script src="../layui/layui.js"></script>
<script src="/public/js/jquery-3.2.1.min.js"></script>
<script>
    var project_name = $("#project").text();
    layui.use('upload', function(){
        var upload = layui.upload;



        //选完文件后不自动上传
        upload.render({
            elem: '#test8'
            ,url: '/upload/?project_name='+project_name
            ,auto: false
            //,multiple: true
            ,bindAction: '#test9'
            // ,exts: 'zip' //只允许上传压缩文件
            ,done: function(res){
                console.log(res)
            }
        });
    });
</script>
</body>
</html>