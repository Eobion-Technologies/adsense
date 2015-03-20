<?php

/**
 * @file
 * Contains \Drupal\adsense\ContentAdBase.
 */

namespace Drupal\adsense;

abstract class ContentAdBase extends AdsenseAdBase {
  protected $format;

  abstract public static function adsenseAdFormats($key = NULL);

  public static function dimensions($format) {
    if (preg_match('!^(\d+)x(\d+)(.*)$!', $format, $matches)) {
      return [$matches[1], $matches[2]];
    }
    return ['', ''];
  }

  public function getFormat() {
    return $this->format;
  }

}
