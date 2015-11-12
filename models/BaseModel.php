<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/base.php';

class BaseModel extends Base
{
    public $_DB_TABLE_NAME;
    public $_MODEL;
    public function __construct() {
        parent::__construct();
    }
    
    function getModelKeys()
    {
        return $this->_MODEL;
    }
	
	
    function getEntity($parm)
    {
        $entity = $this->getsingle('*', $parm);
        return $this->getModel((array)$entity);
    }
    
    
    function getModel($data)
    {
        $model = array();
        $modelkeys = $this->_MODEL;
        foreach($modelkeys as $modelkey)
        {
            $model[$modelkey] = $data[$modelkey];
        }
        return $model;
    }
    
    public function insert($parm)
    {
        $id = $this->db->insert($this->getTableName(), $parm);
        //var_dump($this->db->error());
        return $id;
    }
    public function update($parm, $where)
    {
        $rows = $this->db->update($this->getTableName(), $parm, $where);
        return $rows;
    }
    public function delete($parm)
    {
        $rows = $this->db->delete($this->getTableName(), $parm);
        return $rows;
    }
    public function getsingle($parm, $where)
    {
        $item = $this->db->get($this->getTableName(), $parm, $where);
        return $item;
    }
    public function getlist($parm, $where)
    {
        $items = $this->db->select($this->getTableName(), $parm, $where);
        return $items;
    }
    public function query($query)
    {
        $data = $database->query($query)->fetchAll();
        return $data;
    }
    public function getTableName()
    {
        return Config::$mysql_tablepre.$this->_DB_TABLE_NAME;
    }
    
    public function count($where)
    {
        return $this->db->count($this->getTableName(), $where);
    }
}
