<?php

// If it's not a static ressource
if (preg_match('/\/(?:[^\/.])*(?:\.(?:html|php))?$/', $_SERVER["REQUEST_URI"])) {

	// If it's a call to API...
	if(preg_match('/^\/api.*/', $_SERVER["REQUEST_URI"])) {
		// ...forcing output to JSON
		$_GET['render_mode'] = 2;
		header('Content-Type: application/json');

		// ...getting router like normal
		$_SERVER['PATH_INFO'] = str_replace('/api', '', $_SERVER['PATH_INFO']);
	}

	// Redirect to `index.html`
	include 'index.php';

} else {
	// Serve the requested resource as-is.
	return false;
}
