<?php
// $Id$
// Copyright 2005-2008 Khalid Baheyeldin - http://2bits.com
// Copyright 2008 Joao Ventura - http://www.venturas.org

/**
 * @file
 * Helpfile for the Publisher ID tab of the adsense module configuration
 */

function adsense_id_help_text() {
  $referral_link = 'http://baheyeldin.com/click/476/1';

  $output = <<<EOF
<h2>Overview</h2>
<p>This module provides a simple way of selecting the Adsense Publisher ID for a single owner site
that does not need revenue sharing.</p>

<h2>Prerequisites</h2>
<p>You must have a Google AdSense account before using this module.  If you do not have an account,
then please consider using <a href="$referral_link">the modules author's referral link</a>, which
provides us with a referral fee from Google at absolutely no cost to you. This page also contains
various useful links and resources on AdSense, and how to optimize your site for it.</p>

<h2>Configuration</h2>
<p>To use this module, simply enter your Google Adsense Publisher ID in the text field, and click
the 'Save configuration' button.</p>
EOF;
  return $output;
}

