<?php
  
  //1. Auto Load Models & Models
  function __autoload($classname) {
    require_once $_SERVER['DOCUMENT_ROOT'].'/dev/application/models/'.$classname.'.php';
  }
  $view = new load();
    
  //2. Check URL Pattern and Check Mapp
  $mapp = Mapper::checkPageState($_SERVER['REQUEST_URI']);
  if ($mapp !== false) {
  
    //2.1 Setup Objects
    $controlVars = array();
    $db = new Database();
    $fb = new FbDoa();
    $fBSdk = $fb->fBSdk();
    $view->mapp = $mapp;
    $controlVars['mapp'] = $mapp;
    //$view->errorDebug = 'test data'
    
    //2.2 Proceed with Mapping
    if ($fBSdk !== false) {
    
      //2.2.1 Create the Correct Instance
      if ($mapp != 'Play' && $mapp != 'PoolCancel') {
        $babyPool = new BabyPool($db, $fb);        
      }
      if (!empty($babyPool) && $babyPool instanceof BabyPool && $babyPool->hasAccess() === true) {
        $user = new Organizer($db, $fb);
        $hasAccess = true;
      }
      else {
        $user = new User($db, $fb);
        $hasAccess = false;
      }
            
      //2.2.2 Manage POST/GET Data
      if (!empty($_POST['formType']) && method_exists($babyPool, 'set'.$_POST['formType'])) {
        $formType = $_POST['formType'];
        $result = call_user_func(array($babyPool, 'set'.$formType), $mapp); 
        if ($result == 'error') {
          $view->statusMessage = 'Please fill out all required (*) fields. Thank You.';
        } 
        else {
          if ($mapp == 'PoolCreateMother' || $mapp == 'PoolOrgToMother') {
            $oG_action = $fb->openGraph(
              'create',
              'http://www.playtexbabypool.com/dev/pool/'.$result.'/'
            );
            $controlVars['poolID'] = $result;
            $_SESSION['formType'] = $_POST['formType'];
            header('Location: /dev/pool/'.$result); die();
          }
          else if ($_POST['formType'] == 'PoolEdit') {
            $view->statusMessage = 'Pool Successfully Updated!';
          }
          else if ($_POST['formType'] == 'PoolBorn') {
            $_SESSION['formType'] = $_POST['formType'];
            header('Location: /dev/pool/'.$result.'/'); die();
          }
          else if ($mapp == 'PoolCreateOrganizer') {
            header('Location: /dev/invite/'.$result.'/'); die();
          }
          else if ($_POST['formType'] == 'PoolCancel' && $result > 0) {
            //header('Location: /dev/pool/'.$_POST['poolID'].'/cancel/'); die();
            header('Location: /dev/pool/'.$_POST['poolID'].'/'); die();
          }
          else if ($_POST['formType'] == 'PoolGuess') {
            $oG_action = $fb->openGraph(
              'guessed_on',
              'http://www.playtexbabypool.com/dev/pool/'.$_POST['poolID'].'/'
            );
            $view->statusMessage = $result;
          }
          else {
            $view->statusMessage = $result;
          }
        }
      }
      //2.2.3 Initial Variables Setup
      $view->firstName = $user->getFirstName();
      $view->name = $user->getName();
      $controlVars['name'] = $user->getName();
      $view->userID = $user->getID();
      $view->adBlock = Advertisement::getAdBlock();
      $view->adMobile = Advertisement::getAdMobile();
      $view->isMotherOfActivePool = $user->isMotherOfActivePool();
      $view->isMotherOfPendingPool = $user->isMotherOfPendingPool();
      if ($mapp == 'Play') { $view->hideNavigation = true; } //Hide Navigation      
            
      //2.2.4 Match to View and get output vars
      $view->doesLikePage = $user->doesLikePage();
      if ($mapp == 'PoolCreateChoice') { }
      else if ($mapp == 'PoolCreateMother' || $mapp == 'PoolCreateOrganizer' || $mapp == 'PoolOrgToMother') {
        $viewMapper = 'PoolCreate';
        $view->createType = Mapper::checkPageState($_SERVER['REQUEST_URI']);
        $view->listAllFriends = $fb->listAllFriends();
        if ($mapp == 'PoolCreateMother') {
          if ($user->isMotherOfActivePool() === true) { header('Location: /dev/'); die(); }
          if ($user->isMotherOfPendingPool() === true) { header('Location: /dev/'); die(); }
          $view->poolPhotoLink = $babyPool->getPoolPhotoLink();
          $view->poolPhotoOrientation = $babyPool->getPoolPhotoOrientation();
          $view->email = $user->getEmail();
          $view->hideMothersName = true;
          $controlVars['poolPhotoLink'] = $babyPool->getPoolPhotoLink();
        }
        else if ($mapp == 'PoolCreateOrganizer') {
          $view->hidePhotoSelect = true;
          $view->hideGetStartedStep = true;
          $view->hideSpecialOffers = true;
        }
        else if ($mapp == 'PoolOrgToMother') {
          $futurePoolID = $babyPool->getPoolID();
          if ($babyPool->isMother() === false || $babyPool->isPoolInDb() === false || $babyPool->isPoolPending() === false) { runNotFound404(); die(); }
          if ($user->isMotherOfActivePool() === true) { $babyPool->updatePoolStatus('canceled', $futurePoolID); header('Location: /dev/'); die(); }
          $view->hideMothersName = true;
          $view->poolID = $futurePoolID;
          $view->poolPhotoLink = $babyPool->getPoolPhotoLink();
          $view->poolPhotoOrientation = $babyPool->getPoolPhotoOrientation();
          $view->motherEmail = $babyPool->getMotherEmail();
          $view->gender = $babyPool->getGender();
          $view->dueDate  = $babyPool->getDueDate();
          $view->poolEnd = $babyPool->getPoolEnd();
          $view->registryLink = $babyPool->getRegistryLink();
          $controlVars['poolPhotoLink'] = $babyPool->getPoolPhotoLink();
        }
      }
      else if ($mapp == 'SendInvite') {
        if ($babyPool->isOrganizer() === false || $babyPool->isPoolInDb() === false || $babyPool->isPoolPending() === false) { runNotFound404(); die(); }
        $view->poolID = $babyPool->getPoolID();
        $view->motherID = $babyPool->getMotherID($result);
      }
      else if ($mapp == 'PoolSingle' || $mapp == 'PoolEdit') {
        if ($babyPool->isPoolInDb() === false || $babyPool->isPoolPending() === true) { runNotFound404(); die(); }
        $PoolIsCanceled = $babyPool->isPoolCanceled();
        if ($PoolIsCanceled === true &&  $mapp == 'PoolEdit') { runNotFound404(); die(); }
        if ($PoolIsCanceled !== true) {
          $babyPool->checkPoolEnd();
          $view->poolStatus = $babyPool->getPoolStatus();
          $view->hasAccess = $hasAccess; //aka has adminstrator access
          $view->poolID = $babyPool->getPoolID();
          $view->poolPhotoLink = $babyPool->getPoolPhotoLink();
          $view->poolPhotoOrientation = $babyPool->getPoolPhotoOrientation();
          $controlVars['poolID'] = $babyPool->getPoolID();
          $controlVars['poolPhotoLink'] = $babyPool->getPoolPhotoLink();
        }

        if ($PoolIsCanceled == true) {
          $view->motherFullName = $babyPool->getMotherFullName();
        }
        else if ($mapp == 'PoolSingle') {
          if (!empty($_SESSION['formType']) && $_SESSION['formType'] == 'PoolEdit') {
            $view->statusMessage = 'Successfully updated your pool settings!';
            $_SESSION['formType'] = '';
          }
          if ($babyPool->getPoolStatus() == 'ranked') {
            $view->showRankResults = true;
            $view->rankUsers = $babyPool->getUsersPlace();
            $view->pointUsers = $babyPool->getUsersPoints();
            $getBabyInfo = $babyPool->getBabyDisplayInfo();
            $getBabyInfo_babyBirthdate = date("m/d/y", strtotime($getBabyInfo[0]['babyBirthdate']));
              $view->babyName = $getBabyInfo[0]['babyName'];
              $view->babyBirthdate = $getBabyInfo_babyBirthdate;
              $view->babyGender = $getBabyInfo[0]['babyGender'];
              $view->babyWeightLbs = $getBabyInfo[0]['babyWeightLbs'];
              $view->babyWeightOz = $getBabyInfo[0]['babyWeightOz'];
              $view->babyBirthtime = $getBabyInfo[0]['babyBirthtime'];
              $view->babyLength = $getBabyInfo[0]['babyLength'];
          }
          $view->registryLink = $babyPool->getRegistryLink();
          $view->motherID = $babyPool->getMotherID();
          $view->motherFirstName = $babyPool->getMotherFirstName();
          $view->motherFullName = $babyPool->getMotherFullName();
          $controlVars['motherFullName'] = $babyPool->getMotherFullName();
          $view->dueDate  = $babyPool->getDueDate();
          $view->poolEndDays = $babyPool->getPoolEndDays();
          $view->poolEnd = $babyPool->getPoolEnd_MDY();
          $view->scoreGender = $babyPool->isGenderScored(); //changed
          $view->hasMadeGuess = $babyPool->hasMadeGuess();
          $view->poolGuesses = $babyPool->getPoolGuesses();
        }
        else if ($mapp == 'PoolEdit') {
          if ($hasAccess === false) { runNotFound404(); die(); } //route to 404
          $view->gender = $babyPool->getGender();
          $view->scoreGender = $babyPool->isGenderScored(); //changed
          $view->motherEmail = $babyPool->getMotherEmail();
          $view->motherMobile = $babyPool->getMotherMobile();
          $view->registryLink = $babyPool->getRegistryLink();
          $view->poolEnd = $babyPool->getPoolEnd();
        }
        
      }
      else if ($mapp == 'SomeView') {
        $view->listAllFriends = $fb->listAllFriends();
        $view->allGuesses = $babyPool->getAllGuesses();
        $view->babyInfo = $babyPool->getBabyInfo();
      }
      else { //($mapp == 'Play')
        if ($mapp == 'PoolCancel') { $view->statusMessage = 'Successfully Canceled your Baby Pool.'; }
        if ($mapp == 'PoolInviteOrganizer') { $view->runPopupOrganizer = true; }
        $view->usersPools = $user->getUsersPools();
        $view->friendsPools = $user->getFriendsPools();
      }
    }

    //2.3 FB is NOT Authorized, Login Screen
    if ($fBSdk === false) {
      $view->hideNavigation = true;
      $view->FbLogin = $fb->getLoginButton();
    }

    //2.4 Facebook OpenGraph
    if ($mapp == 'PoolSingle') {
      if (empty($babyPool) || !($babyPool instanceof BabyPool)) { $babyPool = new BabyPool($db, $fb); }
      if (empty($controlVars['poolID'])) { $controlVars['poolID'] = $babyPool->getPoolID(); }
      $userPoolID = $controlVars['poolID']; 
      if (empty($controlVars['poolPhotoLink'])) { $controlVars['poolPhotoLink'] = $babyPool->getPoolPhotoLink($userPoolID); }
      if (empty($controlVars['motherFullName'])) { $controlVars['motherFullName'] = $babyPool->getMotherFullName($babyPool->getMotherID($userPoolID)); }
      //$poolURL = 'http://www.playtexbabypool.com/dev/pool/'. $userPoolID .'/';
      $poolURL = 'http://samples.ogp.me/269683149824393';
      $view->openGraphHead = '
      <meta property="fb:app_id" content="256375344488507" /> 
      <meta property="og:type"   content="playtexbabypool:baby_pool" /> 
      <meta property="og:url"    content="'.$poolURL.'" /> 
      <meta property="og:title"  content="'.$controlVars['motherFullName'].'\'s Baby Pool" />
      <meta property="og:image"  content="'. $controlVars['poolPhotoLink'] .'" />
      ';
    }
    
    //2.5 Final Output
    $view->_PageHeader = $view->render('_PageHeader'); //Ouput: Page Header
    $view->_Header = $view->render('_Header'); //Output: Header (1 of 2)
    $view->_FbSDK = $view->render('_FbSDK'); //Output: Header (2 of 2)    
    if ($fBSdk === false) { $view->_Content = $view->render('Login'); } //Output: Content Switch (see 2.3)
    else if ($mapp == 'PoolCreateChoice')    { $view->_Content = $view->render($mapp); }
    else if ($mapp == 'PoolCreateMother')    { $view->_Content = $view->render('PoolCreate'); }
    else if ($mapp == 'PoolCreateOrganizer') { $view->_Content = $view->render('PoolCreate'); }
    else if ($mapp == 'PoolOrgToMother' )    { $view->_Content = $view->render('PoolCreate'); }
    else if ($PoolIsCanceled === true)       { $view->_Content = $view->render('PoolCanceled'); }
    else if ($mapp == 'PoolSingle')          { $view->_Content = $view->render($mapp); }
    else if ($mapp == 'PoolEdit')            { $view->_Content = $view->render($mapp); }
    else if ($mapp == 'SendInvite')          { $view->_Content = $view->render($mapp); }
    else if ($mapp == 'HowToPlay')           { $view->_Content = $view->render($mapp); }
    else if ($mapp == 'SomeView')            { $view->_Content = $view->render($mapp); }
    else                                     { $view->_Content = $view->render('Play'); }
    $view->_Footer = $view->render('_Footer'); //Output: Footer
    echo $view->render('_PageTemplate'); //Output: Page Content
  }
  
  //3. Send to 404 since No Map
  else {
    runNotFound404();
    die();
  }



//4. Temp 404 Error Page
function runNotFound404() {
  echo '<h1>ERROR: 404 (Temp. Page)</h1><hr/>';
  echo '<h3>MAPP:</h3>';
  echo '<pre>'.Mapper::checkPageState($_SERVER['REQUEST_URI']).'</pre>';
  echo '<h3>REQUEST_URI:</h3>';
  echo '<pre>'; print_r($_SERVER['REQUEST_URI']); echo '</pre>';
  echo '<h3>QUERY_STRING:</h3>';
  echo '<pre>'; print_r($_SERVER['QUERY_STRING']); echo '</pre>';
}