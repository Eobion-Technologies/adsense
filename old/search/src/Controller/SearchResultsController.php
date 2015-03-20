<?php

/**
 * @file
 * Contains \Drupal\adsense_search\Controller\SearchResultsController.
 */

namespace Drupal\adsense_search\Controller;

use Drupal\Component\Utility\String;
use Drupal\Core\Controller\ControllerBase;

/**
 * Default controller for the adsense_search module.
 */
class SearchResultsController extends ControllerBase {

  public function display() {
    $search_config = \Drupal::config('adsense_search.settings');
    $width = $search_config->get('adsense_search_frame_width');
    $country = $search_config->get('adsense_search_country');

    $core_config = \Drupal::config('adsense.settings');
    if ($core_config->get('adsense_test_mode')) {
      $content = theme_adsense_placeholder(['content' => "Results<br/>width = ${width}<br/>country = ${country}", 'width' => $width, 'height' => 100]);
    }
    else {
      // Log the search keys:
      \Drupal::logger('AdSense Search')->notice('Search keywords: %keyword', [
        '%keyword' => urldecode(String::checkPlain($_GET['as_q'])),
      ]);

      $content = <<<SEARCH_RESULTS_TXT
<div id="googleSearchUnitIframe"></div>
<script type="text/javascript">
  var googleSearchIframeName = 'googleSearchUnitIframe';
  var googleSearchFrameWidth = $width;
  var googleSearchFrameborder = 0 ;
  var googleSearchDomain = '$country';
</script>
<script type="text/javascript"
  src="http://www.google.com/afsonline/show_afs_search.js">
</script>
SEARCH_RESULTS_TXT;
    }
    return [
      '#markup' => $content,
    ];
  }

}
