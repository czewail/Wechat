<?php 
/**
 * 微信企业号SDK
 * @author 陈泽韦 <549226266@qq.com>
 */

namespace Ppeerit;
use Ppeerit\Wechatqy\Auth;

/**
* 
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
		$param = array(
					'appid'         =>  $this->CorpID,
					'redirect_uri'  =>	$redirect_uri,
					'response_type' =>	'code',
					'scope'         =>	'snsapi_base',
					'state'         =>	$state,
	            );
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
	public function departmentCreate($name, $parentid, $order = '', $id = '')
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
	    $param = ['id' => $id];
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
	    $param = ['id' => $id];
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
	public function userCreate($userid, $name, $department = [], $position = '', $mobile = '', $gender = '', $email = '', $weixinid = '', $avatar_mediaid = '', $extattr = [])
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
	 */
	public function userUpdate($userid, $name, $department = [], $position = '', $mobile = '', $gender = '', $email = '', $weixinid = '', $avatar_mediaid = '', $extattr = [])
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
	 * 获取指定部门成员列表
	 * @param  integer $department_id [部门id]
	 * @param  integer $fetch_child   [1/0：是否递归获取子部门下面的成员]
	 * @param  integer $status        [0获取全部成员,
	 *                                 1获取已关注成员列表,
	 *                                 2获取禁用成员列表,
	 *                                 4获取未关注成员列表。]
	 * @return [type]                 [description]
	 */
	public function userSimplelist($department_id = 1, $fetch_child = 0, $status = 0)
	{
		$param = array(
	                'department_id' =>      $department_id,
	                'fetch_child'   =>      $fetch_child,
	                'status'        =>      $status,
	            );
	    return $this->api('user/simplelist', '', 'GET', $param);
	}
	/**
	 * 获取指定部门成员列表(详细)
	 * @param  integer $department_id [部门id]
	 * @param  integer $fetch_child   [1/0：是否递归获取子部门下面的成员]
	 * @param  integer $status        [0获取全部成员,
	 *                                 1获取已关注成员列表,
	 *                                 2获取禁用成员列表,
	 *                                 4获取未关注成员列表。]
	 * @return [type]                 [description]
	 */
	public function userList($department_id = 1, $fetch_child = 0, $status = 0)
	{
	    $param = array(
	                'department_id' =>      $department_id,
	                'fetch_child'   =>      $fetch_child,
	                'status'        =>      $status,
	            );
	    return $this->api('user/list', '', 'GET', $param);
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------标签管理-开始--------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	/**
	 * [tagList 获取标签列表]
	 * @return [type] [description]
	 */
	public function tagList()
	{
		return $this->api('tag/list', '', 'GET');
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------标签管理-结束--------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

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