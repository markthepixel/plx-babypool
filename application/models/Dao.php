<?php
class Dao {
   protected $db;
   protected $fb;
   public function __construct(Database $db, FbDoa $fb) {
     $this->db = $db;
     $this->fb = $fb;
   }
   public function getDB() {
      return $this->db;
   }
   public function getFB() {
      return $this->fb;
   }
}