<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SingerModel extends BaseModel
{
    
    function __construct()
    {
        $this->_DB_TABLE_NAME = 'singer';
        $this->_MODEL = array('id','uid','name','level','realname','idcard','location_prov','location_city', 'location_detail', 'statement', 'dateline', 'replydateline');
        parent::__construct();
      # code...
    }
}