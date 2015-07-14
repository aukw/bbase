<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/base.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/view.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/UserModel.php';

class BaseController extends Base
{
	public $parm1;
	public $parm2;
	public $parm3;
	public $login;
	public $author;
    public function __construct($parm1, $parm2, $parm3) {
        parent::__construct();
		$this->loadParm($parm1, $parm2, $parm3);
		if($_COOKIE['token'] && strlen($_COOKIE['token'])>0){
			$token = JWTAuth::getToken($_COOKIE['token']);
			if($token){
				$dbuser = new UserModel();
				$user = $dbuser->getUser(array('mobile'=>$token['mobile']));
				$user['name'] = $user['name']?$user['name']:$user['mobile'];
				$this->login = true;
				$this->author = $user;
				
			}
		}
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

	public function loadParm($parm1, $parm2, $parm3)
	{
		$this->parm1 = ($parm1 != null)?$parm1:'';
		$this->parm2 = ($parm2 != null)?$parm2:'';
		$this->parm3 = ($parm3 != null)?$parm3:'';
	}

}
