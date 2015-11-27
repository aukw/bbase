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
        $results = array();
        if(is_array($keys)){
            foreach($values as $value)
            {
                $result = array();
                foreach($keys as $key)
                {
                    if(isset($value[$key]))
                    {
                        $result[$key] = $value[$key];
                    }
                }
                $results[] = $result;
            }
        }else{
            foreach($values as $value){
                $results[] = $value[$key];
            }
        }
        return $results;
    }
    
    public static function mapKeys($values, $keys)
    {        
//        var_dump($values);
//        var_dump($keys);
        $result = array();
        foreach ($keys as $key)
        {
            if(isset($values[$key])){
                $result[$key] = $values[$key];
            }
        }
        return $result;
    }
}
