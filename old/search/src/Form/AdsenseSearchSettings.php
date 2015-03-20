<?php

/**
 * @file
 * Contains \Drupal\adsense_search\Form\AdsenseSearchSettings.
 */

namespace Drupal\adsense_search\Form;

use Drupal\Component\Utility\String;
use Drupal\Component\Utility\Unicode;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

use Drupal\adsense_search\Plugin\AdsenseAd\SearchAd;

class AdsenseSearchSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'adsense_search_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['adsense_search.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    module_load_include('inc', 'adsense', 'includes/adsense.search_options');

    $config = \Drupal::config('adsense_search.settings');

    $form['searchbox'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => t('Search Box Options'),
      '#description' => t("Allows users to search the web or the specific site(s) of your choice. Enter the site's URL without the last '/'"),
    ];

    for ($i = 0; $i <= 2; $i++) {
      $form['searchbox']['adsense_search_domain_' . $i] = [
        '#type' => 'textfield',
        '#field_prefix' => 'http://',
        '#default_value' => $config->get('adsense_search_domain_' . $i),
        '#size' => 32,
        '#maxlength' => 255,
      ];
    }

    $form['searchbox']['adsense_search_safe_mode'] = [
      '#type' => 'checkbox',
      '#title' => t('Use SafeSearch'),
      '#default_value' => $config->get('adsense_search_safe_mode'),
    ];

    $form['searchbox']['adsense_search_logo'] = [
      '#type' => 'radios',
      '#title' => t('Logo Type'),
      '#default_value' => $config->get('adsense_search_logo'),
      '#options' => [
        'adsense_search_logo_google' => t('Google Logo'),
        'adsense_search_logo_above_textbox' => t('Logo above text box'),
        'adsense_search_logo_on_button' => t('"Google Search" on button'),
      ],
    ];

    $form['searchbox']['adsense_search_button'] = [
      '#type' => 'checkbox',
      '#title' => t('Search button below text box'),
      '#default_value' => $config->get('adsense_search_button'),
    ];

    $form['searchbox']['adsense_search_color_box_background'] = [
      '#type' => 'select',
      '#title' => t('Background color'),
      '#default_value' => $config->get('adsense_search_color_box_background'),
      '#options' => [
        '#FFFFFF' => t('White'),
        '#000000' => t('Black'),
        '#CCCCCC' => t('Gray'),
      ],
    ];

    $form['searchbox']['adsense_search_color_box_text'] = [
      '#type' => 'select',
      '#title' => t('Text color'),
      '#default_value' => $config->get('adsense_search_color_box_text'),
      '#options' => [
        '#000000' => t('Black'),
        '#FFFFFF' => t('White'),
      ],
    ];

    $form['searchbox']['adsense_search_language'] = [
      '#type' => 'select',
      '#title' => t('Site Language'),
      '#default_value' => $config->get('adsense_search_language'),
      '#options' => SearchAd::adsenseLanguages(),
    ];

    $form['searchbox']['adsense_search_encoding'] = [
      '#type' => 'select',
      '#title' => t('Site Encoding'),
      '#default_value' => $config->get('adsense_search_encoding'),
      '#options' => SearchAd::adsenseEncodings(),
    ];

    $form['searchbox']['adsense_search_textbox_length'] = [
      '#type' => 'textfield',
      '#title' => t('Length of text box (Max 64)'),
      '#default_value' => $config->get('adsense_search_textbox_length'),
      '#size' => 2,
      '#maxlength' => 2,
    ];

    $form['result'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => t('Search Results Style'),
    ];

    $form['result']['adsense_search_country'] = [
      '#type' => 'select',
      '#title' => t('Country or territory for Google domain'),
      '#default_value' => $config->get('adsense_search_country'),
      '#options' => SearchAd::adsenseCountries(),
    ];

    $form['result']['adsense_search_frame_width'] = [
      '#type' => 'textfield',
      '#title' => t('Width of results area'),
      '#default_value' => $config->get('adsense_search_frame_width'),
      '#size' => 4,
      '#maxlength' => 4,
    ];

    $form['result']['colors'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => t('Color attributes'),
    ];

    // Add Farbtastic color picker.
    $form['result']['colors']['colorpicker'] = [
      '#type' => 'markup',
      '#markup' => '<div id="colorpicker" style="float:right;"></div>',
    ];

    $form['result']['colors']['adsense_search_color_border'] = [
      '#type' => 'textfield',
      '#title' => t('Border'),
      '#default_value' => $config->get('adsense_search_color_border'),
      '#size' => 7,
      '#maxlength' => 7,
    ];

    $form['result']['colors']['adsense_search_color_title'] = [
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#default_value' => $config->get('adsense_search_color_title'),
      '#size' => 7,
      '#maxlength' => 7,
    ];

    $form['result']['colors']['adsense_search_color_bg'] = [
      '#type' => 'textfield',
      '#title' => t('Background'),
      '#default_value' => $config->get('adsense_search_color_bg'),
      '#size' => 7,
      '#maxlength' => 7,
    ];

    $form['result']['colors']['adsense_search_color_text'] = [
      '#type' => 'textfield',
      '#title' => t('Text'),
      '#default_value' => $config->get('adsense_search_color_text'),
      '#size' => 7,
      '#maxlength' => 7,
    ];

    $form['result']['colors']['adsense_search_color_url'] = [
      '#type' => 'textfield',
      '#title' => t('URL'),
      '#default_value' => $config->get('adsense_search_color_url'),
      '#size' => 7,
      '#maxlength' => 7,
    ];

    $form['result']['colors']['adsense_search_color_visited_url'] = [
      '#type' => 'textfield',
      '#title' => t('Visited URL'),
      '#default_value' => $config->get('adsense_search_color_visited_url'),
      '#size' => 7,
      '#maxlength' => 7,
    ];

    $form['result']['colors']['adsense_search_color_light_url'] = [
      '#type' => 'textfield',
      '#title' => t('Light URL'),
      '#default_value' => $config->get('adsense_search_color_light_url'),
      '#size' => 7,
      '#maxlength' => 7,
    ];

    $form['result']['colors']['adsense_search_color_logo_bg'] = [
      '#type' => 'hidden',
      '#title' => t('Logo Background'),
      '#default_value' => $config->get('adsense_search_color_logo_bg'),
      '#size' => 7,
      '#maxlength' => 7,
    ];

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
        '#default_value' => $config->get('adsense_ad_channel_' . $channel, ADSENSE_AD_CHANNEL_DEFAULT),
        '#size' => 30,
        '#maxlength' => 30,
      ];
    }

    $form['#attached']['library'] = ['adsense_search/adsense_search.colorpicker'];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $textbox_length = $form_state->getValue('adsense_search_textbox_length');
    $min = 8;
    $max = 64;
    if (($textbox_length < $min) || ($textbox_length > $max)) {
      $form_state->setErrorByName('adsense_search_textbox_length', $this->t("Text Box Length must be between !min and !max", ['!min' => $min, '!max' => $max]));
    }

    $colors = [
      'adsense_search_color_border',
      'adsense_search_color_title',
      'adsense_search_color_bg',
      'adsense_search_color_text',
      'adsense_search_color_url',
      'adsense_search_color_visited_url',
      'adsense_search_color_light_url',
      'adsense_search_color_logo_bg',
    ];

    foreach ($colors as $field_name) {
      $field_value = $form_state->getValue($field_name);
      $form_state->setValueForElement($form['result']['colors'][$field_name], Unicode::strtoupper($field_value));
      if (!preg_match('/#[0-9A-F]{6}/i', $field_value)) {
        $form_state->setErrorByName($field_name, $this->t("Color must be between #000000 and #FFFFFF"));
      }
    }

    $box_background_color = $form_state->getValue('adsense_search_color_box_background');
    if ($box_background_color == '#000000') {
      $form_state->setValueForElement($form['searchbox']['adsense_search_color_box_text'], '#FFFFFF');
    }
    elseif ($box_background_color == '#FFFFFF') {
      $form_state->setValueForElement($form['searchbox']['adsense_search_color_box_text'], '#000000');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::configFactory()->getEditable('adsense_search.settings');
    $form_state->cleanValues();

    foreach ($form_state->getValues() as $key => $value) {
      $config->set($key, String::checkPlain($value));
    }
    $config->save();
  }

}
