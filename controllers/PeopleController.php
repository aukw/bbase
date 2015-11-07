<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/controllers/BaseController.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/UserModel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/VistorModel.php';

class PeopleController extends BaseController
{
    public $usermodel;
    public $visitormodel;
    
    public function __construct() {
            parent::__construct();
            $this->usermodel = new UserModel();
            $this->visitormodel = new VistorModel();
    }
    
    public function profile($uid)
    {
        $where = array(
            'id' => $uid
        );
        $user = $this->usermodel->getEntity($where);
        if($user['id']){
            $this->visit($uid);
            $user['uid'] = $uid;
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
        $follows = $this->followmodel->getlist('*', $where);
        $followlist = array();
        foreach($follows as $follow)
        {
            $followlist[] = array(
                'id' => $follow['id'],
                'user' => array(
                    'uid' => $follow['uid'],
                    'name' => $follow['name']
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
    
}