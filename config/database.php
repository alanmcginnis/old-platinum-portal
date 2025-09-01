<?php

// Database configuration using environment variables
class DBConn {
  public $servername;
  public $username;
  public $password;
  public $dbname;
  
  public function __construct() {
    // Check for Heroku JawsDB URL first
    $jawsdb_url = $_ENV['JAWSDB_URL'] ?? $_SERVER['JAWSDB_URL'] ?? null;
    
    if ($jawsdb_url) {
      // Parse Heroku JawsDB URL: mysql://username:password@host:port/database
      $url_parts = parse_url($jawsdb_url);
      $this->servername = $url_parts['host'];
      $this->username = $url_parts['user'];
      $this->password = $url_parts['pass'];
      $this->dbname = ltrim($url_parts['path'], '/');
    } else {
      // Fallback to individual environment variables or local values
      $this->servername = $_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? 'localhost';
      $this->username = $_ENV['DB_USER'] ?? $_SERVER['DB_USER'] ?? 'root';
      $this->password = $_ENV['DB_PASSWORD'] ?? $_SERVER['DB_PASSWORD'] ?? 'A!an19840116';
      $this->dbname = $_ENV['DB_NAME'] ?? $_SERVER['DB_NAME'] ?? 'platinumind_accounting_original';
    }
  }
}

?>
