<?php 
namespace Ppeerit\WeChat\WechatQy;
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
use Ppeerit\Wechat\Factory\DriverQy;

/**
 * 微信企业号通讯录接口类
 */
class Contact extends DriverQy
{	
	/**
	 * 创建部门接口地址
	 */
	const CONTACT_DEPT_CREATE_URL = 'department/create';
	/**
	 * 更新部门接口地址
	 */
	const CONTACT_DEPT_UPDATE_URL = 'department/update';
	/**
	 * 删除部门接口地址
	 */
	const CONTACT_DEPT_DELETE_URL = 'department/delete';
	/**
	 * 部门列表接口地址
	 */
	const CONTACT_DEPT_LIST_URL = 'department/list';
	/**
	 * 创建成员接口地址
	 */
	const CONTACT_USER_CREATE_URL = 'user/create';
	/**
	 * 更新成员接口地址
	 */
	const CONTACT_USER_UPDATE_URL = 'user/update';
	/**
	 * 删除成员接口地址
	 */
	const CONTACT_USER_DELETE_URL = 'user/delete';
	/**
	 * 批量删除成员接口地址
	 */
	const CONTACT_USER_BATCH_DELETE_URL = 'user/batchdelete';
	/**
	 * 获取成员接口地址
	 */
	const CONTACT_USER_GET_URL = 'user/get';
	/**
	 * 获取部门成员接口地址
	 */
	const CONTACT_USER_SIMPLELIST_URL = 'user/simplelist';
	/**
	 * 获取部门成员(详细)接口地址
	 */
	const CONTACT_USER_LIST_URL = 'user/list';
	/**
	 * 创建标签接口地址
	 */
	const CONTACT_TAG_CREATE_URL = 'tag/create';
	/**
	 * 更新标签接口地址
	 */
	const CONTACT_TAG_UPDATE_URL = 'tag/update';
	/**
	 * 删除标签接口地址
	 */
	const CONTACT_TAG_DELETE_URL = 'tag/delete';
	/**
	 * 获取标签成员接口地址
	 */
	const CONTACT_TAG_GET_URL = 'tag/get';
	/**
	 * 创建标签成员接口地址
	 */
	const CONTACT_TAG_ADDTAGUSERS_URL = 'tag/addtagusers';
	/**
	 * 删除标签成员接口地址
	 */
	const CONTACT_TAG_DELTAGUSERS_URL = 'tag/deltagusers';
	/**
	 * 获取标签列表接口地址
	 */
	const CONTACT_TAG_LIST_URL = 'tag/list';

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
	public function departmentCreate( $name, $parentid = 1, $order = '', $id = '' )
	{
		$param = [
					'name'     =>      $name,
					'parentid' =>      $parentid,
					'order'    =>      $order,
					'id'       =>      $id,
	            ];
	    return $this->api( self::CONTACT_DEPT_CREATE_URL, $param );
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
	public function departmentUpdate( $id, $name = '', $parentid = '', $order = '' )
	{
		$param = [
					'id'       =>      $id,
					'name'     =>      $name,
					'parentid' =>      $parentid,
					'order'    =>      $order,
	            ];
	    return $this->api( self::CONTACT_DEPT_UPDATE_URL, $param );
	}

	/**
	 * 删除部门
	 * @param  [type] $id [部门id]
	 * @return [type]     [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function departmentDelete( $id )
	{
	    $param = [
	    			'id' => $id
	    		];
	    return $this->api( self::CONTACT_DEPT_DELETE_URL, '', 'GET', $param );
	}

	/**
	 * 获取部门列表
	 * @param  string $id [部门id。获取指定部门及其下的子部门]
	 * @return [type]     [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function departmentList( $id = '' )
	{
	    $param = [
	    			'id' => $id
	    		];
	    return $this->api( self::CONTACT_DEPT_LIST_URL, '', 'GET', $param );
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
	 * @author 陈泽韦 				  <549226266@qq.com>
	 */
	public function userCreate( $userid, $name, array$department, $position = '', $mobile = '', $gender = '', $email = '', $weixinid = '', $avatar_mediaid = '', $extattr = [] )
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
	    return $this->api( self::CONTACT_USER_CREATE_URL, $param );
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
	public function userUpdate( $userid, $name, array$department, $position = '', $mobile = '', $gender = '', $email = '', $weixinid = '', $avatar_mediaid = '', $extattr = [] )
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
	    return $this->api( self::CONTACT_USER_UPDATE_URL, $param );
	}

	/**
	 * 删除成员
	 * @param  [type] $userid [成员UserID。对应管理端的帐号]
	 * @return [type]         [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function userDelete( $userid )
	{
		$param = [
					'userid'=>$userid
				];
	    return $this->api( self::CONTACT_USER_DELETE_URL, '', 'GET', $param );
	}

	/**
	 * 批量删除成员
	 * @param  array  $useridlist [成员UserID列表。对应管理端的帐号。（最多支持200个）]
	 * @return [type]             [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function userBatchdelete( array$useridlist )
	{
		$param = [
					'useridlist'	=>	$useridlist
	            ];
	    return $this->api( self::CONTACT_USER_BATCH_DELETE_URL, $param );
	}
	
	/**
	 * 获取成员
	 * @param  [type] $userid [成员UserID。对应管理端的帐号]
	 * @return [type]         [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function userGet( $userid )
	{
		$param = [
					'userid'=>$userid
				];
	    return $this->api( self::CONTACT_USER_GET_URL, '', 'GET', $param );
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
	public function userSimplelist( $department_id = 1, $fetch_child = 0, $status = 0 )
	{
		$param = [
	                'department_id' =>      $department_id,
	                'fetch_child'   =>      $fetch_child,
	                'status'        =>      $status,
	            ];
	    return $this->api( self::CONTACT_USER_SIMPLELIST_URL, '', 'GET', $param );
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
	public function userList( $department_id = 1, $fetch_child = 0, $status = 0 )
	{
	    $param = [
	                'department_id' =>      $department_id,
	                'fetch_child'   =>      $fetch_child,
	                'status'        =>      $status,
	            ];
	    return $this->api( self::CONTACT_USER_LIST_URL, '', 'GET', $param );
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
	public function tagCreate( $tagname, $tagid = '' )
	{
		$param = [
					'tagname' =>      $tagname,
					'tagid'   =>      $tagid,
	            ];
	    return $this->api( self::CONTACT_TAG_CREATE_URL, $param );
	}

	/**
	 * 更新标签名字
	 * @param  [type] $tagid   [标签ID]
	 * @param  [type] $tagname [标签名称，长度限制为32个字（汉字或英文字母），标签不可与其他标签重名。]
	 * @return [type]          [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagUpdate( $tagid, $tagname )
	{
		$param = [
					'tagid'   =>      $tagid,
					'tagname' =>      $tagname,
	            ];
	    return $this->api( self::CONTACT_TAG_UPDATE_URL, $param );
	}

	/**
	 * 删除标签
	 * @param  [type] $tagid [标签ID]
	 * @return [type]        [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagDelete( $tagid )
	{
		$param = [
	                'tagid' =>	$tagid
	            ];
	    return $this->api( self::CONTACT_TAG_DELETE_URL, '', 'GET', $param );
	}

	/**
	 * 获取标签成员
	 * @param  [type] $tagid [标签ID]
	 * @return [type]        [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagGet( $tagid )
	{
		$param = [
	                'tagid' =>	$tagid
	            ];
	    return $this->api( self::CONTACT_TAG_GET_URL, '', 'GET', $param );
	}

	/**
	 * 增加标签成员
	 * @param  [type] $tagid     [标签ID]
	 * @param  array  $userlist  [企业成员ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过1000]
	 * @param  array  $partylist [企业部门ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过100]
	 * @return [type]            [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagAddtagusers( $tagid, array$userlist = [], array$partylist = [] )
	{
		$param = [
					'tagid'     =>      $tagid,
					'userlist'  =>      $userlist,
					'partylist' =>      $partylist,
	            ];
	    return $this->api( self::CONTACT_TAG_ADDTAGUSERS_URL, $param );
	}

	/**
	 * 删除标签成员
	 * @param  [type] $tagid     [标签ID]
	 * @param  array  $userlist  [企业成员ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过1000]
	 * @param  array  $partylist [企业部门ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过100]
	 * @return [type]            [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagDeltagusers( $tagid, array$userlist = [], array$partylist = [] )
	{
		$param = [
					'tagid'     =>      $tagid,
					'userlist'  =>      $userlist,
					'partylist' =>      $partylist,
	            ];
	    return $this->api( self::CONTACT_TAG_DELTAGUSERS_URL, $param );
	}

	/**
	 * 获取标签列表
	 * @return [type] [description]
	 * @author 陈泽韦 <549226266@qq.com>
	 */
	public function tagList()
	{
		return $this->api( self::CONTACT_TAG_LIST_URL, '', 'GET' );
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------标签管理-结束----------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		
}