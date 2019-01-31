<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>呵呵</title>
</head>
<body>
用户名：<input type="text" class="form-control" id="username" placeholder="请输入用户名">
密码：  <input type="password" class="form-control" id="password" placeholder="请输入密码">  
<button type="submit" id="sub-btn" class="btn btn-default">登录</button>

<input type="button" id="get_user_ifno" value="点击获取用户信息">
</body>
<script src="/public/js/jquery-3.2.1.min.js"></script>

<script type="text/javascript">
    $('#sub-btn').click(function(){
        var user = $('#username').val();
        var pass = $('#password').val();
        $.get("/api/login?action=login", { user: user, pass: pass },
            function(data){
                console.log(data);

                var parsedJson = jQuery.parseJSON(data); 
　　　　
                if(parsedJson.result == 'success'){
                    localStorage.setItem("jwt_token",parsedJson.jwt);
                }

        });
    });
    
    $('#get_user_ifno').click(function(){
        token = localStorage.getItem('jwt_token');
        console.log("token = ",token);
        $.ajax({
            type: "GET",
            url: "/api/getUserInfo",
            beforeSend: function(request) {
                request.setRequestHeader("X-token", token);
            },
            success: function(result) {
                console.log(result);
            }
        });
    });

</script>
</html>