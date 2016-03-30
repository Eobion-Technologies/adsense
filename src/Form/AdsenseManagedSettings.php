<?php

/**
 * @file
 * Contains \Drupal\adsense\Form\AdsenseManagedSettings.
 */

namespace Drupal\adsense\Form;

use Drupal\Component\Utility\Html;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class AdsenseManagedSettings.
 */
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
    return ['adsense.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = \Drupal::config('adsense.settings');

    $form['adsense_managed_async'] = [
      '#type' => 'checkbox',
      '#title' => t('Use asynchronous code?'),
      '#default_value' => $config->get('adsense_managed_async'),
      '#description' => t('This will enable the new Asynchronous code type. [@moreinfo]', [
        '@moreinfo' => Link::fromTextAndUrl(t('More information'), Url::fromUri('https://support.google.com/adsense/answer/3221666'))->toString(),
      ]),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::configFactory()->getEditable('adsense.settings');
    $form_state->cleanValues();

    foreach ($form_state->getValues() as $key => $value) {
      $config->set($key, Html::escape($value));
    }
    $config->save();
  }

}
