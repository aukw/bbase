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
include_once $_SERVER['DOCUMENT_ROOT'].'/models/UserModel.php';

class UserController extends BaseController
{
	public $usermobel;
	public function __construct($parm1, $parm2, $parm3) {
		parent::__construct($parm1, $parm2, $parm3);
		$this->usermobel = new UserModel();
		
	}
	
	public function register()
	{
		$mobile = $_POST['mobile'];
		$name = $_POST['name'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$user =  $this->usermobel->register($mobile, $password, $name, $email);		
		if($user){
			$seed = array(
				'mobile' => $mobile,
				'password' => $password
			);
			$token = JWTAuth::setToken($seed);
			//var_dump($token);
			$name = $user['name']?$user['name']:$mobile;
			return '0:'.$name.':'.$token;
		}else{
			return '1:登录失败';
		}
	}
	
	public function login()
	{
		$mobile = $_POST['mobile'];
		$password = $_POST['password'];
		$user = $this->usermobel->login($mobile, $password);
		if($user){
			$seed = array(
				'mobile' => $mobile,
				'password' => $password
			);
			$token = JWTAuth::setToken($seed);
			//var_dump($token);
			$name = $user['name']?$user['name']:$mobile;
			return '0:'.$name.':'.$token;
		}else{
			return '1:登录失败';
		}
	}
	
	public function show()
	{
		$parm = array('id' => $this->author['id']);
		$profile = $this->usermobel->getEntity($parm);
		$parmValue = array(
			'login' => $this->login,
			'author' => $this->author,
			'profile' => $profile
		);
		return View::load('profile-edit', $parmValue);
	}
	
	public function update()
	{
		$name = $_POST['name'];
		$parm = array(
			'name' => $name
		);
		$where = array(
			'id' => $this->author['id']
		);
		$rows = $this->usermobel->update($parm, $where);
		if($rows){
			return $this->go(Lang::$profile_update_succ);
		}else{
			return $this->stop(Lang::$profile_update_fail);
		}
	}
}
?>
