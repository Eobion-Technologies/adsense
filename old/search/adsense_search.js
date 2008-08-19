// $Id$

if (Drupal.jsEnabled) {
  $(document).ready(function () {
    var colorFields = new Array();
    colorFields[0] = "#edit-adsense-search-color-border";
    colorFields[1] = "#edit-adsense-search-color-title";
    colorFields[2] = "#edit-adsense-search-color-bg";
    colorFields[3] = "#edit-adsense-search-color-text";
    colorFields[4] = "#edit-adsense-search-color-url";
    colorFields[5] = "#edit-adsense-search-color-visited-url";
    colorFields[6] = "#edit-adsense-search-color-light-url";
    colorFields[7] = "#edit-adsense-search-color-logo-bg";

    // initiate farbtastic colorpicker
    var farb = $.farbtastic("#colorpicker");

    for (x in colorFields) {
      farb.linkTo(colorFields[x]);
    };
  });
}
