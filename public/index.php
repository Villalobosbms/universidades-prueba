<?php

session_start();

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($url, '/');

$segmentos = $path === '' ? [] : explode('/', $path);

if(!empty($segmentos) and $segmentos[0] == 'login'){
    $controllerName = 'HomeController';
    $action = empty($segmentos[1]) ? 'login' : 'index';
} else if(!empty($segmentos) and $segmentos[0] == 'register'){
    $controllerName = 'HomeController';
    $action = empty($segmentos[1]) ? 'register' : 'index';
} else if(!empty($segmentos) and $segmentos[0] == 'universidades'){
    $controllerName = 'HomeController';
    $action = empty($segmentos[1]) ? 'universidades' : 'index';
}else {
    $controllerName = !empty($segmentos[0]) ? ucfirst($segmentos[0]) . 'Controller' : 'HomeController';
    $action = $segmentos[1] ?? 'index';
}

$controllerFile = __DIR__ . '/../app/Controllers/' . $controllerName . '.php';

if(file_exists($controllerFile)){
    error_log($controllerFile);
    require_once $controllerFile;
    $controller = new $controllerName();
    if (method_exists($controller, $action)) {
        $params = array_slice($segmentos, 2);
        call_user_func_array([$controller, $action], $params);
        exit;
    } 
}

http_response_code(404);
echo "404 Not Found";
#var_dump($_SERVER['REQUEST_URI']);