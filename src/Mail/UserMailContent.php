<?php
/**
 * @file
 * Contains \Drupal\custom_user\Mail\UserMailContent.
 */

namespace Drupal\custom_user\Mail;
use Drupal\user;

class UserMailContent {
  protected static $instance = FALSE;

  protected function __construct(){}

  public static function instance(){
    if( ! static::$instance ){
      static::$instance = new static();
    }
    return static::$instance;
  }

  // Accuse de reception registration fidele
  public function accuseRegisterFidele(){
    
  }

}