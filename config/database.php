<?php

// Database configuration using environment variables
class DBConn {
  public $servername;
  public $username;
  public $password;
  public $dbname;
  
  public function __construct() {
    // Use environment variables if available (Railway), otherwise fallback to local values
    $this->servername = $_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? 'localhost';
    $this->username = $_ENV['DB_USER'] ?? $_SERVER['DB_USER'] ?? 'root';
    $this->password = $_ENV['DB_PASSWORD'] ?? $_SERVER['DB_PASSWORD'] ?? 'A!an19840116';
    $this->dbname = $_ENV['DB_NAME'] ?? $_SERVER['DB_NAME'] ?? 'platinumind_accounting_original';
  }
}

?>
