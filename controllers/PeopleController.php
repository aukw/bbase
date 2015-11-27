<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/controllers/BaseController.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/UserModel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/VistorModel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/UploadModel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/SingerModel.php';

class PeopleController extends BaseController
{
    public $usermodel;
    public $visitormodel;
    public $uploadmodel;
    public $singermodel;
    
    public function __construct() {
            parent::__construct();
            $this->usermodel = new UserModel();
            $this->visitormodel = new VistorModel();
            $this->uploadmodel = new UploadModel();
            $this->singermodel = new SingerModel();
    }
    
    public function profile($uid=0)
    {
        $uid = ($uid)?$uid:$this->author['id'];
        $where = array(
            'id' => $uid
        );
        $user = $this->usermodel->getEntity($where);
        if($user['id']){
            $this->visit($uid);
            $user['uid'] = $uid;
            $user['avatar'] = $this->uploadmodel->getAvatarByUid($uid);
            $singer = $this->singermodel->getEntity(array('uid'=>$this->author['id']));
            $singerstatus = 0;
            if($singer['level'])
            {
                $singerstatus = 2;
            }elseif($singer['idcardno']){
                $singerstatus = 1;
            }
            $user['singer'] = $singerstatus;
            return $this->go('user profile', $user);
        }else{
            return $this->warn('user no exist');
        }
    }
    
    private function visit($uid)
    {
        $target = $this->usermodel->getEntity('*', array('id'=>$uid));
        $visit = array(
            'targetuid' => $uid,
            'targetname' => $target['name'],
            'uid' => $this->author['id'],
            'name' => $this->author['name'],
            'dateline' => time()
        );
        $id = $this->visitormodel->insert($visit);
    }
    
    public function getVisitorList()
    {
        $where = array('targetuid' => $this->author['id']);
        $follows = $this->visitormodel->getlist('*', $where);
        $users = $this->usermodel->getlist('*', array('uid'=>  Util::getValueByKeys($follows, 'uid')));
        $followids = Util::getValueByKeys($users, 'avatar');
        $followavatars = $this->uploadmodel->getAvatars($followids);
        $followlist = array();
        foreach($follows as $follow)
        {
            $followlist[] = array(
                'id' => $follow['id'],
                'user' => array(
                    'uid' => $follow['uid'],
                    'name' => $follow['name'],
                    'avatar' => $followavatars[$follow['uid']]
                    ),
                'dateline' => $follow['dateline']
            );
        }
        if(count($followlist)){
            return $this->go('visitor list', $followlist);
        }else{
            return $this->warn('visitor list empty');
        }
    }
    
    public function certify()
    {
        $realname = parent::parm('realname');
        $sex = parent::parm('sex');
        $location_prov = parent::parm('location_prov');
        $location_city = parent::parm('location_city');
        $location_detail = parent::parm('location_detail');
        $statement = parent::parm('statement');
        $idcardno = parent::parm('idcardno');
        $idcard = parent::file('flyimage'); 
        $uploadid = 0;
        if($idcard){
            $pic = array(
                'path' => $idcard,
                'dateline' => time(),
                'uid' => $this->author['id'],
                'name' => $this->author['name']
            );
            $uploadid = $this->uploadmodel->insert($pic);
            if($uploadid)
            {
                $this->usermodel->update(array('avatar'=>$uploadid), array('id'=>$this->author['id']));
            }
        }
        $singer = array(
            'uid' => $this->author['id'],
            'name' => $this->author['name'],
            'realname' => $realname,
            'sex' => $sex,
            'location_prov' => $location_prov,
            'location_city' => $location_city,
            'location_detail' => $location_detail,
            'idcard' => $uploadid,
            'idcardno' => $idcardno,
            'statement' => $statement,
            'level' => 0,
        );
        
        
        $singerid = $this->singermodel->insert($singer);
        if($singerid){
            return $this->go(Lang::$singer_apply_ok);
        }else{
            return $this->warn(Lang::$singer_apply_fail);
        }
    }
    
    public function avatar()
    {
        $avatar = parent::file('flyimage');
        //var_dump($avatar);
        $path = $this->uploadmodel->single($avatar);
        if($path)
        {
            $file = array(
                'path' => $path,
                'dateline' => time(),
                'uid' => $this->author['id'],
                'name' => $this->author['name']
            );
            $uploadid = $this->uploadmodel->insert($file);
            if($uploadid)
            {
                $this->usermodel->update(array('avatar'=>$uploadid), array('id'=>$this->author['id']));
                return $this->go('avatar updated', $this->uploadmodel->server_host.$path);
            }else{
                return $this->warn('avatar update failed');
            }
        }else{
            return $this->warn('avatar save failed');
        }
    }
    
    public function field()
    {
        $parms = parent::parmall();
//        var_dump($parms);
//        var_dump($this->usermodel->getModelKeys());
        $fields = Util::mapKeys($parms, $this->usermodel->getModelKeys());
//        var_dump($fields);
        if(count($fields))
        {
            $this->usermodel->update($fields, array('id'=>$this->author['id']));
            return $this->go('profile fields saved');
        }else{
            return $this->warn('profile fields can not be null');
        }
    }
    
    
}