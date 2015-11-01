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
include_once $_SERVER['DOCUMENT_ROOT'].'/models/EventModel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/CommentModel.php';


class EventController extends BaseController
{
	public $eventmodel;
	public $commentmodel;
	public function __construct() {
		parent::__construct();
		$this->eventmodel = new EventModel();
		$this->commentmodel = new CommentModel();
	}
	
	public function index()
	{

	}
	
	public function store()
	{
            $data = $this->parmall();
            $event = $this->data2model($data);
            $poster = $this->file('poster');
            $event['uid'] = $this->author['id'];
            $event['poster'] = $poster;
            $event['dateline'] = time();
            $id = $this->eventmodel->insert($event);
            $event['id'] = $id;
            return $this->go('event stored', $event);
	}
	
	public function show($id)
	{
            $eventdata = $this->eventmodel->getsingle('*', array('id' => $id));
            $event= $this->model2data($eventdata);
            return $this->go('event', $event);
            
	}
        
        public function showList()
        {
            $events = $this->eventmodel->getlist('*', []);
            foreach ($events as $event)
            {
                $eventlist[] = $this->toModel($event);
            }
            return $this->go('event list', $eventlist);
            
        }
	
	public function edit($id)
	{

	}
	
	public function update($id)
	{
            $data = $this->parmall();
            $event = $this->data2model($data);
            $poster = $this->file('poster');
            $event['uid'] = $this->author['uid'];
            $event['poster'] = $poster?$poster:'';
            $this->eventmodel->update($event, array('id'=>$id));
            return $this->go('event updated');
            
	}
	
	public function delete($id)
	{
            $this->eventmodel->delete(array('id'=>$id));
            return $this->go('delete event ok');
	}
        
        public function model2data($model)
        {
            $event = array(
                'id' => $model['id'],
                'uid' => $model['uid'],
                'poster' => $model['poster'],
                'title' => $model['title'],
                'dateline' => $model['dataline'],
                'content' => $model['content'],
                'contact' => $model['contact'],
                'fee' => $model['fee'],
                'place' => $model['place'],
                'starttime' => $model['starttime'],
                'endtime' => $model['endtime']
            );
            return $event;
        }
        
        public function data2model($data)
        {
            $event = array(
                'uid' => $data['uid'],
                'poster' => $data['poster'],
                'title' => $data['title'],
                'dateline' => $data['dateline'],
                'content' => $data['content'],
                'contact' => $data['contact'],
                'fee' => $data['fee'],
                'place' => $data['place'],
                'starttime' => $data['starttime'],
                'endtime' => $data['endtime']
            );
            return $event;
        }
}
?>
