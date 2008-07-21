<?php
// $Id$

/**
 * @file
 * Displays the page containing the results of the Adsense for Search box
 */

function _adsense_search_results() {
  // Log the search keys:
  watchdog('AdSense', 'Search keywords: %keyword', array('%keyword' => urldecode($_GET['as_q'])), WATCHDOG_NOTICE);

  // Output search results
  $width   = variable_get('adsense_search_frame_width', '800');
  $country = variable_get('adsense_search_country', 'www.google.com');

  if (variable_get('adsense_test_mode', 0)) {
    $adtest = '  var googleAdtest = "on";';
  }

  $output = <<<SEARCH_RESULTS_TXT
<!-- Google Search Result Snippet Begins -->
<div id="googleSearchUnitIframe"></div>
<script type="text/javascript">
  var googleSearchIframeName = 'googleSearchUnitIframe';
  var googleSearchFrameWidth = $width;
  var googleSearchFrameborder = 0 ;
  var googleSearchDomain = '$country';
$adtest
</script>
<script type="text/javascript"
  src="http://www.google.com/afsonline/show_afs_search.js">
</script>
<!-- Google Search Result Snippet Ends -->
SEARCH_RESULTS_TXT;

  // Remove empty lines
  $output = str_replace("\n\n", "\n", $output);

  return $output;
}
