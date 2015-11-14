<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include_once $_SERVER['DOCUMENT_ROOT'].'/models/BaseModel.php';

ini_set('date.timezone','Asia/Shanghai');

class UploadModel extends BaseModel
{
    public $storage_base;
    public $server_host;
    
    public function __construct()
    {
//         $processUser = posix_getpwuid(posix_geteuid());
//        echo($processUser['name']);
        $this->_DB_TABLE_NAME = 'upload';
        $this->_MODEL = array('id','uid','name','path','dateline');
        $this->storage_base = $_SERVER['DOCUMENT_ROOT'].'/storage/';
        $this->server_host = $_SERVER['SERVER_NAME'].'/storage/';
        parent::__construct();
    }
    
    public function single($file, $key=0)
    {
        $check = false;
        $targetname = md5(rand(1,99).$file['name'][$key].time());
        $target = $this->checkDir().'/'.$targetname.'.'.pathinfo($file['name'][$key], PATHINFO_EXTENSION);
        $move = move_uploaded_file($file['tmp_name'][$key],$target);
        if($move){
            $check = str_replace($this->storage_base, '', $target);
        }
        return $check;
    }
    
    public function multi($files)
    {
        
    }
    
    private function checkDir()
    {
        $year = date('Y');
        $monthday = date('md');
        
        $yeardir = $this->storage_base.$year;
        $monthdaydir = $yeardir.'/'.$monthday;
        if(!is_dir($yeardir))
        {
            mkdir($yeardir);
        }
        if(!is_dir($monthdaydir))
        {
            mkdir($monthdaydir);
        }
        return $monthdaydir;
    }
    
    public function getAvatars($ids)
    {
        $avatars = array();
        $uploads = $this->getlist('*', array('id'=>$ids));
        foreach($uploads as $upload)
        {
            $avatars[$upload['uid']] = $this->server_host.$upload['path']; 
        }
        return $avatars;
    }
    
    public function getAvatar($id)
    {
        if($id){
            $upload = $this->getEntity(array('id'=>$id));
            $avatar = $this->server_host.$upload['path'];
            return $avatar;
        }else{
            return '';
        }
    }
    
    public function getAvatarByUid($uid)
    {
        if($uid)
        {
            $avatarpath = $this->db->query("select upload.path from ".$this->getTableName()." upload where upload.id = (select user.avatar from ".$this->getTableName('user')." as user where user.id=$uid)" )->fetchAll();
            if($avatarpath){
                return $this->server_host.$avatarpath[0]['path'];
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
    
    public function getAvatarByUids($uids)
    {
        if(is_array($uids))
        {
            $avatars = $this->db->query("select upload.uid, upload.path from ".$this->getTableName()." upload "
                    . "where upload.id in (select user.avatar from ".$this->getTableName('user')." as user "
                    . "where user.id in (".  join(',', $uids)."))" )->fetchAll();
            foreach ($avatars as $avatar)
            {
                $userface[$avatar['uid']] = $this->server_host.$avatar['path'];
            }
            return $userface;
        }
    }
    
    
}