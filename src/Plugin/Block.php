<?php
/**
 * @file
 * Contains \Drupal\custom_user\Plugin\Block\HelloBlock.
 */
 
namespace Drupal\custom_user\Plugin\Block;
use Drupal\Core\Block\BlockBase;
 
/**
 * Provides a 'Hello' Block
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello block"),
 * )
 */
class HelloBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#markup' => $this->t('My block'),
    );
  }
 
}