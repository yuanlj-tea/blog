<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="row" style="margin-top: 30px;">
    <div class="col-md-4 col-sm-12 col-md-offset-3">
        <div id="showpage" style="display: block;">
            <div class="form-group">
                <label for="username">用户名</label>
                <input type="text" class="form-control" id="username" placeholder="请输入用户名">
            </div>
            <div class="form-group">
                <label for="password">密码</label>
                <input type="password" class="form-control" id="password" placeholder="请输入密码">
            </div>
            <button type="submit" id="sub-btn" class="btn btn-default">登录</button>

            <br>
            <p class="bg-warning" style="padding: 10px;">演示用户名和密码都是<code>demo</code>。</p>
        </div>
        <div id="user" style="display: none"><p>欢迎<strong id="uname"></strong>，您已登录，<a href="javascript:;" id="logout">退出&gt;&gt;</a>
            </p></div>
    </div>

</div>
</body>

<script src="https://cdn.bootcss.com/axios/0.17.1/axios.min.js"></script>
<script>
    document.querySelector('#sub-btn').onclick = function () {
        let username = document.querySelector('#username').value;
        let password = document.querySelector('#password').value;

        var params = new URLSearchParams();
        params.append('user', username);
        params.append('pass', password);
        console.log(username+password);
        axios.post(
            'http://www.blog.com／api/login?action=login',
            params
        )
            .then((response) => {
                //console.log(response);
                if (response.result === 'success') {
                    // 本地存储token
                    localStorage.setItem('jwt', response.data.jwt);
                    // 把token加入header里
                    axios.defaults.headers.common['X-token'] = response.jwt;
                    axios.get('http://www.blog.com/api/login').then(function (response) {
                        if (response.data.result === 'success') {
                            document.querySelector('#showpage').style.display = 'none';
                            document.querySelector('#user').style.display = 'block';
                            document.querySelector('#uname').innerHTML = response.data.info.data.username;
                        } else {
                        }
                    });
                } else {
                    console.log(response.data.msg);
                }
            })
            .catch(function (error) {
                console.log(error);
            });


        let jwt = localStorage.getItem('jwt');

        if (jwt) {
            axios.defaults.headers.common['X-token'] = jwt;
            axios.get('http://www.blog.com/api/login')
                .then(function (response) {
                    if (response.data.result === 'success') {
                        document.querySelector('#showpage').style.display = 'none';
                        document.querySelector('#user').style.display = 'block';
                        document.querySelector('#uname').innerHTML = response.data.info.data.username;
                    } else {
                        document.querySelector('#showpage').style.display = 'block';
                        console.log(response.data.msg);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        } else {
            document.querySelector('#showpage').style.display = 'block';
        }


        document.querySelector('#logout').onclick = function () {
            localStorage.removeItem('jwt');
            document.querySelector('#showpage').style.display = 'block';
            document.querySelector('#user').style.display = 'none';
        }
    }

</script>

</html>