<?php

require 'flight/Flight.php';



Flight::route('/', function(){    echo 'hello world!';});
Flight::route('GET /test', function(){router('Test', 'ttt');});

Flight::start();


function router($controller, $method)
{
	include_once './controllers/'.$controller.'.php';
	$entity = new $controller();
	echo $entity->$method();
}
?>
