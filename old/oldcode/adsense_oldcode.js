// $Id$

if (Drupal.jsEnabled) {
  $(document).ready(function () {
    var i=0;
    for (i=1;i<=5;i++) {
      // initiate farbtastic colorpicker
      var farb = $.farbtastic("#colorpicker-" + i);
      farb.linkTo("#edit-adsense-color-text-" + i);
      farb.linkTo("#edit-adsense-color-border-" + i);
      farb.linkTo("#edit-adsense-color-bg-" + i);
      farb.linkTo("#edit-adsense-color-link-" + i);
      farb.linkTo("#edit-adsense-color-url-" + i);
    }
  });
}
