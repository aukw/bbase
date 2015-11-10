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
include_once $_SERVER['DOCUMENT_ROOT'].'/models/CommentModel.php';


class CommentController extends BaseController
{
	public $commentmodel;
	public function __construct() {
		parent::__construct();
		$this->commentmodel = new CommentModel();
	}
		
	public function store($targettype, $targetid)
	{
		$content = parent::parm('content');
		$authorid = $this->author['id'];
		$authorname = $this->author['name'];
		$comment = array(
			'targettype' => $this->getTarget($targettype),
			'targetid' => $targetid,
			'content' => $content,
			'uid' => $authorid,
			'name' => $authorname,
			'dateline' => time()
		);
		$row = $this->commentmodel->insert($comment);
		if($row){
                    $comment['id'] = $row;
                    $comment = $this->data2model($comment);
			return $this->go(Lang::$comment_create_succ,$comment);
		}else{
			return $this->stop(Lang::$comment_create_fail);
		}
	}
        
        public function getList($targettype, $targetid)
        {
            $target = $this->getTarget($targettype);
            $where = array(
                'targettype' => $target,
                'targetid' => $targetid
            );
            $commentlist = array();
            $comments = $this->commentmodel->getlist('*', array('AND'=>$where));
            foreach($comments as $comment)
            {
                $commentlist[] = $this->data2model($comment);
            }
            if(count($commentlist)){
                return $this->go('comment list', $commentlist);
            }else{
                return $this->stop('comment list empty');
            }
            return $commentlist;
        }
	private function model2data($model)
        {
            
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
?>
