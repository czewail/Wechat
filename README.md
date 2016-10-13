# Wechatqy
微信企业号开发SDK for thinkphp 5.0<br>
支持多公众号管理<br>
自动管理access_token<br>
暂不支持其他框架 因为使用了tp5的缓存机制<br>
后期再进行修改

## 安装
使用命令<br>
```Bash
composer require ppeerit/wechat
```
## 使用
###加载命名空间
```php
use Ppeerit\Wechat\WechatQy;
```
###实例化企业号对象
```php
// 设置调用的缓存文件名称，默认wechatqy
WechatQy::setConfig('wechat2');
// 实例化授权类
$oauth = & WechatQy::instance('Oauth');
```


待完善<br>

