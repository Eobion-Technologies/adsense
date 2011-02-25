
Copyright 2005 http://2bits.com

Drupal 4.7 update sponsored by http://scribendi.com


Description
-----------
This module provides web site admins the factility to display Google AdSense
ads on their web site, thus earning revenue.


Resources
---------
You can read the module author's collection of articles on resources for
using Google Adsense with Drupal. They contain hints and tips on how to use
the module, as well as Adsense in general.

http://baheyeldin.com/click/476/0


Prerequisites
-------------
You must signup for a Google AdSense account. If you do not have an account,
please consider using the author's referral link for signup at the following
URL:
http://baheyeldin.com/click/476/0


Installation
------------
To install, copy the adsense directory and all its contents to your modules
directory.


Configuration
-------------
To enable this module, visit Administer -> Site building -> Modules, and
enable adsense.

To configure it, go to Administer -> Site configuration -> Google AdSense.

Follow the online instructions on that page on how to display ads and the
various ways to do so.


Bugs/Features/Patches
---------------------
If you want to report bugs, feature requests, or submit a patch, please do
so at the project page on the Drupal web site.
http://drupal.org/project/adsense


Hacks/Workarounds
-----------------
If you would prefer the Adsense ID field in Profiles to be invisible to all
users except the admin, here's a workaround:

1) Log in as User 1. Set up the profile field as described in the help text
   ("Private field, content only available to privileged users") and enter
   your account number. Press save. This will store the record in the
   profile_values table. This is where the Adsense module expects to find
   the ID value.

2) Once saved, you can then set the field to "hidden profile field, only
   accessible by administrators, modules and themes." While this option
   stores the ID in a completely different table, the original value in the
   profile_values table DOES NOT get deleted. The Adsense module will
   continue to find and load the ID value properly. However, the field will
   now be invisible to other users.

NOTE: Just keep in mind that if you need to change the ID value later, you
will first need to:

1) Set the field option back to "Private field, content only available to
   privileged users"
2) Put in the new value and save
3) Then set the field option to "hidden profile field, only accessible by
   administrators, modules and themes"

You can check to make sure the Adsense module is picking up the proper value
by viewing the source of a page with the ads and checking the javascript
code. You should see the value of your account ID there.


Author
------
Khalid Baheyeldin (http://baheyeldin.com/khalid and http://2bits.com)

If you use this module, find it useful, and want to send the author a thank
you note, then use the Feedback/Contact page at the URL above.

The author can also be contacted for paid customizations of this and other
modules.

