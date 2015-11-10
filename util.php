<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Util
{
    public static function time2date($dateline)
    {
        return date("Y-m-d H:m",$dateline);
    }
    
    
    public static function checkMobile($mobile)
    {
        $check = true;
        if(!is_numeric($mobile))
        {
            $check = false;
        }
        return $check;
    }
    
    public static function getValueByKeys($values, $keys)
    {
        $value = array();
        foreach($keys as $key)
        {
            $value[$key] = $values[$key];
        }
        return $value;
    }
}
