<?php
class UserDao extends Dao {

  public function isUserInDb($userID = NULL) {
    if (empty($userID)) { $userID = $this->fb->getID(); }
    if (!empty($userID)) {
      $stmt = $this->db->Read('SELECT COUNT(1) FROM Users WHERE userID = :userID', array(':userID' => $userID));
      if ($stmt[0]['COUNT(1)'] == 0) { return false; }
      else { return true; }
    }
    else { return null; }
  }
  public function getID() {
    $stmt = $this->fb->getID();
    return $stmt;
  }
  public function getFirstName($userID = NULL) {
    if (empty($userID)) { $userID = $this->fb->getID(); }
    $stmt = $this->db->Read('SELECT firstName FROM Users WHERE userID = :userID', array(':userID' => $userID));
    if (!empty($stmt)) { return $stmt[0]['firstName']; }
    else { return false; }
  }
  public function getName($userID = NULL) {
    if (empty($userID)) { $userID = $this->fb->getID(); }
    $stmt = $this->db->Read('SELECT fullName FROM Users WHERE userID = :userID', array(':userID' => $userID));
    if (!empty($stmt)) { return $stmt[0]['fullName']; }
    else { return false; }
  }
  public function getProfileLink($userID = NULL) {
    if (empty($userID)) { $userID = $this->fb->getID(); }
    $stmt = $this->db->Read('SELECT profileLink FROM Users WHERE userID = :userID', array(':userID' => $userID));
    if (!empty($stmt)) { return $stmt[0]['profileLink']; }
    else { return false; }
  }
  public function getEmail($userID = NULL) {
    if (empty($userID)) { $userID = $this->fb->getID(); }
    $stmt = $this->db->Read('SELECT email FROM Users WHERE userID = :userID', array(':userID' => $userID));
    if (!empty($stmt)) { return $stmt[0]['email']; }
    else { return false; }
  }
  public function isMotherOfActivePool($userID = NULL) {
    if (empty($userID)) { $userID = $this->fb->getID(); }
    $stmt = $this->db->Read(
      'SELECT COUNT(1)
         FROM Access
         JOIN Pools
           ON Access.poolID = Pools.poolID
        WHERE Access.userID = :userID
          AND Access.role = :role
          AND Pools.poolStatus IN ( \'running\', \'closed\')',
      array(':userID' => $userID, ':role' => 'Mother')
    );
    if ($stmt[0]['COUNT(1)'] == 0) { return false; }
    else { return true; }
  }
  public function isMotherOfPendingPool($userID = NULL) {
    if (empty($userID)) { $userID = $this->fb->getID(); }
    $stmt = $this->db->Read(
      'SELECT COUNT(1)
         FROM Access
         JOIN Pools
           ON Access.poolID = Pools.poolID
        WHERE Access.userID = :userID
          AND Access.role = :role
          AND Pools.poolStatus = :poolStatus',
      array(':userID' => $userID, ':role' => 'Mother', ':poolStatus' => 'pending')
    );
    if ($stmt[0]['COUNT(1)'] == 0) { return false; }
    else { return true; }
  }
  public function createUser() {
    $profileInfo = $this->fb->getProfileInfo();
    $stmt = $this->db->Create('INSERT INTO Users (userID, fullName, firstName, profileLink, email) VALUES (:userID, :fullName, :firstName, :profileLink, :email)',
      array(
        ':userID'      => $profileInfo['id'],
        ':fullName'    => $profileInfo['name'],
        ':firstName'   => $profileInfo['first_name'],
        ':profileLink' => $profileInfo['link'],
        ':email'       => $profileInfo['email'],
      ));
    return $stmt;
  }
  public function updateUser() {
    $profileInfo = $this->fb->getProfileInfo();
    $stmt = $this->db->Update('UPDATE Users SET fullName = :fullName, firstName = :firstName, profileLink = :profileLink, email = :email WHERE userID = :userID',
      array(
        ':userID'      => $profileInfo['id'],
        ':fullName'    => $profileInfo['name'],
        ':firstName'   => $profileInfo['first_name'],
        ':profileLink' => $profileInfo['link'],
        ':email'       => $profileInfo['email'],
      ));
    return $stmt;
  }
  public function getUsersPools() {
    $userID = $this->fb->getID();
    $stmt = $this->db->Read(
     'SELECT Pools.poolID
           , Pools.poolEnd
           , Pools.poolStatus
           , Access.role
           , Users.fullName AS usersFullName
           , Mothers.userID
           , Mothers.poolID AS motherpoolID
        FROM Pools
        
        JOIN Access
          ON Access.poolID = Pools.poolID
          
        JOIN Access AS Mothers
          ON Mothers.poolID = Pools.poolID
          
        JOIN Users
          ON Users.userID = Mothers.userID
          
       WHERE Access.userID = :userID
         AND Mothers.role = :mother
         AND (Access.role = :mother OR Access.role = :organizer)
         AND Pools.poolStatus
             IN (\'pending\', \'running\', \'closed\', \'ranked\')'
      ,
      array(
        ':userID' => $userID, ':mother' => 'Mother', ':organizer' => 'Organizer'
      )
    );
    if (!empty($stmt)) { return $stmt; }
    else { return false; }
  }
  public function getFriendsPools() {
    //# http://sqlfiddle.com/#!2/e4175/24
    $FbIDs = $this->fb->listAppFriends();
    $userID = $this->fb->getID();
    if (!empty($FbIDs)) {
      $stmt = $this->db->Read(
       'SELECT Pools.poolID
             , Pools.poolEnd
             , Pools.poolStatus
             , Access.userID
             , Guesses.guessID
             , Users.fullName AS usersFullName
          FROM Access         AS Access
          JOIN Pools          AS Pools
            ON Pools.poolID = Access.poolID
         
          JOIN (SELECT poolID
                  FROM Access
                 GROUP BY poolID
                HAVING SUM(role = :organizer) = 0
               ) AS allowed_pools
            ON Access.poolID = allowed_pools.poolID
            
          JOIN Users
            ON Users.userID = Access.userID
        
          LEFT JOIN Guesses AS Guesses
            ON Pools.poolID = Guesses.poolID
           AND :userID   = Guesses.userID
        
         WHERE Access.userID IN ('.$FbIDs.')
           AND Access.role  = :mother
           AND Pools.poolStatus IN (\'running\', \'closed\', \'ranked\')',
        array(':userID' => $userID, ':mother' => 'Mother', ':organizer' => 'Organizer')
      );
    }
    if (!empty($stmt)) { return $stmt; }
    else { return false; }
  }
  
}


