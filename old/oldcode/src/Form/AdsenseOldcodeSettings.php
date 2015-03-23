<?php

/**
 * @file
 * Contains \Drupal\adsense_oldcode\Form\AdsenseOldcodeSettings.
 */

namespace Drupal\adsense_oldcode\Form;

use Drupal\Component\Utility\String;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

class AdsenseOldcodeSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'adsense_oldcode_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['adsense_oldcode.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = \Drupal::config('adsense_oldcode.settings');

    $form['types_colors'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => t('Ad groups'),
    ];

    for ($group = 1; $group <= $config->get('adsense_max_groups'); $group++) {
      $title = $config->get('adsense_group_title_' . $group);
      $form['types_colors']['groups'][$group] = [
        '#type' => 'details',
        '#open' => FALSE,
        '#title' => t('Group @group attributes', ['@group' => $group . (!empty($title) ? " ($title)" : '')]),
      ];

      $form['types_colors']['groups'][$group]['adsense_group_title_' . $group] = [
        '#type' => 'textfield',
        '#title' => t('Title'),
        '#default_value' => $title,
        '#size' => 100,
        '#maxlength' => 100,
        '#description' => t('Title of the group.'),
      ];

      $form['types_colors']['groups'][$group]['adsense_ad_type_' . $group] = [
        '#type' => 'radios',
        '#title' => t('Ad type'),
        '#default_value' => $config->get('adsense_ad_type_' . $group),
        '#options' => [t('Text'), t('Image'), t('Both')],
      ];

      // Add Farbtastic color picker.
      $form['types_colors']['groups'][$group]['colorpicker'] = [
        '#type' => 'markup',
        '#markup' => "<div id='colorpicker-$group' style='float: right;'></div>",
      ];

      $form['types_colors']['groups'][$group]['adsense_color_text_' . $group] = [
        '#type' => 'textfield',
        '#title' => t('Text color'),
        '#default_value' => $config->get('adsense_color_text_' . $group),
        '#size' => 7,
        '#maxlength' => 7,
        '#pattern' => '#[a-fA-F0-9]{6}',
      ];

      $form['types_colors']['groups'][$group]['adsense_color_border_' . $group] = [
        '#type' => 'textfield',
        '#title' => t('Border color'),
        '#default_value' => $config->get('adsense_color_border_' . $group),
        '#size' => 7,
        '#maxlength' => 7,
        '#pattern' => '#[a-fA-F0-9]{6}',
      ];

      $form['types_colors']['groups'][$group]['adsense_color_bg_' . $group] = [
        '#type' => 'textfield',
        '#title' => t('Background color'),
        '#default_value' => $config->get('adsense_color_bg_' . $group),
        '#size' => 7,
        '#maxlength' => 7,
        '#pattern' => '#[a-fA-F0-9]{6}',
      ];

      $form['types_colors']['groups'][$group]['adsense_color_link_' . $group] = [
        '#type' => 'textfield',
        '#title' => t('Title color'),
        '#default_value' => $config->get('adsense_color_link_' . $group),
        '#size' => 7,
        '#maxlength' => 7,
        '#pattern' => '#[a-fA-F0-9]{6}',
      ];

      $form['types_colors']['groups'][$group]['adsense_color_url_' . $group] = [
        '#type' => 'textfield',
        '#title' => t('URL color'),
        '#default_value' => $config->get('adsense_color_url_' . $group),
        '#size' => 7,
        '#maxlength' => 7,
        '#pattern' => '#[a-fA-F0-9]{6}',
      ];

      $form['types_colors']['groups'][$group]['adsense_alt_' . $group] = [
        '#type' => 'select',
        '#title' => t('Alternate URL color'),
        '#default_value' => $config->get('adsense_alt_' . $group),
        '#options' => [
          t('None'),
          t('Alternate URL'),
          t('Alternate color'),
        ],
      ];

      $form['types_colors']['groups'][$group]['adsense_alt_info_' . $group] = [
        '#type' => 'textfield',
        '#title' => t('Alternate info'),
        '#default_value' => $config->get('adsense_alt_info_' . $group),
        '#size' => 100,
        '#maxlength' => 100,
        '#description' => t('Enter either 6 letter alternate color code, or alternate URL to use'),
        '#states' => [
          'invisible' => [
            ":input[name='adsense_alt_{$group}']" => ['value' => 0],
          ],
        ],
      ];

      $form['types_colors']['groups'][$group]['adsense_ui_features_' . $group] = [
        '#type' => 'select',
        '#title' => t('Rounded corners'),
        '#default_value' => $config->get('adsense_ui_features_' . $group),
        '#options' => [
          'rc:0' => 'Square',
          'rc:6' => 'Slightly rounded',
          'rc:10' => 'Very rounded',
        ],
        '#description' => t('Choose type of round corners'),
      ];
    }

    $form['channels'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => t('Custom channels'),
      '#description' => t('Enter up to !channels custom channels that you have configured in Google AdSense. If you are not using custom channels, or you are only using URL channels, then leave this empty.', [
        '!channels' => ADSENSE_MAX_CHANNELS
        ]),
    ];

    for ($channel = 1; $channel <= ADSENSE_MAX_CHANNELS; $channel++) {
      $form['channels']['adsense_ad_channel_' . $channel] = [
        '#type' => 'textfield',
        '#title' => t('Custom channel ID') . ' ' . $channel,
        '#default_value' => $config->get('adsense_ad_channel_' . $channel),
        '#size' => 30,
        '#maxlength' => 30,
      ];
    }

    $form['#attached']['library'] = ['adsense_oldcode/adsense_oldcode.colorpicker'];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::configFactory()->getEditable('adsense_oldcode.settings');
    $form_state->cleanValues();

    foreach ($form_state->getValues() as $key => $value) {
      $config->set($key, String::checkPlain($value));
    }
    $config->save();
  }

}
