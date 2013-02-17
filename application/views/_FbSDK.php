<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId: '256375344488507',
      channelUrl: '//www.playtexbabypool.com/dev/channel.php',
      status: true,
      cookie: true,
      xfbml: true,
      oauth: true
    });
       
    FB.Event.subscribe('auth.login', function(response) {
      window.location.reload();
    });
    FB.Event.subscribe('auth.logout', function(response) {
      window.location.reload();
    });

    FB.getLoginStatus(function(response) {
      var token = response,
          cookie = readCookie('ptxbp_256375344488507');
      if (response.authResponse && response.authResponse.accessToken != cookie && response.authResponse.expiresIn >= 0) { /* accessToken | expiresIn */
        createCookie('ptxbp_256375344488507', response.authResponse.accessToken, response.authResponse.expiresIn)
      }
    });

    FB.Canvas.setSize({ width: 810 });
    FB.Canvas.setAutoGrow();

  };
  
  (function(d, debug){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0]
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
     ref.parentNode.insertBefore(js, ref);
   }(document, false)); /*<<--debug*/

  function fbLogin() {
    FB.login(function(response) {
      if (response.session) { //user is logged in, reload page
        window.location.reload(true);
        return false;
      }
      else {
        window.location.reload(true);
        return false;
      } // user is not logged in
    }, {scope:'email,user_likes,publish_actions,publish_stream,user_photos'});
    /* email,user_likes,friends_likes,publish_actions,publish_stream,read_friendlists // offline_access */
  }
</script>