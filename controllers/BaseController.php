<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/base.php';

class BaseController extends Base
{
    public function __construct() {
        parent::__construct();
    }
    
    public function go($msg, $result=array())
    {
        $data = array(
            'code' => '0',
            'message' => $msg,
            'result' => $result
        );
        return json_encode($data);
    }
    
    public function stop($msg)
    {
        $data = array(
            'code' => '1',
            'message' => $msg
        );
        return json_encode($data);
    }
    
    public function warn($msg)
    {
        $data = array(
            'code' => '2',
            'message' => $msg
        );
        return json_encode($data);
    }
    
    
}