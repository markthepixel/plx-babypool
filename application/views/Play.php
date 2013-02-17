<?php if (!empty($statusMessage)) : ?>
<div class="notification_area">
  <h2 class="notification"><span><?= $statusMessage; ?></span></h2>
  <script>$(".notification_area").show().delay(5400).slideUp(1200);</script>
</div>
<?php endif; ?>
<div class="headline_box">
  <div class="headline_welcome">
    <div class="slogan hideMobile">
      <img src="http://www.playtexbabypool.com/dev/_/img/pick-play-prepare.png" />
    </div>
    <div class="welcome_desc outerText">
      <h1 class="innerHead">Welcome to Baby Pool,</h1>
      <div class="innerText">
        <span class="foldblock">The social game that challenges you and your friends to guess the details around a baby's arrival. Get your little knit thinking-caps on!</span>
      </div> <!-- /.innerText -->
      <h2 class="innerButton">
        <a href="#popupCreatePool" data-rel="popup" data-position-to="window" data-transition="pop" data-role="button" data-icon="arrow-r" data-iconpos="right" data-inline="true" data-theme="c" class="btn-red-ovrd">
          CREATE A BABY POOL
        </a>
      </h2>
    </div>  <!-- /#welcome_desc.outerText -->
    <div class="clear">&nbsp;</div>
  </div>  <!-- /#headline_welcome -->
</div> <!-- /#headline_box -->
<div class="content_wrap content_PIP sharpTop">
  <div class="desktop-not-collapsible"  data-role="collapsible" data-inset="false" data-theme="a" data-collapsed="<?= (!empty($usersPools)) ? 'false' : 'true'; ?>" data-collapsed-icon="plus" data-expanded-icon="minus" data-iconpos="right">
    <h2 class="poolList">Your Pools <span class="badge"><?= (!empty($usersPools)) ? count($usersPools) : '0'; ?></span></h2>
    <div class="doily aligntop hideMobile"><hr /></div>
    <?php if (!empty($usersPools)) : ?>
    <div class="list_carousel">
    <ul class="slider1">
    <?php foreach ($usersPools as $uPs) : ?>
      <li class="eachYourPool">
        <div class="userIdImage">
          <?php if ($uPs['poolStatus'] == 'pending' && $uPs['role'] != 'Mother') : ?>
            <img src="//graph.facebook.com/<?= $uPs['userID'];?>/picture?width=90&height=90" />
          <?php else : ?>
            <a href="/dev/pool/<?= $uPs['poolID']; ?>/">
              <img src="//graph.facebook.com/<?= $uPs['userID'];?>/picture?width=90&height=90" />
            </a>
          <?php endif; ?>
        </div>
        <div class="usersFullName"><?= isset($uPs['usersFullName']) ? $uPs['usersFullName'] : 'New Baby Pool'; ?></div>
        <div class="poolEnd">
          <?php
            if (!empty($uPs['poolEnd'])) { $uPs_daysLeft = convertToDays($uPs['poolEnd']); } else { $uPs_daysLeft = 0; }
            if ($uPs['poolStatus'] == 'pending') {
              echo 'Request Pending.';
            }
            else if ($uPs['poolStatus'] == 'ranked') {
              echo 'The Baby is Here!';
            }
            else if ($uPs_daysLeft <= 0 || $uPs['poolStatus'] == 'closed') {
              echo 'Awaiting Arrival!';
            }
            else if (isset($uPs['poolEnd'])) {
              echo convertToDays($uPs['poolEnd']).' days left to guess.';
            }
            else {
              echo 'Let\'s Play!';
            }
          ?>
        </div>
        <div class="buttonGroup">
        <?php if ($uPs['poolStatus'] == 'pending') : ?>
          <?php if ($uPs['role'] == 'Mother') : ?>
            <a href="/dev/create/organizer/<?= $uPs['poolID']; ?>/" class="setupButton"></a>
            <!-- <a href="/dev/create/organizer/<?= $uPs['poolID']; ?>/" data-role="button" data-inline="true" data-mini="true" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="btn-red-ovrd">SET UP</a> -->
          <?php else : ?>
            <div>&nbsp;</div>
          <?php endif; ?>
        <?php else : ?>
            <!-- <div data-role="controlgroup" data-type="horizontal"></div> -->
            <a href="/dev/pool/<?= $uPs['poolID']; ?>/edit/" class="manageSplit"></a><a href="/dev/pool/<?= $uPs['poolID']; ?>/" class="viewSplit"></a>
            <!-- <a href="/dev/pool/<?= $uPs['poolID']; ?>/edit/" data-role="button" data-mini="true" data-inline="true" data-icon="gear" data-iconpos="left" data-theme="c" class="btn-red-ovrd">MANAGE</a>  -->
            <!-- <a href="/dev/pool/<?= $uPs['poolID']; ?>/" data-role="button" data-mini="true" data-inline="true" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="btn-red-ovrd">VIEW</a> -->
        <?php endif; ?>
        <a href="#" style="visibility:hidden;" data-role="button">&nbsp;</a>
        </div>
      </li>
    <?php endforeach;
      echo '</ul>
            <div class="clear">&nbsp;</div>
            <a class="prev slid1_prev" href="#"><span>prev</span></a>
            <a class="next slid1_next" href="#"><span>next</span></a>
            </div>';
    else:
      echo '<div style="text-align:center;padding:10px;margin-bottom:30px;">&nbsp;<br/>You have not <a href="#popupCreatePool" data-rel="popup" data-position-to="window" data-transition="pop">created</a> a Baby Pool yet.</div>';
    endif; ?>
  </div>
  <div class="desktop-not-collapsible" data-role="collapsible" data-inset="false" data-theme="a" data-collapsed="<?= (!empty($friendsPools)) ? 'false' : 'true'; ?>" data-collapsed-icon="plus" data-expanded-icon="minus" data-iconpos="right">
    <h2 class="poolList">Friend's Pools <span class="badge"><?= (!empty($friendsPools)) ? count($friendsPools) : '0'; ?></span></h2>
    <div class="doily aligntop hideMobile"><hr /></div>  
    <?php if (!empty($friendsPools)) : ?>
    <div class="list_carousel">
    <ul class="slider2">
    <?php foreach ($friendsPools as $fPs) : ?>
      <li class="eachFriendsPool">
        <div class="userIdImage">
          <?php if ($fPs['poolStatus'] == 'pending' && $fPs['role'] != 'Mother') : ?>
            <img src="//graph.facebook.com/<?= $fPs['userID'];?>/picture?width=90&height=90" />
          <?php else : ?>
            <a href="/dev/pool/<?= $fPs['poolID']; ?>/">
              <img src="//graph.facebook.com/<?= $fPs['userID'];?>/picture?width=90&height=90" />
            </a>
          <?php endif; ?>
        </div>
        <div class="usersFullName"><?= isset($fPs['usersFullName']) ? $fPs['usersFullName'] : 'New Baby Pool'; ?></div>
        <div class="poolEnd">
          <?php
            if (!empty($fPs['poolEnd'])) { $fPs_daysLeft = convertToDays($fPs['poolEnd']); } else { $fPs_daysLeft = 0; }
            if ($fPs['poolStatus'] == 'ranked') {
              echo 'The Baby is Here!';
            }
            else if ($fPs_daysLeft <= 0 || $fPs['poolStatus'] == 'closed') {
              echo 'Awaiting Arrival!';
            }
            else if (isset($fPs['poolEnd'])) {
              echo $fPs_daysLeft.' days left to guess.';
            }
            else {
              echo 'Let\'s Play!';
            }
          ?>
        </div>
        <div class="buttonGroup">
          <!-- <a class="btn-red-ovrd" href="/dev/pool/<?= $fPs['poolID']; ?>/" data-role="button" data-inline="true" data-mini="true" data-icon="arrow-r" data-iconpos="right" data-theme="c"><?= (!empty($fPs['guessID'])  || $fPs_daysLeft <= 0 || $fPs['poolStatus'] != 'running') ? 'VIEW' : 'PLAY'; ?></a> -->
          <?php if (!empty($fPs['guessID'])  || $fPs_daysLeft <= 0 || $fPs['poolStatus'] != 'running') : ?>
            <a href="/dev/pool/<?= $fPs['poolID']; ?>/" class="viewButton"></a>
          <?php else : ?>
            <a href="/dev/pool/<?= $fPs['poolID']; ?>/" class="playButton"></a>
          <?php endif; ?>   
        </div> 
        <a href="#" style="visibility:hidden;" data-role="button">&nbsp;</a>
      </li>
    <?php endforeach;
      echo '</ul>
            <div class="clear">&nbsp;</div>
            <a class="prev slid2_prev" href="#"><span>prev</span></a>
            <a class="next slid2_next" href="#"><span>next</span></a>
            </div>';
    else:
      echo '<div style="text-align:center;padding:10px;margin-bottom:30px;">&nbsp;<br/>The more people you <a href="http://www.facebook.com/sharer.php?app_id=256375344488507&sdk=joey&u=http%3A%2F%2Fwww.playtexbabypool.com%2Fdev%2F&display=popup" target="_blank">invite</a> to play, the more fun you\'ll have!</div>';
    endif; ?>
  </div>
  <a class="showMobileBlock btn-red-ovrd ui-fullsize-ovrd" href="http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.playtexbabypool.com/dev/" target="_blank" data-theme="c" data-role="button" data-icon="arrow-r" data-iconpos="right">Share with Friends</a>
  <div class="doily alignmiddle hideMobile"><hr /></div>  
  
  <div class="grid_3 showMobile">
    <div class="poolInfoBox">
      <?= $adMobile;?>
    </div>
  </div>
 
<?php
function convertToDays($e) {
  //$end = strtotime($e);
  $end = date_format(date_create_from_format('Y-m-d', $e), 'U');
  $today = strtotime('now');
  $diff = $end - $today;
  $result = floor($diff/(60*60*24));
  if ($result <= 0) { return '0'; }
  else { return $result; }
}
$slider1 = '
$(".slider1").carouFredSel({
  auto : true,
	prev: {
		button: ".slid1_prev",
		key: "left"
	},
	next: {
		button: ".slid1_next",
		key: "right"
	},
	scroll: {
	  easing : "linear",
		items: 1,
		duration: 600,
		pauseOnHover: true
	},
  pauseOnHover : "immediate",
  mousewheel: false, 
  swipe: { 
    onMouse: true, 
    onTouch: true,
  },
	responsive	: true,
	items: {
		height : 185,
		width  : 400,
		visible   : {
			min     : 1,
			max     : 3,
		},
	}
});';

$slider2 = '
$(".slider2").carouFredSel({
  auto : true,
	prev: {
		button: ".slid2_prev",
		key: "left"
	},
	next: {
		button: ".slid2_next",
		key: "right"
	},
	scroll: {
	  easing : "swing",
		items: 1,
		duration: 600,
		pauseOnHover: true
	},
  pauseOnHover : "immediate",
  mousewheel: false, 
  swipe: { 
    onMouse: true, 
    onTouch: true,
  },
	responsive	: true,
	items		: {
		height  : 180,
		width		: 400,
		visible		: {
			min			: 1,
			max			: 3,
		},
	}
});';
?>
<script type="text/javascript">
  $(document).on('pageshow', function(){
    <?php
    echo $slider2.$slider1;
    ?>
    $(".ui-collapsible").bind( "expand", function(event, ui) {
      <?php
      echo $slider2.$slider1;
      ?>
    });
  });
</script>