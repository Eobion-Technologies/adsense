<?php

/**
 * @file
 * Displays the page containing the results of the Adsense for Search box.
 */

/**
 * Creates the CSE search results page for site-embedded search results.
 *
 * @return string
 *   JavaScript that embeds the Google results
 */
function _adsense_cse_results() {
  $config = config('adsense_cse.settings');
  global $base_url;

  // Log the search keys:
  watchdog('AdSense search', 'Search keywords: %keywords', array('%keywords' => urldecode(check_plain($_GET['as_q']))));

  $script = $base_url . '/' . backdrop_get_path('module', 'adsense_cse') . '/adsense_cse.results.js';

  // Output search results.
  $width   = $config->get('adsense_cse_frame_width');
  $country = $config->get('adsense_cse_country');

  // TODO This variable was probably removed in Backdrop without replacement.
  if (variable_get('adsense_test_mode', ADSENSE_TEST_MODE_DEFAULT)) {
    $output = theme('adsense_placeholder', array(
      'text' => "Results<br />width = {$width}<br />country = {$country}",
      'width' => $width,
      'height' => 100,
    ));
  }
  else {
    $output = <<<CSE_RESULTS_TXT
<div id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = "cse-search-results";
  var googleSearchFormName = "cse-search-box";
  var googleSearchFrameWidth = $width;
  var googleSearchDomain = "$country";
  var googleSearchPath = "/cse";
  var googleSearchQueryString = "as_q";
</script>
<script type="text/javascript" src="$script"></script>
CSE_RESULTS_TXT;
    // @codingStandardsIgnoreStart Backdrop.WhiteSpace.ScopeIndent.IncorrectExact
    // <script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
    // @codingStandardsIgnoreEnd

    // Remove empty lines.
    $output = str_replace("\n\n", "\n", $output);
  }

  return $output;
}
