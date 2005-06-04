$Id$

Copyright 2005 http://2bits.com

Description
-----------
This module provides web site admins the factility to display Google AdSense
ads on their web site, thus earning revenue.

The colors are customizable, as well as the type (text/image). Ads can be
displayed from themes, blocks or other modules.

Prerequisites
-------------
You must signup for a Google AdSense account. If you do not have an account,
go to http://www.google.com/adsense to apply for one.

Supported Formats
-----------------
The following ad formats are supported:

Type            Dimensions
Banner          468x60
Large Rectangle 336x280
Skyscraper      120x600
Wide Skyscraper 160x600
Ad Links        120x90
Wide Ad Links   160x90

Installation
------------
This module requires no database changes.

To install, copy the adsense.module to your module directory.

Configuration
-------------
To enable this module, visit Admin -> Modules, and enable adsense.

To configure it, go to Admin -> Settings -> AdSense.

The only required parameter is the your Google account Client ID. You
can get that from the Ad code in your Google AdSense account.

You can customize the colors and format if you want. Three color and 
type groups can be configured. This means that you can have ads in
different colors in different places on your pages. This is useful
if your theme uses different color schemes for different areas, such 
as content, left sidebar, and right sidebar.
You can alsoi have an image ad in some place, and a text ad in another,
or you can make the ads contrast with your theme, or blends with it.

If you are using Custom Channels, you can configure up to 5 custom
channels and display ads for those channels. If you are using URL
channels only, then leave the custom channels blank.

The advanced options include the ability to disable showing ads. This
is useful if the site is on a test machine that you do not want to
get crawled by Google, or when you copy the data to a test machine
for demos and such. A configurable placeholder is available to show
the place where ads would display.

Displaying Ads
--------------

Ads can be displayed in blocks or in any phptemplate based theme.

To display ads, you call a function adsense_display and supply it with
the following arguments.

* Format: This is a string of two numbers with an "x" in between. It can
  be any valid combination from the list provided above. If not specified,
  then 160x600 is assumed.

* Group: This is the group that denotes the type (text or image) and color
  of the ad. This can be 1, 2 or 3. If not specified, then 1 is assumed.

* Channel: This is the Custom Channel for the ad, as configured in AdSense.
  This is an optional parameter and if not specified, then 1 is assumed.
  If you did not configure any channels, then leave this parameter out.

* Blocks

To display ads in blocks, add a new block, make its type "PHP", and enclose
it in php tags, such as:

<?php print adsense_display("120x600", 1, 2); ?>

If you want to make sure that you do not get errors if adsense module is
accidentally disabled or deleted, then use the longer form:

<?php
if (module_exist("adsense"))
{
 print adsense_display("120x600", 2, 4);
}
?>

* Themes

You must use a phptemplate based theme to display ads from within the theme.
This requires some familiarity with PHP. Edit the page.tpl.php file in your
theme directory, and add:

<?php print adsense_display("468x60"); ?>

Make sure you enclose it in php tags.

You could also use the longer format that protects you against deleting or
disabling the module:

<?php
if (module_exist("adsense"))
{
 print adsense_display("120x600", 2, 4);
}
?>

Notes:
------
The site administrator will not see ads displayed as long as they are logged in.
This is by design, in order not to skew the page views, and not to accidentally
click on ads (against Google's policy). Log out to see the ads.

You can use the advanced options to disable ads and configure a placeholder when
you are developing or theming to know where the ads will appear.

If ads are not displayed, that could be caused by several things:

- You are logged in as the site administrator. Log off to see the ads.

- Your site is still new and Google did not index it yet.

- The maximum possible ad units to display have already been displayed. Your
  page does not have enough content to display more than one or two units.

- Check the page source for comments like this <!--adsense: ???-->. These tell
  more what is going on, and if you know PHP you can trace those in the module's
  source code.

Bugs/Features/Patches:
----------------------
If you want to report bugs, feature requests, or submit a patch, please do so
at the project page on the Drupal web site.
http://drupal.org/project/adsense

Author
------
Khalid Baheyeldin (http://baheyeldin.com/khalid and http://2bits.com)

If you use this module, find it useful, and want to send the author
a thank you note, then use the Feedback/Contact page at the URL above.

The author can also be contacted for paid customizations of this
and other modules.
