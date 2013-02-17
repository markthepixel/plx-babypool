<?php

/**
* The Advertisment class is a simple class to display the Advertisment code
*/
class Advertisement {
  private static $codeDesktop = '<div class="advertisement"><a href="http://www.playtexbaby.com/DiaperGenie/Diaper-Genie-Elite.aspx" target="_blank"><img width="260" height="180" src="http://www.playtexbabypool.com/dev/_/img/ad_desktop.jpg" /></a></div>';
  private static $codeMobile  = '<div class="advertisement"><a href="http://www.playtexbaby.com/DiaperGenie/Diaper-Genie-Elite.aspx" target="_blank"><img width="320" height="100" src="http://www.playtexbabypool.com/dev/_/img/ad_mobile.jpg"  /></a></div>';
  
  public static function getAdBlock() { return self::$codeDesktop; }
  public static function getAdMobile() { return self::$codeMobile; }
}