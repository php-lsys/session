# session 操作
> 封装session操作
> 接口参考kohana的session类

快捷安装:
```
composer require lsys/session
```

使用示例:
```
$sess=\LSYS\Session\DI::get()->session();
echo $sess->get("aa");
$sess->set("aa", "aaa");
```