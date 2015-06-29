<?php

require 'flight/Flight.php';



Flight::route('/', function(){    echo 'hello world!';});
Flight::route('GET /test', function(){router('TestController', 'testGet');});

Flight::start();


function router($controller, $method, $parm1='', $parm2='', $parm3='')
{
	include_once './controllers/'.$controller.'.php';
	$entity = new $controller();
	$entity->loadParm($parm1, $parm2, $parm3);
	echo $entity->$method();
}

?>
