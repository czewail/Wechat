<?php 
/**
 * Copyright (c) 2016-2021, Chen Ze Wei <549226266@qq.com>
 * All rights reserved.
 *
 *THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 *"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 *LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 *FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 *INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 *BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 *LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 *CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 *LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 *ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 *POSSIBILITY OF SUCH DAMAGE.
 */

namespace Ppeerit;
use Ppeerit\Wechatqy\Auth;

/**
 * Library for company wechat platform
 *
 * @author  Chen Ze Wei <549226266@qq.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 APACHE-2.0 License
 */
class Wechatqy extends Auth
{
	/**
	 * 构造方法，调用父类构造方法
	 */
	function __construct($CorpID, $Secret, $Identity = '')
	{
		parent::__construct($CorpID, $Secret, $Identity = '');
	}

	/**
	 * 企业获取code
	 * @param  [type] $redirect_uri [description]
	 * @param  string $state        [description]
	 * @return [type]               [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function authorize($redirect_uri, $state = '')
	{
		$param = [
					'appid'         =>  $this->CorpID,
					'redirect_uri'  =>	$redirect_uri,
					'response_type' =>	'code',
					'scope'         =>	'snsapi_base',
					'state'         =>	$state,
	            ];
		$ship = '#wechat_redirect';
        $url  = "{$this->authURL}/authorize";
        // array_walk_recursive($param, function(&$value){
        //     $value = urlencode($value);
        // });
        // $param = urldecode(json_encode($param));
        $data = self::http($url, $param, '', 'GET', $ship);
        return json_decode($data, true);
	}

	/**
	 * 返回管理组内应用的id及名称、头像等信息
	 * @return [type] [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function agentList()
	{
	    return $this->api('agent/list', '', 'GET');
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------管理通讯录-开始--------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------部门管理-开始-----------------------------------------------------------------------------------
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 创建部门
	 * @param  string  $name     [部门名称]
	 * @param  integer $parentid [父部门id 根部门id为1]
	 * @param  string  $order    [在父部门中的次序值]
	 * @param  string  $id       [部门id]
	 * @return [type]            [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function departmentCreate($name, $parentid = 1, $order = '', $id = '')
	{
		$param = [
					'name'     =>      $name,
					'parentid' =>      $parentid,
					'order'    =>      $order,
					'id'       =>      $id,
	            ];
	    return $this->api('department/create', $param);
	}

	/**
	 * 更新部门
	 * @param  [type] $id       [部门id]
	 * @param  string $name     [部门名称]
	 * @param  string $parentid [父部门id 根部门id为1]
	 * @param  string $order    [在父部门中的次序值]
	 * @return [type]           [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function departmentUpdate($id, $name = '', $parentid = '', $order = '')
	{
		$param = [
					'id'       =>      $id,
					'name'     =>      $name,
					'parentid' =>      $parentid,
					'order'    =>      $order,
	            ];
	    return $this->api('department/update', $param);
	}

	/**
	 * 删除部门
	 * @param  [type] $id [部门id]
	 * @return [type]     [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function departmentDelete($id)
	{
	    $param = [
	    			'id' => $id
	    		];
	    return $this->api('department/delete', '', 'GET', $param);
	}

	/**
	 * 获取部门列表
	 * @param  string $id [部门id。获取指定部门及其下的子部门]
	 * @return [type]     [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function departmentList($id = '')
	{
	    $param = [
	    			'id' => $id
	    		];
	    return $this->api('department/list', '', 'GET', $param);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------部门管理-结束-----------------------------------------------------------------------------------
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------管理成员-开始-----------------------------------------------------------------------------------
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 创建成员
	 * @param  [type] $userid         [成员UserID，企业内必须唯一，不区分大小写，长度为1~64个字节]
	 * @param  [type] $name           [成员名称。长度为1~64个字节]
	 * @param  array  $department     [成员所属部门id列表,不超过20个]
	 * @param  string $position       [职位信息。长度为0~64个字节]
	 * @param  string $mobile         [手机号码。企业内必须唯一，mobile/weixinid/email三者不能同时为空]
	 * @param  string $gender         [性别。1表示男性，2表示女性]
	 * @param  string $email          [邮箱。长度为0~64个字节。企业内必须唯一]
	 * @param  string $weixinid       [微信号。企业内必须唯一。（注意：是微信号，不是微信的名字）]
	 * @param  string $avatar_mediaid [成员头像的mediaid，通过多媒体接口上传图片获得的mediaid]
	 * @param  array  $extattr        [扩展属性。扩展属性需要在WEB管理端创建后才生效，否则忽略未知属性的赋值]
	 * @return [type]                 [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function userCreate($userid, $name, array$department, $position = '', $mobile = '', $gender = '', $email = '', $weixinid = '', $avatar_mediaid = '', $extattr = [])
	{
		$param = [
					'userid'         =>      $userid,
					'name'           =>      $name,
					'department'     =>      $department,
					'position'       =>      $position,
					'mobile'         =>      $mobile,
					'gender'         =>      $gender,
					'email'          =>      $email,
					'weixinid'       =>      $weixinid,
					'avatar_mediaid' =>      $avatar_mediaid,
					'extattr'        =>      $extattr,
	            ];
	    return $this->api('user/create', $param);
	}

	/**
	 * 更新成员
	 * @param  [type] $userid         [成员UserID，企业内必须唯一，不区分大小写，长度为1~64个字节]
	 * @param  [type] $name           [成员名称。长度为1~64个字节]
	 * @param  array  $department     [成员所属部门id列表,不超过20个]
	 * @param  string $position       [职位信息。长度为0~64个字节]
	 * @param  string $mobile         [手机号码。企业内必须唯一，mobile/weixinid/email三者不能同时为空]
	 * @param  string $gender         [性别。1表示男性，2表示女性]
	 * @param  string $email          [邮箱。长度为0~64个字节。企业内必须唯一]
	 * @param  string $weixinid       [微信号。企业内必须唯一。（注意：是微信号，不是微信的名字）]
	 * @param  string $avatar_mediaid [成员头像的mediaid，通过多媒体接口上传图片获得的mediaid]
	 * @param  array  $extattr        [扩展属性。扩展属性需要在WEB管理端创建后才生效，否则忽略未知属性的赋值]
	 * @return [type]                 [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function userUpdate($userid, $name, array$department, $position = '', $mobile = '', $gender = '', $email = '', $weixinid = '', $avatar_mediaid = '', $extattr = [])
	{
		$param = [
					'userid'         =>      $userid,
					'name'           =>      $name,
					'department'     =>      $department,
					'position'       =>      $position,
					'mobile'         =>      $mobile,
					'gender'         =>      $gender,
					'email'          =>      $email,
					'weixinid'       =>      $weixinid,
					'avatar_mediaid' =>      $avatar_mediaid,
					'extattr'        =>      $extattr,
	            ];
	    return $this->api('user/update', $param);
	}

	/**
	 * 删除成员
	 * @param  [type] $userid [成员UserID。对应管理端的帐号]
	 * @return [type]         [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function userDelete($userid)
	{
		$param = [
					'userid'=>$userid
				];
	    return $this->api('user/delete', '', 'GET', $param);
	}

	/**
	 * 批量删除成员
	 * @param  array  $useridlist [成员UserID列表。对应管理端的帐号。（最多支持200个）]
	 * @return [type]             [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function userBatchdelete(array$useridlist)
	{
		$param = [
					'useridlist'	=>	$useridlist
	            ];
	    return $this->api('user/batchdelete', $param);
	}
	
	/**
	 * 获取成员
	 * @param  [type] $userid [成员UserID。对应管理端的帐号]
	 * @return [type]         [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function userGet($userid)
	{
		$param = [
					'userid'=>$userid
				];
	    return $this->api('user/get', '', 'GET', $param);
	}

	/**
	 * 获取部门成员
	 * @param  integer $department_id [部门id]
	 * @param  integer $fetch_child   [1/0：是否递归获取子部门下面的成员]
	 * @param  integer $status        [0获取全部成员,
	 *                                 1获取已关注成员列表,
	 *                                 2获取禁用成员列表,
	 *                                 4获取未关注成员列表。]
	 * @return [type]                 [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function userSimplelist($department_id = 1, $fetch_child = 0, $status = 0)
	{
		$param = [
	                'department_id' =>      $department_id,
	                'fetch_child'   =>      $fetch_child,
	                'status'        =>      $status,
	            ];
	    return $this->api('user/simplelist', '', 'GET', $param);
	}

	/**
	 * 获取部门成员(详细)
	 * @param  integer $department_id [部门id]
	 * @param  integer $fetch_child   [1/0：是否递归获取子部门下面的成员]
	 * @param  integer $status        [0获取全部成员,
	 *                                 1获取已关注成员列表,
	 *                                 2获取禁用成员列表,
	 *                                 4获取未关注成员列表。]
	 * @return [type]                 [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function userList($department_id = 1, $fetch_child = 0, $status = 0)
	{
	    $param = [
	                'department_id' =>      $department_id,
	                'fetch_child'   =>      $fetch_child,
	                'status'        =>      $status,
	            ];
	    return $this->api('user/list', '', 'GET', $param);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------成员管理-结束-----------------------------------------------------------------------------------
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------标签管理-开始-----------------------------------------------------------------------------------
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	/**
	 * 创建标签
	 * @param  [type] $tagname [标签名称，长度限制为32个字（汉字或英文字母），标签名不可与其他标签重名。]
	 * @param  string $tagid   [标签id，整型，指定此参数时新增的标签会生成对应的标签id，不指定时则以目前最大的id自增。]
	 * @return [type]          [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagCreate($tagname, $tagid = '')
	{
		$param = [
					'tagname' =>      $tagname,
					'tagid'   =>      $tagid,
	            ];
	    return $this->api('tag/create', $param);
	}

	/**
	 * 更新标签名字
	 * @param  [type] $tagid   [标签ID]
	 * @param  [type] $tagname [标签名称，长度限制为32个字（汉字或英文字母），标签不可与其他标签重名。]
	 * @return [type]          [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagUpdate($tagid, $tagname)
	{
		$param = [
					'tagid'   =>      $tagid,
					'tagname' =>      $tagname,
	            ];
	    return $this->api('tag/update', $param);
	}

	/**
	 * 删除标签
	 * @param  [type] $tagid [标签ID]
	 * @return [type]        [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagDelete($tagid)
	{
		$param = [
	                'tagid' =>	$tagid
	            ];
	    return $this->api('tag/delete', '', 'GET', $param);
	}

	/**
	 * 获取标签成员
	 * @param  [type] $tagid [标签ID]
	 * @return [type]        [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagGet($tagid)
	{
		$param = [
	                'tagid' =>	$tagid
	            ];
	    return $this->api('tag/get', '', 'GET', $param);
	}

	/**
	 * 增加标签成员
	 * @param  [type] $tagid     [标签ID]
	 * @param  array  $userlist  [企业成员ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过1000]
	 * @param  array  $partylist [企业部门ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过100]
	 * @return [type]            [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagAddtagusers($tagid, array$userlist = [], array$partylist = [])
	{
		$param = [
					'tagid'     =>      $tagid,
					'userlist'  =>      $userlist,
					'partylist' =>      $partylist,
	            ];
	    return $this->api('tag/addtagusers', $param);
	}

	/**
	 * 删除标签成员
	 * @param  [type] $tagid     [标签ID]
	 * @param  array  $userlist  [企业成员ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过1000]
	 * @param  array  $partylist [企业部门ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过100]
	 * @return [type]            [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagDeltagusers($tagid, array$userlist = [], array$partylist = [])
	{
		$param = [
					'tagid'     =>      $tagid,
					'userlist'  =>      $userlist,
					'partylist' =>      $partylist,
	            ];
	    return $this->api('tag/deltagusers', $param);
	}

	/**
	 * 获取标签列表
	 * @return [type] [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagList()
	{
		return $this->api('tag/list', '', 'GET');
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------标签管理-结束----------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------管理通讯录-结束--------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------管理素材文件-开始------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------上传临时素材文件-开始--------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 上传临时素材文件
	 * @param  [type] $type  [媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件(file)]
	 * @param  [type] $media [form-data中媒体文件标识，有filename、filelength、content-type等信息]
	 * @return [type]        [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 *
	 * 上传的媒体文件限制
	 * 所有文件size必须大于5个字节
	 * 图片（image）:2MB，支持JPG,PNG格式
	 * 语音（voice）：2MB，播放长度不超过60s，支持AMR格式
	 * 视频（video）：10MB，支持MP4格式
     * 普通文件（file）：20MB
	 */
	public function mediaUpload($type, $media)
	{
		$param = [
					'type'  =>      $type,
					'media' =>      $media,
	            ];
	    return $this->api('media/upload', $param);
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------上传临时素材文件-结束--------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------获取临时素材文件-开始--------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 获取临时素材文件
	 * @param  [type] $media_id [媒体文件id。最大长度为256字节]
	 * @return [type]           [和普通的http下载相同，请根据http头做相应的处理]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function mediaGet($media_id)
	{
		$param = [
	                'media_id' =>	$media_id
	            ];
	    return $this->api('media/get', '', 'GET', $param);
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------获取临时素材文件-结束--------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------上传永久素材-开始----------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 上传其他类型永久素材
	 * @param  [type] $type  [媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件(file)]
	 * @param  [type] $media [form-data中媒体文件标识，有filename、filelength、content-type等信息]
	 * @return [type]        [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function materialAddMaterial($type, $media)
	{
		$param = [
					'type'  =>      $type,
					'media' =>      $media,
	            ];
	    return $this->api('media/add_material', $param);
	}

	/**
	 * 上传永久图文素材
	 * @param  array  	$articles 	[文章列表]
	 * @return json 	media_id 	[素材资源标识ID。最大长度为256字节]
	 * @author 陈泽韦 <549226266@qq.com>
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
	public function materialAddMpnews(array$articles)
	{
		$param = [
					'mpnews'  =>  [
						'articles'	=>	$articles
					],
	            ];
	    return $this->api('media/add_mpnews', $param);
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------上传永久素材-结束------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------获取永久素材-开始------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 获取永久素材
	 * @param  string $media_id [素材资源标识ID]
	 * @return json/http        [图文：正确时返回json,其他类型：返回结果http下载的头部信息]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function materialGet($media_id)
	{
		$param = [
	                'media_id' =>	$media_id
	            ];
	    return $this->api('material/get', '', 'GET', $param);
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------获取永久素材-结束------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------删除永久素材-开始------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 删除永久素材
	 * @param  [type] $media_id 	[素材资源标识ID]
	 * @return json     	      	[description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function materialDel($media_id)
	{
		$param = [
	                'media_id' =>	$media_id
	            ];
	    return $this->api('material/del', '', 'GET', $param);
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------删除永久素材-结束------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------修改永久图文素材-开始--------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 修改永久图文素材
	 * @param  [type] $media_id [素材资源标识ID]
	 * @param  array  $articles [文章列表]
	 * @author 陈泽韦 <549226266@qq.com>
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
	public function materialUpdateMpnews($media_id, array$articles)
	{
		$param = [
					'media_id'	=>	$media_id,
					'mpnews'  	=>  [
						'articles'	=>	$articles
					],
	            ];
	    return $this->api('media/add_mpnews', $param);
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------修改永久图文素材-开始--------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	/**
	 * 获取素材列表
	 * @param string  $type    素材类型，可以为图文(mpnews)、图片（image）、音频（voice）、视频（video）、文件（file）
	 * @param integer $agentid 企业应用的id，整型。可在应用的设置页面查看
	 * @param integer $offset  从该类型素材的该偏移位置开始返回，0表示从第一个素材 返回
	 * @param integer $count   返回素材的数量，取值在1到50之间
	 */
	public function materialBatchget($type = 'image', $agentid = 1, $offset = 0, $count = 10)
	{
	    $param = array(
	                'type'    =>      $type,
	                'agentid' =>      $agentid,
	                'offset'  =>      $offset,
	                'count'   =>      $count,
	            );
	    return $this->api('material/batchget', $param);
	}



	public function messageSend($param = '')
	{
		return $this->api('message/send', $param);
	}
}