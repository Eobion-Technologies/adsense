<?php

/**
 * @file
 * Contains \Drupal\adsense\Plugin\Block\ManagedAdBlock.
 */

namespace Drupal\adsense\Plugin\Block;

use Drupal\adsense\AdBlockInterface;
use Drupal\adsense\Plugin\AdsenseAd\ManagedAd;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

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
      'ad_width' => '250',
      'ad_height' => '250',
      'ad_shape' => 'auto',
      'ad_align' => 'center',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function createAd() {
    $format = $this->configuration['ad_format'];
    if ($format == 'custom') {
      $format = $this->configuration['ad_width'] . 'x' . $this->configuration['ad_height'];
    }

    return new ManagedAd([
      'format' => $format,
      'slot' => $this->configuration['ad_slot'],
      'shape' => $this->configuration['ad_shape'],
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Set up ad alignment.
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
    return $this->createAd()->display($classes);
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    // Hide block title by default.
    $form['label_display']['#default_value'] = FALSE;

    $link = Link::fromTextAndUrl(t('Google AdSense account page'), Url::fromUri('https://www.google.com/adsense/app#main/myads-springboard'))->toString();

    $ad_list = [];
    foreach (ManagedAd::adsenseAdFormats() as $format => $data) {
      $ad_list[$format] = $format . ' : ' . $data['desc'];
    }

    $form['ad_slot'] = [
      '#type' => 'textfield',
      '#title' => t('Ad ID'),
      '#default_value' => $this->configuration['ad_slot'],
      '#description' => t('This is the Ad ID from your @adsensepage, such as 1234567890.',
        ['@adsensepage' => $link]),
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
      '#type' => 'number',
      '#title' => t('Width'),
      '#default_value' => $this->configuration['ad_width'],
      '#description' => t('Custom ad width.'),
      '#field_suffix' => ' ' . t('pixels'),
      '#size' => 3,
      '#maxlength' => 4,
      '#min' => 120,
      '#max' => 1200,
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
      '#type' => 'number',
      '#title' => t('Height'),
      '#default_value' => $this->configuration['ad_height'],
      '#description' => t('Custom ad height.'),
      '#field_suffix' => ' ' . t('pixels'),
      '#size' => 3,
      '#maxlength' => 4,
      '#min' => 50,
      '#max' => 1200,
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

}
