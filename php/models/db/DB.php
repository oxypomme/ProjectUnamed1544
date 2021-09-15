<?php

class DB
{
  private static self $_instance;
  public static function getInstance(...$params): self
  {
    if (!isset(self::$_instance)) {
      self::$_instance = new self($params);
    }
    return self::$_instance;
  }

  private PDO $_pdo;
  private function __construct(array $params)
  {
    try {
      $this->_pdo = new PDO("mysql:host={$_ENV['SQL_HOST']};dbname={$_ENV['SQL_DB']}", $_ENV['SQL_USER'], $_ENV['SQL_PASSWORD']);
    } catch (\Exception $e) {
      //throw $th;
    }
  }

  /**
   * Prepare a query and binds params.
   * 
   * @param string $query The SQL statement to prepare and execute.
   * @param array $params The parameters passed to the SQL statement.
   * 
   * Params follow the form: `['p1' => 'val1', 'p2' => ['val2'], 'p3' => ['val3', PDO::PARAM_STR]]`
   * @param int $mode Controls the contents of the returned array as documented in `PDOStatement::fetch`.
   * 
   * @return array Returns an array containing all of the result set rows
   */
  public function prepare(string $query, array $params = [], int $mode = PDO::FETCH_OBJ): array
  {
    $query = $this->_pdo->prepare($query);
    
    $tmpVals = [];
    foreach ($params as $pname => $pcontent) {
      $tmpVals[] = is_array($pcontent) ? $pcontent[0] : $pcontent;
      $ptype = (is_array($pcontent) && $pcontent[1]) ? $pcontent[1] : PDO::PARAM_STR;
      $query->bindParam($pname, $tmpVals[count($tmpVals) - 1], $ptype);
    }

    $query->execute();
    $rows = $query->fetchAll($mode);
    return $rows;
  }

  /**
   * Shorthand to `$pdo->exec()`.
   * 
   * @param string $query The SQL statement to prepare and execute.
   * @return null|int Returns the number of rows that were modified or deleted by the SQL statement you issued or null if an error occured.
   */
  public function exec(string $query): ?int
  {
    $res = $this->_pdo->exec($query);
    if($res === false) {
      return null;
    }
    return $res;
  }

  /**
   * Shorthand to `$pdo->quote()`
   * 
   * @param string $string The string to be quoted.
   * @param int $type Provides a data type hint for drivers that have alternate quoting styles.
   * @return null|string A quoted string that is theoretically safe to pass into an SQL statement or null if the driver does not support quoting in this way.
   */
  public function quote(string $string, int $type = PDO::PARAM_STR): ?string {
    $res = $this->_pdo->quote($string, $type);
    if($res === false) {
      return null;
    }
    return $res;
  }
}
