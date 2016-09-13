# Wechatqy
微信企业号开发SDK for thinkphp 5.0<br>
暂不支持其他框架 因为使用了tp5的缓存机制<br>
后期再进行修改

## 安装
使用命令<br>
```Bash
composer require ppeerit/wechatqy
```
## 使用
###加载命名空间
```php
use Ppeerit\Wechatqy;
```
###实例化对象
```php
$wechatqy = new Wechatqy($CorpID, $Secret, $Identity = '');
```
###参数介绍
$CorpID：企业号唯一ID<br>
$Secret：企业号管理组凭证密钥<br>
$Identity：公众号标识，自定义，用户区分多个公众号调用缓存时的标识，不可重复，否则会导致多个公众号数据错乱，只有一个公众号时可不传入，默认缓存access_token，所以多个公众号时切勿使用access_token作为标识
###接口介绍
* 认证接口
* 资源接口
	* 管理企业号应用
	* 自定义菜单
	* 管理通讯录
		* 部门管理
		```php
		// 创建部门
		$wechatqy->departmentCreate($name, $parentid, $order = '', $id = '');

		// 更新部门
		$wechatqy->departmentUpdate($id, $name = '', $parentid = '', $order = '');

		// 删除部门
		$wechatqy->departmentDelete($id);

		// 获取部门列表
		$wechatqy->departmentList($id = '');
		```
		* 管理成员
		```php
		// 创建用户
		$wechatqy->userCreate($userid, $name, $department = [], $position = '', $mobile = '', $gender = '', 
								$email = '', $weixinid = '', $avatar_mediaid = '', $extattr = []);
		```
* 能力接口


待完善<br>

