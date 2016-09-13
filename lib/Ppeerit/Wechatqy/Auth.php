<?php 
/**
 * 微信企业号SDK
 * @author 陈泽韦 <chenzewei@nbdeli.com>
 */

namespace Ppeerit\Wechatqy;
use think\Cache;

class Auth
{
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
    protected $CorpID = '';

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
     * 微信企业号api根路径
     * @var string
     */
    protected $apiURL = 'https://qyapi.weixin.qq.com/cgi-bin';

    /**
     * 微信企业号auth根路径
     * @var string
     */
    protected $authURL = 'https://open.weixin.qq.com/connect/oauth2';
    
    /**
     * 构造方法，调用微信高级接口时实例化SDK
     * @param [type] $CorpID   [企业唯一标识号]
     * @param [type] $Secret   [企业管理组凭证密钥]
     * @param [type] $Identity [公众号唯一标识--见成员变量]
     * @param [type] $token    [获取到的accesstoken]
     */
    public function __construct($CorpID, $Secret, $Identity = '')
    {
        //没有传入标识号和密钥时抛出异常
        if($CorpID && $Secret){
            //将唯一标识号赋值给类成员变量
            $this->CorpID   =   $CorpID;
            //将凭证密钥赋值给类成员变量
            $this->Secret   =   $Secret;
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
            throw new \Exception('缺少参数 CorpID 和 Secret!');
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
            Cache::set($Identity, $access_token, 7200);
        }else{
            //默认标识设置缓存
            Cache::set('access_token', $access_token, 7200);
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
            $token = Cache::get($Identity);
        } else {
            //通过默认标识获取缓存
            $token = Cache::get('access_token');
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
        $param = array(
            'corpid'        => $this->CorpID,
            'corpsecret'    => $this->Secret
        );
        //组合token接口地址
        $url = "{$this->apiURL}/gettoken";
        //通过http方法从接口获取token
        $token = self::http($url, $param);
        //将返回的接送、数据解码为数组
        $token = json_decode($token, true);
        //token返回成功
        if(is_array($token)){
            //返回的是错误信息
            if(isset($token['errcode'])){
                //抛出异常，异常信息为返回的错误信息
                throw new \Exception($token['errmsg']);
            } else {
                //返回成功，将token赋值给成员变量
                $this->accessToken = $token['access_token'];
                //返回token数组
                return $token;
            }
        } else {
            //返回失败，抛出异常
            throw new \Exception('获取微信access_token失败！');
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

        $params = array('access_token' => $this->accessToken);

        if(!empty($param) && is_array($param)){
            $params = array_merge($params, $param);
        }

        $url  = "{$this->apiURL}/{$name}";
        if($json && !empty($data)){
            //保护中文，微信api不支持中文转义的json结构
            array_walk_recursive($data, function(&$value){
                $value = urlencode($value);
            });
            $data = urldecode(json_encode($data));
        }

        $data = self::http($url, $params, $data, $method);

        return json_decode($data, true);
    }

    /**
     * 发送HTTP请求方法，目前只支持CURL发送请求
     * @param  string $url    请求URL
     * @param  array  $param  GET参数数组
     * @param  array  $data   POST的数据，GET请求时该参数无效
     * @param  string $method 请求方法GET/POST
     * @param  string $ship   #参数
     * @return array          响应数据
     */
    protected static function http($url, $param, $data = '', $method = 'GET', $ship = ''){
      
        $opts = array(
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        );

        /* 根据请求类型设置特定参数 */
        $opts[CURLOPT_URL] = $url . '?' . http_build_query($param) . $ship;

        if(strtoupper($method) == 'POST'){
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $data;
            
            if(is_string($data)){ //发送JSON数据
                $opts[CURLOPT_HTTPHEADER] = array(
                    'Content-Type: application/json; charset=utf-8',  
                    'Content-Length: ' . strlen($data),
                );
            }
        }

        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        //发生错误，抛出异常
        if($error) throw new \Exception('请求发生错误：' . $error);

        return  $data;
    }
}