<?php

/**
 * @file
 * Contains \Drupal\adsense_managed\Plugin\AdsenseAd\ManagedAd.
 */

namespace Drupal\adsense_managed\Plugin\AdsenseAd;

use Drupal\adsense\ContentAdBase;
use Drupal\adsense\PublisherId;

/**
 * Provides an AdSense managed ad unit.
 *
 * @AdsenseAd(
 *   id = "managed",
 *   name = @Translation("Content ads"),
 *   isSearch = FALSE,
 *   needsSlot = TRUE
 * )
 */
class ManagedAd extends ContentAdBase {
  private $slot;
  private $shape;

  public function __construct($args) {
    $fo = (!empty($args['format'])) ? $args['format'] : '';
    $sl = (!empty($args['slot'])) ? $args['slot'] : '';
    $sh = (!empty($args['shape'])) ? $args['shape'] : ['auto'];

    if (($fo != 'Search Box') && !empty($fo) && !empty($sl)) {
      $this->format = $fo;
      $this->slot = $sl;
      $this->shape = $sh;

      $fmt = $this->adsenseAdFormats($fo);
      $this->type = $fmt['type'];
    }
  }

  public function getAdPlaceholder() {
    if (!empty($this->format) && !empty($this->slot)) {
      $client = PublisherId::get();
      // Get width and height from the format.
      list($width, $height) = $this->dimensions($this->format);

      $content = "client = ca-{$client}<br/>slot = {$this->slot}";
      $content .= ($this->format == 'responsive') ? ("<br/>shape = " . implode(',', $this->shape)) : "<br/>width = {$width}<br/>height = {$height}";

      return ['content' => $content, 'width' => $width, 'height' => $height, 'format' => $this->format];
    }
    return [];
  }

  public function getAdContent() {
    if (!empty($this->format) && !empty($this->slot)) {
      $client = PublisherId::get();
      \Drupal::moduleHandler()->alter('adsense', $client);

      // Get width and height from the format.
      list($width, $height) = $this->dimensions($this->format);
      $shape = ($this->format == 'responsive') ? implode(',', $this->shape) : '';

      if ($this->format == 'responsive') {
        // Responsive smart sizing code.
        $content = <<<MANAGED_RESP_SMART_TXT
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- {$this->format} -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-{$client}"
     data-ad-slot="{$this->slot}"
     data-ad-format="{$shape}"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script> 
MANAGED_RESP_SMART_TXT;
      }
      else {
        $managed_config = \Drupal::config('adsense_managed.settings');
        if ($managed_config->get('adsense_managed_async')) {
          // Asynchronous code.
          $content = <<<MANAGED_ASYNC_TXT
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- {$this->format} -->
<ins class="adsbygoogle"
     style="display:inline-block;width:{$width}px;height:{$height}px"
     data-ad-client="ca-{$client}"
     data-ad-slot="{$this->slot}"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
MANAGED_ASYNC_TXT;
        }
        else {
          // Synchronous code.
          $secret = '';
          $core_config = \Drupal::config('adsense.settings');
          if ($lang = $core_config->get('adsense_secret_language')) {
            $secret = "    google_language = '$lang';\n";
          }

          $content = <<<MANAGED_SYNC_TXT
<script type="text/javascript">
    google_ad_client = "ca-{$client}";
    google_ad_slot = "{$this->slot}";
    google_ad_width = {$width};
    google_ad_height = {$height};
{$secret}
</script>
<!-- {$this->format} -->
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
MANAGED_SYNC_TXT;
        }
      }
      // Remove empty lines.
      $content = str_replace("\n\n", "\n", $content);

      return ['content' => $content, 'width' => $width, 'height' => $height, 'format' => $this->format];
    }
    return [];
  }

  /**
   * This is the array that holds all ad formats.
   *
   * All it has is a multi-dimensional array indexed by a key, containing the ad
   * type and the description.
   *
   * To add a new code:
   * - Make sure the key is not in use by a different format
   * - Go to Google AdSense
   *   . Get the dimensions
   *   . Get the description
   * - Add it below
   *
   * @param string $key
   *   Ad key for which the format is needed (optional).
   *
   * @return array
   *   if no key is provided: array of supported ad formats as an array (type,
   *   description).
   *   if a key is provided, the array containing the ad format for that key,
   *   or NULL if there is no ad with that key.
   */
  public static function adsenseAdFormats($key = NULL) {
    $ads = [
      'responsive' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Responsive ad unit')],
      'custom' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Custom size ad unit')],
      // Top performing ad sizes.
      '300x250' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Medium Rectangle')],
      '336x280' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Large Rectangle')],
      '728x90' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Leaderboard')],
      '300x600' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Large Skyscraper')],
      '320x100' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Large Mobile Banner')],
      // Other supported ad sizes.
      '320x50' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Mobile Banner')],
      '468x60' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Banner')],
      '234x60' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Half Banner')],
      '120x600' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Skyscraper')],
      '120x240' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Vertical Banner')],
      '160x600' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Wide Skyscraper')],
      '300x1050' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Portrait')],
      '970x90' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Large Leaderboard')],
      '970x250' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Billboard')],
      '250x250' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Square')],
      '200x200' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Small Square')],
      '180x150' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Small Rectangle')],
      '125x125' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Button')],
      // 4-links
      '120x90' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Vertical Small')],
      '160x90' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Vertical Medium')],
      '180x90' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Vertical Large')],
      '200x90' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Vertical X-Large')],
      '468x15' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Horizontal Medium')],
      '728x15' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Horizontal Large')],
     ];

    if (!empty($key)) {
      return (array_key_exists($key, $ads)) ? $ads[$key] : NULL;
    }
    else {
      return $ads;
    }
  }

}
