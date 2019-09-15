<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SSO-CLIENT A</title>
</head>
<body>
当前系统已登录，登录用户：{{ $username }}
<button type="submit" id="sub-btn" class="btn btn-default">点击退出登录</button>

</body>
<script src="/public/js/jquery-3.2.1.min.js"></script>

<script type="text/javascript">
    $('#sub-btn').click(function () {

        $.post("/sso/site_a/browserLogout",
            function (data) {
                console.log(data);
                var parsedJson = jQuery.parseJSON(data);

                if (parsedJson.code == 1) {
                    window.location.href = parsedJson.data.login_url;
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