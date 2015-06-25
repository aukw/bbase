<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/util.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/medoo/medoo.php';

class Base
{
    public $db;
    public function __construct() {
        $this->db = $this->initDB();
        ;
    }
    
    private function initDB()
    {
        $dbconfig = array(
            'database_type' => 'mysql',
            'database_name' => Config::$mysql_database,
            'server' => Config::$mysql_hostname,
            'username' => Config::$mysql_username,
            'password' => Config::$mysql_password,
        );
        $medoo = new medoo($dbconfig);
        return $medoo;
    }
}