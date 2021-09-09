<?php

include 'config.php';

function getController(string $name)
{
	$controller = "${name}Controller";
	$file = CONTROLLERS_DIR . "/${controller}.php";

	if(!file_exists($file)) {
		http_response_code(404);
		return getController('NotFound');
	}
	include_once $file;
	return new $controller();
}

// Extracting route
$args = explode('/', $_SERVER['PATH_INFO'] ?? '');
$route = 'home';
if (count($args) > 1 && $args[1]) {
	$route = ucfirst(strtolower($args[1]));
}

// Render route
getController($route)->render($_GET['render_mode'] ?? ERenderType::STANDALONE);
exit();
