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
include_once $_SERVER['DOCUMENT_ROOT'].'/controllers/SMSController.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/UserModel.php';

class UserController extends BaseController
{
	public $usermodel;
        public $smsmodel;
	public function __construct() {
		parent::__construct();
		$this->usermodel = new UserModel();
                $this->smsmodel = new SMSModel();
		
	}
	
	public function register()
	{
		$mobile = parent::parm('mobile');
		$password = parent::parm('password');
                $valicode = parent::parm('valicode');
                $check = SMSController::vali($mobile, $valicode);
//                var_dump($check);
//                die();
                $name = $mobile;
                if($this->isMobileRegister($mobile))
                {
                    return $this->stop(Error::$err_100);
                }
		$user =  $this->usermodel->register($mobile, $password, $name);		
		if($user){
			$seed = array(
                            'uid' =>$user,
                            'mobile' => $mobile,			
                            );
			$token = JWTAuth::setToken($seed);
                        $data = array(
                            'name' => $mobile,
                            'token' => $token
                            );
			return $this->go("register ok", $data);
		}else{
			return $this->stop("register failed");
		}
	}
	
	public function login()
	{
		$mobile = parent::parm('mobile');
		$password = parent::parm('password');
		$user = $this->usermodel->login($mobile, $password);
		if($user){
			$seed = array(
				'mobile' => $mobile,
				'uid' => $user['id']
			);
			$token = JWTAuth::setToken($seed);
			//var_dump($token);
                        $data = array(
                            'token' => $token,
                            'name' => $user['name']
                        );
			return $this->go('login success', $data);
		}else{
			return $this->stop("login failed");
		}
	}
	
	public function show()
	{
		$parm = array('id' => $this->author['id']);
		$profile = $this->usermodel->getEntity($parm);
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
		$rows = $this->usermodel->update($parm, $where);
		if($rows){
			return $this->go(Lang::$profile_update_succ);
		}else{
			return $this->stop(Lang::$profile_update_fail);
		}
	}
        
        private function isMobileRegister($mobile)
        {
            $check = false;
            $where = array(
                'mobile' => $mobile
            );
            $mobile = $this->usermodel->getsingle("*", $where);
            if($mobile['id'])
            {
                $check = true;
            }
            return $check;
        }
}
?>
