<?php

/**
 * @file
 * Contains \Drupal\adsense_search\Plugin\Block\SearchAdBlock.
 */

namespace Drupal\adsense_search\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;

use Drupal\adsense\AdBlockInterface;
use Drupal\adsense_search\Plugin\AdsenseAd\SearchAd;

/**
 * Provides an AdSense Custom Search ad block.
 *
 * @Block(
 *   id = "adsense_search_ad_block",
 *   admin_label = @Translation("Old search"),
 *   category = @Translation("Adsense")
 * )
 */
class SearchAdBlock extends BlockBase implements AdBlockInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'ad_slot' => '',
    ];
  }

  public function createAd() {
    return new SearchAd(['channel' => $this->configuration['ad_channel']]);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'markup',
      '#markup' => $this->createAd()->display(),
      '#attached' => ['library' => ['adsense/adsense']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $config = \Drupal::config('adsense_search.settings');
    $channel_list[''] = t('None');
    for ($channel = 1; $channel <= ADSENSE_MAX_CHANNELS; $channel++) {
      $channel_list[$channel] = $channel . ' : ' . $config->get('adsense_ad_channel_' . $channel);
    }

    $form['ad_channel'] = [
      '#type' => 'select',
      '#title' => t('Channel'),
      '#default_value' => $this->configuration['ad_channel'],
      '#options' => $channel_list,
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
    $this->configuration['ad_channel'] = $form_state->getValue('ad_channel');
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
