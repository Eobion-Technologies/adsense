<?php
// $Id$
// Copyright 2005-2008 Khalid Baheyeldin - http://2bits.com
// Copyright 2008 Joao Ventura - http://www.venturas.org

/**
 * @file
 * Helpfile for the Publisher ID tab of the adsense_managed module configuration
 */

function adsense_managed_help_text() {
  $referral_link = 'http://baheyeldin.com/click/476/1';

  $output = <<<EOF
<h2>Overview</h2>
<p>This module enables the simple inclusion of the new form of Google AdSense Managed Ads in your
Drupal site.</p>

<h2>Prerequisites</h2>
<p>You must have a Google AdSense account before using this module.  If you do not have an account,
then please consider using <a href="$referral_link">the modules author's referral link</a>, which
provides us with a referral fee from Google at absolutely no cost to you. This page also contains
various useful links and resources on AdSense, and how to optimize your site for it.</p>

<h2>Configuration</h2>
<p>To use this module, simply go to <a href="https://www.google.com/adsense/settings">Google's
AdSense site</a> and create your ad units. Simply note down their slot numbers and use them in this
module.</p>
EOF;
  return $output;
}

