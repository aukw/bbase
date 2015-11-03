<?php

require 'flight/Flight.php';



Flight::route('/', function(){ router('HomeController', 'index');});
Flight::route('GET /api', function(){ router('HomeController', 'api');});
Flight::route('GET /api/info/@module', function($module){ router('InfoController', $module);});
Flight::route('POST /api/sms/send', function(){ router('SMSController', 'send');});
Flight::route('POST /api/auth/register', function(){ router('UserController', 'register');});
Flight::route('POST /api/auth/login', function(){ router('UserController', 'login');});


Flight::route('POST /api/events', function(){ router('EventController', 'store');});
Flight::route('GET /api/events', function(){ router('EventController', 'showList');});
Flight::route('GET /api/events/@eventid', function($eventid){ router('EventController', 'show', $eventid);});



Flight::route('POST /auth/login', function(){router('UserController', 'login');});
Flight::route('POST /auth/register', function(){router('UserController', 'register');});
Flight::route('GET /auth/profile', function(){router('UserController', 'show');});
Flight::route('POST /auth/profile', function(){router('UserController', 'update');});
Flight::route('GET /review', function(){router('ReviewController', 'index');});
Flight::route('GET /review/create', function(){router('ReviewController', 'create');});
Flight::route('POST /review/update', function(){router('ReviewController', 'update');});
Flight::route('POST /review/delete', function(){router('ReviewController', 'delete');});
Flight::route('GET /review/edit/@id', function($id){router('ReviewController', 'edit', $id);});
Flight::route('GET /review/@id', function($id){router('ReviewController', 'show', $id);});
Flight::route('POST /@type/@id/comment', function($type, $id){router('CommentController', 'store', $type, $id);});


Flight::route('POST /review', function(){router('ReviewController', 'store');});


Flight::route('GET /test', function(){router('TestController', 'testGet');});
Flight::route('GET /testt', function(){router('TestController', 'testTemplate');});


Flight::start();


function router($controller, $method, $parm1='', $parm2='', $parm3='')
{
	include_once './controllers/'.$controller.'.php';
	$entity = new $controller();
	$parm = array($parm1, $parm2, $parm3);
	$parmcount = count(array_filter($parm));
	if($parmcount == 0){
		echo $entity->$method();
	}elseif($parmcount == 1){
		echo $entity->$method($parm1);
	}elseif($parmcount == 2){
		echo $entity->$method($parm1, $parm2);
	}elseif($parmcount == 3){
		echo $entity->$method($parm1, $parm2, $parm3);
	}
}

?>