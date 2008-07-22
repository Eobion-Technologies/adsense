<?php
// $Id$

/**
 * @file
 * Contains the administrative functions of the adsense module.
 *
 * This file is included by the core adsense module, and includes the
 * settings form.
 */

/**
 * Menu callback for the adsense module settings form.
 *
 * @ingroup forms
 */
function adsense_main_settings() {
  $form['visibility'] = array(
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#title' => t('Visibility'),
  );

  $form['visibility']['adsense_visibility'] = array(
    '#type' => 'radios',
    '#title' => t('Show AdSense on specific pages'),
    '#default_value' => variable_get('adsense_visibility', 0),
    '#options' => array(t('Show on every page except the listed pages.'), t('Show on only the listed pages.')),
  );

  $form['visibility']['adsense_access_pages'] = array(
    '#type' => 'textarea',
    '#default_value' => variable_get('adsense_access_pages', ''),
    '#rows' => 3,
    '#description' => t("Enter one page per line as Drupal paths. The '*' character is a wildcard. Example paths are  %blog for the blog page and %blog-wildcard for every personal blog. %front is the front page.", array('%blog' => 'blog', '%blog-wildcard' => 'blog/*', '%front' => '<front>')),
  );

  $form['advanced'] = array(
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#title' => t('Advanced options'),
  );

  $form['advanced']['adsense_test_mode'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable test mode?'),
    '#default_value' => variable_get('adsense_test_mode', 0),
    '#description' => t('This enables you to test the AdSense module settings. This can be useful in some situations: for example, testing whether revenue sharing is working properly or not without having to display real ads on your site. It is best to test this after you log out.'),
  );

  $form['advanced']['adsense_disable'] = array(
    '#type' => 'checkbox',
    '#title' => t('Disable Google AdSense ads?'),
    '#default_value' => variable_get('adsense_disable', 0),
    '#description' => t('This disables all display of Google AdSense ads from your web site. This is useful in certain situations, such as site upgrades, or if you make a copy of the site for development and test purposes.'),
  );

  $form['advanced']['adsense_placeholder'] = array(
    '#type' => 'checkbox',
    '#title' => t('Placeholder when ads are disabled?'),
    '#default_value' => variable_get('adsense_placeholder', 1),
    '#description' => t('This causes an empty box to be displayed in place of the ads when they are disabled.'),
  );

  $form['advanced']['adsense_placeholder_text'] = array(
    '#type' => 'textarea',
    '#title' => t('Placeholder text to display'),
    '#default_value' => variable_get('adsense_placeholder_text', t('Google AdSense')),
    '#rows' => 3,
    '#description' => t('Enter any text to display as a placeholder when ads are disabled.'),
  );

  $form['advanced']['adsense_section_targeting'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable AdSense section targeting?'),
    '#default_value' => variable_get('adsense_section_targeting', 1),
    '#description' => t('This better targets Google ads to the teaser and body of nodes.'),
  );

  return system_settings_form($form);
}

/**
 * Menu callback for the adsense publisher ID settings form.
 *
 * @ingroup forms
 */
function adsense_id_settings() {
  include_once(drupal_get_path('module', 'adsense') .'/help/adsense_id_help.inc');

  $form['help'] = array(
    '#type'        => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed'   => TRUE,
    '#title'       => t('Help and instructions'),
  );

  $form['help']['help'] = array(
    '#type'  => 'markup',
    '#value' => adsense_id_help_text(),
  );

  $form['adsense_basic_id'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Google AdSense Publisher ID'),
    '#required'      => TRUE,
    '#default_value' => variable_get('adsense_basic_id', ''),
    '#description'   => t('This is the Google AdSense Publisher ID for the site owner. You should get this from your Google Adsense account. It should be similar to %id.', array('%id' => 'pub-9999999999999')),
  );

  $form['#validate'][] = '_adsense_id_settings_validate';

  return system_settings_form($form);
}

function _adsense_id_settings_validate($form, &$form_state) {
  $form_state['values']['adsense_basic_id'] = trim($form_state['values']['adsense_basic_id']);
}