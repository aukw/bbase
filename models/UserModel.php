<?php


include_once $_SERVER['DOCUMENT_ROOT'].'/models/BaseModel.php';
/**
 *
 */
class UserModel extends BaseModel
{
    
    function __construct()
    {
        $this->_DB_TABLE_NAME = 'user';
        $this->_MODEL = array('id','name','password','email','mobile','avatar','created_at','updated_at');
        parent::__construct();
      # code...
    }
    
    function getUser($parm)
    {
        $user = $this->getsingle('*', $parm);
        return $this->getModel((array)$user);
    }
	
	function register($mobile, $password, $name='', $email='')
	{
                $name = $mobile;
		$user = array(
			'mobile' => $mobile,
			'password' => md5($password),
			'name' => $name,
			'email' => $email,
			'created_at' => time(),
			'updated_at' => time(),
			);
		$insert = $this->insert($user);
		return $insert;
	}
	
	function login($mobile, $password)
	{
		$where = array(
			'mobile' => $mobile,
			'password' => md5($password)
		);
		$user = $this->getsingle('*', array('AND' => $where));
		return $user;
	}
	
	function rePassword($newpassword, $id)
	{
		$parm = array(
			'password' => md5($newpassword)
		);
		$where = array(
			'id' => $id
		);
		return $this->update($parm, $where);
	}
    
    
    
    
    
    
    
}



?>
