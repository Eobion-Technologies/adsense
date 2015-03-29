<?php

/**
 * @file
 * Contains \Drupal\adsense\AdsenseAdBase.
 */

namespace Drupal\adsense;

use Drupal\Component\Plugin\PluginBase;

abstract class AdsenseAdBase extends PluginBase implements AdsenseAdInterface {
  protected $type;

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

  /**
   * Display ad HTML.
   *
   * @return array
   *   render array with ad or placeholder depending on current configuration.
   */
  public function display(array $classes) {
    $config = \Drupal::config('adsense.settings');
    $libraries = ['adsense/adsense.css'];

    if (!$config->get('adsense_basic_id')) {
      $text = '<!-- adsense: no publisher id configured. -->';
    }
    elseif ($config->get('adsense_test_mode') ||
        \Drupal::currentUser()->hasPermission('show adsense placeholders')) {
      // Show ad placeholder.
      $text = theme_adsense_placeholder($this->getAdPlaceholder());
    }
    else {
      if ($config->get('adsense_disable')) {
        $text = '<!-- adsense: adsense disabled. -->';
      }
      elseif (\Drupal::currentUser()->hasPermission('hide adsense')) {
        $text = '<!-- adsense: disabled for current user. -->';
      }
      elseif (!$this->canInsertAnother()) {
        $text = '<!--adsense: ad limit reached for type. -->';
      }
      else {
        // Show ad.
        $text = theme_adsense_ad($this->getAdContent());

        // Display ad-block disabling request.
        if ($config->get('adsense_unblock_ads')) {
          $libraries[] = 'adsense/adsense.unblock';
        }
      }
    }

    if (!empty($classes)) {
      $text = '<div class="' . implode(' ', $classes) . '">' . $text . '</div>';
    }

    return [
      '#type' => 'markup',
      '#markup' => $text,
      '#attached' => ['library' => $libraries],
    ];
  }

  /**
   * Check if another ad of this type can be inserted.
   *
   * @return bool
   *   TRUE if ad can be inserted.
   */
  public function canInsertAnother() {
    static $num_ads = [
      ADSENSE_TYPE_AD     => 0,
      ADSENSE_TYPE_LINK   => 0,
      ADSENSE_TYPE_SEARCH => 0,
    ];

    $max_ads = [
      ADSENSE_TYPE_AD     => 3,
      ADSENSE_TYPE_LINK   => 3,
      ADSENSE_TYPE_SEARCH => 2,
    ];

    if ($num_ads[$this->type] < $max_ads[$this->type]) {
      $num_ads[$this->type]++;
      return TRUE;
    }

    // Because of #1627846, it's better to always return TRUE
    return TRUE;

    return FALSE;
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
