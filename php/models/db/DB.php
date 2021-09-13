<?php

class DB {
	private static $_instance;
	public static function getInstance(...$params): self {
		if(is_null(self::$_instance)) {
			self::$_instance = new self($params);
		}
		return self::$_instance;
	}

	private function __construct($params) {

	}
}
