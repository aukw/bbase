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
        public $parms;
	public $login;
	public $author;
        public $allparms;
    public function __construct() {
        parent::__construct();
		if($_GET['token']){
			$token = JWTAuth::getToken($_GET['token']);
                        //var_dump($token);
			if($token){
				$dbuser = new UserModel();
				$user = $dbuser->getUser(array('mobile'=>$token['mobile']));
				$user['name'] = $user['name']?$user['name']:$user['mobile'];
				$this->login = true;
				$this->author = $user;
				
			}
		}
    }
    
    public function setParms($parms)
    {
        //var_dump($parms);
        $this->allparms = $parms;
        //var_dump($this->allparms);
    }

    public static function parm($key)
    {
        $putvalues = explode('&',Flight::request()->getBody());
        $putparms = array();
        if($putvalues)
        {
            foreach ($putvalues as $value)
            {
                $parmnow = explode('=', $value);
                $putparms[$parmnow[0]] = $parmnow[1];
            }
        }
        $parms = array_merge(array_values((array)(Flight::request()->query))[0], array_values(((array)Flight::request()->data))[0], $putparms);
        
        return $parms[$key];
    }
    
    
    public function parmall()
    {
        
        $putvalues = explode('&',Flight::request()->getBody());
        $putparms = array();
        if($putvalues)
        {
            foreach ($putvalues as $value)
            {
                $parmnow = explode('=', $value);
                $putparms[$parmnow[0]] = $parmnow[1];
            }
        }
        $parms = array_merge(array_values((array)(Flight::request()->query))[0], array_values(((array)Flight::request()->data))[0], $putparms);
        
        return $parms;
    }
    
    public static function file($key)
    {
        if(isset($_FILES[$key])){
            $file = $_FILES[$key];
        }else{
            $file = false;
        }
        return $file;
    }
    public function go($msg, $result=array())
    {
        $data = array(
            'code' => '1',
            'message' => $msg,
            'result' => $result
        );
        return json_encode($data);
    }

    public function stop($msg)
    {
        $data = array(
            'code' => '0',
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

        public function info()
        {
            
        }
        
        public function checkAuth()
        {
            if($this->author['id'] < 0)
            {
                return $this->stop(Error::$err_000);
            }
        }
}
