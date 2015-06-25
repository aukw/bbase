<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/base.php';

abstract class BaseModel extends Base
{
    public function __construct() {
        parent::__construct();
    }
    public abstract function insert($parm);
    public abstract function update($parm);
    public abstract function delete($parm);
    public abstract function getsingle($parm);
    public abstract function getlist($parm);
}