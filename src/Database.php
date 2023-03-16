<?php

namespace Cookly;

use \PDO, \PDOException;

class Database
{
  private static $instance = null;
  private $connection;

  private function __construct()
  {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $db = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASS');

    $dsn = "pgsql:host=$host;port=$port;dbname=$db";

    $options = array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    $this->connection = new PDO(
      $dsn,
      $user,
      $password,
      $options
    );
  }

  public static function getInstance()
  {
    if (self::$instance == null) {
      try {
        self::$instance = new Database();
      } catch (PDOException $e) {
        die($e->getMessage());
      }
    }

    return self::$instance;
  }

  public function getConnection()
  {
    return $this->connection;
  }
}
