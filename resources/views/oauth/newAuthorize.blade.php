<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>党建登录</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        html,body {
            background-color: #2A3F53;
        }

        .login_out {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 240px;
            height: 300px;
            text-align: center;
            transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            -o-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        .login_top {
            position: relative;
            font-size: 20px;
            font-weight: bold;
            color: #86889f;
        }

        .login_top:before,.login_top:after {
            position: absolute;
            content:'';
            top: 13px;
            width: 40px;
            height: 1px;
            background-color: #646b71;
        }

        .login_top:before{
            left: 0;
        }

        .login_top:after {
            right:0;
        }

        .login_out> div {
            margin: 15px 0;
        }

        .login_out> div input {
            width:200px;
            padding: 0 10px;
            height: 34px;
            line-height: 34px;
            background-color: #fff;
            color: #AFB8C5;
        }

        #login {
            width: 100px;
            font-size: 18px;
        }
    </style>
</head>
<body>
<div class="login_out">
    <div class="login_top">党建</div>
    <div><input type="text" name="username" id="username" placeholder="登录名"></div>
    <div><input type="password" name="pwd" id="pwd" placeholder="密码"></div>
    <input type="button" id="login" value="党建">
</div>

<script src="/public/js/jquery-3.2.1.min.js"></script>

<script>
    $("#login").click(function(){
        var username = $("#username").val();
        var pwd = $("#pwd").val();

        $.post("/oauth/authorize?client_id=demo&redirect_uri=http://www.blog.com/oauth/callback&response_type=code&state=6071", {
            user: username,
            pwd: pwd,
            // client_id:"demo",
            // redirect_uri:"http://www.blog.com/oauth/callback",
            // response_type:"code",
            // state:6071
        },
            function(data){
                console.log(data);

                //var parsedJson = jQuery.parseJSON(data);

                if(data.code == '1'){
                    var jumpUrl = data.info;
                    location.href = jumpUrl;
                }else{
                    alert(data.info);
                }

            });
    });
</script>
</body>
</html>