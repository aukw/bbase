<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 *  @abstract 申明变量/类/方法
 *  @access指明这个变量、类、函数/方法的存取权限
 *  @author brooks
 *  @const指明常量
 *  @final指明这是一个最终的类、方法、属性，禁止派生、修改。
 *  @global指明在此函数中引用的全局变量
 *  @include指明包含的文件的信息
 *  @module定义归属的模块信息
 *  @modulegroup定义归属的模块组
 *  @package定义归属的包的信息
 *  @param定义函数或者方法的参数信息
 *  @return定义函数或者方法的返回信息
 *  @see定义需要参考的函数、变量，并加入相应的超级连接。
 *  @since 指明该api函数或者方法是从哪个版本开始引入的
 *  @static 指明变量、类、函数是静态的。
 *  @todo指明应该改进或没有实现的地方
 *  @var定义说明变量/属性。
 *  @version定义版本信息
 * 
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/controllers/BaseController.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/SMSModel.php';

class InfoController extends BaseController
{
	public $reviewmodel;
	public function __construct() {
		parent::__construct();
	}
	
        public function index()
        {
            
        }
        
        public function register(){
            $info = array(
                'url' => '/api/auth/register',
                'method' => Config::$METHOD_POST,
                'params' => array(
                    array('name'=>'mobile', 'value'=>'用户手机号'),
                    array('name'=>'password', 'value'=>'密码'),
                    array('name'=>'valicode', 'value'=>'验证码,请先调用 获取验证码 接口获得'),
                ),
                'return' => array(
                    array('name' =>'user', 'value' => '手机号 //第一次注册，没有填写用户名，就以手机号替代用户名'),
                    array('name' => 'authcode', 'value' => 'JWT code //登录后，所有的请求操作都将该参数添加到URL后面，返回到服务器')
                )
            );
            return $this->go("resiter", $info);
        }
        
        public function login(){
            $info = array(
                'url' => '/api/auth/login',
                'method' => Config::$METHOD_POST,
                'params' => array(
                    array('name'=>'mobile', 'value'=>'用户手机号'),
                    array('name'=>'password', 'value'=>'密码')
                ),
                'return' => array(
                    array('name' =>'user', 'value' => '手机号 //第一次注册，没有填写用户名，就以手机号替代用户名'),
                    array('name' => 'authcode', 'value' => 'JWT code //登录后，所有的请求操作都将该参数添加到URL后面，返回到服务器')
                )
            );
            return $this->go("resiter", $info);
        }
        
        public function sendvalicode(){
            $info = array(
                'url' => '/api/sms/@type',
                'method' => Config::$METHOD_POST,
                'params' => array(
                    array('name'=>'说明 @type', 'value'=>' enum("register", "password")'),
                    array('name'=>'mobile', 'value'=>'用户手机号'),
                ),
                'return' => ''
            );
            return $this->go("sendvalicode", $info);
        }
        
        public function valicodelist(){
            $sms = new SMSModel();
            $smslist = $sms->getlist('*', []);
            foreach ($smslist as $smssingle){
                $valicode[] = array(
                    'name' => '手机号: '.$smssingle['mobile'],
                    'value' =>  '验证码: '.$smssingle['valicode'],
                    'type' => '类型: '.$smssingle['type']
                );
            }
            $info = array(
                'url' => '在发布之前，不真实发验证码，把验证码列出来，方便测试',
                'method' => Config::$METHOD_GET,
                'params' => $valicode,
                'return' => ''
            );
            return $this->go('valicodelist', $info);
        }
        
        public function eventcreate()
        {
            
            $info = array(
                'url' => '/api/events',
                'method' => Config::$METHOD_POST,
                'params' => array(
                    array('name'=>'title', 'value'=>'活动标题'),
                    array('name'=>'theme', 'value'=>'活动主题'),
                    array('name'=>'content', 'value'=>'活动内容'),
                    array('name'=>'contact', 'value'=>'联系方式'),
                    array('name'=>'fee', 'value'=>'活动费用'),
                    array('name'=>'location_prov', 'value'=>'活动地点，省份2位数字，可不用'),
                    array('name'=>'location_city', 'value'=>'活动地点，城市2位数字，可不用'),
                    array('name'=>'location_detail', 'value'=>'活动地点，详细地点'),
                    array('name'=>'starttime', 'value'=>'活动开始时间'),
                    array('name'=>'endtime', 'value'=>'活动结束时间'),
                ),
                'return' => array(
                    array('name'=>'id', 'value'=>'活动ID'),
                    array('name'=>'user', 'value'=>'User模型'),
                    array('name'=>'theme', 'value'=>'活动主题'),
                    array('name'=>'title', 'value'=>'活动标题'),
                    array('name'=>'content', 'value'=>'活动内容'),
                    array('name'=>'contact', 'value'=>'联系方式'),
                    array('name'=>'fee', 'value'=>'活动费用'),
                    array('name'=>'location', 'value'=>'活动地点'),
                    array('name'=>'dateline', 'value'=>'活动发布时间'),
                    array('name'=>'starttime', 'value'=>'活动开始时间'),
                    array('name'=>'endtime', 'value'=>'活动结束时间'),
                    array('name'=>'likenum', 'value'=>'活动被赞个数'),
                    array('name'=>'viewnum', 'value'=>'活动被评论个数'),
                ),
            );
            return $this->go("eventcreate", $info);
        }
        public function eventupdate()
        {
            
            $info = array(
                'url' => '/api/events/{eventid}',
                'method' => Config::$METHOD_PUT,
                'params' => array(
                    array('name'=>'title', 'value'=>'活动标题'),
                    array('name'=>'content', 'value'=>'活动内容'),
                    array('name'=>'contact', 'value'=>'联系方式'),
                    array('name'=>'fee', 'value'=>'活动费用'),
                    array('name'=>'place', 'value'=>'活动地点'),
                    array('name'=>'starttime', 'value'=>'活动开始时间'),
                    array('name'=>'endtime', 'value'=>'活动结束时间'),
                ),
                'return' => array(
                    array('name'=>'id', 'value'=>'活动ID'),
                    array('name'=>'user', 'value'=>'User模型'),
                    array('name'=>'title', 'value'=>'活动标题'),
                    array('name'=>'content', 'value'=>'活动内容'),
                    array('name'=>'contact', 'value'=>'联系方式'),
                    array('name'=>'fee', 'value'=>'活动费用'),
                    array('name'=>'place', 'value'=>'活动地点'),
                    array('name'=>'dateline', 'value'=>'活动发布时间'),
                    array('name'=>'starttime', 'value'=>'活动开始时间'),
                    array('name'=>'endtime', 'value'=>'活动结束时间'),
                    array('name'=>'likenum', 'value'=>'活动被赞个数'),
                    array('name'=>'viewnum', 'value'=>'活动被评论个数'),
                ),
            );
            return $this->go("eventupdate", $info);
        }
        
        public function eventdelete()
        {
            
            $info = array(
                'url' => '/api/events/{eventid}',
                'method' => Config::$METHOD_DELETE,
                'params' => '',
                'return' => '',
            );
            return $this->go("eventdelete", $info);
        }
        
        public function eventdetail()
        {
            
            $info = array(
                'url' => '/api/events/{eventid}',
                'method' => Config::$METHOD_GET,
                'params' => '',
                'return' => array(
                    array('name'=>'id', 'value'=>'活动ID'),
                    array('name'=>'user', 'value'=>'User模型'),
                    array('name'=>'theme', 'value'=>'活动主题'),
                    array('name'=>'title', 'value'=>'活动标题'),
                    array('name'=>'content', 'value'=>'活动内容'),
                    array('name'=>'contact', 'value'=>'联系方式'),
                    array('name'=>'fee', 'value'=>'活动费用'),
                    array('name'=>'location', 'value'=>'活动地点'),
                    array('name'=>'dateline', 'value'=>'活动发布时间'),
                    array('name'=>'starttime', 'value'=>'活动开始时间'),
                    array('name'=>'endtime', 'value'=>'活动结束时间'),
                    array('name'=>'likenum', 'value'=>'赞的个数'),
                    array('name'=>'commentnum', 'value'=>'评论的个数'),
                    array('name'=>'isliked', 'value'=>'登录用户是否赞过该活动（仅在详情接口中有这个字段）'),
                ),
            );
            return $this->go("eventdetail", $info);
        }
        
        public function eventlist()
        {
            
            $info = array(
                'url' => '/api/events',
                'method' => Config::$METHOD_GET,
                'params' => '',
                'return' => array(
                    array('name'=>'所有的参数与详情一致', 'value'=>'按时间倒序排列'),
                ),
            );
            return $this->go("eventlist", $info);
        }
        
        public function eventjoin()
        {
            
            $info = array(
                'url' => '/api/events/{eventid}/members',
                'method' => Config::$METHOD_POST,
                'params' => '',
                'return' => '',
            );
            return $this->go("event join ok", $info);
        }
        
        public function eventquit()
        {
            $info = array(
                'url' => '/api/events/{eventid}/members',
                'method' => Config::$METHOD_DELETE,
                'params' => '',
                'return' => '',
            );
            return $this->go("event quit ok", $info);
        }
        
        public function comment()
        {
            $info = array(
                'url' => '/api/{targettype}/{targetid}/comments',
                'method' => Config::$METHOD_POST,
                'params' => array(
                    array('name'=>'{targettype}', 'value'=>'enum("events","people") 对活动评论，对人物留言'),
                    array('name'=>'{targetid}', 'value'=>'enum("eventid","uid") '),
                    array('name'=>'content', 'value'=>'评论内容'),
                ),
                'return' => array(
                    array('name'=>'id', 'value'=>'评论ID'),
                    array('name'=>'user', 'value'=>'user{uid, name}'),
                    array('name'=>'content', 'value'=>'评论内容'),
                    array('name'=>'dateline', 'value'=>'评论时间，10位Unix Timestamp'),
                    
                ),
            );
            return $this->go("event quit ok", $info);
        }
        
        public function commentlist()
        {
            $info = array(
                'url' => '/api/{targettype}/{targetid}/comments',
                'method' => Config::$METHOD_GET,
                'params' => array(
                    array('name'=>'{targettype}', 'value'=>'enum("events","people") 对活动评论，对人物留言'),
                    array('name'=>'{targetid}', 'value'=>'enum("eventid","uid") '),
                    array('name'=>'content', 'value'=>'评论内容'),
                ),
                'return' => array(
                    array('name'=>'id', 'value'=>'评论ID'),
                    array('name'=>'user', 'value'=>'user{uid, name}'),
                    array('name'=>'content', 'value'=>'评论内容'),
                    array('name'=>'dateline', 'value'=>'评论时间，10位Unix Timestamp'),
                    
                ),
            );
            return $this->go("event quit ok", $info);
        }
        
        public function commentdelete()
        {
            $info = array(
                'url' => '/api/comments/{commentid}',
                'method' => Config::$METHOD_DELETE,
                'params' => array(
                    array('name'=>'content', 'value'=>'评论内容 留言'),
                    array('name'=>'说明', 'value'=>'如果没有DELETE方法，请使用POST方法+Post变量 _method=delete'),
                ),
                'return' => ''
            );
            return $this->go("event quit ok", $info);
        }
        
        
        public function followdelete()
        {
            $info = array(
                'url' => '/api/follows/{followid}',
                'method' => Config::$METHOD_DELETE,
                'params' => array(
                    array('name'=>'{followid}', 'value'=>'followid, 关注的对方的关注ID'),
                    array('name'=>'说明', 'value'=>'如果没有DELETE方法，请使用POST方法+Post变量 _method=delete'),
                ),
                'return' => ''
            );
            return $this->go("follow delete ok", $info);
        }
        public function follow()
        {
            $info = array(
                'url' => '/api/follows',
                'method' => Config::$METHOD_POST,
                'params' => array(
                    array('name'=>'targetuid', 'value'=>'被关注对方的用户ID'),
                ),
                'return' => array(
                    array('name'=>'id', 'value'=>'关注ID'),
                    array('name'=>'user', 'value'=>'用户模型， user{uid, name}'),
                    array('name'=>'dateline', 'value'=>'关注的时间')
                )
            );
            return $this->go("event quit ok", $info);
        }
        public function followlist()
        {
            $info = array(
                'url' => '/api/follows',
                'method' => Config::$METHOD_GET,
                'params' => '',
                'return' => array(
                    array('name'=>'[follow]', 'value'=>'follow array')
                )
            );
            return $this->go("follow list ", $info);
        }
        public function fanlist()
        {
            $info = array(
                'url' => '/api/fans',
                'method' => Config::$METHOD_GET,
                'params' => '',
                'return' => array(
                    array('name'=>'[fans]', 'value'=>'fans array, 与关注列表同一样的结构')
                )
            );
            return $this->go("fans list ", $info);
        }
        
        public function vistorlist()
        {
            $info = array(
                'url' => '/api/vistors',
                'method' => Config::$METHOD_GET,
                'params' => '',
                'return' => array(
                    array('name'=>'[visitors]', 'value'=>'vistors array, 与关注列表同一样的结构')
                )
            );
            return $this->go("vistor list ", $info);
        }
        
        public function profile()
        {
            $info = array(
                'url' => '/api/people/{uid}',
                'method' => Config::$METHOD_GET,
                'params' => '',
                'return' => array(
                    array('name'=>'说明', 'value'=>'返回的就是一个user类，内容包括下面的字段'),
                    array('name'=>'uid', 'value'=>'用户ID'),
                    array('name'=>'name', 'value'=>'用户昵称'),
                    array('name'=>'signature', 'value'=>'个性签名'),
                    array('name'=>'intro', 'value'=>'个人简介'),
                    array('name'=>'avatar', 'value'=>'头像'),
                    array('name'=>'follownum', 'value'=>'我的关注人数'),
                    array('name'=>'fannum', 'value'=>'我的粉丝人数'),
                )
            );
            
            return $this->go('people profile ', $info);
        }
        
        public function avatar()
        {
            $info = array(
                'url' => '/api/profile/avatar',
                'method' => Config::$METHOD_POST,
                'params' => array(
                    array('name'=>'flyimage[0]', 'value'=>'用户头像文件，上传前压缩，max_size:300k, max_width=max_height:1280')
                ),
                'return' => array(
                    array('name'=>'http://www.fly.com/avatar.jpg', 'value'=>'头像地址')
                )
            );
            return $this->go('people profile avatar', $info);
        }
        
        public function field()
        {
            $info = array(
                'url' => '/api/profile/field',
                'method' => Config::$METHOD_PUT,
                'params' => array(
                    array('name'=>'name', 'value'=>'昵称'),
                    array('name'=>'signature', 'value'=>'个性签名'),
                    array('name'=>'intro', 'value'=>'个人简介'),
                ),
                'return' => ''
            );
            return $this->go('people profile avatar', $info);
        }
        
        public function certify()
        {
            $info = array(
                'url' => '/api/profile/certify',
                'method' => Config::$METHOD_PUT,
                'params' => array(
                    array('name'=>'level', 'value'=>'0申请中，1已同意，2被拒绝，默认是0，不需要客户端给出该值'),
                    array('name'=>'realname', 'value'=>'直接姓名'),
                    array('name'=>'idcard', 'value'=>'身份证照片上传，可选'),
                    array('name'=>'idcardno', 'value'=>'身份证号码，18位'),
                    array('name'=>'location_prov', 'value'=>'省份代码'),
                    array('name'=>'location_city', 'value'=>'城市代码'),
                    array('name'=>'location_detail', 'value'=>'详细地址'),
                    array('name'=>'statement', 'value'=>'申请理由'),
                ),
                'return' => array(
                    array('name'=>'结果', 'value'=>'1 成功， 2 不成功'),
                )
            );
            return $this->go('people profile certify', $info);
        }
        public function like()
        {
            $info = array(
                'url' => '/api/@type/@id/likes',
                'method' => Config::$METHOD_POST,
                'params' => array(
                    array('name'=>'@type', 'value'=>'events'),
                    array('name'=>'@id', 'value'=>'event id'),
                ),
                'return' => array(
                    array('name'=>'结果', 'value'=>'1 成功， 2 不成功'),
                )
            );
            return $this->go('people profile certify', $info);
        }
        
        
        public function report()
        {
            $info = array(
                'url' => '/api/@type/@id/likes',
                'method' => Config::$METHOD_POST,
                'params' => array(
                    array('name'=>'@type', 'value'=>'events'),
                    array('name'=>'@id', 'value'=>'event id'),
                ),
                'return' => array(
                    array('name'=>'结果', 'value'=>'1 成功， 2 不成功'),
                )
            );
            return $this->go('people profile certify', $info);
        }
        
//	public function index()
//	{
//		$keywords = $_GET['keywords'];
//		$whereparm = array(
//			'title[~]' => $keywords,
//			'content[~]' => $keywords
//		);
//		if($keywords){
//			$reviews = $this->reviewmodel->getlist('*', array('OR'=>$whereparm));
//		}else{
//			$reviews = $this->reviewmodel->getlist('*', array());
//		}
//				
//		
//		$parmValue = array(
//			'title' => 'RTS',
//			'login' => $this->login,
//			'author' => $this->author,
//			'reviews' => $reviews,
//			'keywords' => $keywords
//		);
//		return View::load('home', $parmValue);
//	}
}
?>
