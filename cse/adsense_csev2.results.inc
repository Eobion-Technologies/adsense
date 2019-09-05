<?php

/**
 * @file
 * Displays the page containing the results of the Adsense for Search box v2.
 */

/**
 * Creates the CSE v2 search results page for site-embedded search results.
 *
 * @return string
 *   JavaScript that embeds the Google results
 */
function _adsense_csev2_results($slot) {
  $client = adsense_get_client_slot_id();

  // Log the search keys:
  watchdog('AdSense search', 'Search keywords: %keywords', array('%keywords' => urldecode(check_plain($_GET['as_q']))));

  // Output search results.
  if (variable_get('adsense_test_mode', ADSENSE_TEST_MODE_DEFAULT)) {
    $output = theme('adsense_placeholder', array(
      'text' => "Results",
      'height' => 100,
    ));
  }
  else {
    // Add data-queryParameterName because of conflicts with Drupal's 'q' query.
    $output = "<script async src='https://cse.google.com/cse.js?cx=partner-$client:$slot'></script><div class='gcse-searchresults-only' data-queryParameterName='as_q'></div>";
  }

  return $output;
}
