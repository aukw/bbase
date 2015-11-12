<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/controllers/BaseController.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/ReportModel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/UserModel.php';

class ReportController extends BaseController
{
    
    public $reportmodel;
    public $usermodel;
    
    public function __construct() {
            parent::__construct();
            $this->reportmodel = new ReportModel();
            $this->usermodel = new UserModel();
    }
    
    /**
     * 关注别人
     * @param type $id
     */
    public function report()
    {
        $targetuid = parent::parm('targetuid');
        $target = $this->usermodel->getEntity('*', array('id'=>$targetuid));
        $report = array(
            'targetuid' => $targetuid,
            'targetname' => $target['name'],
            'uid' => $this->author['id'],
            'name' => $this->author['name'],
            'dateline' => time()
        );
        $id = $this->reportmodel->insert($report);
        if($id){
            $report['id'] = $id;
            $report['user'] = array(
                'uid' => $report['uid'],
                'name' => $report['name']
            );
            return $this->go('report ok', $report);
        }else{
            return $this->warn('report failed');
        }
    }
    
    /**
     * 取得自己的关注列表
     */
    public function getList()
    {
        $where = array('uid' => $this->author['id']);
        $follows = $this->followmodel->getlist('*', $where);
        $users = $this->usermodel->getlist('*', array('uid'=>  Util::getValueByKeys($follows, 'targetuid')));
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
            return $this->go('follow list', $followlist);
        }else{
            return $this->warn('follow list empty');
        }
    }
    
    public function getFanList()
    {
        $where = array('targetuid' => $this->author['id']);
        $follows = $this->followmodel->getlist('*', $where);
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