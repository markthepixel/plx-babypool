<title>Playtex Baby Pool</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<meta name="robots" content="noindex,nofollow">

<?php if ($mapp == 'PoolSingle' && !empty($openGraphHead)) : ?>
<?= $openGraphHead; ?>
<?php endif; ?>

<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
<![endif]-->
<!--[if lt IE 8]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
<![endif]-->
<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->

<?php //The Fonts; ?>
<script type="text/javascript" src="//use.typekit.net/ivd2yqw.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

<?php //The CSS; ?>
<link rel="stylesheet" type="text/css" href="//www.playtexbabypool.com/dev/_/css/preloader.css" />
<link rel="stylesheet" type="text/css" href="//www.playtexbabypool.com/dev/_/css/jquery-ui-1.10.0.custom.min.css" />
<link rel="stylesheet" type="text/css" href="//www.playtexbabypool.com/dev/_/css/jqm-datebox.min.css" />
<link rel="stylesheet" type="text/css" href="//www.playtexbabypool.com/dev/_/css/playtex-baby-pool.min.css" />
<link rel="stylesheet" type="text/css" href="//www.playtexbabypool.com/dev/_/css/jquery.mobile.structure-1.2.0.min.css" />
<link rel="stylesheet" type="text/css" href="//www.playtexbabypool.com/dev/_/css/jquery-mobile-override.css" />
<link rel="stylesheet" type="text/css" href="//www.playtexbabypool.com/dev/_/css/jquery-mobile-fluid960.css" />
<link rel="stylesheet" type="text/css" href="//www.playtexbabypool.com/dev/_/css/tabletsorter.mod.css">
<link rel="stylesheet" type="text/css" href="//www.playtexbabypool.com/dev/_/css/styles.css" />

<?php //The JS Libs; ?>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).bind('mobileinit', function () {
  //$.mobile.ajaxEnabled = false; //<--
  $.mobile.loader.prototype.options.theme = "b";
  $.mobile.loader.prototype.options.text = "Loading...";
  $.mobile.loader.prototype.options.textVisible = true;
  $.mobile.defaultPageTransition = 'slide';
})
</script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery.mobile-1.2.0.min.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/babypool.scripts.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery.carouFredSel-6.1.0.min.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jqm-datebox.core.min.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jqm-datebox.mode.calbox.min.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jqm-datebox.mode.flipbox.min.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery.mobile.datebox.i18n.en_US.utf8.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery.tablesorter.min.js"></script>	
<!--
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/responsive-tables.min.js"></script>
-->

<!--[if gte IE 9]>
  <style type="text/css">
    /* IE9 Gradient */
    .ui-bar-c, .ui-submit.ui-btn-up-c, .ui-btn-up-c, .ui-radio-on.ui-btn-up-a {
       filter: none;
    }
  </style>
<![endif]-->

<script type="text/javascript">
  //jQMobile: Change Default Date
  jQuery.extend(jQuery.mobile.datebox.prototype.options, {
    'overrideDateFormat': '%m/%d/%y',
    'overrideHeaderFormat': '%m/%d/%y',
  });
  //jQMobie: On page change
  $(document).on('pageshow', function(){
    try{
        FB.XFBML.parse();
    } catch(err){ }
    
  });
</script>