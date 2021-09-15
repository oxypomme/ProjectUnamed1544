<?php

include_once MODELS_DIR . '/db/DB.php';

abstract class CRUDModel
{
	protected const TABLE_NAME = null;
	
	// public static abstract function read();
	// public abstract function update();
	// public abstract function delete();
	public function create()
	{
		$reflection = new ReflectionClass($this);
		$classAttrs = parseAttributes($reflection);

		$data = [];
		foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
			$propName = $prop->getName();
			$propAttrs = parseAttributes($prop);
			// Ignore props without values
			if(!$this->$propName || $propAttrs['Ignore']) {
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

			if($isFirst) {
				$isFirst = false;
				$model_sql .= ', ';
				$values_sql .= ', ';
			}
		}

		var_dump($data);
		print 'INSERT INTO ' 
					. ($classAttrs['Table'][0] ?? str_replace('Model', '', get_class($this)) . 's') 
					. " (${model_sql}) VALUES (${values_sql})";
		// TODO: pass $data to fetch
	}
	public static function read()
	{
	}
	public function update()
	{
	}
	public function delete()
	{
	}

	public function __set(string $property, $value)
  {
    switch ($property) {

      default:
				$this->$property = $value;
        break;
    }
  }
}
