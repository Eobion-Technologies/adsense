<?php
/**
 * @file
 * Provides Drupal\adsense\AdsenseAdInterface.
 */

namespace Drupal\adsense;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for the adsense ad plugins.
 */
interface AdsenseAdInterface extends PluginInspectionInterface {

  public static function createAd(array $args);

  /**
   * Return the ad content.
   *
   * @return array
   *   ad content
   */
  public function getAdContent();

  /**
   * Return the ad placeholder.
   *
   * @return array
   *   ad placeholder
   */
  public function getAdPlaceholder();

  /**
   * Return the list of available languages.
   *
   * @return array
   *   list of language options with the key used by Google and description.
   */
  static public function adsenseLanguages();

}
