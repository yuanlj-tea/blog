#### SSO单点登录demo介绍：

1、参考：https://www.cnblogs.com/ywlaker/p/6113927.html#!comments#undefined

2、登录时序图：https://gitee.com/Alex-e/blog/blob/master/app/Http/Controllers/SSO/%E7%99%BB%E5%BD%95%E6%97%B6%E5%BA%8F%E5%9B%BE.png

登出时序图：https://gitee.com/Alex-e/blog/blob/master/app/Http/Controllers/SSO/%E9%80%80%E5%87%BA%E7%99%BB%E5%BD%95%E6%97%B6%E5%BA%8F%E5%9B%BE.png

3、sso运行配置：

```html
1、需要配置两个站点:
	1:SSO服务中心的domain，比如：http://sso_server.com
	2:子系统的domain：比如：http://sso_client_a.com
2、配置.env:
	在.env文件中新增如下配置：
	#SSO配置参数
    #SSO-SERVER的domain
    SSO_DOMAIN=http://sso_server.com
    #当前子系统的domain
    SITE_DOMAIN=http://sso_client_a.com

3、在blog/app/Http/Controllers/SSO/SsoServer.php的属性subsysterm_logout_url中修改为你的子系统的退出登录的接口地址
4、然后访问：
http://sso_client_a.com/sso/site_a/checkIsLogin 
```

