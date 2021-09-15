<?php
include_once 'CRUDModel.php';

/**
 * #Table(users)
 */
class UserModel extends CRUDModel
{
  /**
   * #ReadOnly
   */
  public int $id;
  public string $login;
  /**
   * #WriteOnly
   */
  public string $password;

  public function __construct(string $login, string $password)
  {
    $this->login = $login;
    $this->password = password_hash((string) $password, PASSWORD_DEFAULT);
  }

  public function __set(string $property, $value): void
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
