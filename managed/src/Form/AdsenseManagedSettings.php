<?php

/**
 * @file
 * Contains \Drupal\adsense_managed\Form\AdsenseManagedSettings.
 */

namespace Drupal\adsense_managed\Form;

use Drupal\Component\Utility\String;
use Drupal\Core\Url;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

class AdsenseManagedSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'adsense_managed_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['adsense_managed.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    module_load_include('inc', 'adsense_managed', 'help/adsense_managed.help');

    $config = \Drupal::config('adsense_managed.settings');

    $form['help'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => t('Help and instructions'),
    ];

    $form['help']['help'] = ['#markup' => adsense_managed_help_text()];

    $form['code'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => t('Code type'),
    ];

    $form['code']['adsense_managed_async'] = [
      '#type' => 'checkbox',
      '#title' => t('Use asynchronous code?'),
      '#default_value' => $config->get('adsense_managed_async'),
      '#description' => t('This will enable the new Asynchronous code type. [!moreinfo]', [
        '!moreinfo' => \Drupal::l(t('More information'), Url::fromUri('https://support.google.com/adsense/answer/3221666'))
        ]),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::configFactory()->getEditable('adsense_managed.settings');
    $form_state->cleanValues();

    foreach ($form_state->getValues() as $key => $value) {
      $config->set($key, String::checkPlain($value));
    }
    $config->save();
  }

}
