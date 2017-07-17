<?php
/**
 * @file
 * Contains \Drupal\custom_user\Controller\UserMenu.
 */
 
namespace Drupal\custom_user\Controller;
 
use Drupal\Core\Controller\ControllerBase;
use Drupal\custom_user\Form;
class UserMenu extends ControllerBase {
  public function fideleForm() {
    $form = \Drupal::formBuilder()->getForm('\Drupal\custom_user\Form\UserFideleRegisterForm');
    return $form;
  }
}