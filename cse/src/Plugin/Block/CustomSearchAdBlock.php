<?php

/**
 * @file
 * Contains \Drupal\adsense_cse\Plugin\Block\CustomSearchAdBlock.
 */

namespace Drupal\adsense_cse\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;

use Drupal\adsense\AdBlockInterface;
use Drupal\adsense_cse\Plugin\AdsenseAd\CustomSearchAd;

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

  public function createAd() {
    return new CustomSearchAd(['slot' => $this->configuration['ad_slot']]);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    /*$config = \Drupal::config('adsense_cse.settings');
    if ($config->get('adsense_cse_logo') == 'adsense_cse_branding_watermark') {
      $libraries[] = 'adsense_cse/adsense_cse.searchbox';
    }*/

    return $this->createAd()->display();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $form['ad_slot'] = [
      '#type' => 'textfield',
      '#title' => t('Ad Slot ID'),
      '#default_value' => $this->configuration['ad_slot'],
      '#description' => t('This is provided by the AdSense site in the Search Box Code "cx" field.  This is usually provided in the form partner-<em>Publisher ID</em>:<em>Slot Id</em>.  If the code provided is, for example, partner-pub-xxxxxxxxxx:<strong>yyyyyyyyyy</strong>, then insert only <strong>yyyyyyyyyy</strong> here.'),
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
