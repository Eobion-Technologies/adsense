<?php
// $Id$

/**
 * @file
 * Contains the administrative functions of the adsense_search module.
 *
 * This file is included by the adsense_search module, and includes the
 * settings form.
 */

/**
 * Menu callback for the adsense_search module settings form.
 *
 * @ingroup forms
 */
function adsense_search_settings() {
  global $base_url;
  require_once(drupal_get_path('module', 'adsense') .'/includes/adsense.search_options.inc');

  $form['searchbox'] = array(
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#title' => t('Search Box Options'),
    '#description' => t('Allows users to search the web or the specific site(s) of your choice. Enter the site\'s URL without the last \'/\''),
  );

  $form['searchbox']['adsense_search_domain_0'] = array(
    '#type' => 'textfield',
    '#field_prefix' => 'http://',
    '#default_value' => variable_get('adsense_search_domain_0', str_replace('http://', '', $base_url)),
    '#size' => 32,
    '#maxlength' => 255,
  );

  $form['searchbox']['adsense_search_domain_1'] = array(
    '#type' => 'textfield',
    '#field_prefix' => 'http://',
    '#default_value' => variable_get('adsense_search_domain_1', ''),
    '#size' => 32,
    '#maxlength' => 255,
  );

  $form['searchbox']['adsense_search_domain_2'] = array(
    '#type' => 'textfield',
    '#field_prefix' => 'http://',
    '#default_value' => variable_get('adsense_search_domain_2', ''),
    '#size' => 32,
    '#maxlength' => 255,
  );

  $form['searchbox']['adsense_search_safe_mode'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use SafeSearch'),
    '#default_value' => variable_get('adsense_search_safe_mode', 0),
  );

  $form['searchbox']['adsense_search_logo'] = array(
    '#type' => 'radios',
    '#title' => t('Logo Type'),
    '#default_value' => variable_get('adsense_search_logo', 'adsense_search_logo_google'),
    '#options' => array(
      'adsense_search_logo_google'        => t('Google Logo'),
      'adsense_search_logo_above_textbox' => t('Logo above text box'),
      'adsense_search_logo_on_button'     => t('"Google Search" on button'),
    ),
  );

  $form['searchbox']['adsense_search_button'] = array(
    '#type' => 'checkbox',
    '#title' => t('Search button below text box'),
    '#default_value' => variable_get('adsense_search_button', 0),
  );

  $form['searchbox']['adsense_search_color_box_background'] = array(
    '#type' => 'select',
    '#title' => t('Background Color'),
    '#default_value' => variable_get('adsense_search_color_box_background', '#FFFFFF'),
    '#options' => array(
      '#FFFFFF' => t('White'),
      '#000000' => t('Black'),
      '#CCCCCC' => t('Gray'),
    ),
  );

  $form['searchbox']['adsense_search_color_box_text'] = array(
    '#type' => 'select',
    '#title' => t('Text Color'),
    '#default_value' => variable_get('adsense_search_color_box_text', '#000000'),
    '#options' => array(
      '#000000' => t('Black'),
      '#FFFFFF' => t('White'),
    ),
  );

  $form['searchbox']['adsense_search_language'] = array(
    '#type' => 'select',
    '#title' => t('Site Language'),
    '#default_value' => variable_get('adsense_search_language', 'en'),
    '#options' => _adsense_search_options_language(),
  );

  $form['searchbox']['adsense_search_encoding'] = array(
    '#type' => 'select',
    '#title' => t('Site Encoding'),
    '#default_value' => variable_get('adsense_search_encoding', 'UTF-8'),
    '#options' => _adsense_search_options_encoding(),
  );

  $form['searchbox']['adsense_search_textbox_length'] = array(
    '#type' => 'textfield',
    '#title' => t('Length of text box (Max 64)'),
    '#default_value' => variable_get('adsense_search_textbox_length', 31),
    '#size' => 2,
    '#maxlength' => 2,
  );

  $form['result'] = array(
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#title' => t('Search Results Style'),
  );

  $form['result']['adsense_search_country'] = array(
    '#type' => 'select',
    '#title' => t('Country or territory for Google domain'),
    '#default_value' => variable_get('adsense_search_country', 'www.google.com'),
    '#options' => _adsense_search_options_country(),
  );

  $form['result']['adsense_search_frame_width'] = array(
    '#type' => 'textfield',
    '#title' => t('Width of results area'),
    '#default_value' => variable_get('adsense_search_frame_width', 800),
    '#size' => 4,
    '#maxlength' => 4,
  );

  $form['result']['colors'] = array(
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#title' => t('Color attributes'),
  );

  // Add Farbtastic color picker
  drupal_add_css('misc/farbtastic/farbtastic.css', 'module', 'all', FALSE);
  drupal_add_js('misc/farbtastic/farbtastic.js');
  drupal_add_js('$(document).ready(function() { $("#colorpicker").farbtastic("#edit-adsense-search-color-border"); });', 'inline');

  $form['result']['colors']['colorpicker'] = array(
    '#type' => 'markup',
    '#value' => '<div id="colorpicker"></div>',
  );

  $form['result']['colors']['adsense_search_color_border'] = array(
    '#type' => 'textfield',
    '#title' => t('Border'),
    '#default_value' => variable_get('adsense_search_color_border', '#336699'),
    '#size' => 7,
    '#maxlength' => 7,
  );

  $form['result']['colors']['adsense_search_color_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => variable_get('adsense_search_color_title', '#0000FF'),
    '#size' => 7,
    '#maxlength' => 7,
  );

  $form['result']['colors']['adsense_search_color_bg'] = array(
    '#type' => 'textfield',
    '#title' => t('Background'),
    '#default_value' => variable_get('adsense_search_color_bg', '#FFFFFF'),
    '#size' => 7,
    '#maxlength' => 7,
  );

  $form['result']['colors']['adsense_search_color_text'] = array(
    '#type' => 'textfield',
    '#title' => t('Text'),
    '#default_value' => variable_get('adsense_search_color_text', '#000000'),
    '#size' => 7,
    '#maxlength' => 7,
  );

  $form['result']['colors']['adsense_search_color_url'] = array(
    '#type' => 'textfield',
    '#title' => t('URL'),
    '#default_value' => variable_get('adsense_search_color_url', '#008000'),
    '#size' => 7,
    '#maxlength' => 7,
  );

  $form['result']['colors']['adsense_search_color_visited_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Visited URL'),
    '#default_value' => variable_get('adsense_search_color_visited_url', '#663399'),
    '#size' => 7,
    '#maxlength' => 7,
  );

  $form['result']['colors']['adsense_search_color_light_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Light URL'),
    '#default_value' => variable_get('adsense_search_color_light_url', '#0000FF'),
    '#size' => 7,
    '#maxlength' => 7,
  );

  $form['result']['colors']['adsense_search_color_logo_bg'] = array(
    '#type' => 'textfield',
    '#title' => t('Logo Background'),
    '#default_value' => variable_get('adsense_search_color_logo_bg', '#336699'),
    '#size' => 7,
    '#maxlength' => 7,
  );

  $form['blocks'] = array(
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#title' => t('AdSense Blocks'),
  );

  $form['blocks']['adsense_search_number_blocks'] = array(
    '#type' => 'textfield',
    '#title' => t('Number of blocks'),
    '#default_value' => variable_get('adsense_search_number_blocks', 2),
    '#size' => 2,
    '#maxlength' => 2,
  );

  $form['channels'] = array(
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#title' => t('Custom channels'),
    '#description' => t('Enter up to !channels custom channels that you have configured in Google AdSense. If you are not using custom channels, or you are only using URL channels, then leave this empty.', array('!channels' => ADSENSE_MAX_CHANNELS)),
  );

  for ($channel=1; $channel <= ADSENSE_MAX_CHANNELS ; $channel++) {
    $form['channels']['adsense_ad_channel_'. $channel] = array(
      '#type' => 'textfield',
      '#title' => t('Custom channel ID') .' '. $channel,
      '#default_value' => variable_get('adsense_ad_channel_'. $channel, ''),
      '#size' => 30,
      '#maxlength' => 30,
    );
  }

  $form['#validate'][] = '_adsense_search_settings_validate';

  return system_settings_form($form);
}

function _adsense_search_settings_validate($form, &$form_state) {
  $textbox_length = $form_state['values']['adsense_search_textbox_length'];
  $min = 8;
  $max = 64;
  if (($textbox_length < $min ) || ($textbox_length > $max )) {
    form_set_error('adsense_search_textbox_length', t("Text Box Length must be between !min and !max", array('!min' => $min, '!max' => $max)));
  }

  $number_blocks = $form_state['values']['adsense_search_number_blocks'];
  if ($number_blocks < 0) {
    form_set_error('adsense_search_number_blocks', t("Number of blocks can't be a negative number"));
  }

  $colors = array(
    'adsense_search_color_border',
    'adsense_search_color_title',
    'adsense_search_color_bg',
    'adsense_search_color_text',
    'adsense_search_color_url',
    'adsense_search_color_visited_url',
    'adsense_search_color_light_url',
    'adsense_search_color_logo_bg',
  );

  foreach ($colors as $field_name) {
    $field_value = $form_state['values'][$field_name];
    if (!preg_match('/#[0-9A-F]{6}/i', $field_value)) {
      form_set_error($field_name, t("Color must be between #000000 and #FFFFFF"));
    }
  }

  $box_background_color = $form_state['values']['adsense_search_color_box_background'];
  if ($box_background_color == '#000000') {
    $form_state['values']['adsense_search_color_box_text'] = '#FFFFFF';
  }
  elseif ($box_background_color == '#FFFFFF') {
    $form_state['values']['adsense_search_color_box_text'] = '#000000';
  }
}