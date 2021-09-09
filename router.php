<?php

if (preg_match('/\/(?:[^\/.])*(?:\.(?:html|php))?$/', $_SERVER["REQUEST_URI"])) {
	if(preg_match('/^\/api.*/', $_SERVER["REQUEST_URI"])) {
		$_GET['render_mode'] = 2;
		$_SERVER['PATH_INFO'] = str_replace('/api', '', $_SERVER['PATH_INFO']);
		header('Content-Type: application/json');
	}
	include 'index.php';
} else {
	return false;
}
