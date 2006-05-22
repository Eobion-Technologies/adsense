/*
 * adsense_click.js - fires counter to log adsense clicks
 * original concept taken from http://www.webmasterworld.com/forum89/1788.htm
 */
var lastStatus = '';
function aslog(e) {
  window.focus();
  if (window.status && (window.status!=lastStatus)) {
    lastStatus = window.status;
    var bug = new Image();
    bug.src = window.location.protocol + '//' + window.location.host + '/adsense/counter';
  }
}

var iframeObj;
var elements;
elements = document.getElementsByTagName("iframe");
for (var i = 0; i < elements.length; i++) {
  if(elements[i].src.indexOf('googlesyndication.com') > -1) {
    if (document.layers) {
      elements[i].captureEvents(Events.ONFOCUS);
    }
    elements[i].onfocus = aslog;
    iframeObj = elements[i];
  }
}

function getVariable(name) {
  var dc = iframeObj.src;
  var prefix = name + "=";
  var begin = dc.indexOf("&" + prefix);
  if (begin == -1) {
    begin = dc.indexOf("?" + prefix);
    if (begin == -1) {
      return null;
    }
  } else {
    begin += 1;
  }
  var end = iframeObj.src.indexOf("&", begin);
  if (end == -1) {
    end = dc.length;
  }
  return unescape(dc.substring(begin + prefix.length, end));
}
