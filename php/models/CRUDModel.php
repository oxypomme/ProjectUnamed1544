<?php

include_once MODELS_DIR . '/db/DB.php';

abstract class CRUDModel
{
	// public abstract function update();

	public function create(): void
	{
		$reflection = new ReflectionClass($this);
		$classAttrs = parseAttributes($reflection);

		$data = [];
		foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
			$propName = $prop->getName();
			$propAttrs = parseAttributes($prop);
			// Ignore props without values
			if (!isset($this->$propName) || $propAttrs['Ignore'] || $propAttrs['ReadOnly']) {
				continue;
			}

			$data[$propName] = $this->$propName;
		}

		$model_sql = '';
		$values_sql = '';

		$isFirst = true;
		foreach ($data as $key => $value) {
			if ($isFirst) {
				$isFirst = false;
			} else {
				$model_sql .= ', ';
				$values_sql .= ', ';
			}
			
			$model_sql .= "`${key}`";
			$values_sql .= ":${key}";
		}

		DB::getInstance()->prepare(
			'INSERT INTO '
				. ($classAttrs['Table'][0] ?? str_replace('Model', '', get_class($this)) . 's')
				. " (${model_sql}) VALUES (${values_sql})",
			$data
		);
	}

	public static function read(): array
	{
		$reflection = new ReflectionClass(static::class);
		$classAttrs = parseAttributes($reflection);

		$props = [];
		foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
			$propName = $prop->getName();
			$propAttrs = parseAttributes($prop);
			if ($propAttrs['Ignore'] || $propAttrs['WriteOnly']) {
				continue;
			}
			$props[] = $propName;
		}

		return DB::getInstance()->prepare(
			'SELECT ' . implode(', ', $props) . ' FROM ' . ($classAttrs['Table'][0] ?? str_replace('Model', '', static::class) . 's')
		);
	}

	public function update()
	{
	}

	public function delete()
	{
		$reflection = new ReflectionClass($this);
		$classAttrs = parseAttributes($reflection);

		$data = [];
		foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
			$propName = $prop->getName();
			$propAttrs = parseAttributes($prop);
			// Ignore props without values
			if (!isset($this->$propName) || $propAttrs['Ignore']) {
				continue;
			}

			$data[$propName] = $this->$propName;
		}

		$sql = '';

		$isFirst = true;
		foreach ($data as $key => $value) {
			if ($isFirst) {
				$isFirst = false;
			} else {
				$sql .= ' AND ';
			}

			$sql .= "`${key}` = :${key}";
		}

		var_dump(['DELETE FROM '
				. ($classAttrs['Table'][0] ?? str_replace('Model', '', get_class($this)) . 's')
				. " WHERE ${sql}", $data]);
		// DB::getInstance()->prepare(
		// 	'DELETE FROM '
		// 		. ($classAttrs['Table'][0] ?? str_replace('Model', '', get_class($this)) . 's')
		// 		. " WHERE ${sql}",
		// 	$data
		// );
	}

	public function __set(string $property, $value): void
	{
		switch ($property) {

			default:
				$this->$property = $value;
				break;
		}
	}
}
