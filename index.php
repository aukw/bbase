<?php

require 'flight/Flight.php';



Flight::route('/', function(){ router('HomeController', 'index');});
Flight::route('POST /auth/login', function(){router('UserController', 'login');});
Flight::route('POST /auth/register', function(){router('UserController', 'register');});
Flight::route('GET /test', function(){router('TestController', 'testGet');});
Flight::route('GET /testt', function(){router('TestController', 'testTemplate');});


Flight::start();


function router($controller, $method, $parm1='', $parm2='', $parm3='')
{
	include_once './controllers/'.$controller.'.php';
	$entity = new $controller();
	$entity->loadParm($parm1, $parm2, $parm3);
	echo $entity->$method();
}

?>
