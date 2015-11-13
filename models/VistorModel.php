<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VistorModel extends BaseModel
{
    function __construct()
    {
        $this->_DB_TABLE_NAME = 'visitor';
        $this->_MODEL = array('id','targetid','targetname','uid','name','dateline');
        parent::__construct();
    }
}