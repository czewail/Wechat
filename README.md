# Wechatqy
微信企业号开发SDK for thinkphp 5.0<br>
支持多公众号管理<br>
自动管理access_token<br>
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
$Identity：公众号标识，自定义，用于区分多个公众号调用缓存时的标识，不可重复，否则会导致多个公众号数据错乱，只有一个公众号时可不传入，默认缓存access_token，所以多个公众号时切勿使用access_token作为标识
###接口介绍
* 认证接口
* 资源接口
	* 管理企业号应用
	* 自定义菜单
	* 管理通讯录
		* 管理部门
		```php
		// 创建部门
		$wechatqy->departmentCreate($name, $parentid = 1, $order = '', $id = '');

		// 更新部门
		$wechatqy->departmentUpdate($id, $name = '', $parentid = '', $order = '');

		// 删除部门
		$wechatqy->departmentDelete($id);

		// 获取部门列表
		$wechatqy->departmentList($id = '');
		```
		* 管理成员
		```php
		// 创建成员
		$wechatqy->userCreate($userid, $name, array$department, $position = '', $mobile = '', $gender = '', 
								$email = '', $weixinid = '', $avatar_mediaid = '', $extattr = []);
		
		// 更新成员
		$wechatqy->userUpdate($userid, $name, array$department, $position = '', $mobile = '', $gender = '', 
								$email = '', $weixinid = '', $avatar_mediaid = '', $extattr = []);
		
		// 删除成员
		$wechatqy->userDelete($userid);

		// 批量删除成员
		$wechatqy->userBatchdelete(array$useridlist);

		// 获取成员
		$wechatqy->userGet($userid);

		// 获取部门成员
		$wechatqy->userSimplelist($department_id = 1, $fetch_child = 0, $status = 0);

		// 获取部门成员(详细)
		$wechatqy->userList($department_id = 1, $fetch_child = 0, $status = 0);
		```
		* 管理标签
		```php
		// 创建标签
		$wechatqy->tagCreate($tagname, $tagid = '');

		// 更新标签名字
		$wechatqy->tagUpdate($tagid, $tagname);

		// 删除标签
		$wechatqy->tagDelete($tagid);

		// 获取标签成员
		$wechatqy->tagGet($tagid);

		// 增加标签成员
		$wechatqy->tagAddtagusers($tagid, array$userlist = [], array$partylist = []);

		// 删除标签成员
		$wechatqy->tagDeltagusers($tagid, array$userlist = [], array$partylist = []);

		// 获取标签列表
		$wechatqy->tagList();
		```
	* 管理素材文件
		* 上传临时素材文件
		```php
		/**
		 * @param  $type  媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件(file)
		 * @param  $media form-data中媒体文件标识，有filename、filelength、content-type等信息
		 *
		 * 上传的媒体文件限制
		 * 所有文件size必须大于5个字节
		 * 图片（image）:2MB，支持JPG,PNG格式
		 * 语音（voice）：2MB，播放长度不超过60s，支持AMR格式
		 * 视频（video）：10MB，支持MP4格式
	     * 普通文件（file）：20MB
		 */
		$wechatqy->mediaUpload($type, $media);
		```
		* 获取临时素材文件
		```php
		/**
		 * @param  $media_id 媒体文件id。最大长度为256字节
		 * @return 			 和普通的http下载相同，请根据http头做相应的处理
		 */
		$wechatqy->mediaGet($media_id);
		```
		* 上传其他类型永久素材
		```php
		/**
		 * 上传其他类型永久素材
		 * @param  $type  		媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件(file)
		 * @param  $media 		form-data中媒体文件标识，有filename、filelength、content-type等信息
		 * @return media_id     素材资源标识ID。最大长度为256字节
		 */
		$wechatqy->materialAddMaterial($type, $media);
		
		/**
		 * 上传永久图文素材
		 * @param  array  $articles 	文章列表
		 * @return media_id          素材资源标识ID。最大长度为256字节
		 *
		 * articles格式
		 * [
		 * 		[
		 * 			'title'              =>	'标题1',//必填
		 * 			'thumb_media_id'     =>	'素材接口返回的id',//必填
		 * 			'author'             =>	'作者',
		 * 			'content_source_url' =>	'原文链接',
		 * 			'content'            =>	'内容'//必填,
		 * 			'digest'             =>	'描述',
		 * 			'show_cover_pic'     =>	'是否显示封面 0或1'
		 * 		],
		 * 		[
		 * 			//同上
		 * 		],
		 * 		//更多....
		 * ]
		 */
		$wechatqy->materialAddMpnews(array$articles);
		```
		
* 能力接口

待完善<br>

