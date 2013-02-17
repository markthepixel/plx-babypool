
  function createCookie(name,value,secs) {
    if (secs) {
      var date = new Date();
      date.setTime(date.getTime()+(secs*1000));
      var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = escape(name)+"="+escape(value)+expires+"; path=/";
  }
  function readCookie(name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length,c.length));
    }
    return null;
  }