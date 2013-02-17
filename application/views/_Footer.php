<!-- Footer -->
<div class="footer_wrap">
  <div class="clear">&nbsp;</div>
  <a href="http://www.playtexbaby.com/" target="_blank">
    <img class="footer_logo" src="http://www.playtexbabypool.com/dev/_/img/footer_logo-02.png" />
  </a>
  <div class="footer_text">
    <div class="ft_each"><a class="playtexbabydotcom" href="http://www.playtexbaby.com/" target="_blank">PLAYTEX BABY.COM</a><span class="hideMobile"> | </span><a href="http://www.playtexbaby.com/terms.aspx" target="_blank">TERMS OF USE</a> | <a href="http://www.playtexbaby.com/privacy.aspx" target="_blank">PRIVACY POLICY</a></div>
    <div class="ft_each"><span class="mobileBlock">© 2012 Energizer Personal Care, LLC. </span><span class="mobileBlock">Playtex is a licensed trademark. </span><span class="mobileBlock">All other trademarks are property of respective owners.</span></div>
  </div>
</div>



<!-- Popup Markup -->
<?php
  //-- Popup -- Create a Pool --//
  if (1 == 1) :
?>
<div data-role="popup" id="popupCreatePool" style="max-width:320px;" class="ui-corner-all" data-theme="a" data-overlay-theme="d">
  <a href="#" data-rel="back" class="ui-btn-right closeBtn"></a>
    <!-- <a href="#" data-rel="back" data-role="button" data-theme="c" data-icon="delete" data-iconpos="notext" class="ui-btn-right closeBtn">Close</a> -->

	<div data-role="header" class="ui-corner-top">
		<h1>CREATE BABY POOL</h1>
	</div>
	<div data-role="content" class="ui-corner-bottom ui-content-padding">
		<h2 data-theme="b" style="font-size:26px;text-align:center;">
		  <?php if (empty($isMotherOfActivePool) && empty($isMotherOfPendingPool)) : ?>
		  Are you the Mother or an Organizer?
      <?php else : ?>
		  Create a Pool for a Mother?
      <?php endif; ?>
		</h2>
		<p class="headingDesc" style="text-align:center;">
		  <?php if (empty($isMotherOfActivePool) && empty($isMotherOfPendingPool)) : ?>
		  If you are not the Mother of the Baby Pool please choose Organizer to get a Mother jump started.
      <?php else : ?>
		  Give a Mother jump started on creating a pool.
      <?php endif; ?>
		</p>
		<div style="text-align:center;" class="popupBox">
		  <?php if (empty($isMotherOfActivePool) && empty($isMotherOfPendingPool)) : ?>
      <a href="/dev/create/mother/"    data-role="button" data-inline="true" data-mini="true" data-icon="arrow-r" data-iconpos="right" data-theme="c" data-transition="slide" class="btn-red-ovrd">Mother</a>
      <?php endif; ?>
      <a href="/dev/create/organizer/" data-role="button" data-inline="true" data-mini="true" data-icon="arrow-r" data-iconpos="right" data-theme="c" data-transition="slide" class="btn-red-ovrd">Organizer</a>
		</div>
	</div>
</div>
<?php 
  endif;
?>