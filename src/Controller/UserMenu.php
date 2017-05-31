<?php
/**
 * @file
 * Contains \Drupal\custom_user\Controller\UserMenu.
 */
 
namespace Drupal\custom_user\Controller;
 
use Drupal\Core\Controller\ControllerBase;
 
class UserMenu extends ControllerBase {
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('This is a test'),
    );
  }
}