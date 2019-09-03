<?php

/**
 * @file
 * Contains the functions to generate the ads.txt page.
 */

/**
 * Generates the ads.txt page.
 */
function adsense_adstxt_controller() {
  $client = adsense_get_client_slot_id();

  if (!empty($client)) {
    drupal_add_http_header('Content-Type', 'text/plain');
    print "google.com, $client, DIRECT, f08c47fec0942fa0\n";
  }
  else {
    drupal_not_found();
  }

  drupal_exit();
}
