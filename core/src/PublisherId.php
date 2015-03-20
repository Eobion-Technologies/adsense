<?php

/**
 * @file
 * Contains \Drupal\adsense\PublisherId.
 */

namespace Drupal\adsense;

class PublisherId {

  public static function get() {
    return \Drupal::config('adsense.settings')->get('adsense_basic_id');
  }

}
