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
include_once $_SERVER['DOCUMENT_ROOT'].'/models/UploadModel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/UserModel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/LikeModel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/FollowModel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/utils/Location.php';


class EventController extends BaseController
{
	public $eventmodel;
	public $commentmodel;
        public $uploadmodel;
        public $usermodel;
        public $followmodel;
        public $likemodel;
        
	public function __construct() {
		parent::__construct();
		$this->eventmodel = new EventModel();
		$this->commentmodel = new CommentModel();
                $this->uploadmodel = new UploadModel();
                $this->usermodel = new UserModel();
                $this->followmodel = new FollowModel();
                $this->likemodel = new LikeModel();
	}
	
	public function index()
	{

	}
	
	public function store()
	{
            $data = $this->parmall();
            $event = $this->data2model($data);
            $poster = $this->file('flyimage');
            $uploadid = 0;
            if(count($poster)>0)
            {
                $path = $this->uploadmodel->single($poster);
                $upload = array(
                    'uid' => $this->author['id'],
                    'name' => $this->author['name'],
                    'path' => $path,
                    'dateline' => time()
                );
                $uploadid = $this->uploadmodel->insert($upload);
            }   
            $event['uid'] = $this->author['id'];
            $event['poster'] = $uploadid;
            $event['dateline'] = time();
            $id = $this->eventmodel->insert($event);
            $event['id'] = $id;
            return $this->go('event stored', $event);
	}
	
	public function show($id)
	{
            $eventdata = $this->eventmodel->getsingle('*', array('id' => $id));
            $event= $this->model2data($eventdata);
            $this->eventmodel->update(array('viewnum'=>$event['viewnum']+1), array('id'=>$event['id']));
            $likearr = array(
                'uid' => $this->author['id'],
                'targettype' => 'event',
                'targetid' => $event['id']
            );
            $likenum = $this->likemodel->count(array('and'=>$likearr));
            $event['isliked'] = $likenum?1:0;
            return $this->go('event', $event);
            
	}
        
        public function showList()
        {
            $events = $this->eventmodel->getlist('*', []);
            foreach ($events as $event)
            {
                $eventlist[] = $this->data2model($event);
            }
            return $this->go('event list', $eventlist);
        }
        
        public function showMyList()
        {
            $events = $this->eventmodel->getlist('*', array('uid'=>$this->author['id']));
            $eventlist = array();
            foreach ($events as $event)
            {
                $eventlist[] = $this->data2model($event);
            }
            return $this->go('event list', $eventlist);
        }
        
        public function showFollowList()
        {
            $follows = $this->followmodel->getlist('*', array('targetuid'=>$this->author['id']));
            $followids = Util::getValueByKeys($follows, 'uid');
            $events = $this->eventmodel->getlist('*', array('uid'=>$followids));
            $eventlist = array();
            foreach ($events as $event)
            {
                $eventlist[] = $this->data2model($event);
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
            if($model['poster'])
            {
                $upload = $this->uploadmodel->getEntity(array('id'=>$model['poster']));
                $model['poster'] = $this->uploadmodel->server_host.$upload['path'];
            }
            $user = $this->usermodel->getEntity(array('id'=>$model['uid']));
            $avatar = $this->uploadmodel->getAvatar($user['avatar']);
            $author = array(
                'uid' => $user['id'],
                'name' => $user['name'],
                'avatar' => $avatar
            );
            $event = array(
                'id' => $model['id'],
                'uid' => $model['uid'],
                'user' => $author,
                'poster' => $model['poster'],
                'theme' => $model['theme'],
                'title' => $model['title'],
                'dateline' => $model['dateline'],
                'content' => $model['content'],
                'contact' => $model['contact'],
                'fee' => $model['fee'],
                'location' => Location::getPlace($model['location_prov'], $model['location_city'], $model['location_detail']),
                'starttime' => $model['starttime'],
                'endtime' => $model['endtime'],
                'viewnum' => $model['viewnum'],
                'likenum' => $model['likenum']
                    
                    
            );
            return $event;
        }
        
        public function data2model($data)
        {
            $event = array(
                'uid' => $data['uid'],
                'poster' => $data['poster'],
                'theme' => trim($data['theme']),
                'title' => trim($data['title']),
                'dateline' => $data['dateline'],
                'content' => $data['content'],
                'contact' => $data['contact'],
                'fee' => $data['fee'],
                'place' => $data['place'],
                'location_prov' => $data['location_prov'],
                'location_city' => $data['location_city'],
                'location_detail' => $data['location_detail'],
                'starttime' => $data['starttime'],
                'endtime' => $data['endtime']
            );
            if(isset($data['id'])){
                $event['id'] = $data['id'];
            }
            return $event;
        }
}
?>
