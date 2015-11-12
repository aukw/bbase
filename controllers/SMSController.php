<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include_once $_SERVER['DOCUMENT_ROOT'].'/controllers/BaseController.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/utils/Message.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/SMSModel.php';


class SMSController extends BaseController
{
    public $message;
    public $sms;
    public function __construct() {
            parent::__construct();
            $this->message = new Message();
            $this->sms = new SMSModel();
    }
    
    public function send($type='register')
    {
        $mobile = parent::parm('mobile');
        //var_dump($mobile);
        if(!Util::checkMobile($mobile))
        {
            return $this->stop("wrong mobile");
        }
        $valicode = $this->getRandomNum();
        $message = $this->getContent($valicode);
        $data = array(
            'type' => $type,
            'mobile' => $mobile,
            'valicode' => $valicode,
            'dateline' => time()
        );
        $this->sms->insert($data);
        //var_dump($data);
        //$this->message->_postSingle($mobile, $message);
        return $this->go('valicode sent');
    }
    
    
    
    public static function vali($mobile, $valicode, $type='register')
    {
        $check = false;
        $where = array(
            'mobile' => $mobile,
            'valicode' => $valicode,
            'type' => $type
        );
        $smsmodel = new SMSModel();
        $single = $smsmodel->getsingle('*', array('AND' => $where));
        if(count($single) > 0){
            $check = true;
        }
        return $check;
    }
    
    private function getContent($valicode, $type='register')
    {
        switch ($type)
        {
            case 'register':
                $msg = '验证码：'.$valicode.'，30分钟内有效';
                break;
            default :
                
        }
        return $msg;
    }
    
    private function getRandomNum()
    {
        return rand(1000, 9999);
    }
    
    
    
}