<?php

define('BASE_DIR', __DIR__);
define('CONTROLLERS_DIR', BASE_DIR . '/php/controllers');
define('MODELS_DIR', BASE_DIR . '/php/models');
define('VIEWS_DIR', BASE_DIR . '/php/views');

// Get .env content
if(file_exists(__DIR__ . '/.env')) {
  $rows = explode("\n", file_get_contents(__DIR__ . '/.env'));
  foreach ($rows as $row) {
    $varArr = explode('=', $row);
    $name = trim($varArr[0]);

    if(!isset($_ENV[$name])) {
      $_ENV[$name] = trim($varArr[1]);
    }
  }
}