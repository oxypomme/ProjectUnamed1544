<?php

include 'config.php';
include 'functions.php';

// Extracting route
$args = explode('/', $_SERVER['PATH_INFO'] ?? '');
$route = 'home';
if (count($args) > 1 && $args[1]) {
	$route = ucfirst(strtolower($args[1]));
}

// Render route
getController($route)->render($_GET['render_mode'] ?? ERenderType::STANDALONE);
exit();
