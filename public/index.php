<?php
session_start();
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$url = explode('/', $url);

$controller = ucfirst($url[0]) . 'Controller';
$method = isset($url[1]) ? $url[1] : 'index';
$param = isset($url[2]) ? $url[2] : null;

require_once '../controllers/' . $controller . '.php';
$controller = new $controller;

if (method_exists($controller, $method)) {
    $controller->$method($param);
} else {
    require '../views/404.php';
}