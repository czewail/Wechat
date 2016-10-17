<?php 
namespace Ppeerit\WeChat\Wechat;
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
use Ppeerit\Wechat\Factory\Driver;

/**
 * 微信企业号OAuth2.0授权类
 */
class Oauth extends Driver
{	
	/**
     * 微信企业号auth根路径
	 */
	const OAUTH_PREFIX = 'https://open.weixin.qq.com/connect/oauth2/';
	/**
	 * 授权跳转地址接口
	 */
	const OAUTH_AUTHORIZE_URL  = 'authorize';
	/**
	 * 获取授权后的用户信息接口
	 */
	const OAUTH_USERINFO_URL = 'user/getuserinfo';

	/**
	 * 授权跳转方法
	 * @return [type] [description]
	 */
	public function redirect( $redirect_uri, $state = '', $scope = 'snsapi_base' )
	{
		$url = urlencode( $redirect_uri );
		return self::OAUTH_PREFIX . self::OAUTH_AUTHORIZE_URL . "?appid={$this->CorpID}&redirect_uri={$url}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
	}

	/**
	 * 获取授权后的用户信息
	 * @param  [type] $code [description]
	 * @return [type]       [description]
	 */
	public function getUserInfo($code)
	{
		$param = [
			'code'	=>	$code
		];
		return $this->api( self::OAUTH_USERINFO_URL, '', 'GET', $param );
	}
}