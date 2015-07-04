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
        parent::__construct();
      # code...
    }
}



?>
