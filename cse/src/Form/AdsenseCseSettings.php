<?php

/**
 * @file
 * Contains \Drupal\adsense_cse\Form\AdsenseCseSettings.
 */

namespace Drupal\adsense_cse\Form;

use Drupal\Component\Utility\String;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

use Drupal\adsense_cse\Plugin\AdsenseAd\CustomSearchAd;

class AdsenseCseSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'adsense_cse_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['adsense_cse.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    module_load_include('inc', 'adsense_cse', 'help/adsense_cse.help');
    module_load_include('inc', 'adsense', 'includes/adsense.search_options');

    $config = \Drupal::config('adsense_cse.settings');

    $form['help'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => t('Help and instructions'),
    ];

    $form['help']['help'] = ['#markup' => adsense_cse_help_text()];

    $form['searchbox'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => t('Search Box Options'),
    ];

    $form['searchbox']['adsense_cse_logo'] = [
      '#type' => 'radios',
      '#title' => t('Logo Type'),
      '#default_value' => $config->get('adsense_cse_logo'),
      '#options' => [
        'adsense_cse_branding_watermark' => t('Watermark on search box (requires JavaScript)'),
        'adsense_cse_branding_right' => t('Next to the search box'),
        'adsense_cse_branding_bottom' => t('Below the search box'),
      ],
    ];

    $form['searchbox']['adsense_cse_color_box_background'] = [
      '#type' => 'select',
      '#title' => t('Background color'),
      '#default_value' => $config->get('adsense_cse_color_box_background'),
      '#options' => [
        'FFFFFF' => t('White'),
        '999999' => t('Gray'),
        '000000' => t('Black'),
      ],
    ];

    $form['searchbox']['adsense_cse_encoding'] = [
      '#type' => 'select',
      '#title' => t('Site Encoding'),
      '#default_value' => $config->get('adsense_cse_encoding'),
      '#options' => CustomSearchAd::adsenseEncodings(),
    ];

    $form['searchbox']['adsense_cse_textbox_length'] = [
      '#type' => 'textfield',
      '#title' => t('Text Box Length'),
      '#default_value' => $config->get('adsense_cse_textbox_length'),
      '#size' => 2,
      '#maxlength' => 2,
    ];

    $form['searchbox']['adsense_cse_language'] = [
      '#type' => 'select',
      '#title' => t('Watermark Language'),
      '#default_value' => $config->get('adsense_cse_language'),
      '#options' => CustomSearchAd::adsenseLanguages(),
    ];

    $form['result'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => t('Search Results Style'),
    ];

    $form['result']['adsense_cse_country'] = [
      '#type' => 'select',
      '#title' => t('Country or territory for Google domain'),
      '#default_value' => $config->get('adsense_cse_country'),
      '#options' => CustomSearchAd::adsenseCountries(),
    ];

    $form['result']['adsense_cse_frame_width'] = [
      '#type' => 'textfield',
      '#title' => t('Width of results area'),
      '#default_value' => $config->get('adsense_cse_frame_width'),
      '#size' => 3,
      '#maxlength' => 4,
    ];

    $form['result']['adsense_cse_ad_location'] = [
      '#type' => 'radios',
      '#title' => t('Ad Location'),
      '#default_value' => $config->get('adsense_cse_ad_location'),
      '#options' => [
        'adsense_cse_loc_top_right' => t('Top and Right'),
        'adsense_cse_loc_top_bottom' => t('Top and Bottom'),
        'adsense_cse_loc_right' => t('Right'),
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $textbox_length = $form_state->getValue('adsense_cse_textbox_length');
    $min = 8;
    $max = 64;
    if (($textbox_length < $min) || ($textbox_length > $max)) {
      $form_state->setErrorByName('adsense_cse_textbox_length', $this->t("Text Box Length must be between !min and !max", ['!min' => $min, '!max' => $max]));
    }
    $min = ($form_state->getValue('adsense_cse_ad_location') == 'adsense_cse_loc_top_bottom') ? 500 : 795;
    $max = 10000;
    $frame_width = $form_state->getValue('adsense_cse_frame_width');
    if (($frame_width < $min) || ($frame_width > $max)) {
      $form_state->setErrorByName('adsense_cse_frame_width', $this->t("Results area width must be between !min and !max", ['!min' => $min, '!max' => $max]));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::configFactory()->getEditable('adsense_cse.settings');
    $form_state->cleanValues();

    foreach ($form_state->getValues() as $key => $value) {
      $config->set($key, String::checkPlain($value));
    }
    $config->save();
  }

}
