<?php


include_once $_SERVER['DOCUMENT_ROOT'].'/models/BaseModel.php';
/**
 *
 */
class SMSModel extends BaseModel
{
    
    function __construct()
    {
        $this->_DB_TABLE_NAME = 'sms';
        $this->_MODEL = array('id','type','valicode','dateline','mobile');
        parent::__construct();
      # code...
    }
    
    
}



?>