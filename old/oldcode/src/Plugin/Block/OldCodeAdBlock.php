<?php

/**
 * @file
 * Contains \Drupal\adsense_oldcode\Plugin\Block\OldCodeAdBlock.
 */

namespace Drupal\adsense_oldcode\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;

use Drupal\adsense\AdBlockInterface;
use Drupal\adsense_oldcode\Plugin\AdsenseAd\OldCodeAd;

/**
 * Provides an AdSense oldcode ad block.
 *
 * @Block(
 *   id = "adsense_oldcode_ad_block",
 *   admin_label = @Translation("Old code ad"),
 *   category = @Translation("Adsense")
 * )
 */
class OldCodeAdBlock extends BlockBase implements AdBlockInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'ad_format' => '250x250',
      'ad_group' => 1,
      'ad_channel' => 1,
      'ad_align' => 'center',
    ];
  }

  public function createAd() {
    return new OldCodeAd([
      'format' => $this->configuration['ad_format'],
      'group' => $this->configuration['ad_group'],
      'channel' => $this->configuration['ad_channel']
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $classes = [];
    switch ($this->configuration['ad_align']) {
      case 'left':
        $classes[] = 'text-align-left';
        break;

      case 'center':
        $classes[] = 'text-align-center';
        break;

      case 'right':
        $classes[] = 'text-align-right';
        break;
    }
    $class = implode(' ', $classes);

    $text = $this->createAd()->display();

    return [
      '#type' => 'markup',
      '#markup' => "<div class='$class'>{$text}</div>",
      '#attached' => ['library' => ['adsense/adsense']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $config = \Drupal::config('adsense_oldcode.settings');

    $ad_list = [];
    foreach (OldCodeAd::adsenseAdFormats() as $format => $data) {
      $ad_list[$format] = $format . ' : ' . $data['desc'];
    }

    $group_list = [];
    for ($group = 1; $group <= $config->get('adsense_max_groups'); $group++) {
      $group_list[$group] = $group . ' : ' . $config->get('adsense_group_title_' . $group);
    }

    $channel_list[''] = t('None');
    for ($channel = 1; $channel <= ADSENSE_MAX_CHANNELS; $channel++) {
      $channel_list[$channel] = $channel . ' : ' . $config->get('adsense_ad_channel_' . $channel);
    }

    $form['ad_format'] = [
      '#type' => 'select',
      '#title' => t('Ad format'),
      '#default_value' => $this->configuration['ad_format'],
      '#options' => $ad_list,
      '#description' => t('Select the ad dimensions you want for this block.'),
      '#required' => TRUE,
    ];

    $form['ad_group'] = [
      '#type' => 'select',
      '#title' => t('Group'),
      '#default_value' => $this->configuration['ad_group'],
      '#options' => $group_list,
    ];

    $form['ad_channel'] = [
      '#type' => 'select',
      '#title' => t('Channel'),
      '#default_value' => $this->configuration['ad_channel'],
      '#options' => $channel_list,
    ];

    $form['ad_align'] = [
      '#type' => 'select',
      '#title' => t('Ad alignment'),
      '#default_value' => $this->configuration['ad_align'],
      '#options' => [
        '' => t('None'),
        'left' => t('Left'),
        'center' => t('Centered'),
        'right' => t('Right'),
      ],
      '#description' => t('Select the horizontal alignment of the ad within the block.'),
    ];

    $form['cache']['#disabled'] = TRUE;
    $form['cache']['max_age']['#value'] = 0;
    $form['cache']['#description'] = t('This block is always cached forever, it is not configurable.');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['ad_format'] = $form_state->getValue('ad_format');
    $this->configuration['ad_group'] = $form_state->getValue('ad_group');
    $this->configuration['ad_channel'] = $form_state->getValue('ad_channel');
    $this->configuration['ad_align'] = $form_state->getValue('ad_align');
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    /* return Cache::PERMANENT;*/
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function isCacheable() {
    /*return TRUE;*/
    return FALSE;
  }

}
