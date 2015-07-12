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
        $this->_MODEL = array('id','name','password','create_dateline','update_dateline');
        parent::__construct();
      # code...
    }
    
    function getUser($parm)
    {
        $user = $this->getsingle('*', $parm);
        return $this->getModel((array)$user);
    }
    
    
    
    
    
    
    
}



?>
