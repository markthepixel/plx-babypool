<?php

/**
* The BabyPool class is the class that holds all the game mechanics
*/
class BabyPool {
  protected $db, $fb;
  protected $BabyPoolDao;
  
  public function __construct(Database $db, FbDoa $fb) {
    $this->db = $db;
    $this->fb = $fb;
    $this->BabyPoolDao = new BabyPoolDao($db, $fb);
  }
  
  //Functional Methods
  public function hasAccess() {
    return $this->BabyPoolDao->hasAccess();
  }
  public function getDueDate_MDY() {
    $e = $this->BabyPoolDao->getDueDate();
    return date_format(date_create_from_format('m/d/y', $e), 'm/d/y');
  }
  public function getPoolEnd_MDY() {
    $e = $this->BabyPoolDao->getPoolEnd();
    return date_format(date_create_from_format('m/d/y', $e), 'm/d/y');
  }
  public function getPoolEndDays($end = NULL) {
    if (empty($end)) {
      $e = $this->BabyPoolDao->getPoolEnd();
      $end = date_format(date_create_from_format('m/d/y', $e), 'U');
    }
    $today = strtotime('now');
    $diff = $end - $today;
    $result = floor($diff/(60*60*24));
    if ($result <= 0) { return '0'; }
    else { return $result; }
  }
  public function checkPoolEnd() {
    if ($this->BabyPoolDao->isPoolRunning() && $this->getPoolEndDays() <= 0) {
      //End the Pool
      $this->BabyPoolDao->updatePoolStatus(); //default: closed.
      return true;
    }
    else {
      return false;
    }
  }
  
//__ Form Functions  
  //Create a Pool by Mother
  public function setPoolCreateMother() {
    $userID = $_POST['userID'];    
    if (empty($_POST['poolEnd']) || empty($_POST['gender']) ||
        empty($_POST['dueDate']) || empty($_POST['privacy_policy']) ) {
      return 'error';
    }
    else {
      $editArr = array();
      $editArr['poolStatus'] = 'running';
      if (!empty($_POST['motherEmail'])) { $editArr['motherEmail'] = $_POST['motherEmail']; }
      if (!empty($_POST['gender'])) { $editArr['gender'] = $_POST['gender']; }
      if (!empty($_POST['dueDate'])) { $editArr['dueDate'] = $_POST['dueDate']; }
      if (!empty($_POST['motherMobile'])) { $editArr['motherMobile'] = $_POST['motherMobile']; }
      if (!empty($_POST['poolEnd'])) { $editArr['poolEnd'] = $_POST['poolEnd']; }
      if (!empty($_POST['registryLink']) && $_POST['registryLink'] != 'http://' && $_POST['registryLink'] != 'https://') { $editArr['registryLink'] = $_POST['registryLink']; }
      if (!empty($_POST['poolPhotoLink'])) { $editArr['poolPhotoLink'] = $_POST['poolPhotoLink']; }
      if (!empty($_POST['poolPhotoOrientation'])) { $editArr['poolPhotoOrientation'] = $_POST['poolPhotoOrientation']; }
      $stmt = $this->BabyPoolDao->setPoolCreateMother($userID, $editArr);
      return $stmt; //Returns Pool's ID
    }
  }
  //Create a Pool by Organizer
  public function setPoolCreateOrganizer() {
    $motherID = $_POST['motherID'];
    if (empty($_POST['privacy_policy']) || empty($_POST['motherID']) ) {
      return 'error';
    }
    else {
      $editArr = array();
      $editArr['poolStatus'] = 'pending';
      if (!empty($_POST['userID'])) { $editArr['userID'] = $_POST['userID']; }
      if (!empty($_POST['motherName'])) { $editArr['motherName'] = $_POST['motherName']; }
      if (!empty($_POST['motherEmail'])) { $editArr['motherEmail'] = $_POST['motherEmail']; }
      if (!empty($_POST['gender'])) { $editArr['gender'] = $_POST['gender']; }
      if (!empty($_POST['dueDate'])) { $editArr['dueDate'] = $_POST['dueDate']; }
      if (!empty($_POST['poolEnd'])) { $editArr['poolEnd'] = $_POST['poolEnd']; }
      if (!empty($_POST['registryLink']) && $_POST['registryLink'] != 'http://' && $_POST['registryLink'] != 'https://') { $editArr['registryLink'] = $_POST['registryLink']; }
      if (!empty($_POST['poolPhotoLink'])) { $editArr['poolPhotoLink'] = $_POST['poolPhotoLink']; }
      if (!empty($_POST['poolPhotoOrientation'])) { $editArr['poolPhotoOrientation'] = $_POST['poolPhotoOrientation']; }
      $stmt = $this->BabyPoolDao->setPoolCreateOrganizer($motherID, $editArr);
      return $stmt; //Returns Pool's ID
    }
  }
  //Create a Pool by Mother via Organizer
  public function setPoolOrgToMother() { //uses BabyPoolDao -> setPoolEdit()
    $poolID = $_POST['poolID'];
    if (empty($_POST['poolEnd']) || empty($_POST['gender']) ||
        empty($_POST['dueDate']) || empty($_POST['privacy_policy']) ) {
      return 'error';
    }
    else {
      $editArr = array();
      $editArr['poolStatus'] = 'running';
      if (!empty($_POST['motherEmail'])) { $editArr['motherEmail'] = $_POST['motherEmail']; }
      if (!empty($_POST['gender'])) { $editArr['gender'] = $_POST['gender']; }
      if (!empty($_POST['dueDate'])) { $editArr['dueDate'] = $_POST['dueDate']; }
      if (!empty($_POST['poolEnd'])) { $editArr['poolEnd'] = $_POST['poolEnd']; }
      if (!empty($_POST['registryLink']) && $_POST['registryLink'] != 'http://' && $_POST['registryLink'] != 'https://') { $editArr['registryLink'] = $_POST['registryLink']; }
      if (!empty($_POST['poolPhotoLink'])) { $editArr['poolPhotoLink'] = $_POST['poolPhotoLink']; }
      if (!empty($_POST['poolPhotoOrientation'])) { $editArr['poolPhotoOrientation'] = $_POST['poolPhotoOrientation']; }
      $stmt = $this->BabyPoolDao->setPoolEdit($poolID, $editArr); //REUSE EDIT!
      return $poolID;
    }
  }
  //Edit a Pool by Mother or Organizer
  public function setPoolPhotoUpdate() {
    $poolID = $_POST['poolID'];
    if (empty($_POST['poolID']) ) {
      return 'error';
    }
    else {
      $editArr = array();
      $editArr['poolPhotoLink'] = $_POST['poolPhotoLink'];
      $editArr['poolPhotoOrientation'] = $_POST['poolPhotoOrientation'];
      $stmt = $this->BabyPoolDao->setPoolEdit($poolID, $editArr);
      return $poolID;
    }
  }
  //Edit a Pool by Mother or Organizer
  public function setPoolEdit() {
    $poolID = $_POST['poolID'];
    if (empty($_POST['poolEnd']) ) {
      return 'error';
    }
    else {
      $editArr = array();
      if (!empty($_POST['motherEmail'])) { $editArr['motherEmail'] = $_POST['motherEmail']; } else { $editArr['motherEmail'] = NULL; }
      if (!empty($_POST['motherMobile'])) { $editArr['motherMobile'] = $_POST['motherMobile']; } else { $editArr['motherMobile'] = NULL; }
      if (!empty($_POST['gender'])) { $editArr['gender'] = $_POST['gender']; }
      if (!empty($_POST['dueDate'])) { $editArr['dueDate'] = $_POST['dueDate']; }
      if (!empty($_POST['poolEnd'])) { $editArr['poolEnd'] = $_POST['poolEnd']; }
      if (!empty($_POST['registryLink']) && $_POST['registryLink'] != 'http://' && $_POST['registryLink'] != 'https://') { $editArr['registryLink'] = $_POST['registryLink']; }
      if (!empty($_POST['poolPhotoLink'])) { $editArr['poolPhotoLink'] = $_POST['poolPhotoLink']; }
      if (!empty($_POST['poolPhotoOrientation'])) { $editArr['poolPhotoOrientation'] = $_POST['poolPhotoOrientation']; }
      $stmt = $this->BabyPoolDao->setPoolEdit($poolID, $editArr);
      return $poolID;
    }
  }
  //The Baby is Here!
  public function setPoolBorn() {
    $poolID = $_POST['poolID'];    
    if (empty($_POST['babyName']) || empty($_POST['babyGender']) ||
        empty($_POST['babyLength']) || empty($_POST['poolID']) ||
        empty($_POST['babyWeightLbs']) || empty($_POST['babyWeightOz']) ||
        empty($_POST['babyBirthdate']) || empty($_POST['babyBirthtime']) ) {
      return 'error';
    }
    else {
      $editArr = array();
      $editArr['poolStatus'] = 'ranked';
      $editArr['motherID'] = $this->BabyPoolDao->getMotherID($poolID);
      if (!empty($_POST['babyName'])) { $editArr['babyName'] = $_POST['babyName']; }
      if (!empty($_POST['babyGender'])) { $editArr['babyGender'] = $_POST['babyGender']; }
      if (!empty($_POST['babyBirthdate'])) { $editArr['babyBirthdate'] = $_POST['babyBirthdate']; }
      if (!empty($_POST['babyBirthtime'])) { $editArr['babyBirthtime'] = $_POST['babyBirthtime']; }
      if (!empty($_POST['babyLength'])) { $editArr['babyLength'] = $_POST['babyLength']; }
      if (!empty($_POST['babyWeightLbs'])) { $editArr['babyWeightLbs'] = $_POST['babyWeightLbs']; }
      if (!empty($_POST['babyWeightOz'])) { $editArr['babyWeightOz'] = $_POST['babyWeightOz']; }
      $stmt = $this->BabyPoolDao->setPoolBorn($poolID, $editArr);
      return $stmt; //Returns Pool's ID
    }
  }
  //Cancel a Pool
  public function setPoolCancel() {
    $poolID = $_POST['poolID'];
    $editArr['poolStatus'] = 'canceled';
    $stmt = $this->BabyPoolDao->setPoolCancel($poolID, $editArr);
    return $stmt;
  }
  //Submit a Guess to Single Pool Page
  public function setPoolGuess() {
    $poolID = $_POST['poolID'];
    if ($this->BabyPoolDao->hasMadeGuess() !== true) {
      if (empty($_POST['date']) || empty($_POST['time']) || empty($_POST['length']) ||
          empty($_POST['weight_lbs']) || empty($_POST['weight_oz']) ) {
        return 'error';
      }
      else {
        $editArr = array();
        if (!empty($_POST['gender'])) { $editArr['gender'] = $_POST['gender']; }
        if (!empty($_POST['date'])) { $editArr['date'] = $_POST['date']; }
        if (!empty($_POST['time'])) { $editArr['time'] = $_POST['time']; }
        if (!empty($_POST['length'])) { $editArr['length'] = $_POST['length']; }
        if (!empty($_POST['weight_lbs'])) { $editArr['weight_lbs'] = $_POST['weight_lbs']; }
        if ($_POST['weight_oz'] == 0 || !empty($_POST['weight_oz'])) { $editArr['weight_oz'] = $_POST['weight_oz']; }
        $stmt = $this->BabyPoolDao->setPoolGuess($poolID, $editArr);
        return 'You\'ve guessed successfully!';
      }
    }
  }
  public function getUsersPoints($babyInfo = NULL, $allGuesses = NULL) {
    if (empty($babyInfo)) { $babyInfo = $this->BabyPoolDao->getBabyInfo(); }
    if (empty($allGuesses)) { $allGuesses = $this->BabyPoolDao->getAllGuesses(); }
    $allArr = array();
    foreach ($allGuesses as $aGuess) {
      $allArr['gender'][$aGuess['userID']]    = ($aGuess['gender'] == $babyInfo[0]['babyGender']) ? true : false;
      $allArr['weight_oz'][$aGuess['userID']] = abs($aGuess['weight_oz'] - $babyInfo[0]['babyWeightOz']);
      $allArr['length'][$aGuess['userID']]    = abs($aGuess['length'] - $babyInfo[0]['babyLength']);
      $allArr['date'][$aGuess['userID']]      = abs($aGuess['date'] - $babyInfo[0]['babyBirthdate']);
      $allArr['time'][$aGuess['userID']]      = abs($aGuess['time'] - $babyInfo[0]['babyBirthtime']);
    }
    $ptSys = array(10, 5, 2, 1);
    $ptUsers = array();
    foreach ($allArr as $eK => $eV) {
      $i = 0; $lastGuess = '';
      asort($allArr[$eK]);
      if ($eK == 'gender') {
        foreach ($eV as $user => $guess) {
          if (!array_key_exists($user, $ptUsers)) { $ptUsers[$user] = 0; }
          if ($guess === true) { $ptUsers[$user] += $ptSys[0]; }
        }
      }
      else {
        foreach ($eV as $user => $guess) {
          if (!array_key_exists($user, $ptUsers)) { $ptUsers[$user] = 0; }
          if ($lastGuess != $guess) {
            $i = $i + 1;
            if (!array_key_exists($i, $ptSys)) { break; }
          }
          $ptUsers[$user] += $ptSys[$i];
          $lastGuess = $guess;
        }
      }
    }
    return $ptUsers; //to return points
  }
  public function getUsersPlace($babyInfo = NULL, $allGuesses = NULL) {
    $ptUsers = $this->getUsersPoints($babyInfo, $allGuesses);
    arsort($ptUsers);
    $r = 1; $rankUsers = array();
    foreach ($ptUsers as $userID => $userPoints) {
      $rankUsers[$userID] = $r;
      $r = $r + 1;
    }
    return $rankUsers; //to return rank
  }

  //Pass-Through Methods
  public function getAllGuesses() {
    return $this->BabyPoolDao->getAllGuesses();
  }
  public function getBabyInfo() {
    return $this->BabyPoolDao->getBabyInfo();
  }
  public function getBabyDisplayInfo() {
    return $this->BabyPoolDao->getBabyDisplayInfo();
  }
  public function getPoolStatus() {
    return $this->BabyPoolDao->getPoolStatus();
  }
  public function getPoolGuesses() {
    return $this->BabyPoolDao->getPoolGuesses();
  }
  public function isPoolActive() {
    return $this->BabyPoolDao->isPoolActive();
  }
  public function isPoolCanceled() {
    return $this->BabyPoolDao->isPoolCanceled();
  }
  public function isPoolPending() {
    return $this->BabyPoolDao->isPoolPending();
  }
  public function isPoolInDb() {
    return $this->BabyPoolDao->isPoolInDb();
  }
  public function mothersPool() {
    return $this->BabyPoolDao->mothersPool();
  }
  public function isMother($userID = NULL, $poolID = NULL) {
    return $this->BabyPoolDao->isMother($userID, $poolID);
  }
  public function isOrganizer($userID = NULL, $poolID = NULL) {
    return $this->BabyPoolDao->isOrganizer($userID, $poolID);
  }
  public function hasMadeGuess() {
    return $this->BabyPoolDao->hasMadeGuess();
  }
  public function getPoolID() {
    return $this->BabyPoolDao->getPoolID();
  }
  public function getMotherID($motherID = NULL) {
    return $this->BabyPoolDao->getMotherID($motherID);
  }
  public function isGenderScored() {
    return $this->BabyPoolDao->isGenderScored();
  }
  public function getMotherFirstName() {
    return $this->BabyPoolDao->getMotherFirstName();
  }
  public function getMotherFullName($poolID = NULL) {
    return $this->BabyPoolDao->getMotherFullName($poolID);
  }
  public function getMotherEmail() {
    return $this->BabyPoolDao->getMotherEmail();
  }
  public function getMotherMobile() {
    return $this->BabyPoolDao->getMotherMobile();
  }
  public function getGender() {
    return $this->BabyPoolDao->getGender();
  }
  public function getRegistryLink() {
    return $this->BabyPoolDao->getRegistryLink();
  }
  public function getDueDate() {
    return $this->BabyPoolDao->getDueDate();
  }
  public function getPoolEnd() {
    return $this->BabyPoolDao->getPoolEnd();
  }
  public function getPoolPhotoLink($poolID = NULL) {
    return $this->BabyPoolDao->getPoolPhotoLink($poolID);
  }
  public function getPoolPhotoOrientation() {
    return $this->BabyPoolDao->getPoolPhotoOrientation();
  }
  public function updatePoolStatus($poolStatus = NULL, $poolID = NULL) {
    return $this->BabyPoolDao->updatePoolStatus($poolStatus, $poolID);
  }
}