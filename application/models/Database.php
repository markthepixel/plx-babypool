<?php

/**
* The Database class is the PDO MYSQL database connection class
*/
class Database {
  protected $conn;
  protected $host = 'localhost';
  protected $dbname = 'babypool_PLXBabyPool';
  protected $username = 'babypool_PLXBaby';
  protected $password = '1Cr4zy#W0rld!';
  public function __construct() {
    try {
      $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo 'Error (Conn): ' . $e->getMessage(); exit;
      error_log('Error (Conn): ' . $e->getMessage(), 0);
    }
  }
  public function Create($query, array $data = NULL) {
    try {
      $stmt = $this->conn->prepare($query);
      $stmt->execute($data);
      return $this->conn->lastInsertId(); //->rowCount();
    } catch(PDOException $e) {
      echo 'Error (Create): ' . $e->getMessage(); exit;
      error_log('Error (Create): ' . $e->getMessage(), 0);
    }  
  }
  public function Read($query, array $data = NULL) {
    try {
      $stmt = $this->conn->prepare($query);
      $stmt->execute($data);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result; //foreach loop
    } catch(PDOException $e) {
      echo 'Error (Read): ' . $e->getMessage(); exit;
      error_log('Error (Read): ' . $e->getMessage(), 0);
    }
  }
  public function Update($query, array $data = NULL) {
    try {
      $stmt = $this->conn->prepare($query);
      $stmt->execute($data);
      return $stmt; //->rowCount();
    } catch(PDOException $e) {
      echo 'Error (Update): ' . $e->getMessage(); exit;
      error_log('Error (Update): ' . $e->getMessage(), 0);
    }
  }
  public function Delete($query, array $data = NULL) {
    try {
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam($data);
      $stmt->execute();
      return $stmt; //->rowCount();
    } catch(PDOException $e) {
      echo 'Error (Delete): ' . $e->getMessage(); exit;
      error_log('Error (Delete): ' . $e->getMessage(), 0);
    }
  }
}