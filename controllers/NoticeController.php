<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/controllers/BaseController.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/models/CommentModel.php';


class NoticeController extends BaseController
{
	public function __construct() {
		parent::__construct();
		$this->commentmodel = new CommentModel();
	}

        
}