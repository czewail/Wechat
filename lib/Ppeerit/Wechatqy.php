<?php 
/**
 * 微信企业号SDK
 * @author 陈泽韦 <chenzewei@nbdeli.com>
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
	 */
	public function authorize($redirect_uri, $state = '')
	{
		$param = array(
	                'appid' => $this->CorpID,
	                'redirect_uri'	=>	$redirect_uri,
	                'response_type'	=>	'code',
	                'scope'	=>	'snsapi_base',
	                'state'	=>	$state,
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
	 */
	public function agentList()
	{
	    return $this->api('agent/list', '', 'GET');
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------部门管理-开始--------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 获取部门列表
	 * @param  string $id [部门id。获取指定部门及其下的子部门]
	 * @return [type]     [description]
	 */
	public function departmentList($id = '')
	{
	    $param = array(
	                'id' => $id,
	            );
	    return $this->api('department/list', '', 'GET', $param);
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------部门管理-结束--------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
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