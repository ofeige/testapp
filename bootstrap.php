<?php

$OPF_START = microtime(true);

require ('vendor/autoload.php');

use Opf\Registry\Registry;
use Opf\Mvc\CommandResolver;
use Opf\Mvc\Controller;
use Opf\Http\Request;
use Opf\Http\Response;
use Opf\Session\Php;

define('OPF_APPLICATION_PATH', __DIR__.'/testapp');
chdir(OPF_APPLICATION_PATH);

$request = new Request();
$response = new Response();
$session = new Php();

Registry::getInstance()->setSession($session);

$driver = new \Opf\Auth\Driver\PhpArray(array(
   'ofeige' => 'test',
   'test'   => 'test'
));

//$auth = new \Opf\Auth\Auth($driver, ,$session);

$login = new \Opf\Template\ViewTwig('signin');
$auth = new \Opf\Auth\AuthEventHandler($driver, $session, $request, $response, $login);

\Opf\Event\Dispatcher::getInstance()->addHandler('CommandConstructor', $auth);


$resolver = new CommandResolver(OPF_APPLICATION_PATH, 'Home');
$controller = new Controller($resolver);
$controller->handleRequest($request, $response);

printf("\n<!-- page generation time: %s -->", (microtime(true) - $OPF_START));