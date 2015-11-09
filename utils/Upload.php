<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include_once $_SERVER['DOCUMENT_ROOT'].'/models/BaseModel.php';

ini_set('date.timezone','Asia/Shanghai');

class Upload extends BaseModel
{
    public $storage_base;
    
    public function __construct()
    {
//         $processUser = posix_getpwuid(posix_geteuid());
//        echo($processUser['name']);
        $this->_DB_TABLE_NAME = 'upload';
        $this->_MODEL = array('id','uid','name','path','dateline');
        $this->storage_base = $_SERVER['DOCUMENT_ROOT'].'/storage/';
    }
    
    public function single($file)
    {
        $check = false;
        $targetname = md5(rand(1,99).$file['name'][0].time());
        $target = $this->checkDir().'/'.$targetname.'.'.pathinfo($file['name'][0], PATHINFO_EXTENSION);
        $move = move_uploaded_file($file['tmp_name'][0],$target);
        if($move){
            $check = str_replace($this->storage_base, '', $target);
        }
        return $move;
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
    
    public function avatar($uploadid)
    {
        $where = array('id'=>$uploadid);
        $upload = $this->getEntity('*', $where);
        return $_SERVER['SERVER_NAME'].'/storage/'.$upload['path'];
    }
}