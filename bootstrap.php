<?php

use Opf\Route\Route;
use Opf\Route\Router;
use Opf\Route\RouteStatic;

$OPF_START = microtime(true);

$loader = require ('vendor/autoload.php');
$loader->add('', __DIR__.'/application/models');


define('OPF_APPLICATION_PATH', __DIR__.'/application');
chdir(OPF_APPLICATION_PATH);

date_default_timezone_set('Europe/Berlin');

if(filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
    /*
     * change values for your live server
     */
    ORM::configure('mysql:host=localhost;dbname=testapp');
    ORM::configure('username', '');
    ORM::configure('password', '');
}
else {
    ORM::configure('mysql:host=localhost;dbname=testapp');
    ORM::configure('username', 'root');
    ORM::configure('password', 'test');
    ORM::configure('logging', true);
}

$router = new Router();

$router->addRoute(new RouteStatic('/', 'index'));
$router->addRoute(new RouteStatic('/application', 'application'));
$router->addRoute(new RouteStatic('/signup', 'index', 'signup'));
$router->addRoute(new RouteStatic('/admin', 'admin', 'main'));
$router->addRoute(new RouteStatic('/admin/info', 'admin', 'info'));
$router->addRoute(new RouteStatic('/profile', 'profile', 'main'));
$router->addRoute(new RouteStatic('/profile/img/iid', 'secure', 'imgByImageId'));
$router->addRoute(new RouteStatic('/profile/img/uid', 'secure', 'imgByUserId'));
$router->addRoute(new Route('/profile/img/iid/{id}', 'secure', 'imgByImageId'));
$router->addRoute(new Route('/profile/img/uid/{id}', 'secure', 'imgByUserId'));
$router->addRoute(new Route('/admin/toggleAdmin/{id}', 'admin', 'toggleAdmin'));


$bootstrap = \Opf\Bootstrap\Bootstrap::getInstance()->setPathApp(__DIR__.'/application');
$bootstrap->setRoutes($router);
$bootstrap->run();


printf("\n<!-- page generation time: %s -->", (microtime(true) - $OPF_START));
