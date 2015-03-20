<?php

/**
 * @file
 * Contains \Drupal\adsense_managed\Plugin\Block\ManagedAdBlock.
 */

namespace Drupal\adsense_managed\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;

use Drupal\adsense\AdBlockInterface;
use Drupal\adsense_managed\Plugin\AdsenseAd\ManagedAd;

/**
 * Provides an AdSense managed ad block.
 *
 * @Block(
 *   id = "adsense_managed_ad_block",
 *   admin_label = @Translation("Managed ad"),
 *   category = @Translation("Adsense")
 * )
 */
class ManagedAdBlock extends BlockBase implements AdBlockInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'ad_slot' => '',
      'ad_format' => '250x250',
      'ad_width' => '',
      'ad_height' => '',
      'ad_shape' => 'auto',
      'ad_align' => 'center',
    ];
  }

  public function createAd() {
    $format = $this->configuration['ad_format'];
    if ($format == 'custom') {
      $format = $this->configuration['ad_width'] . 'x' . $this->configuration['ad_height'];
    }

    return new ManagedAd([
      'format' => $format,
      'slot' => $this->configuration['ad_slot'],
      'shape' => $this->configuration['ad_shape']
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

    $ad_list = [];
    foreach (ManagedAd::adsenseAdFormats() as $format => $data) {
      $ad_list[$format] = $format . ' : ' . $data['desc'];
    }

    $form['ad_slot'] = [
      '#type' => 'textfield',
      '#title' => t('Ad Slot ID'),
      '#default_value' => $this->configuration['ad_slot'],
      '#description' => t('This is the Ad Slot ID from your Google Adsense account, such as 0123456789.'),
      '#required' => TRUE,
    ];

    $form['ad_format'] = [
      '#type' => 'select',
      '#title' => t('Ad format'),
      '#default_value' => $this->configuration['ad_format'],
      '#options' => $ad_list,
      '#description' => t('Select the ad dimensions you want for this block.'),
      '#required' => TRUE,
    ];

    $form['ad_width'] = [
      '#type' => 'textfield',
      '#title' => t('Width'),
      '#default_value' => $this->configuration['ad_width'],
      '#description' => t('Custom ad width.'),
      '#states' => [
        'enabled' => [
          ':input[name="settings[ad_format]"]' => ['value' => 'custom'],
        ],
        'visible' => [
          ':input[name="settings[ad_format]"]' => ['value' => 'custom'],
        ],
        'required' => [
          ':input[name="settings[ad_format]"]' => ['value' => 'custom'],
        ],
      ],
    ];

    $form['ad_height'] = [
      '#type' => 'textfield',
      '#title' => t('Height'),
      '#default_value' => $this->configuration['ad_height'],
      '#description' => t('Custom ad height.'),
      '#states' => [
        'enabled' => [
          ':input[name="settings[ad_format]"]' => ['value' => 'custom'],
        ],
        'visible' => [
          ':input[name="settings[ad_format]"]' => ['value' => 'custom'],
        ],
        'required' => [
          ':input[name="settings[ad_format]"]' => ['value' => 'custom'],
        ],
      ],
    ];

    $form['ad_shape'] = [
      '#type' => 'select',
      '#title' => t('Responsive ad shape'),
      '#default_value' => $this->configuration['ad_shape'],
      '#multiple' => TRUE,
      '#options' => [
        'auto' => t('Auto-sizing'),
        'horizontal' => t('Horizontal'),
        'vertical' => t('Vertical'),
        'rectangle' => t('Rectangle'),
      ],
      '#description' => t("Shape of the responsive ad unit. Google's default is 'auto' for auto-sizing behaviour, but can also be a combination of one or more of the following: 'rectangle', 'vertical' or 'horizontal'."),
      '#states' => [
        'visible' => [
          ':input[name="settings[ad_format]"]' => ['value' => 'responsive'],
        ],
      ],
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
    $this->configuration['ad_slot'] = $form_state->getValue('ad_slot');
    $this->configuration['ad_format'] = $form_state->getValue('ad_format');
    $this->configuration['ad_width'] = $form_state->getValue('ad_width');
    $this->configuration['ad_height'] = $form_state->getValue('ad_height');
    $this->configuration['ad_shape'] = $form_state->getValue('ad_shape');
    $this->configuration['ad_align'] = $form_state->getValue('ad_align');
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
    /*return TRUE;*/
    return FALSE;
  }

}
