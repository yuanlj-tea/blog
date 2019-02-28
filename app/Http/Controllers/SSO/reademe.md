#### SSO单点登录demo介绍：

1、参考：https://www.cnblogs.com/ywlaker/p/6113927.html#!comments#undefined

2、

登录时序图：https://gitee.com/Alex-e/blog/blob/master/app/Http/Controllers/SSO/%E7%99%BB%E5%BD%95%E6%97%B6%E5%BA%8F%E5%9B%BE.png

登出时序图：https://gitee.com/Alex-e/blog/blob/master/app/Http/Controllers/SSO/%E9%80%80%E5%87%BA%E7%99%BB%E5%BD%95%E6%97%B6%E5%BA%8F%E5%9B%BE.png

3、sso运行配置：

```html
1、需要配置两个站点:
	1:SSO服务中心的domain，比如：http://sso_server.com
	2:子系统的domain：比如：http://sso_client_a.com
2、配置.env:
在.env文件中新增如下配置：(参考.env.example)
    #SSO配置参数
    #SSO-SERVER的domain
    SSO_DOMAIN=http://sso_server.com
    #当前子系统的domain
    SITE_DOMAIN=http://sso_client_a.com
3、数据库：
   blog\public\blog.sql中的blog_auth_clients表
4、在blog/app/Http/Controllers/SSO/SsoServer.php的属性subsysterm_logout_url中修改为你的子系统的退出登录的接口地址
5、然后访问：http://sso_client_a.com/sso/site_a/checkIsLogin 
```

4、遇到的问题：

> 1、为了防止SSO全局会话已结束，而子系统局部会话未结束，造成系统之间登录失效时间不一致；
> 在文件：blog\app\Http\Controllers\SSO\SsoServer.php的validateToken接口中返回当前access_token对应的全局会话的失效时间戳；
> 子系统获取到这个时间戳后，把对应cookie设为此时间戳就可以避免这个问题(文件blog\app\Http\Controllers\SSO\SiteA.php的86行)。
> （由于laravel随着浏览器的访问会自动延长cookie的过期时间，这里会话用的$_SESSION）
>
> 2、子系统退出登录时，调用SSO的登出接口成功后，要清理子系统的局部会话。(不清理则：SSO调用子系统删除session文件的接口删除成功；但是子系统请求结束后，$_SESSION里的数据又写入到了redis/files里)
> SSO只通知其它子系统删除session文件

