<?php

function json($payload, int $status = 200): string {
	$data = [
		'status' => $status,
		'payload' => $payload
	];
	return json_encode($data,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}
