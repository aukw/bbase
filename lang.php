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

class Lang
{
	public static $review_create_succ = "创建书评成功";
	public static $review_create_fail = "创建书评失败";
	public static $review_update_succ = "修改书评成功";
	public static $review_update_fail = "修改书评失败";
	public static $review_delete_succ = "删除书评成功";
	public static $review_delete_fail = "删除书评失败";
	public static $comment_create_succ = "创建评论成功";
	public static $comment_create_fail = "创建评论失败";
	public static $comment_delete_succ = "删除评论成功";
	public static $comment_delete_fail = "删除评论失败";
	public static $profile_update_succ = "修改信息成功";
	public static $profile_update_fail = "修改信息失败";
}
?>
