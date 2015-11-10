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
include_once $_SERVER['DOCUMENT_ROOT'].'/models/ReviewModel.php';

class HomeController extends BaseController
{
	public $reviewmodel;
	public function __construct() {
		parent::__construct();
		$this->reviewmodel = new ReviewModel();
	}
	
        public function index()
        {
            return View::load('fly',[]);
        }
        
        public function api()
        {
            
            $apilist = array(
                array('name' => '注册','module' => 'register'),
                array('name' => '登录','module' => 'login'),
                array('name' => '发送验证码','module' => 'sendvalicode'),
                array('name' => '验证码列表','module' => 'valicodelist'),
                array('name' => '创建活动','module' => 'eventcreate'),
                array('name' => '修改活动','module' => 'eventupdate'),
                array('name' => '删除活动','module' => 'eventdelete'),
                array('name' => '活动详情','module' => 'eventdetail'),
                array('name' => '活动列表','module' => 'eventlist'),
                array('name' => '加入活动','module' => 'eventjoin'),
                array('name' => '退出活动','module' => 'eventquit'),
                array('name' => '评论','module' => 'comment'),
                array('name' => '评论列表','module' => 'commentlist'),
                array('name' => '删除评论','module' => 'commentdelete'),
                array('name' => '粉丝列表','module' => 'fanlist'),
                array('name' => '关注列表','module' => 'followlist'),
                array('name' => '关注他人','module' => 'follow'),
                array('name' => '删除关注','module' => 'followdelete'),
                array('name' => '访客列表','module' => 'visitorlist'),
                array('name' => '用户详情','module' => 'profile'),
                array('name' => '修改头像','module' => 'avatar'),
                array('name' => '修改其他属性','module' => 'field'),
                
            );
            return View::load('api',array('apilist' => $apilist));
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
