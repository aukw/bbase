<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MarkModel extends BaseModel
{
    function __construct()
    {
        $this->_DB_TABLE_NAME = 'mark';
        $this->_MODEL = array('id','targettype','targetid','uid','name','dateline');
        parent::__construct();
    }
}