<?php

/**
 * @file
 * Contains \Drupal\adsense_cse\Plugin\AdsenseAd\CustomSearchAd.
 */

namespace Drupal\adsense_cse\Plugin\AdsenseAd;

use Drupal\Core\Url;

use Drupal\adsense\SearchAdBase;
use Drupal\adsense\PublisherId;

/**
 * Provides an AdSense custom search engine form.
 *
 * @AdsenseAd(
 *   id = "cse",
 *   name = @Translation("CSE Search"),
 *   isSearch = TRUE,
 *   needsSlot = TRUE
 * )
 */
class CustomSearchAd extends SearchAdBase {
  private $slot;

  public function __construct($args) {
    $sl = (!empty($args['slot'])) ? $args['slot'] : '';

    if (!empty($sl)) {
      $this->slot = $sl;
    }
  }

  public function getAdPlaceholder() {
    if (!empty($this->slot)) {
      $client = PublisherId::get();

      $content = "CSE<br/>cx = partner-{$client}:{$this->slot}";

      return ['content' => $content, 'format' => 'Search Box'];
    }
    return [];
  }

  public function getAdContent() {
    if (!empty($this->slot)) {
      global $base_url;
      $client = PublisherId::get();

      $cse_config = \Drupal::config('adsense_cse.settings');

      $branding = $cse_config->get('adsense_cse_logo');
      $box_background_color = $cse_config->get('adsense_cse_color_box_background');
      $ad_location = $cse_config->get('adsense_cse_ad_location');
      $encoding = $cse_config->get('adsense_cse_encoding');
      $textbox_length = $cse_config->get('adsense_cse_textbox_length');
      $language = $cse_config->get('adsense_cse_language');

      $search = t('Search');
      $custom_search = t('Custom Search');

      if (TRUE) {
        $results_path = Url::fromRoute('adsense_cse.results');
        $hidden_q_field = '';
      }
      else {
        $results_path = $base_url;
        $hidden_q_field = '<input type="hidden" name="q" value="." />';
      }

      $box_text_color = ($box_background_color == '000000') ? 'FFFFFF' : '000000';

      $forid = 0;
      switch ($ad_location) {
        case 'adsense_cse_loc_top_right':
          $forid = 10;
          break;

        case 'adsense_cse_loc_top_bottom':
          $forid = 11;
          break;

        case 'adsense_cse_loc_right':
          $forid = 9;
          break;
      }

      if ($branding == 'adsense_cse_branding_watermark') {
        $script = $base_url . '/' . drupal_get_path('module', 'adsense_cse') . '/js/adsense_cse.js';
        // When using a watermark, code is not reusable due to indentation.
        $content = <<<CSE_TXT1
<script type="text/javascript"><!--
drupal_adsense_cse_lang = '{$language}';
//-->
</script>
<form action="{$results_path}" id="cse-search-box">
  <div>{$hidden_q_field}
    <input type="hidden" name="cx" value="partner-{$client}:{$this->slot}" />
    <input type="hidden" name="cof" value="FORID:{$forid}" />
    <input type="hidden" name="ie" value="{$encoding}" />
    <input type="text" name="as_q" size="{$textbox_length}" />
    <input type="submit" name="sa" value="{$search}" />
  </div>
</form>
<script type="text/javascript" src="{$script}"></script>
CSE_TXT1;
// <script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=cse-search-box&amp;lang=en"></script>
      }
      else {
        $class = ($branding == 'adsense_cse_branding_right') ? 'cse-branding-right' : 'cse-branding-bottom';

        $content = <<<CSE_TXT2
<style type="text/css">
@import url(http://www.google.com/cse/api/branding.css);
</style>
<div class="{$class}" style="background-color:#{$box_background_color};color:#{$box_text_color}">
  <div class="cse-branding-form">
    <form action="{$results_path}" id="cse-search-box">
      <div>{$hidden_q_field}
        <input type="hidden" name="cx" value="partner-{$client}:{$this->slot}" />
        <input type="hidden" name="cof" value="FORID:{$forid}" />
        <input type="hidden" name="ie" value="{$encoding}" />
        <input type="text" name="as_q" size="{$textbox_length}" />
        <input type="submit" name="sa" value="{$search}" />
      </div>
    </form>
  </div>
  <div class="cse-branding-logo">
    <img src="http://www.google.com/images/poweredby_transparent/poweredby_{$box_background_color}.gif" alt="Google" />
  </div>
  <div class="cse-branding-text">
    {$custom_search}
  </div>
</div>
CSE_TXT2;
      }
      // Remove empty lines.
      $content = str_replace("\n\n", "\n", $content);

      return ['content' => $content, 'format' => 'Search Box'];
    }
    return [];
  }

}
