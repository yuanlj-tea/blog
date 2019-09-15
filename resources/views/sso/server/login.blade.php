<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SSO-SERVER</title>
</head>
<body>
用户名：<input type="text" class="form-control" id="username" placeholder="请输入用户名">
密码： <input type="password" class="form-control" id="password" placeholder="请输入密码">
<button type="submit" id="sub-btn" class="btn btn-default">登录</button>


</body>
<script src="/public/js/jquery-3.2.1.min.js"></script>

<script type="text/javascript">
    $('#sub-btn').click(function () {
        var redirect_url = getUrlParam('redirect_url');
        console.log(redirect_url);
        var user = $('#username').val();
        var pass = $('#password').val();
        $.post("/sso/server/login?redirect_url="+redirect_url, {user: user, pwd: pass},
            function (data) {
                console.log(data);
                var parsedJson = jQuery.parseJSON(data);

                if(parsedJson.code == 1){
                    window.location.href = parsedJson.data.redirect_url;
                }
            });
    });

    $('#get_user_ifno').click(function () {
        token = localStorage.getItem('jwt_token');
        console.log("token = ", token);
        $.ajax({
            type: "GET",
            url: "/api/getUserInfo",
            beforeSend: function (request) {
                request.setRequestHeader("X-token", token);
            },
            success: function (result) {
                console.log(result);
            }
        });
    });

    function getUrlParam(paraName) {
        var url = document.location.toString();
        var arrObj = url.split("?");

        if (arrObj.length > 1) {
            var arrPara = arrObj[1].split("&");
            var arr;

            for (var i = 0; i < arrPara.length; i++) {
                arr = arrPara[i].split("=");

                if (arr != null && arr[0] == paraName) {
                    return arr[1];
                }
            }
            return "";
        }
        else {
            return "";
        }
    }
</script>
</html>