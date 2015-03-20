<?php

/**
 * @file
 * Contains \Drupal\adsense_search\Plugin\AdsenseAd\SearchAd.
 */

namespace Drupal\adsense_search\Plugin\AdsenseAd;

use \Drupal\Core\Url;

use Drupal\adsense\SearchAdBase;
use Drupal\adsense\PublisherId;

class SearchAd extends SearchAdBase {
  private $channel;

  public function __construct($args) {
    $ch = (!empty($args['channel'])) ? $args['channel'] : 1;

    $this->channel = $ch;
  }

  public function getAdPlaceholder() {
    $client = PublisherId::get();

    $content = "Old<br/>client = {$client}";

    return ['content' => $content, 'format' => 'Search Box'];
  }

  public function getAdContent() {
    $client = PublisherId::get();

    $config = \Drupal::config('adsense_search.settings');
    $border   = $config->get('adsense_search_color_border');
    $title    = $config->get('adsense_search_color_title');
    $bg       = $config->get('adsense_search_color_bg');
    $text     = $config->get('adsense_search_color_text');
    $url      = $config->get('adsense_search_color_url');
    $visited  = $config->get('adsense_search_color_visited_url');
    $light    = $config->get('adsense_search_color_light_url');
    $logobg   = $config->get('adsense_search_color_logo_bg');
    $logo     = $config->get('adsense_search_logo');
    $search_button = $config->get('adsense_search_button');
    $box_text_color = $config->get('adsense_search_color_box_text');
    $box_background_color = $config->get('adsense_search_color_box_background');
    $encoding = $config->get('adsense_search_encoding');

    $domain_0 = $config->get('adsense_search_domain_0');
    $domain_1 = $config->get('adsense_search_domain_1');
    $domain_2 = $config->get('adsense_search_domain_2');
    $domain   = $domain_1 ? "$domain_0;$domain_1" : $domain_0;
    $domain   = $domain_2 ? "$domain;$domain_2" : $domain;

    $language = $config->get('adsense_search_language');
    $textbox_length = $config->get('adsense_search_textbox_length');

    if (TRUE) {
      $results_path = Url::fromRoute('adsense_search.results');
      $hidden_q_field = "";
    }
    else {
      global $base_url;

      $results_path = $base_url;
      $hidden_q_field = '<input type="hidden" name="q" value="." />';
    }

    if ($logo != 'adsense_search_logo_on_button') {
      $btn = t('Search');
      if ($box_background_color == '#000000') {
        $logo_color = 'blk';
      }
      elseif ($box_background_color == '#CCCCCC') {
        $logo_color = 'gry';
      }
      else {
        $logo_color = 'wht';
      }

      $part1 = "<a href=\"http://www.google.com/\">\n" .
        "<img src=\"http://www.google.com/logos/Logo_25{$logo_color}.gif\" border=\"0\" alt=\"Google\" align=\"middle\"></img></a>";
      $part3 = "";
      if ($logo == 'adsense_search_logo_google') {
        $part1 .= "\n</td>\n<td nowrap=\"nowrap\">";
        $part3 = "<td>&nbsp;</td>";
      }
      elseif ($logo == 'adsense_search_logo_above_textbox') {
        $part1 .= "\n<br/>";
      }
    }
    else {
      $btn = t('Google Search');
      $part1 = "</td>\n<td nowrap=\"nowrap\">";
      $part3 = "<td>&nbsp;</td>";
    }

    $button_html = "<label for=\"sbb\" style=\"display: none\">Submit search form</label>\n" .
      "<input type=\"submit\" name=\"sa\" value=\"{$btn}\" id=\"sbb\"></input>";

    if (!$search_button) {
      $part2 = $button_html;
      $part5 = "";
    }
    else {
      $part5 = $button_html;
      $part2 = "";
    }

    // Searched domains >=1 (2 or 3)
    if ($domain_1) {
      $part4 = "<tr>\n<td>\n<input type=\"radio\" name=\"sitesearch\" value=\"$domain_1\" id=\"ss2\"></input>\n" .
        "<label for=\"ss2\" title=\"Search $domain_1\"><font size=\"-1\" color=\"$box_text_color\">$domain_1</font></label></td>\n";
      if ($domain_2) {
        $part4 .= "<td>\n<input type=\"radio\" name=\"sitesearch\" value=\"$domain_2\" id=\"ss3\"></input>\n" .
          "<label for=\"ss3\" title=\"Search $domain_2\"><font size=\"-1\" color=\"$box_text_color\">$domain_2</font></label></td>";
      }
      else {
        $part4 .= "<td></td>";
      }
      $part4 .= "\n</tr>";
    }
    else {
      $part4 = "";
    }

    $channel = $config->get('adsense_ad_channel_' . $this->channel);

    if (!empty($channel)) {
      $part6 = "<input type=\"hidden\" name=\"channel\" value=\"$channel\"></input>";
    }
    else {
      $part6 = "";
    }

    $part7 = $config->get('adsense_search_safe_mode') ? '<input type="hidden" name="safe" value="active"></input>' : '';

    $content = <<<SEARCH_TXT
<!-- SiteSearch Google -->
<form method="get" action="$results_path" target="_top">
<table border="0" bgcolor="$box_background_color">
<tr><td nowrap="nowrap" valign="top" align="left" height="32">
$part1
$hidden_q_field
<input type="hidden" name="domains" value="$domain"></input>
<label for="sbi" style="display: none">Enter your search terms</label>
<input type="text" name="as_q" size="$textbox_length" maxlength="255" value="" id="sbi"></input>
$part2
</td></tr>
<tr>
$part3
<td nowrap="nowrap">
<table>
<tr>
<td>
<input type="radio" name="sitesearch" value="" checked id="ss0"></input>
<label for="ss0" title="Search the Web"><font size="-1" color="$box_text_color">Web</font></label></td>
<td>
<input type="radio" name="sitesearch" value="$domain_0" id="ss1"></input>
<label for="ss1" title="Search $domain_0"><font size="-1" color="$box_text_color">$domain_0</font></label></td>
</tr>
$part4
</table>
$part5
<input type="hidden" name="client" value="$client"></input>
<input type="hidden" name="forid" value="1"></input>
$part6
<input type="hidden" name="ie" value="$encoding"></input>
<input type="hidden" name="oe" value="$encoding"></input>
$part7
<input type="hidden" name="cof" value="GALT:$url;GL:1;DIV:$border;VLC:$visited;AH:center;BGC:$bg;LBGC:$logobg;ALC:$title;LC:$title;T:$text;GFNT:$light;GIMP:$light;FORID:11"></input>
<input type="hidden" name="hl" value="$language"></input>
</td></tr></table>
</form>
<!-- SiteSearch Google -->
SEARCH_TXT;

    // Remove empty lines.
    $content = str_replace("\n\n", "\n", $content);

    return ['content' => $content, 'format' => 'Search Box'];
  }

}
