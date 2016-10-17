<?php 
/**
 * 微信企业号SDK
 * @author 陈泽韦 <chenzewei@nbdeli.com>
 */
namespace Ppeerit\Wechat\Factory;

use think\Cache;
use Ppeerit\Wechat\Library\Http;
use Ppeerit\Wechat\Exceptions\ParamErrorException;
use Ppeerit\Wechat\Exceptions\AccessTokenInvalidException;
use Ppeerit\Wechat\Exceptions\HttpInvalidException;

class Driver
{
    /**
     * 企业号缓存前缀
     */
    const TOKEN_PREFIX  = 'wechat_';
    /**
     * 微信企业号api根路径
     */
    const API_PREFIX = 'https://api.weixin.qq.com/cgi-bin/';
    /**
     * 换取token的接口地址
     */
    const API_TOKEN_URL = 'token';
    
    /**
     * 公众号标识
     * 自定义，用户区分多个公众号调用缓存时的标识，不可重复，否则会导致多个公众号数据错乱
     * 只有一个公众号时可不传入
     * 默认缓存access_token，所以多个公众号时切勿使用access_token作为标识
     * @var string
     */
    protected $Identity = '';
    /**
     * 企业号唯一ID
     * @var string
     */
    protected $AppId = '';

    /**
     * 企业号管理组凭证密钥
     * @var string
     */
    protected $Secret = '';

    /**
     * 获取到的access_token
     * @var string
     */
    protected $accessToken = '';
    
    /**
     * 构造方法，调用微信高级接口时实例化SDK
     * @param [type] $CorpID   [企业唯一标识号]
     * @param [type] $Secret   [企业管理组凭证密钥]
     * @param [type] $Identity [公众号唯一标识--见成员变量]
     * @param [type] $token    [获取到的accesstoken]
     */
    public function __construct( array$options = [] )
    {
        //没有传入标识号和密钥时抛出异常
        if($options['appid'] && $options['secret']){
            //将唯一标识号赋值给类成员变量
            $this->AppId   =   $options['appid'];
            //将凭证密钥赋值给类成员变量
            $this->Secret   =   $options['secret'];
            // 微信企业号标识
            $Identity = $options['identity'] ? $options['identity'] : '';
            //从缓存中获取accesstoken
            $token = $this->getTokenCache($Identity);
            //如果缓存中不存在accesstoken
            if (!$token) {
                //从公众号接口获取token
                $token = $this->getAccessToken();
                //缓存token
                $this->setTokenCache($token, $Identity);
            }
        } else {
            //抛出异常
            throw new ParamErrorException('缺少参数 AppId 和 Secret!');
        }
    }

    /**
     * 保存accessToken到缓存中
     * @param string $access_token [description]
     * @param [type] $Identity [公众号唯一标识--见成员变量]
     */
    protected function setTokenCache($access_token = '', $Identity)
    {   
        //判断是否存在唯一标识
        if ($Identity) {
            //通过标识设置缓存
            Cache::set( self::TOKEN_PREFIX . $Identity, $access_token, 7200 );
        }else{
            //默认标识设置缓存
            Cache::set( self::TOKEN_PREFIX . 'wechat', $access_token, 7200 );
        }
    }

    /**
     * 获取缓存中的accessToken
     * @param [type] $Identity [公众号唯一标识--见成员变量]
     * @return [type] [description]
     */
    protected function getTokenCache($Identity)
    {
        //判断是否存在唯一标识
        if ($Identity) {
            //通过标识获取
            $token = Cache::get( self::TOKEN_PREFIX . $Identity );
        } else {
            //通过默认标识获取缓存
            $token = Cache::get( self::TOKEN_PREFIX . 'wechat' );
        }
        //判断缓存是否存在
        if (is_array($token)) {
            //将缓存的access_token赋值给类成员变量
            $this->accessToken = $token['access_token'];
            //返回缓存数组
            return $token;
        }else{
            //不存在--返回假值
            return false;
        }
    }

    /**
     * 获取AccessToken，用于后续接口访问
     * @return [type] [description]
     */
    public function getAccessToken()
    {
        //构造一个用于获取token接口的参数数组
        $param = [
            'grant_type' => 'client_credential',
            'appid'      => $this->AppId,
            'secret'     => $this->Secret
        ];
        //组合token接口地址
        $url = self::API_PREFIX . self::API_TOKEN_URL;
        //通过http方法从接口获取token
        $token = Http::http( $url, $param );
        //将返回的接送、数据解码为数组
        $token = json_decode( $token, true );
        //token返回成功
        if( is_array($token) ){
            //返回的是错误信息
            if( isset($token['errcode']) ){
                //抛出异常，异常信息为返回的错误信息
                throw new AccessTokenInvalidException( $token['errmsg'] );
            } else {
                //返回成功，将token赋值给成员变量
                $this->accessToken = $token['access_token'];
                //返回token数组
                return $token;
            }
        } else {
            //返回失败，抛出异常
            throw new AccessTokenInvalidException( '获取微信access_token失败！' );
        }
    }

    /**
     * 调用微信api获取响应数据
     * @param  string $name   API名称
     * @param  string $data   POST请求数据
     * @param  string $method 请求方式
     * @param  string $param  GET请求参数
     * @return array          api返回结果
     */
    protected function api($name, $data = '', $method = 'POST', $param = '', $json = true){

        $params = ['access_token' => $this->accessToken];

        if(!empty($param) && is_array($param)){
            $params = array_merge($params, $param);
        }

        $url  = self::API_PREFIX . "{$name}";
        if($json && !empty($data)){
            //保护中文，微信api不支持中文转义的json结构
            array_walk_recursive($data, function(&$value){
                $value = urlencode($value);
            });
            $data = urldecode(json_encode($data));
        }

        $data = Http::http($url, $params, $data, $method);

        return json_decode($data, true);
    }

    
}