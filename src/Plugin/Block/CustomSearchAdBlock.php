<?php

/**
 * @file
 * Contains \Drupal\adsense\Plugin\Block\CustomSearchAdBlock.
 */

namespace Drupal\adsense\Plugin\Block;

use Drupal\adsense\AdBlockInterface;
use Drupal\adsense\Plugin\AdsenseAd\CustomSearchAd;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides an AdSense Custom Search ad block.
 *
 * @Block(
 *   id = "adsense_cse_ad_block",
 *   admin_label = @Translation("Custom search"),
 *   category = @Translation("Adsense")
 * )
 */
class CustomSearchAdBlock extends BlockBase implements AdBlockInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'ad_slot' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function createAd() {
    return new CustomSearchAd([
      'slot' => $this->configuration['ad_slot'],
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return $this->createAd()->display();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $link = Link::fromTextAndUrl(t('Google AdSense account page'), Url::fromUri('https://www.google.com/adsense/app#main/myads-springboard'))->toString();

    $form['ad_slot'] = [
      '#type' => 'textfield',
      '#title' => t('Ad ID'),
      '#default_value' => $this->configuration['ad_slot'],
      '#description' => t('This is the Ad ID from your @adsensepage, such as 1234567890.', ['@adsensepage' => $link]),
      '#required' => TRUE,
    ];

    $form['cache']['#disabled'] = TRUE;
    $form['cache']['max_age']['#value'] = Cache::PERMANENT;
    $form['cache']['#description'] = t('This block is always cached forever, it is not configurable.');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['ad_slot'] = $form_state->getValue('ad_slot');
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    /*return Cache::PERMANENT;*/
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function isCacheable() {
    return TRUE;
  }

}