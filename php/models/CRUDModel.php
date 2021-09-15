<?php

include_once MODELS_DIR . '/db/DB.php';

abstract class CRUDModel
{
	// public static abstract function read();
	// public abstract function update();
	// public abstract function delete();
	public function create(): void
	{
		$reflection = new ReflectionClass($this);
		$classAttrs = parseAttributes($reflection);

		$data = [];
		foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
			$propName = $prop->getName();
			$propAttrs = parseAttributes($prop);
			// Ignore props without values
			if (!$this->$propName || $propAttrs['Ignore'] || $propAttrs['ReadOnly']) {
				continue;
			}

			$data[$propName] = $this->$propName;
		}

		$model_sql = '';
		$values_sql = '';

		$isFirst = true;
		foreach ($data as $key => $value) {
			$model_sql .= "`${key}`";
			$values_sql .= ":${key}";

			if ($isFirst) {
				$isFirst = false;
				$model_sql .= ', ';
				$values_sql .= ', ';
			}
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
