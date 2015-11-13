<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FollowModel extends BaseModel
{
    function __construct()
    {
        $this->_DB_TABLE_NAME = 'follow';
        $this->_MODEL = array('id','targetuid','targetname','uid','name','dateline');
        parent::__construct();
    }
}