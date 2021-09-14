<?php
include_once 'CRUDModel.php';

class UserModel extends CRUDModel
{
  private string $_login;
  private string $_password;

  public function __construct(string $login, string $password) {
    $this->_login = $login;
    $this->_password = $password;
  }
}

