<?php

/**
 * @file
 * Contains \Drupal\adsense_cse\Controller\CseResultsController.
 */

namespace Drupal\adsense_cse\Controller;

use Drupal\Component\Utility\String;
use Drupal\Core\Controller\ControllerBase;

/**
 * Default controller for the adsense_cse module.
 */
class CseResultsController extends ControllerBase {

  public function display() {
    $cse_config = \Drupal::config('adsense_cse.settings');
    $width = $cse_config->get('adsense_cse_frame_width');
    $country = $cse_config->get('adsense_cse_country');

    $core_config = \Drupal::config('adsense.settings');
    if ($core_config->get('adsense_test_mode')) {
      $content = theme_adsense_placeholder(['content' => "Results<br/>width = ${width}<br/>country = ${country}", 'width' => $width, 'height' => 100]);
    }
    else {
      // Log the search keys:
      \Drupal::logger('AdSense CSE')->notice('Search keywords: %keyword', [
        '%keyword' => urldecode(String::checkPlain($_GET['as_q'])),
      ]);

      $content = <<<CSE_RESULTS_TXT
<div id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = "cse-search-results";
  var googleSearchFormName = "cse-search-box";
  var googleSearchFrameWidth = $width;
  var googleSearchDomain = "$country";
  var googleSearchPath = "/cse";
  var googleSearchQueryString = "as_q";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
CSE_RESULTS_TXT;
    }
    return [
      '#markup' => $content,
    ];
  }

}
