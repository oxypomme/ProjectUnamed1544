<?php

function json($value): string {
	return json_encode($value,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}

$_GET['render_mode'] = 2;
header('Content-Type: application/json');
include 'index.php';
