<?php
/**
 * @file
 * Contains \Drupal\custom_user\Controller\UserTemplate.
 */
 
namespace Drupal\custom_user\Controller;
 
use Drupal\Core\Controller\ControllerBase;
use Drupal\user;
use Drupal\custom_user\UserAccountForm;
use Drupal\custom_user\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityInterface;

class UserTemplate extends ControllerBase {
  public function prehome() {
    $content = [];
    // text
    $content['text'] = $this->t('Vous devez etre membre pour pouvoir entrer dans le site');
    // user block
    $block_manager = \Drupal::service('plugin.manager.block');
    $block_config = [];
    $block_plugin = $block_manager->createInstance('UserPrehomeBlock', $block_config);
    $block_build = $block_plugin->build();
    $block_content = render($block_build);

    $content['block'] = $block_content;

    return [
      '#theme' => 'page_prehome',
      '#intro' => $this->t('Veuillez vous identifier !!!'),
      '#content' => $content,
    ];
  }
}