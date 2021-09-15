<?php
include_once 'CRUDModel.php';

/**
 * #Table(user)
 */
class UserModel extends CRUDModel
{
  public string $login;
  public string $password;

  public function __construct(string $login, string $password)
  {
    $this->login = $login;
    $this->password = password_hash((string) $password, PASSWORD_DEFAULT);
  }

  public function __set(string $property, $value)
  {
    switch ($property) {
      case 'password':
        $this->password = password_hash((string) $value, PASSWORD_DEFAULT);
        break;

      default:
        parent::__set($property, $value);
        break;
    }
  }
}
