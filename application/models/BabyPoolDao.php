<?php
class BabyPoolDao extends Dao {

  public function isPoolInDb() {
    $poolID = $this->getPoolID();
    if ($poolID !== false) {
      $stmt = $this->db->Read('SELECT COUNT(1) FROM Pools WHERE poolID = :poolID', array(':poolID' => $poolID));
      if ($stmt[0]['COUNT(1)'] == 0) {
        return false;
      }
      else { return true; }
    }
    else { return false; }
  }
  public function isPoolActive() {
    $poolID = $this->getPoolID();
    if ($poolID !== false) {
      $stmt = $this->db->Read('SELECT COUNT(1) FROM Pools WHERE poolID = :poolID AND poolStatus IN (\'running\', \'closed\', \'ranked\')', array(':poolID' => $poolID));
      if ($stmt[0]['COUNT(1)'] == 0) {
        return false;
      }
      else { return true; }
    }
    else { return false; }
  }
  public function isPoolCanceled() {
    $poolID = $this->getPoolID();
    if ($poolID !== false) {
      $stmt = $this->db->Read('SELECT COUNT(1) FROM Pools WHERE poolID = :poolID AND poolStatus = :poolStatus', array(':poolID' => $poolID, ':poolStatus' => 'canceled'));
      if ($stmt[0]['COUNT(1)'] == 0) {
        return false;
      }
      else { return true; }
    }
    else { return false; }
  }
  public function isPoolRunning($poolID = NULL) {
    if (empty($poolID)) { $poolID = $this->getPoolID(); }
    if ($poolID !== false) {
      $stmt = $this->db->Read('SELECT COUNT(1) FROM Pools WHERE poolID = :poolID AND poolStatus = :poolStatus', array(':poolID' => $poolID, ':poolStatus' => 'running'));
      if ($stmt[0]['COUNT(1)'] == 0) {
        return false;
      }
      else { return true; }
    }
    else { return false; }
  }
  public function isPoolPending() {
    $poolID = $this->getPoolID();
    if ($poolID !== false) {
      $stmt = $this->db->Read('SELECT COUNT(1) FROM Pools WHERE poolID = :poolID AND poolStatus IN (\'pending\')', array(':poolID' => $poolID));
      if ($stmt[0]['COUNT(1)'] == 0) {
        return false;
      }
      else { return true; }
    }
    else { return false; }
  }
  public function hasMadeGuess() {
    $poolID = $this->getPoolID();
    $userID = $this->fb->getID();
    if ($userID !== false && $poolID !== false) {
      $stmt = $this->db->Read('SELECT COUNT(1) FROM Guesses WHERE poolID = :poolID AND userID = :userID', array(':poolID' => $poolID, ':userID' => $userID));
      if ($stmt[0]['COUNT(1)'] == 0) { //theres nothing
        return false;
      }
      else { return true; } //theres a guess
    }
    else { return false; } //couldnt even check
  }
  public function getAllGuesses() {
    $poolID = $this->getPoolID();
    $stmt = $this->db->Read('SELECT poolID, guessID, gender, UNIX_TIMESTAMP(CONCAT(date)) as date, UNIX_TIMESTAMP(CONCAT(date, \' \', time))-UNIX_TIMESTAMP(CONCAT(date)) as time, length, ((weight_lbs * 16) + weight_oz) as weight_oz, userID FROM Guesses WHERE poolID = :poolID', array(':poolID' => $poolID));
    if (!empty($stmt)) { return $stmt; }
    else { return false; }
  }
  public function getBabyInfo() { //use getBabyDisplayInfo for Displaying
    $poolID = $this->getPoolID();
    $stmt = $this->db->Read(
      'SELECT poolID
            , babyID
            , babyGender
            , UNIX_TIMESTAMP(CONCAT(babyBirthdate)) as babyBirthdate
            , UNIX_TIMESTAMP(CONCAT(babyBirthdate, \' \', babyBirthtime))-UNIX_TIMESTAMP(CONCAT(babyBirthdate)) as babyBirthtime
            , babyLength
            , ((babyWeightLbs * 16) + babyWeightOz) as babyWeightOz
            , motherID
         FROM Babies
        WHERE poolID = :poolID',
      array(':poolID' => $poolID)
    );
    if (!empty($stmt)) { return $stmt; }
    else { return false; }
  }
  public function getBabyDisplayInfo() {
    $poolID = $this->getPoolID();
    $stmt = $this->db->Read('
      SELECT
        poolID
      , babyID
      , babyName
      , babyGender
      , babyBirthdate
      , TIME_FORMAT(babyBirthtime, \'%h:%i %p\') AS babyBirthtime
      , babyLength
      , babyWeightLbs
      , babyWeightOz
      , motherID
      FROM
        Babies
      WHERE
        poolID = :poolID',
      array(':poolID' => $poolID)
    );
    if (!empty($stmt)) { return $stmt; }
    else { return false; }
  }
  public function getPoolStatus() {
    $poolID = $this->getPoolID();
    $stmt = $this->db->Read('SELECT poolStatus FROM Pools WHERE poolID = :poolID', array(':poolID' => $poolID));
    if (!empty($stmt)) { return $stmt[0]['poolStatus']; }
    else { return false; }
  }
  public function getPoolID() {
    $matches = Mapper::getPoolID($_SERVER['REQUEST_URI']);
    if (empty($matches)) { return false; }
    else { return $matches[1]; }
  }
  public function getMotherID($poolID = NULL) {
    if (empty($poolID)) { $poolID = $this->getPoolID(); }
    $stmt = $this->db->Read('SELECT userID FROM Access WHERE poolID = :poolID AND role = :role', array(':poolID' => $poolID, ':role' => 'Mother'));
    if (!empty($stmt)) { return $stmt[0]['userID']; }
    else { return false; }
  }
  public function updatePoolStatus($poolStatus = 'closed', $poolID = NULL) {
    if (empty($poolID)) { $poolID = $this->getPoolID(); }
    $stmt = $this->db->Update(
      'UPDATE Pools SET poolStatus = :poolStatus WHERE poolID = :poolID',
      array(':poolStatus' => $poolStatus, ':poolID' => $poolID)
    );
    return $stmt;
  }
  public function mothersPool() {
    $userID = $this->fb->getID();
    if ($userID !== false) {
      $stmt = $this->db->Read('
        SELECT COUNT(1)
          FROM Access
         WHERE userID = :userID
           AND role = :mother',
        array(
          ':userID' => $userID,
          ':mother' => 'Mother',
        )
      );
      if ($stmt[0]['COUNT(1)'] == 0) {
        return false;
      }
      else { return true; }
    }
    else { return false; } 
  }
  public function isMother($userID = NULL, $poolID = NULL) {
    if (empty($userID)) { $userID = $this->fb->getID(); }
    if (empty($poolID)) { $poolID = $this->getPoolID(); }
    if ($userID !== false && $poolID !== false) {
      $stmt = $this->db->Read('
        SELECT COUNT(1)
          FROM Access
         WHERE poolID = :poolID
           AND userID = :userID
           AND role = :mother',
        array(
          ':userID' => $userID,
          ':poolID' => $poolID,
          ':mother' => 'Mother',
        )
      );
      if ($stmt[0]['COUNT(1)'] == 0) {
        return false;
      }
      else { return true; }
    }
    else { return false; } 
  }
  public function isOrganizer($userID = NULL, $poolID = NULL) {
    if (empty($userID)) { $userID = $this->fb->getID(); }
    if (empty($poolID)) { $poolID = $this->getPoolID(); }
    if ($userID !== false && $poolID !== false) {
      $stmt = $this->db->Read('
        SELECT COUNT(1)
          FROM Access
         WHERE poolID = :poolID
           AND userID = :userID
           AND role = :organizer',
        array(
          ':userID' => $userID,
          ':poolID' => $poolID,
          ':organizer' => 'Organizer',
        )
      );
      if ($stmt[0]['COUNT(1)'] == 0) {
        return false;
      }
      else { return true; }
    }
    else { return false; } 
  }
  public function hasAccess() {
    $poolID = $this->getPoolID();
    $userID = $this->fb->getID();
    if ($userID !== false && $poolID !== false) {
      $stmt = $this->db->Read('
        SELECT COUNT(1)
          FROM Access
         WHERE poolID = :poolID
           AND userID = :userID
           AND (role = :mother OR role = :organizer)',
        
        array(':userID' => $userID,
              ':poolID' => $poolID,
              ':mother' => 'Mother',
              ':organizer' => 'Organizer'
      ));
      if ($stmt[0]['COUNT(1)'] == 0) {
        return false;
      }
      else { return true; }
    }
    else { return false; } 
  }
  public function getName($userID) {
    $stmt = $this->db->Read('SELECT fullName FROM Users WHERE userID = :userID', array(':userID' => $userID));
    if (!empty($stmt)) { return $stmt[0]['fullName']; }
    else { return false; }
  }
  public function getMotherFirstName() {
    $motherID = $this->getMotherID();
    $stmt = $this->db->Read('SELECT firstName FROM Users WHERE userID = :motherID', array(':motherID' => $motherID));
    if (!empty($stmt)) { return $stmt[0]['firstName']; }
    else { return false; }
  } 
  public function getMotherFullName($motherID = NULL) {
    if (empty($motherID)) { $motherID = $this->getMotherID(); }
    $stmt = $this->db->Read('SELECT fullName FROM Users WHERE userID = :motherID', array(':motherID' => $motherID));
    if (!empty($stmt)) { return $stmt[0]['fullName']; }
    else { return false; }
  } 
  public function getMotherEmail($motherID = NULL) {
    if (empty($motherID)) { $motherID = $this->getMotherID(); }
    $stmt = $this->db->Read('SELECT email FROM Users WHERE userID = :motherID', array(':motherID' => $motherID));
    if (!empty($stmt)) { return $stmt[0]['email']; }
    else { return false; }
  }
  public function getMotherMobile($motherID = NULL) {
    if (empty($motherID)) { $motherID = $this->getMotherID(); }
    $stmt = $this->db->Read('SELECT mobilePhone FROM Users WHERE userID = :motherID', array(':motherID' => $motherID));
    if (!empty($stmt)) { return $stmt[0]['mobilePhone']; }
    else { return false; }
  }
  public function isGenderScored() {
    $poolID = $this->getPoolID();
    $stmt = $this->db->Read('SELECT gender FROM Pools WHERE poolID = :poolID', array(':poolID' => $poolID));
    if (!empty($stmt) && $stmt[0]['gender'] == 'surprise') { return true; }
    else { return false; }
  }
  public function getGender() {
    $poolID = $this->getPoolID();
    $stmt = $this->db->Read('SELECT gender FROM Pools WHERE poolID = :poolID', array(':poolID' => $poolID));
    if (!empty($stmt)) { return $stmt[0]['gender']; }
    else { return false; }
  }
  public function getRegistryLink() {
    $poolID = $this->getPoolID();
    $stmt = $this->db->Read('SELECT registryLink FROM Pools WHERE poolID = :poolID', array(':poolID' => $poolID));
    if (!empty($stmt) &&
        $stmt[0]['registryLink'] != 'http://' &&
        $stmt[0]['registryLink'] != 'https://') { return $stmt[0]['registryLink']; }
    else { return false; }
  }
  public function getPoolEnd() {
    $poolID = $this->getPoolID();
    $stmt = $this->db->Read('SELECT DATE_FORMAT(poolEnd, \'%m/%d/%y\') AS poolEnd FROM Pools WHERE poolID = :poolID', array(':poolID' => $poolID));
    if (!empty($stmt)) { return $stmt[0]['poolEnd']; }
    else { return false; }
  }
  public function getDueDate() {
    $poolID = $this->getPoolID();
    $stmt = $this->db->Read('SELECT DATE_FORMAT(dueDate,\'%m/%d/%y\') AS dueDate FROM Pools WHERE poolID = :poolID', array(':poolID' => $poolID));
    if (!empty($stmt)) { return $stmt[0]['dueDate']; }
    else { return false; }
  }
  public function getPoolPhotoLink($poolID = NULL) {
    if (empty($poolID)) { $poolID = $this->getPoolID(); }
    $stmt = $this->db->Read('SELECT poolPhotoLink FROM Pools WHERE poolID = :poolID', array(':poolID' => $poolID));
    if (!empty($stmt)) { return $stmt[0]['poolPhotoLink']; }
    else { return false; }
  }
  public function getPoolPhotoOrientation() {
    $poolID = $this->getPoolID();
    $stmt = $this->db->Read('SELECT poolPhotoOrientation FROM Pools WHERE poolID = :poolID', array(':poolID' => $poolID));
    if (!empty($stmt)) { return $stmt[0]['poolPhotoOrientation']; }
    else { return false; }
  }
    
  public function setPoolCancel($poolID, $editArr) {
    extract($editArr);
    $rowCount = 0;
    foreach ($editArr as $key => $val) {
      $stmt = $this->db->Update(
        'UPDATE Pools 
         SET '.$key.' = :val
         WHERE poolID = :poolID',
        array(
          ':poolID' => $poolID,
          ':val' => $val
        )
      );
      $rowCount = $rowCount + $stmt->rowCount();
    }
    return $rowCount;
  }
  public function setPoolBorn($poolID, $editArr) {
    extract($editArr);
    $stmt = $this->db->Create('
      INSERT INTO Babies
        ( poolID
        , babyID
        , created
        , babyName
        , babyGender
        , babyBirthdate
        , babyBirthtime
        , babyLength
        , babyWeightLbs
        , babyWeightOz
        , motherID
      ) VALUES (
          :poolID
        , :babyID
        , :created
        , :babyName
        , :babyGender
        , STR_TO_DATE( :babyBirthdate, \'%m/%d/%y\')
        , STR_TO_DATE( :babyBirthtime, \'%h:%i %p\')
        , :babyLength
        , :babyWeightLbs
        , :babyWeightOz
        , :motherID
      )',
      array(
        ':poolID' => $poolID,
        ':babyID' => NULL,
        ':created' => NULL,
        ':babyName' => $babyName,
        ':babyGender' => $babyGender,
        ':babyBirthdate' => $babyBirthdate,
        ':babyBirthtime' => $babyBirthtime,
        ':babyLength' => $babyLength,
        ':babyWeightLbs' => $babyWeightLbs,
        ':babyWeightOz' => $babyWeightOz,
        ':motherID' => $motherID,
      )
    );
    $stmt2 = $this->db->Update(
      'UPDATE Pools SET poolStatus = :poolStatus WHERE poolID = :poolID',
      array(':poolID' => $poolID, ':poolStatus' => $poolStatus)
    );
    return $stmt; //Returns poolID
  }

  public function setPoolCreateMother($motherID, $editArr) {
    extract($editArr);
    $role = 'Mother';
    $stmt = $this->db->Create('
      INSERT INTO Pools
        ( poolID
        , created
        , gender
        , dueDate
        , registryLink
        , poolEnd
        , poolPhotoLink
        , poolPhotoOrientation
        , poolStatus
      ) VALUES (
          :poolID
        , :created
        , :gender
        , STR_TO_DATE( :dueDate, \'%m/%d/%y\')
        , :registryLink
        , STR_TO_DATE( :poolEnd, \'%m/%d/%y\')
        , :poolPhotoLink
        , :poolPhotoOrientation
        , :poolStatus
      )',
      array(
        ':poolID' => NULL,
        ':created' => NULL,
        ':gender' => (!empty($gender)) ? $gender : NULL,
        ':dueDate' => (!empty($dueDate)) ? $dueDate : NULL,
        ':registryLink' => (!empty($registryLink)) ? $registryLink : NULL,
        ':poolEnd' => (!empty($poolEnd)) ? $poolEnd : NULL,
        ':poolPhotoLink' => (!empty($poolPhotoLink)) ? $poolPhotoLink : NULL,
        ':poolPhotoOrientation' => (!empty($poolPhotoOrientation)) ? $poolPhotoOrientation : NULL,
        ':poolStatus' => (!empty($poolStatus)) ? $poolStatus : NULL,
      )
    );
    $poolID = $stmt; //Add User Access
    $stmt1 = $this->db->Create('
      INSERT INTO Access
        ( userID
        , accessID
        , role
        , poolID
      ) VALUES (
          :userID
        , :accessID
        , :role
        , :poolID
      )',
      array(
        ':userID' => $motherID,
        ':accessID' => NULL,
        ':role' => $role,
        ':poolID' => $poolID
      )
    ); //Update user email
    if (!empty($motherEmail)) {
      $stmt2 = $this->db->Update(
        'UPDATE Users SET email = :email WHERE userID = :userID',
        array(':userID' => $motherID, ':email' => $motherEmail)
      );
    } //Update user phone
    if (!empty($motherMobile)) {
      $stmt3 = $this->db->Update(
        'UPDATE Users SET mobilePhone = :mobilePhone WHERE userID = :userID',
        array(':userID' => $motherID, ':mobilePhone' => $motherMobile)
      );
    }
    return $poolID; //Returns poolID
  }
  public function setPoolCreateOrganizer($motherID, $editArr) {
    extract($editArr);
    $stmt = $this->db->Create(
     'INSERT INTO Pools
        ( poolID
        , created
        , gender
        , dueDate
        , registryLink
        , poolEnd
        , poolPhotoLink
        , poolPhotoOrientation
        , poolStatus
      ) VALUES (
          :poolID
        , :created
        , :gender
        , STR_TO_DATE( :dueDate, \'%m/%d/%y\')
        , :registryLink
        , STR_TO_DATE( :poolEnd, \'%m/%d/%y\')
        , :poolPhotoLink
        , :poolPhotoOrientation
        , :poolStatus
      )',
      array(
        ':poolID' => NULL,
        ':created' => NULL,
        ':gender' => (!empty($gender)) ? $gender : NULL,
        ':dueDate' => (!empty($dueDate)) ? $dueDate : NULL,
        ':registryLink' => (!empty($registryLink)) ? $registryLink : NULL,
        ':poolEnd' => (!empty($poolEnd)) ? $poolEnd : NULL,
        ':poolPhotoLink' => (!empty($poolPhotoLink)) ? $poolPhotoLink : NULL,
        ':poolPhotoOrientation' => (!empty($poolPhotoOrientation)) ? $poolPhotoOrientation : NULL,
        ':poolStatus' => (!empty($poolStatus)) ? $poolStatus : NULL,
      )
    );
    $poolID = $stmt; //Add User Access
    $stmt1 = $this->db->Create('
      INSERT INTO Access
        ( userID
        , accessID
        , role
        , poolID
      ) VALUES (
          :userID
        , :accessID
        , :role
        , :poolID
      )',
      array(
        ':userID' => $motherID,
        ':accessID' => NULL,
        ':role' => 'Mother',
        ':poolID' => $poolID
      )
    );
    $stmt2 = $this->db->Create('
      INSERT INTO Access
        ( userID
        , accessID
        , role
        , poolID
      ) VALUES (
          :userID
        , :accessID
        , :role
        , :poolID
      )',
      array(
        ':userID' => $userID,
        ':accessID' => NULL,
        ':role' => 'Organizer',
        ':poolID' => $poolID
      )
    ); //Update Users Email
    if ($this->isUserAdded($userID) === false) { //not in database
      $stmt0 = $this->db->Create(
        'INSERT INTO Users (userID, fullName, firstName, profileLink, email) VALUES (:userID, :fullName, :firstName, :profileLink, :email)',
        array(
          ':userID'      => $motherID,
          ':fullName'    => NULL,
          ':firstName'   => NULL,
          ':profileLink' => NULL,
          ':email'       => (!empty($motherEmail)) ? $motherEmail : NULL,
      ));
    }
    else { //is in database, email update?
      if (!empty($motherEmail) && $this->getMotherEmail($motherID) !== false) {
        $stmt3 = $this->db->Update(
          'UPDATE Users SET email = :email WHERE userID = :userID',
          array(':userID' => $motherID, ':email' => $motherEmail)
        );
      }
    }
    return $poolID; //Returns poolID
  }
  public function setPoolEdit($poolID, $editArr) { //&& used by setPoolOrgToMother()
    $rowCount = 0;
    foreach ($editArr as $key => $val) {
      if ($key == 'motherEmail') {
        $userID = $this->getMotherID($poolID);
        $stmt = $this->db->Update(
          'UPDATE Users SET email = :val WHERE userID = :userID',
          array(':userID' => $userID, ':val' => $val)
        );
        $rowCount = $rowCount + $stmt->rowCount();
      }
      else if ($key == 'motherMobile') {
        $userID = $this->getMotherID($poolID);
        $stmt = $this->db->Update(
          'UPDATE Users SET mobilePhone = :val WHERE userID = :userID',
          array(':userID' => $userID, ':val' => $val)
        );
        $rowCount = $rowCount + $stmt->rowCount();
      }
      else if ($key == 'dueDate' || $key == 'poolEnd') {
        $format = '%m/%d/%y'; //$format = ($key == 'dueTime') ? '%h:%i %p' : '%m/%d/%y';
        $stmt = $this->db->Update(
          'UPDATE Pools SET '.$key.' = STR_TO_DATE(:val, \''.$format.'\') WHERE poolID = :poolID',
          array(':poolID' => $poolID, ':val' => $val)
        );
        $rowCount = $rowCount + $stmt->rowCount();
      }
      else {
        $stmt = $this->db->Update(
          'UPDATE Pools SET '.$key.' = :val WHERE poolID = :poolID',
          array(':poolID' => $poolID, ':val' => $val)
        );
        $rowCount = $rowCount + $stmt->rowCount();
      }
    }
    return $rowCount; //Total Rows Affected, 0 means no change.
  }
  public function setPoolGuess($poolID, $editArr) { //Make a Guess - MakeGuess
    extract($editArr);
    $userID = $this->fb->getID();
    $stmt = $this->db->Create('
      INSERT INTO Guesses
        ( poolID
        , guessID
        , gender
        , date
        , time
        , length
        , weight_lbs
        , weight_oz
        , userID
      ) VALUES(
          :poolID
        , :guessID
        , :gender
        , STR_TO_DATE( :date, \'%m/%d/%y\')
        , STR_TO_DATE( :time, \'%h:%i %p\')
        , :length
        , :weight_lbs
        , :weight_oz
        , :userID
      )',
      array(
        'poolID' => $poolID,
        ':guessID' => NULL,
        ':gender' => (!empty($gender) ? $gender : NULL),
        ':date' => $date,
        ':time' => $time,
        ':length' => $length,
        ':weight_lbs' => $weight_lbs,
        ':weight_oz' => $weight_oz,
        ':userID' => $userID
      )
    );
    return $stmt; //Returns poolID
  }
  public function getPoolGuesses() {
    $poolID = $this->getPoolID();
    //$stmt = $this->db->Read('SELECT gs.gender, STR_TO_DATE(gs.date,\'%m/%d/%y\') AS gs.date, STR_TO_DATE(gs.time, \'%r\') AS gs.time, gs.length, gs.weight_lbs, gs.weight_oz, gs.userID, us.fullName FROM Guesses AS gs, Users AS us WHERE gs.poolID = :poolID AND gs.userID = us.userID', array(':poolID' => $poolID));
    $stmt = $this->db->Read('
      SELECT gs.gender
           , DATE_FORMAT(gs.date,\'%m/%d/%y\') AS date
           , TIME_FORMAT(gs.time, \'%h:%i %p\') AS time
           , gs.length
           , gs.weight_lbs
           , gs.weight_oz
           , gs.userID
           , us.fullName
      FROM Guesses AS gs
      JOIN Users
        AS us
        ON gs.userID = us.userID
      WHERE gs.poolID = :poolID',
      array(
        ':poolID' => $poolID
      )
    );
    if (!empty($stmt)) { return $stmt; }
    else { return false; }
  }

  public function isUserAdded($userID = NULL) {
    if (!empty($userID)) {
      $stmt = $this->db->Read('SELECT COUNT(1) FROM Users WHERE userID = :userID', array(':userID' => $userID));
      if ($stmt[0]['COUNT(1)'] == 0) { //not
        return false;
      }
      else { //is
        return true;
      }
    }
    else { return null; }
  }
}