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

You can customize the colors and format if you want.

Displaying Ads
--------------
Ads can be displayed in blocks or in any phptemplate based theme.

* Blocks

To display ads in blocks, add a new block, make sure its type is "PHP", and 
then enter the following:

<?php
print adsense_display("120x600");
?>

Change the 120x600 to any other format you like from the supported list
above.

If you want to make sure that you do not get errors if adsense module is
accidentally disabled or deleted, then use the long form:

<?php
if (module_exist("adsense"))
{
 print adsense_display("120x600");
}
?>

* Themes

You must use a phptemplate based theme to display ads from within the theme.
This requires some familiarity with PHP. Edit the page.tpl.php file in your
theme directory, and add:

<?php print adsense_display("468x60"); ?>

Again, you can select any of the supported formats above.

Bugs/Features/Patches:
----------------------
If you want to report bugs, feature requests, or submit a patch, please do so
at the project page on the Drupal web site.
http://drupal.org/project/adsense

Author
------
Khalid Baheyeldin (http://baheyeldin.com/khalid)

If you use this module, find it useful, and want to send the author
a thank you note, then use the Feedback/Contact page at the URL above.

The author can also be contacted for paid customizations of this
and other modules.
