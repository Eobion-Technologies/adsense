<?php

/**
 * @file
 * Contains \Drupal\adsense_managed\Plugin\AdsenseAd\OldCodeAd.
 */

namespace Drupal\adsense_oldcode\Plugin\AdsenseAd;

use Drupal\Component\Utility\Unicode;

use Drupal\adsense\ContentAdBase;
use Drupal\adsense\PublisherId;

/**
 * Provides an AdSense old code ad unit.
 *
 * @AdsenseAd(
 *   id = "oldcode",
 *   name = @Translation("Old code ads"),
 *   isSearch = FALSE,
 *   needsSlot = FALSE
 * )
 */
class OldCodeAd extends ContentAdBase {
  private $group;
  private $channel;

  public function __construct($args) {
    $fo = (!empty($args['format'])) ? $args['format'] : '';
    $gr = (!empty($args['group'])) ? $args['group'] : 1;
    $ch = (!empty($args['channel'])) ? $args['channel'] : 1;

    $oldcode_config = \Drupal::config('adsense_oldcode.settings');
    if (($gr < 1) || ($gr > $oldcode_config->get('adsense_max_groups'))) {
      // Default to 1 if an invalid group is supplied.
      $gr = 1;
    }

    if (($fo != 'Search Box') && !empty($fo)) {
      $this->format = $fo;
      $this->group = $gr;
      $this->channel = $ch;
    }
  }

  public function getAdPlaceholder() {
    if (!empty($this->format)) {
      $client = PublisherId::get();
      // Get width and height from the format.
      list($width, $height) = $this->dimensions($this->format);

      $content = "client = {$client}<br/>format = {$this->format}<br/>width = {$width}<br/>height = {$height}";

      return ['content' => $content, 'width' => $width, 'height' => $height, 'format' => $this->format];
    }
    return [];
  }

  public function getAdContent() {
    if (!empty($this->format)) {
      $core_config = \Drupal::config('adsense.settings');
      $oldcode_config = \Drupal::config('adsense_oldcode.settings');

      $client = PublisherId::get();
      // Get width and height from the format.
      list($width, $height) = $this->dimensions($this->format);

      $ad = $this->adsenseAdFormats($this->format);
      if ($ad != NULL) {
        switch ($oldcode_config->get('adsense_ad_type_' . $this->group)) {
          case 0:
            $type = 'text';
            break;

          case 1:
            $type = 'image';
            break;

          default:
            $type = 'text_image';
            break;
        }

        $channel = $oldcode_config->get('adsense_ad_channel_' . $this->channel);

        $border = Unicode::substr($oldcode_config->get('adsense_color_border_' . $this->group), 1);
        $bg = Unicode::substr($oldcode_config->get('adsense_color_bg_' . $this->group), 1);
        $link = Unicode::substr($oldcode_config->get('adsense_color_link_' . $this->group), 1);
        $url = Unicode::substr($oldcode_config->get('adsense_color_url_' . $this->group), 1);
        $text = Unicode::substr($oldcode_config->get('adsense_color_text_' . $this->group), 1);

        $corner = $oldcode_config->get('adsense_ui_features_' . $this->group);
        $alt = $oldcode_config->get('adsense_alt_' . $this->group);
        $alt_info = $oldcode_config->get('adsense_alt_info_' . $this->group);
        switch ($alt) {
          case 1:
            $part1 = "google_alternate_ad_url = \"$alt_info\";";
            break;

          case 2:
            $part1 = "google_alternate_color = \"$alt_info\";";
            break;

          case 0:
            // Disabled.
          default:
            $part1 = "";
        }

        $part2 = "";
        if ($ad['type'] == ADSENSE_TYPE_AD) {
          $part2 .= "google_ad_type = \"$type\";\n";
        }
        if (!empty($channel)) {
          $part2 .= "google_ad_channel = \"$channel\";";
        }

        $secret = '';
        if ($lang = $core_config->get('adsense_secret_language')) {
          $secret = "google_language = '$lang';\n";
        }

        $content = <<<OLDCODE_TXT
<script type="text/javascript"><!--
google_ad_client = "{$client}";
{$part1}
google_ad_width = {$width};
google_ad_height = {$height};
google_ad_format = "{$ad['code']}";
{$part2}
google_color_border = "{$border}";
google_color_bg = "{$bg}";
google_color_link = "{$link}";
google_color_text = "{$text}";
google_color_url = "{$url}";
google_ui_features = "{$corner}";
{$secret}
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
OLDCODE_TXT;
      }
      else {
        $content = '<!-- unknown ad format -->';
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
   * type, the description, Google's javascript ad code and the dimensions.
   *
   * To add a new code:
   * - Make sure the key is not in use by a different format
   * - Go to Google AdSense
   *   . Get the dimensions
   *   . Get the description
   *   . Get the code
   * - Add it below
   *
   * @param string $key
   *   Ad key for which the format is needed (optional).
   *
   * @return array
   *   if no key is provided: array of supported ad formats as an array (type,
   *   desc(ription), code, width and height).
   *   if a key is provided, the array containing the ad format for that key,
   *   or NULL if there is no ad with that key.
   */
  public static function adsenseAdFormats($key = NULL) {
    $ads = [
      // Top performing ad sizes.
      '300x250' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Medium Rectangle'), 'code' => '300x250_as'],
      '336x280' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Large Rectangle'), 'code' => '336x280_as'],
      '728x90' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Leaderboard'), 'code' => '728x90_as'],
      /*'300x600' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Large Skyscraper'), 'code' => '300x600_as'],*/
      /*'320x100' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Large Mobile Banner'), 'code' => '320x100_as'],*/
      // Other supported ad sizes.
      /*'320x50' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Mobile Banner'), 'code' => '320x50_as'],*/
      '468x60' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Banner'), 'code' => '468x60_as'],
      '234x60' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Half Banner'), 'code' => '234x60_as'],
      '120x600' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Skyscraper'), 'code' => '120x600_as'],
      '120x240' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Vertical Banner'), 'code' => '120x240_as'],
      '160x600' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Wide Skyscraper'), 'code' => '160x600_as'],
      /*'300x1050' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Portrait'), 'code' => '300x1050_as'],*/
      /*'970x90' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Large Leaderboard'), 'code' => '970x90_as'],*/
      /*'970x250' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Billboard'), 'code' => '970x250_as'],*/
      '250x250' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Square'), 'code' => '250x250_as'],
      '200x200' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Small Square'), 'code' => '200x200_as'],
      '180x150' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Small Rectangle'), 'code' => '180x150_as'],
      '125x125' => ['type' => ADSENSE_TYPE_AD, 'desc' => t('Button'), 'code' => '125x125_as'],
      // 4-links
      '120x90' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Vertical Small'), 'code' => '120x90_0ads_al'],
      '160x90' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Vertical Medium'), 'code' => '160x90_0ads_al'],
      '180x90' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Vertical Large'), 'code' => '180x90_0ads_al'],
      '200x90' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Vertical X-Large'), 'code' => '200x90_0ads_al'],
      '468x15' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Horizontal Medium'), 'code' => '468x15_0ads_al'],
      '728x15' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('4-links Horizontal Large'), 'code' => '728x15_0ads_al'],
      // 5-links
      '120x90_5' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('5-links Vertical Small'), 'code' => '120x90_0ads_al_s'],
      '160x90_5' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('5-links Vertical Medium'), 'code' => '160x90_0ads_al_s'],
      '180x90_5' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('5-links Vertical Large'), 'code' => '180x90_0ads_al_s'],
      '200x90_5' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('5-links Vertical X-Large'), 'code' => '200x90_0ads_al_s'],
      '468x15_5' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('5-links Horizontal Medium'), 'code' => '468x15_0ads_al_s'],
      '728x15_5' => ['type' => ADSENSE_TYPE_LINK, 'desc' => t('5-links Horizontal Large'), 'code' => '728x15_0ads_al_s'],
    ];

    if (!empty($key)) {
      return (array_key_exists($key, $ads)) ? $ads[$key] : NULL;
    }
    else {
      return $ads;
    }
  }

}
