<?php

class DB
{
  private static self $_instance;
  public static function getInstance(...$params): self
  {
    if (!is_null(self::$_instance)) {
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

  public function fetch(string $query, array $params = [], int $mode = PDO::FETCH_OBJ): mixed
  {
    $query = $this->_pdo->prepare($query);
    $query->execute($params);
    $rows = $query->fetch($mode);
    return $rows;
  }

  public function exec(string $query): ?int
  {
    $res = $this->_pdo->exec($query);
    if($res === false) {
      return null;
    }
    return $res;
  }
}
