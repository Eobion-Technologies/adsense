<?php
// $Id$

/**
 * @file
 * Contains the administrative functions of the adsense_oldcode module.
 *
 * This file is included by the adsense_oldcode module, and includes the
 * settings form.
 */

/**
 * Menu callback for the adsense_oldcode module settings form.
 *
 * @ingroup forms
 */
function adsense_oldcode_settings() {
  $form['blocks'] = array(
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#title' => t('AdSense Blocks'),
  );

  $form['blocks']['adsense_oldcode_number_blocks'] = array(
    '#type' => 'textfield',
    '#title' => t('Number of blocks'),
    '#default_value' => variable_get('adsense_oldcode_number_blocks', 3),
    '#size' => 2,
    '#maxlength' => 2,
  );

  $form['types_colors'] = array(
    '#type'        => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed'   => TRUE,
    '#title'       => t('Ad groups'),
  );

  // Add Farbtastic color picker
  drupal_add_css('misc/farbtastic/farbtastic.css', 'module', 'all', FALSE);
  drupal_add_js('misc/farbtastic/farbtastic.js');
  drupal_add_js(drupal_get_path('module', 'adsense_oldcode') .'/adsense_oldcode.js');

  for ($group=1; $group <= ADSENSE_MAX_GROUPS ; $group++) {
    $form['types_colors']['groups'][$group] = array(
      '#type' => 'fieldset',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#title' => t('Group @group attributes', array('@group' => $group .' '. variable_get('adsense_group_title_'. $group, ''))),
    );

    $form['types_colors']['groups'][$group]['adsense_group_title_'. $group] = array(
      '#type'          => 'textfield',
      '#title'         => t('Title'),
      '#default_value' => variable_get('adsense_group_title_'. $group, ''),
      '#size'          => 100,
      '#maxlength'     => 100,
      '#description'   => t('Title of the group.'),
    );

    $form['types_colors']['groups'][$group]['adsense_ad_type_'. $group] = array(
      '#type' => 'radios',
      '#title' => t('Ad type'),
      '#default_value' => variable_get('adsense_ad_type_'. $group, 0),
      '#options' => array(t('Text'), t('Image'), t('Both')),
    );

    $form['types_colors']['groups'][$group]['colorpicker'] = array(
      '#type' => 'markup',
      '#value' => "<div id='colorpicker-$group' style='float: right;'></div>",
    );

    $form['types_colors']['groups'][$group]['adsense_color_text_'. $group] = array(
      '#type' => 'textfield',
      '#title' => t('Ad text color'),
      '#default_value' => variable_get('adsense_color_text_'. $group, '#000000'),
      '#size' => 7,
      '#maxlength' => 7,
    );

    $form['types_colors']['groups'][$group]['adsense_color_border_'. $group] = array(
      '#type' => 'textfield',
      '#title' => t('Ad border color'),
      '#default_value' => variable_get('adsense_color_border_'. $group, '#336699'),
      '#size' => 7,
      '#maxlength' => 7,
    );

    $form['types_colors']['groups'][$group]['adsense_color_bg_'. $group] = array(
      '#type' => 'textfield',
      '#title' => t('Ad background color'),
      '#default_value' => variable_get('adsense_color_bg_'. $group, '#FFFFFF'),
      '#size' => 7,
      '#maxlength' => 7,
    );

    $form['types_colors']['groups'][$group]['adsense_color_link_'. $group] = array(
      '#type' => 'textfield',
      '#title' => t('Ad title color'),
      '#default_value' => variable_get('adsense_color_link_'. $group, '#336699'),
      '#size' => 7,
      '#maxlength' => 7,
    );

    $form['types_colors']['groups'][$group]['adsense_color_url_'. $group] = array(
      '#type' => 'textfield',
      '#title' => t('Ad URL color'),
      '#default_value' => variable_get('adsense_color_url_'. $group, '#FF8C00'),
      '#size' => 7,
      '#maxlength' => 7,
    );

    $form['types_colors']['groups'][$group]['adsense_alt_'. $group] = array(
      '#type' => 'select',
      '#title' => t('Alternate URL color'),
      '#default_value' => variable_get('adsense_alt_'. $group, 0),
      '#options' => array(t('None'), t('Alternate URL'), t('Alternate color')),
    );

    $form['types_colors']['groups'][$group]['adsense_alt_info_'. $group] = array(
      '#type' => 'textfield',
      '#title' => t('Alternate info'),
      '#default_value' => variable_get('adsense_alt_info_'. $group, ''),
      '#size' => 100,
      '#maxlength' => 100,
      '#description' => t('Enter either 6 letter alternate color code, or alternate URL to use'),
    );

    $form['types_colors']['groups'][$group]['adsense_ui_features_'. $group] = array(
      '#type' => 'select',
      '#title' => t('Rounded corners'),
      '#default_value' => variable_get('adsense_ui_features_'. $group, 'rc:0'),
      '#options' => array('rc:0' => 'Square', 'rc:6' => 'Slightly rounded', 'rc:10' => 'Very rounded'),
      '#description' => t('Choose type of round corners'),
    );
  }

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

  $form['#validate'][] = '_adsense_oldcode_settings_validate';

  return system_settings_form($form);
}

/**
 * Validate adsense_oldcode_settings form.
 */
function _adsense_oldcode_settings_validate($form, &$form_state) {
  $number_blocks = $form_state['values']['adsense_oldcode_number_blocks'];
  if ($number_blocks < 0) {
    form_set_error('adsense_oldcode_number_blocks', t("Number of blocks can't be a negative number"));
  }
}
