<?php

/**
 * @file
 * Help file for the Managed ads generator module.
 */

/**
 * Creates the help text for the Managed Ads tab.
 *
 * @return string
 *   HTML with the help text
 */
function adsense_cse_help_text() {
  $output = <<<EOF
<h2>Overview</h2>
<p>This module enables the simple inclusion of the new form of Google
AdSense for Search in your Backdrop site.</p>

<h2>Prerequisites</h2>
<p>You must have a Google AdSense account before using this module.</p>

<h2>Configuration</h2>
<p>To use this module, simply go to
<a href="https://www.google.com/adsense/settings">Google's AdSense site</a>
and create your AdSense for Search ad. The generated code will contain a
field with partner-<em>Publisher ID</em>:<em>Slot Id</em>. If the code
provided is, for example, partner-pub-0123456789:<strong>abcdef-ghij
</strong>, the Slot Id for that ad is <strong>abcdef-ghij</strong>.</p>
<p>When you create your ad in your Google Adsense account, it generally
takes less than 30 minutes before they start showing in your site, but it
can take as long as 48 hours. See the <a
href="https://www.google.com/adsense/support/bin/answer.py?answer=44511">
AdSense Code Implementation Guide</a> for more details.</p>
EOF;
  return $output;
}
