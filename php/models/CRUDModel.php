<?php

abstract class CRUDModel {
	// public abstract function create();
	// public static abstract function read();
	// public abstract function update();
	// public abstract function delete();
	public function create() {
		// INSERT INTO `users` (`login`, `password`) VALUES (${login_param}, ${password_param})
		$sql = 'INSERT INTO ' . strtolower(str_replace('Model', '', get_class($this))) . 's (';

		$values = [];
		$isFirst = true;
		foreach ((array) $this as $key => $value) {
			// Clean this pls
			$varname = preg_replace('/.' . get_class($this) . '._/', '', $key);
			$sql .= ($isFirst ? '' : ', ') . "`${varname}`";
			$isFirst = false;
			$values[] = $value;
		}
		
		$sql .= ') VALUES (';

		$isFirst = true;
		foreach ($values as $val) {
			$sql .= ($isFirst ? '' : ', ') . "'${val}'";
			$isFirst = false;
		}
		$sql .= ')';

		print $sql;
	}
	public static function read() {}
	public function update() {}
	public function delete() {}
}
