<?php

namespace Cookly\Repositories;

use Cookly\Database;

class Repository
{
  protected \PDO $db;

  public function __construct()
  {
    $this->db = Database::getInstance()->getConnection();
  }
}
