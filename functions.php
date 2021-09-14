<?php

function json($payload, int $status = 200): string {
	$data = [
		'status' => $status,
		'payload' => $payload
	];
	return json_encode($data,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}

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