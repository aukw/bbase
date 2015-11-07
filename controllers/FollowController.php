<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/controllers/BaseController.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/FollowModel.php';

class FollowController extends BaseController
{
    
    public $followmodel;
    public $usermodel;
    public function __construct() {
            parent::__construct();
            $this->followmodel = new FollowModel();
            $this->usermodel = new UserModel;
    }
    
    /**
     * 关注别人
     * @param type $id
     */
    public function follow()
    {
        $targetuid = parent::parm('targetuid');
        $target = $this->usermodel->getEntity('*', array('id'=>$targetuid));
        $follow = array(
            'targetuid' => $targetuid,
            'targetname' => $target['name'],
            'uid' => $this->author['id'],
            'name' => $this->author['name'],
            'dateline' => time()
        );
        $id = $this->followmodel->insert($follow);
        if($id){
            $follow['id'] = $id;
            $follow['user'] = array(
                'uid' => $follow['uid'],
                'name' => $follow['name']
            );
            return $this->go('follow ok', $follow);
        }else{
            return $this->warn('follow failed');
        }
    }
    
    /**
     * 取得自己的关注列表
     */
    public function getList()
    {
        $where = array('uid' => $this->author['id']);
        $follows = $this->followmodel->getlist('*', $where);
        $followlist = array();
        foreach($follows as $follow)
        {
            $followlist[] = array(
                'id' => $follow['id'],
                'user' => array(
                    'uid' => $follow['targetuid'],
                    'name' => $follow['targetname']
                    ),
                'dateline' => $follow['dateline']
            );
        }
        if(count($followlist)){
            return $this->go('follow list', $followlist);
        }else{
            return $this->warn('follow list empty');
        }
    }
    
    public function getFanList()
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
            return $this->go('fan list', $followlist);
        }else{
            return $this->warn('fan list empty');
        }
        
    }
    
    public function delete($id)
    {
        $where = array('id' => $id);
        $del = $this->followmodel->delete($where);
        if($del){
            return $this->go('delete ok');
        }else{
            return $this->warn('delete failed');
        }
    }
    
}