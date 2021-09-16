<?php

include_once MODELS_DIR . '/db/DB.php';

abstract class CRUDModel
{
	public function __construct() {
		$this->create();
	}

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

	public function update(string $property, $newvalue): void
	{
		$reflection = new ReflectionClass($this);
		$classAttrs = parseAttributes($reflection);

		$data = [];
		foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
			$propName = $prop->getName();
			$propAttrs = parseAttributes($prop);
			// Ignore props without values
			if (!isset($this->$propName) || $propAttrs['Ignore'] || $propAttrs['WriteOnly']) {
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
		$data['newvalue'] = $newvalue;

		DB::getInstance()->prepare(
			'UPDATE '
				. ($classAttrs['Table'][0] ?? str_replace('Model', '', get_class($this)) . 's')
				. " SET ${property} = :newvalue"
				. " WHERE ${sql}",
			$data
		);
	}

	public function delete(): void
	{
		$reflection = new ReflectionClass($this);
		$classAttrs = parseAttributes($reflection);

		$data = [];
		foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
			$propName = $prop->getName();
			$propAttrs = parseAttributes($prop);
			// Ignore props without values
			if (!isset($this->$propName) || $propAttrs['Ignore'] || $propAttrs['WriteOnly']) {
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

		DB::getInstance()->prepare(
			'DELETE FROM '
				. ($classAttrs['Table'][0] ?? str_replace('Model', '', get_class($this)) . 's')
				. " WHERE ${sql}",
			$data
		);
	}

	public function __set(string $property, $value): void
	{
		$this->update($property, $value);
		$this->$property = $value;
	}
}
