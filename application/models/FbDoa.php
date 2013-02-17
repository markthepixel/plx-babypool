<?php

/**
* The Facebook class deals with all the interactions with Facebook and the Web App
*
* URL for Fix: http://stackoverflow.com/questions/12972856/facebook-php-proper-way-to-keep-users-logged-in-without-js/13995789#13995789
*/
class FbDoa {
  private $facebookID;
  private $fullName;
  public  $accessToken;
  
  private $facebook;
  private $user_profile;
  private $user;
  
  public function __construct() {
    //fBSdk();
  }
  public function fBSdk() {
    $this->facebook = new Facebook(array(
      'appId'  => '256375344488507',
      'secret' => '967d63f94f3f05bd20532851e7e37967',
      'cookie' => true
    ));
    
    if (!empty($_COOKIE['ptxbp_256375344488507'])) {
      $this->facebook->setAccessToken($_COOKIE['ptxbp_256375344488507']);
    }
    
    if (empty($_COOKIE['ptxbp_256375344488507']) && empty($_COOKIE['fbsr_256375344488507'])) {
      return false;
    }
    else {
      $this->user = $this->facebook->getUser();
      if ($this->user) {
        try {
          $this->user_profile = $this->facebook->api('/me');
        } catch (FacebookApiException $e) {
          $this->user = null;
          error_log('FB Error api(/me): '.$e);
        }
      }
      if ($this->user) {
        return true;
      }
      else {
        return false;
      }
    }
  }

  function parse_signed_request($signed_request) {
    list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
    $sig = $this->base64_url_decode($encoded_sig);
    $data = json_decode($this->base64_url_decode($payload), true);
    return $data;
  }
  
  function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
  }
  
  public function getLoginButton() {
    //$scope = 'email,user_likes,publish_actions,publish_stream'; /* offline_access */
    //return '<div class="fb-login-button" size="large" width="177px" perms="'.$scope.'">Login with Facebook</div>';
    //---
    //return '<input type="button" data-inline="true" onclick="fbLogin()" value="Login with Facebook" data-theme="b">';
    return '<a href="#" onclick="fbLogin(); return false;"><img src="http://www.playtexbabypool.com/dev/_/img/facebook-login-button.png" title="Login with Facebook" alt="Login with Facebook"></a>';
  }
  public function getID() {
    return $this->user_profile['id'];
  }
  public function getName() {
    return $this->user_profile['name'];
  }
  public function getFirstName() {
    return $this->user_profile['first_name'];
  }
  public function getLink() {
    return $this->user_profile['link'];
  }
  public function getProfileInfo() {
    return $this->user_profile;
  }
  public function setAccessToken($token) {
    return $this->facebook->setAccessToken($token);
  }
  public function getAccessToken() {
    return $this->facebook->getAccessToken();
  }
  public function getSignedRequest() {
    return $this->facebook->getSignedRequest();
  }
  public function listAppFriends() {
    //Ask FB Who is Friends with App
    $fql = 'SELECT uid FROM user WHERE uid IN (SELECT uid1 FROM friend WHERE uid2 = me() ) AND is_app_user';
    $params = array('method' => 'fql.query', 'query' =>$fql);
    $ids = array_map(function($item) { return $item['uid']; }, $this->facebook->api($params));
    $result = implode(', ', $ids);
    return $result;
  }
  public function listAllFriends() {
    return $this->facebook->api('/me/friends');
  }
  public function doesLikePage() {
    $userID = $this->getID();
    if ($userID == '100005159714253') { return true; }
    
    $fql = 'SELECT uid FROM page_fan WHERE uid='.$userID.' AND page_id=127836367257636'; //PLX BABY = 127836367257636
    $params = array('method' => 'fql.query', 'query' =>$fql);
    $result = $this->facebook->api($params);
    if (!empty($result) && $result[0]['uid'] == $userID) { return true; }
    else { return false; }
  }

  public function openGraph($action = NULL, $url = NULL) {
    try {
      $response = $this->facebook->api(
        '/me/playtexbabypool:'.$action,
        'POST',
        array('baby_pool' => $url)
      );
    } catch (FacebookApiException $e) {
      $response = null;
      error_log('FB Error API(openGraph): '.$e);
    }
    return $response;
  }
  
  /* unused */
  public function checkFriendship($userID1, $userID2) { }
  public function requestFriend($userID) { }
  public function hasLinked($pageID) { }
  public function requestLike($pageID) { }
  public function share($type, $content) { }
  public function notify($type, $content) { }
}