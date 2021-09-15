<?php

abstract class CRUDModel
{
	//? Maybe parseClass like parseAttributes
	protected const TABLE_NAME = null;

	private static function parseAttributes(ReflectionProperty &$prop) {
		$doc = $prop->getDocComment();
		$attrs = [];
		if($doc) {
			$matches = [];
			preg_match_all('/#.*/m', $doc, $matches);
			foreach ($matches[0] as $rawattr) {
				$attr = [];
				preg_match('/#(?<name>[^(\s]+)(\((?<values>.+)\))?/', $rawattr, $attr);

				$vals = [];
				if($attr['values']) {
					foreach (explode(',', $attr['values']) as $val) {
						$vals[] = trim($val);
					}
				} else {
					$vals = true;
				}

				$attrs[$attr['name']] = $vals;
			}
		}
		return $attrs;
	}
	
	// public static abstract function read();
	// public abstract function update();
	// public abstract function delete();
	public function create()
	{
		$reflection = new ReflectionClass($this);

		$sql = 'INSERT INTO ' . ($this::TABLE_NAME ?? str_replace('Model', '', get_class($this)) . 's') . ' (';

		$values = [];
		$isFirst = true;
		foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
			$propName = $prop->getName();
			$propAttrs = self::parseAttributes($prop);
			// Ignore props without values
			if(!$this->$propName || $propAttrs['Ignore']) {
				continue;
			}

			if (!$isFirst) {
				$sql .= ',';
			}
			$isFirst = false;

			$sql .= '`' . ($propAttrs['ColumnName'][0] ?? $propName) . '`';
			$values[] = $this->$propName;
		}

		$sql .= ') VALUES (';

		$isFirst = true;
		foreach ($values as $val) {
			if (!$isFirst) {
				$sql .= ',';
			}
			$isFirst = false;
			
			$sql .= "'${val}'";
		}
		$sql .= ');';

		print $sql;
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
