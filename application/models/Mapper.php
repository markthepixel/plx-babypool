<?php

class Mapper {
  public static $mapper = array(
    '/^\/dev\/?(index\.php\/?)?(\?.*?)?$/' => 'Play',

    '/^\/dev\/working\/?(index\.php\/?)?(\?.*?)?$/' => 'SomeView',
    '/^\/dev\/howtoplay\/?(index\.php\/?)?(\?.*?)?$/' => 'HowToPlay',
    
    '/^\/dev\/create\/?(index\.php\/?)?(\?.*?)?$/' => 'PoolCreateChoice',
    '/^\/dev\/create\/mother\/?(index\.php\/?)?(\?.*?)?$/' => 'PoolCreateMother',
    '/^\/dev\/create\/organizer\/?(index\.php\/?)?(\?.*?)?$/' => 'PoolCreateOrganizer',
    '/^\/dev\/create\/organizer\/[0-9]+(\/index.php)?\/?(\?[^=]+=\S*)?$/' => 'PoolOrgToMother',

    '/^\/dev\/invite\/[0-9]+(\/index.php)?\/?(\?[^=]+=\S*)?$/' => 'SendInvite',
    
    '/^\/dev\/pool\/[0-9]+(\/index.php)?\/?(\?[^=]+=\S*)?$/' => 'PoolSingle',
    '/^\/dev\/pool\/[0-9]+\/edit(\/index.php)?\/?(\?[^=]+=\S*)?$/' => 'PoolEdit',
    //'/^\/dev\/pool\/[0-9]+\/cancel(\/index.php)?\/?(\?[^=]+=\S*)?$/' => 'PoolCancel',
  );
  
  public static function checkPageState($requestURI) {
    foreach (self::$mapper as $key => $value) {
      if (preg_match($key, $requestURI)) {
        $match = $value;
      }
    }
    if (!empty($match)) { return $match; }
    else { return false; }
  }
  
  public static function getPoolID($requestURI) {
    $regex = '/([0-9]+)/';
    preg_match($regex, $requestURI, $matches);
    return $matches;
  }
  
}