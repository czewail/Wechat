<?php 
namespace Ppeerit\Wechat;
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
use Ppeerit\Wechat\Exceptions\ClassTypeInvalidException;
use think\Config;
/**
 * 企业号SDK加载类
 */
class Wechat
{
    /**
     * 定义接口类型常量
     */
    const CLASS_OAUTH    = 'oauth';
    const CLASS_CONTACT  = 'contact';
    const CLASS_MATERIAL = 'material';
    /**
     * 可用接口类型数组
     * @var [type]
     */
    protected static $allowType = [
        self::CLASS_OAUTH,
        self::CLASS_CONTACT,
        self::CLASS_MATERIAL,
    ];
    /**
     * 默认配置参数
     * @var type 
     */
    protected static $config = [
        'appid'     =>  '',
        'appsecret' =>  '',
        'identity'  =>  '',
    ];
    /**
     * 默认配置文件名
     * @var string
     */
    protected static $default_config_name = 'wechat';
    /**
     * 对象缓存
     * @var type 
     */
    protected static $cache = [];
    /**
     * 设置配置参数
     * @param type $config
     */
    public static function setConfig($configname) {
        // 设置调用缓存文件的名称
        self::$default_config_name = $configname;
    }
    /**
     * 获取微信SDK接口对象
     *
     * @param type $type 接口类型(Card|Custom|Device|Extends|Media|Menu|Oauth|Pay|Receive|Script|User)
     * @param type $config SDK配置(token,appid,appsecret,encodingaeskey,mch_id,partnerkey,ssl_cer,ssl_key,qrc_img)
     * @return \WechatQy\Receive
     */
    public static function & instance( $type ) {
        // 判断接口类型合法性
        if ( !in_array(strtolower($type), self::$allowType) ) {
            //抛出异常
            throw new ClassTypeInvalidException('接口类不存在');
        }
        // 检查默认配置，存在即合并
        if ( Config::has(self::$default_config_name) ) {
            self::$config = array_merge( self::$config, Config::get(self::$default_config_name) );
        }
        // 对象缓存主键
        $index = md5(strtolower($type));
        if (!isset(self::$cache[$index])) {
            $basicName = ucfirst(strtolower($type));
            $className = "\\Ppeerit\\Wechat\\Wechat\\{$basicName}";
            !class_exists($basicName, FALSE) && class_alias($className, $basicName);
            
            self::$cache[$index] = new $className( self::$config );
        }
        return self::$cache[$index];
    }

}