<?php

/**
 * @file
 * Contains \Drupal\adsense\Form\AdsenseIdSettings.
 */

namespace Drupal\adsense\Form;

use Drupal\Component\Utility\String;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

class AdsenseIdSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'adsense_id_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['adsense.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    module_load_include('inc', 'adsense', 'help/adsense_id_help');

    $config = \Drupal::config('adsense.settings');

    $form['help'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => t('Help and instructions'),
    ];

    $form['help']['help'] = ['#markup' => adsense_id_help_text()];

    $form['adsense_basic_id'] = [
      '#type' => 'textfield',
      '#title' => t('Site Google AdSense Publisher ID'),
      '#required' => TRUE,
      '#default_value' => $config->get('adsense_basic_id'),
      '#pattern' => 'pub-[0-9]+',
      '#description' => t('This is the Google AdSense Publisher ID for the site owner. It is used if no other ID is suitable. Get this in your Google Adsense account. It should be similar to %id.', [
        '%id' => 'pub-9999999999999'
        ]),
    ];

    $options = $this->adsenseIdSettingsClientIdMods();
    if (count($options) > 1) {
      $form['adsense_id_module'] = [
        '#type' => 'radios',
        '#title' => t('Publisher ID module'),
        '#default_value' => $config->get('adsense_id_module'),
        '#options' => $options,
      ];
    }
    else {
      $form['adsense_id_module'] = [
        '#type' => 'hidden',
        '#value' => 'adsense_basic',
      ];
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::configFactory()->getEditable('adsense.settings');
    $form_state->cleanValues();

    foreach ($form_state->getValues() as $key => $value) {
      $config->set($key, String::checkPlain($value));
    }
    $config->save();
  }

  /**
   * Search for the available Publisher ID modules.
   *
   * @return array
   *   array of selectable Publisher ID functions
   */
  private function adsenseIdSettingsClientIdMods() {
    // TODO ModuleHandler::getImplementations
    $ret['adsense_basic'] = 'Always use the site Publisher ID.';

    $funcs = get_defined_functions();
    foreach ($funcs['user'] as $func) {
      if (preg_match('!_adsense$!', $func)) {
        $settings = $func('settings');
        $ret[$func] = $settings['name'];
        if (!empty($settings['desc'])) {
          $ret[$func] .= "<div style='margin-left: 2.5em;' class='description'>{$settings['desc']}</div>";
        }
      }
    }
    return $ret;
  }

}
