<?php

const BASE_DIR = __DIR__;
const CONTROLLERS_DIR = BASE_DIR . '/php/controllers';
const MODELS_DIR = BASE_DIR . '/php/models';
const VIEWS_DIR = BASE_DIR . '/php/views';

// Get .env content
(function () {
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
})();