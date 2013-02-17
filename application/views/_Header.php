<div class="header_wrap">
  <!-- start of preloader divs -->
  <div class="preloader">
    <div class="setupHover"></div>
    <div class="viewSplitHover"></div>
    <div class="viewHover"></div>
    <div class="manageHover"></div>
    <div class="playHover"></div>
    <div class="mommyBG"></div>
    <div class="mommyMobileBG"></div>
    <div class="closeHover"></div>
  </div>
  <!-- end of preloader divs -->
  
  <div class="head_widget_wrap <?= (empty($hideNavigation)) ? 'nav-subnav-shown':'nav-subnav-hide'; ?>">
    <span class="fbShare head_widget">
      <span class="inner_widget">
        <fb:share-button <?= ($mapp == 'PoolSingle') ? 'expr:href="data:post.url"' : 'href="http://www.playtexbabypool.com/dev/"' ?> type="button_count" data-width="90" data-height="20" />
      </span>
    </span>
    <span class="fbLike head_widget <?= (isset($firstName)) ? '':'last'; ?>">
      <span class="inner_widget">
        <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FPlaytexBaby&amp;send=false&amp;layout=button_count&amp;width=90&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=20&amp;appId=256375344488507" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:20px; padding:0; margin:0;" allowTransparency="true"></iframe>
      </span>
    </span>
    <?php if (isset($firstName)) : ?>
    <span class="fbInfo head_widget last">
      <span class="inner_widget">
        <!-- <img class="fbImg" src="//graph.facebook.com/<?= $userID;?>/picture?width=37&height=37" /> -->
        <a href="/dev/" class="logoutLink" onclick="FB.logout();">Logout</a>
        </span>
    </span>
    <?php endif; ?>
  </div>
  <a class="pbpLogo" href="/dev/">
    <img src="http://www.playtexbabypool.com/dev/_/img/header_logo-01.png" />
  </a>
  <div class="clear">&nbsp;</div>
  <?php
    // NOTE: The 'Make a Guess' and 'Create a Pool' Popups are in _footer.php
    if (empty($hideNavigation)) :
  ?>
  <div class="navigation">
    <ul>
      <li><a href="#popupCreatePool" data-rel="popup" data-position-to="window" data-transition="pop">Create Pool</a></li><li><a href="http://www.playtexbabypool.com/dev/">View Pools</a></li><li><a href="http://www.playtexbabypool.com/dev/howtoplay/" class="last">How to Play</a></li>
      <!--
        <li><a href="#popupCreatePool" data-rel="popup" data-position-to="window" data-transition="pop">Create Pool</a></li><li><a href="http://www.playtexbabypool.com/dev/">View Pools</a></li><li><a href="#" class="<?= ($mapp == 'PoolSingle' && empty($hasMadeGuess) && !empty($poolStatus) && $poolStatus == 'running') ? '':'last' ?>">How to Play</a></li><?php if ($mapp == 'PoolSingle' && empty($hasMadeGuess) && !empty($poolStatus) && $poolStatus == 'running') : ?><li><a href="#popupCreateGuess" data-rel="popup" data-position-to="window" data-transition="pop" class="last">Make Guess</a></li><?php endif; ?>
      -->
    </ul>
  </div>
  <div class="clear">&nbsp;</div>
  <?php endif; ?>
</div>