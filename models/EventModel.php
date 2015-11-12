<?php


include_once $_SERVER['DOCUMENT_ROOT'].'/models/BaseModel.php';
/**
 *
 */
class EventModel extends BaseModel
{
    
    function __construct()
    {
        $this->_DB_TABLE_NAME = 'event';
        $this->_MODEL = array('id','poster','title','dateline','content', 
            'contact', 'fee', 'place', 'placecodepo','starttime', 'endtime', 
            'uid', 'name', 'likenum', 'commentnum', 'location_prov', 
            'location_city', 'location_detail');
        parent::__construct();
      # code...
    }
    
    
}

