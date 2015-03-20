<?php

/**
 * @file
 * Contains \Drupal\adsense\AdsenseAdBase.
 */

namespace Drupal\adsense;

use Drupal\Component\Plugin\PluginBase;

abstract class AdsenseAdBase extends PluginBase implements AdsenseAdInterface {

  public static function createAd(array $args) {
    $is_search = (!empty($args['format']) && ($args['format'] == 'Search Box'));
    $needs_slot = !empty($args['slot']);

    // Search for the AdsenseAd plugins.
    /** @var AdsenseAdManager $manager */
    $manager = \Drupal::service('plugin.manager.adsensead');
    $plugins = $manager->getDefinitions();

    foreach ($plugins as $plugin) {
      if (($plugin['isSearch'] == $is_search) && ($plugin['needsSlot'] == $needs_slot)) {
        // Return an ad created by the compatible plugin.
        return $manager->createInstance($plugin['id'], $args);
      }
    }
    return NULL;
  }

  public function display() {
    if (\Drupal::config('adsense.settings')->get('adsense_test_mode')) {
      $text = theme_adsense_placeholder($this->getAdPlaceholder());
    }
    else {
      $text = theme_adsense_ad($this->getAdContent());
    }
    return $text;
  }

  /**
   * List of available languages.
   *
   * @return array
   *   array of language options with the key used by Google and description.
   */
  public static function adsenseLanguages() {
    return [
      'ar'    => t('Arabic'),
      'bg'    => t('Bulgarian'),
      'ca'    => t('Catalan'),
      'zh-Hans' => t('Chinese Simplified'),
      'zh-TW' => t('Chinese Traditional'),
      'hr'    => t('Croatian'),
      'cs'    => t('Czech'),
      'da'    => t('Danish'),
      'nl'    => t('Dutch'),
      'en'    => t('English'),
      'et'    => t('Estonian'),
      'fi'    => t('Finnish'),
      'fr'    => t('French'),
      'de'    => t('German'),
      'el'    => t('Greek'),
      'iw'    => t('Hebrew'),
      'hi'    => t('Hindi'),
      'hu'    => t('Hungarian'),
      'is'    => t('Icelandic'),
      'in'    => t('Indonesian'),
      'it'    => t('Italian'),
      'ja'    => t('Japanese'),
      'ko'    => t('Korean'),
      'lv'    => t('Latvian'),
      'lt'    => t('Lithuanian'),
      'no'    => t('Norwegian'),
      'pl'    => t('Polish'),
      'pt'    => t('Portuguese'),
      'ro'    => t('Romanian'),
      'ru'    => t('Russian'),
      'sr'    => t('Serbian'),
      'sk'    => t('Slovak'),
      'sl'    => t('Slovenian'),
      'es'    => t('Spanish'),
      'sv'    => t('Swedish'),
      'th'    => t('Thai'),
      'tr'    => t('Turkish'),
      'uk'    => t('Ukrainian'),
      'vi'    => t('Vietnamese'),
    ];
  }

}
