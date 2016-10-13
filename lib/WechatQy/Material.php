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
* 微信企业号素材接口类
*/
class Material extends DriverQy
{
	/**
	 * 上传临时素材文件接口地址
	 */
	const MATERIAL_MEDIA_UPLOAD_URL = 'media/upload';
	/**
	 * 获取临时素材文件接口地址
	 */
	const MATERIAL_MEDIA_GET_URL = 'media/get';
	/**
	 * 上传其他类型永久素材接口地址
	 */
	const MATERIAL_MEDIA_ADD_MATERIAL_URL = 'media/add_material';
	/**
	 * 上传永久图文素材接口地址
	 */
	const MATERIAL_MEDIA_ADD_MPNEWS_URL = 'media/add_mpnews';
	/**
	 * 获取永久素材接口地址
	 */
	const MATERIAL_MATERIAL_GET_URL = 'material/get';
	/**
	 * 删除永久素材接口地址
	 */
	const MATERIAL_MATERIAL_DEL_URL = 'material/del';
	/**
	 * 修改永久图文素材接口地址
	 */
	const MATERIAL_MATERIAL_UPDATE_MPNEWS_URL = 'media/update_mpnews';
	/**
	 * 获取素材总数接口地址
	 */
	const MATERIAL_MATERIAL_GET_COUNT_URL = 'material/get_count';
	/**
	 * 获取素材列表接口地址
	 */
	const MATERIAL_MATERIAL_BATCHGET_URL = 'material/batchget';


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
	public function mediaUpload( $type, $media )
	{
		$param = [
					'type'  =>      $type,
					'media' =>      $media,
	            ];
	    return $this->api( self::MATERIAL_MEDIA_UPLOAD_URL, $param );
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
	    return $this->api( self::MATERIAL_MEDIA_GET_URL, '', 'GET', $param );
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
	public function materialAddMaterial( $type, $media )
	{
		$param = [
					'type'  =>      $type,
					'media' =>      $media,
	            ];
	    return $this->api( self::MATERIAL_MEDIA_ADD_MATERIAL_URL, $param );
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
	public function materialAddMpnews( array$articles )
	{
		$param = [
					'mpnews'  =>  [
						'articles'	=>	$articles
					],
	            ];
	    return $this->api( self::MATERIAL_MEDIA_ADD_MPNEWS_URL, $param );
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
	public function materialGet( $media_id )
	{
		$param = [
	                'media_id' =>	$media_id
	            ];
	    return $this->api( self::MATERIAL_MATERIAL_GET_URL, '', 'GET', $param );
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
	public function materialDel( $media_id )
	{
		$param = [
	                'media_id' =>	$media_id
	            ];
	    return $this->api( self::MATERIAL_MATERIAL_DEL_URL, '', 'GET', $param );
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
	public function materialUpdateMpnews( $media_id, array$articles )
	{
		$param = [
					'media_id'	=>	$media_id,
					'mpnews'  	=>  [
						'articles'	=>	$articles
					],
	            ];
	    return $this->api( self::ATERIAL_MATERIAL_UPDATE_MPNEWS_URL, $param );
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------修改永久图文素材-结束--------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------获取素材总数-开始------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function materialGetCount()
	{
		return $this->api( self::MATERIAL_MATERIAL_GET_COUNT_URL, '', 'GET' );
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------获取素材总数-结束------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------获取素材列表-开始------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 获取素材列表
	 * @param string  $type    素材类型，可以为图文(mpnews)、图片（image）、音频（voice）、视频（video）、文件（file）
	 * @param integer $offset  从该类型素材的该偏移位置开始返回，0表示从第一个素材 返回
	 * @param integer $count   返回素材的数量，取值在1到50之间
	 */
	public function materialBatchget( $type = 'image', $offset = 0, $count = 10 )
	{
	    $param = [
	                'type'    =>      $type,
	                'offset'  =>      $offset,
	                'count'   =>      $count,
	            ];
	    return $this->api( self::MATERIAL_MATERIAL_BATCHGET_URL, $param );
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//------获取素材列表-结束------------------------------------------------------------------------------
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
}