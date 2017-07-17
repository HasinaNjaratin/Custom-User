<?php
/**
 * @file
 * Contains \Drupal\custom_user\Form\UserFideleRegisterForm.
 */
 
namespace Drupal\custom_user\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\custom_user\Controller;
use Drupal\custom_user\Mail;

class UserFideleRegisterForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_fidele_register_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    global $user;
    $form['utilisateur_nom'] = array(
      '#type' => 'textfield',
      '#title' => t('Nom:'),
      '#required' => TRUE,
      '#default_value' => '',
    );
    $form['utilisateur_prenom'] = array(
      '#type' => 'textfield',
      '#title' => t('Prénom:'),
      '#required' => TRUE,
    );
    $form['utilisateur_mail'] = array(
      '#type' => 'email',
      '#title' => t('Email ID:'),
      '#required' => TRUE,
      '#default_value' => '',
    );
    $form['utilisateur_phone'] = array (
      '#type' => 'tel',
      '#title' => t('Mobile no'),
    );
    $form['utilisateur_dob'] = array (
      '#type' => 'date',
      '#title' => t('Date de naissance'),
      '#required' => TRUE,
    );
    $form['utilisateur_gender'] = array (
      '#type' => 'select',
      '#title' => ('Gendre'),
      '#options' => array(
        'Madame' => t('Madame'),
        'Monsieur' => t('Monsieur'),
      ),
    );
    $form['utilisateur_confirmation'] = array (
      '#type' => 'radios',
      '#title' => ('Avez-vous plus de 18ans?'),
      '#options' => array(
        'Yes' =>t('Yes'),
        'No' =>t('No')
      ),
    );
    $form['utilisateur_sendMail'] = array(
      '#type' => 'checkbox',
      '#title' => t('M\'envoyer un mail de confirmation.'),
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // phone validation
    if(!empty($form_state->getValue('utilisateur_phone'))){
      $split_phone = str_split($form_state->getValue('utilisateur_phone'));
      if( $split_phone[0] != '0' || !is_numeric($phone) && count($split_phone) != 10 ){
        $form_state->setErrorByName('utilisateur_phone', $this->t('Votre numero de téléphone n\'est pas au bon format.'));
      }
    }
    // age gate
    if($form_state->getValue('utilisateur_confirmation') != 'Yes'){
      $form_state->setErrorByName('utilisateur_confirmation', $this->t('Vous devez etre majeur pour devenir un membre fidèle.'));
    }
    // deja fidele
    if($gUser = user_load_by_mail($form_state->getValue('utilisateur_mail'))){
      if($gUser->hasRole('fidele')){ 
        $form_state->setErrorByName('utilisateur_mail', $this->t('Vous etes déjà un membre fidèle.')); 
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // insert/update user
    if(user_load_by_mail($form_state->getValue('utilisateur_mail'))){
      $user = user_load_by_mail($form_state->getValue('utilisateur_mail'));
    }else{
      $user = \Drupal\user\Entity\User::create();
      $user->setEmail($form_state->getValue('utilisateur_mail'));
    }
    $user->setUsername($form_state->getValue('utilisateur_prenom')."_".$form_state->getValue('utilisateur_nom'));
    $user->set("field_nom", $form_state->getValue('utilisateur_nom'));
    $user->set("field_prenom", $form_state->getValue('utilisateur_prenom'));
    $user->set("field_mobile", $form_state->getValue('utilisateur_phone'));
    $user->set("field_date_de_naissance", $form_state->getValue('utilisateur_dob'));
    $user->removeRole('collaborateur');
    $user->addRole('fidele');
    $userss = $user->save();
    drupal_set_message($this->t('@user_apellation, Votre demande est bien envoyée!', array('@user_apellation' => $form_state->getValue('utilisateur_gender')." ".$form_state->getValue('utilisateur_prenom')." ".$form_state->getValue('utilisateur_nom'))));
    // send mail
    if($form_state->getValue('utilisateur_sendMail')){ 
      $sendMail = \Drupal\custom_user\Mail\UserMail::accuseRegisterFidele($user);
    }

    $this->redirect('<front>'); // drupal go to homepage
  }


}