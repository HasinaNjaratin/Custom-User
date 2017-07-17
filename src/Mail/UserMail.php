<?php
/**
 * @file
 * Contains \Drupal\custom_user\Mail\UserMail.
 */
 
namespace Drupal\custom_user\Mail;
use Drupal\user;

class UserMail {

  public function accuseRegisterFidele(\Drupal\user\Entity\User $gUser) {
    $mailManager = \Drupal::service('plugin.manager.mail');
    $key = 'accuse_inscription_fidele';
    $to = $gUser->getEmail();
    // Set up email template
    $message = [ 
      '#theme' => 'user_mail_tpl',
      '#logo' => base_path().drupal_get_path('module', 'custom_user')."/images/logo-mail.png", 
      '#title' => 'Inscription fidele',
      '#greeting' => 'Bonjour '.$gUser->get('field_prenom')->value.' '.$gUser->get('field_nom')->value, 
      '#introduction' => 'Nous vous remercions de l’intérêt que vous nous portez.', 
      '#contenu' => [
        'Nom' => $gUser->get('field_nom')->value,
        'Prenom' => $gUser->get('field_prenom')->value,
        'Date de naissance' => $gUser->get('field_date_de_naissance')->value,
        'Mobile' => $gUser->get('field_mobile')->value,
      ], 
      '#conclusion' => 'Vous serez prochainement contacté(e) par un responsable commercial afin de valider votre inscription.'
    ];
    $params['message'] = \Drupal::service('renderer')->render($message);
    $langcode = \Drupal::currentUser()->getPreferredLangcode();
    $result = $mailManager->mail('custom_user', $key, $to, $langcode, $params, NULL, true);
    return $result['result'];
  }
}