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

include_once $_SERVER['DOCUMENT_ROOT'].'/jwt/Authentication/JWT.php';

class JWTAuth
{
	private static $token = array(
			'iss' => 'http://www.readthinkshare.com',
			'aud' => 'http://www.readthinkshare.com',
		);
	private static $key = 'secretkey';
	
	public function __construct() 
	{
		self::$token = 
		JWT::$leeway = 60;
	}
	
	public static function setToken($user)
	{
		$token = array_merge($user, self::$token, array('iat'=>time(), 'nbf'=>time()));
		$seed = JWT::encode($token, self::$key);
		return $seed;
	}
	
	public static function getToken($token)
	{
		$decoded = (array) JWT::decode($token, self::$key, array('HS256'));
		foreach(array_keys(self::$token) as $itemkey)
		{
			unset($decoded[$itemkey]);
		}
		return $decoded;
	}
}
?>