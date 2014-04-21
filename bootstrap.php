<?php

$OPF_START = microtime(true);

$loader = require ('vendor/autoload.php');
$loader->add('', __DIR__.'/testapp/models');

use Opf\Auth\Driver\Mysql;
use Opf\Registry\Registry;
use Opf\Mvc\CommandResolver;
use Opf\Mvc\Controller;
use Opf\Http\Request;
use Opf\Http\Response;
use Opf\Session\Php;

define('OPF_APPLICATION_PATH', __DIR__.'/testapp');
chdir(OPF_APPLICATION_PATH);

date_default_timezone_set('Europe/Berlin');

ORM::configure('mysql:host=localhost;dbname=myapp');
ORM::configure('username', 'root');
ORM::configure('password', '');

$request = new Request();
$response = new Response();
$session = new Php();

Registry::getInstance()->setSession($session);

$driver = new Mysql('User');
$login = new \Opf\Template\ViewTwig('signin');
$auth = new \Opf\Auth\AuthEventHandler($driver, $session, $request, $response, $login);

try {
\Opf\Event\Dispatcher::getInstance()->addHandler('CommandConstructor', $auth);


$resolver = new CommandResolver(OPF_APPLICATION_PATH, 'Home');
$controller = new Controller($resolver);
$controller->handleRequest($request, $response);

}
catch (\Exception $e) {
    echo '<pre>';
    print_r($e);
    echo '</pre>';
}
printf("\n<!-- page generation time: %s -->", (microtime(true) - $OPF_START));
