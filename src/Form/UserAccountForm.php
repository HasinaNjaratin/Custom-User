<?php
/**
 * @file
 * Contains \Drupal\custom_user\Form\UserAccountForm.
 */
 
namespace Drupal\custom_user\form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user;

class UserAccountForm extends \Drupal\user\ProfileForm {
  
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_custom_account_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    return $form;
  }

  /**
  * {@inheritdoc}
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
  }

  
}