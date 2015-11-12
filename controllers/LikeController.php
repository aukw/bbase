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
include_once $_SERVER['DOCUMENT_ROOT'].'/models/LikeModel.php';


class CommentController extends BaseController
{
	public $likemodel;
	public function __construct() {
		parent::__construct();
		$this->likemodel = new LikeModel();
	}
		
	public function store($targettype, $targetid)
	{
            $status = $this->getLikeStatus($targettype, $targetid);
            if($status)
            {
                $check = $this->delLike($status);
            }else{
                $check = $this->addLike($targettype, $targetid);
            }
            if($check){
                return $this->go('like ok', $check);
            }{
                return $this->warn('like faild');
            }
	}
        
        private function addLike($targettype, $targetid)
        {
            $authorid = $this->author['id'];
            $authorname = $this->author['name'];
            $like = array(
                'targettype' => $this->getTarget($targettype),
                'targetid' => $targetid,
                'uid' => $authorid,
                'name' => $authorname,
                'dateline' => time()
            );
            $row = $this->likemodel->insert($like);
            if($row){
                $like['id'] = $row;
                $like = $this->data2model($like);
                return $like;
            }else{
                return false;
            }
        }
        
        private function delLike($likeid)
        {
            $del = 0;
            $where = array(
                'id' => $likeid,
                'uid' => $this->author['id']
            );
            $del = $this->likemodel->delete(array('and' => $where));
            return $del;
        }
        
        private function getLikeStatus($targettype, $targetid)
        {
            $check = 0;
            $where = array(
                'targettype' => $this->getTarget($targettype),
                'targetid' => $targetid,
                'uid' => $this->author['id']
            );
            $like = $this->likemodel->getEntity(array('AND'=>$where));
            if($like){
                $check = $like['id'];
            }
            return $check;
        }
        
        
        private function data2model($data)
        {
            $data['user'] = array(
                'uid' => $data['uid'],
                'name' => $data['name']
            );
            return $data;
        }
        private function getTarget($targettype)
        {
            $target = array(
                'events' => 'event',
                'people' => 'people'
                
            );
            return $target[$targettype];
        }
        
	public function delete($id)
	{
		$comment = array(
			'id' => $id,
			'uid' => $this->author['id']
		);
		$row = $this->commentmodel->delete(array('AND' => $comment));
		if($row){
			return $this->go(Lang::$comment_delete_succ);
		}else{
			return $this->stop(Lang::$comment_delete_fail);
		}
	}
}