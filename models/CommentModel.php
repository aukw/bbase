<?php


include_once $_SERVER['DOCUMENT_ROOT'].'/models/BaseModel.php';
/**
 *
 */
class CommentModel extends BaseModel
{
    
    function __construct()
    {
        $this->_DB_TABLE_NAME = 'comment';
        $this->_MODEL = array('id','targettype','targetid','content','uid','name','dateline');
        parent::__construct();
    }
    
}