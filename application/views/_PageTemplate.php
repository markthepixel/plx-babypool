<?php header('p3p: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml"> 
 <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# playtexbabypool: http://ogp.me/ns/fb/playtexbabypool#">
  <?=$_PageHeader;?>
  </head>
  <body>
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-36906935-1']);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <div id="page" data-role="page" data-theme="a">
      <div data-role="content" class="id-wrap container_12">
  
        <div class="id-header">
        <?=$_FbSDK;?>
        <?=$_Header;?>
        </div>
        
        <div class="id-content">
        <?=$_Content;?>
        </div>
        
        <div class="id-footer">
        <?=$_Footer;?>
        </div>

      </div>
    </div>
  </body>
</html>