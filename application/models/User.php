<?php

/**
* The Participant class is the base user class and is anyone who has accepted the Facebook App 
*/
class User {
  protected $db, $fb;
  protected $UserDao;
  
  protected $userID;
  protected $fullName;
  protected $firstName;
  protected $profileLink;
  protected $email;
    
  public function __construct(Database $db, FbDoa $fb) {
    $this->db = $db;
    $this->fb = $fb;
    $this->UserDao = new UserDao($db, $fb);
    $isUserInDb = $this->UserDao->isUserInDb();
    if ($isUserInDb === false){
      //echo '[False] User is NOT in the database.';
      $this->UserDao->createUser();
    }
    else {
      //echo '[True] User IS in the database.';
      if ($isUserInDb === true && $this->getName() === false) {
        //echo '[True] User is missing info.';
        $this->UserDao->updateUser();
      }
    }

  }
  public function getUserInfo() {
    return array(
      'userID' => $this->userID,
      'fullName' => $this->fullName,
      'profileLink' => $this->profileLink,
      'email' => $this->email,
    );
  }
  /*
  private function constructUser() {
    $this->ID = $this->UserDao->getID();
    $this->fullName = $this->UserDao->getName();
    $this->profileLink = $this->UserDao->getProfileLink();
    $this->email = $this->UserDao->getEmail();
  }
  */
  public function getFriendsPools() {
    $results = $this->UserDao->getFriendsPools();
    return $results;
  }
  public function getUsersPools() {
    return $this->UserDao->getUsersPools();
  }
  public function isUserInDb() {
    return $this->UserDao->isUserInDb();
  }
  public function getID() {
    if (empty($this->userID)) { $this->userID = $this->UserDao->getID(); }
    return $this->userID;
  }
  public function getName($userID = NULL) {
    if (empty($this->fullName) || (!empty($userID))) { $this->fullName = $this->UserDao->getName($userID); }
    return $this->fullName;
  }
  public function getFirstName($userID = NULL) {
    if (empty($this->firstName) || (!empty($userID))) { $this->firstName = $this->UserDao->getFirstName($userID); }
    return $this->firstName;
  }
  public function getProfileLink() {
    if (empty($this->profileLink)) { $this->profileLink = $this->UserDao->getProfileLink(); }
    return $this->profileLink;
  }
  public function getEmail() {
    if (empty($this->email)) { $this->email = $this->UserDao->getEmail(); }
    return $this->email;
  }
  public function doesLikePage() {
    $result = $this->fb->doesLikePage();
    return $result;
  }
  public function isMotherOfActivePool($userID = NULL) {
    return $this->UserDao->isMotherOfActivePool($userID);
  }
  public function isMotherOfPendingPool($userID = NULL) {
    return $this->UserDao->isMotherOfPendingPool($userID);
  }

}