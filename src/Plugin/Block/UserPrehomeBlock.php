<?php
/**
 * @file
 * Contains \Drupal\custom_user\Plugin\Block\UserPrehomeBlock.
 */
 
namespace Drupal\custom_user\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\user; 

/**
 * Provides a 'User Prehome' Block
 *
 * @Block(
 *   id = "UserPrehomeBlock",
 *   admin_label = @Translation("User Prehome block"),
 *   category = @Translation("Blocks")
 * )
 */
class UserPrehomeBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    // login
    $form = \Drupal::formBuilder()->getForm(\Drupal\user\Form\UserLoginForm::class) ;
    $render = \Drupal::service('renderer');
    $login_form = $render->renderPlain($form);

    //register
    $entity = \Drupal::entityTypeManager()->getStorage('user')->create(array());
    $formObject = \Drupal::entityTypeManager()
      ->getFormObject('user', 'register')
      ->setEntity($entity);
    $form = \Drupal::formBuilder()->getForm($formObject);
    $register_form = \Drupal::service('renderer')->render($form);

    return [
      '#theme' => 'user_prehome',
      '#intro' => $this->t('Connexion / Inscription'),
      '#loginForm' => $login_form,
      '#registerForm' => $register_form,
    ];
  }
 
}