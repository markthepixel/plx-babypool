<div class="content_wrap">
  <?php if (!empty($statusMessage)) : ?>
  <div class="notification_area">
    <h2 class="notification"><span><?= $statusMessage; ?></span></h2>
    <script>$(".notification_area").show().delay(5400).slideUp(1200);</script>
  </div>
  <?php endif; ?>

  <div class="poolTitleTop">
    <h1 class="poolTitle">
      <?= $motherFullName;?>'s Baby Pool
      <?php if ($hasAccess === true) : ?>
      <span class="edit_wrap">
        <a href="/dev/pool/<?= $poolID;?>/edit/" data-theme="c" data-role="button" data-inline="true" data-mini="true" data-transition="flip" data-icon="gear" data-iconpos="right" class="btn-red-ovrd hideMobile">MANAGE POOL</a>
      </span>
      <?php endif; ?>
    </h1>

    <?php if (!empty($registryLink)) : ?>
    <a class="registryLink hideMobile" href="<?= $registryLink;?>" target="_blank">
      <span class="registryLink_img">
        <img src="http://www.playtexbabypool.com/dev/_/img/registry-gift-box.jpg" />
      </span>
      <span class="registryLink_txt">
        <span class="registry"><?= $motherFirstName;?>'s Registry</span>
        <span class="rL_txt">Click here to visit.</span>
      </span>
    </a>
    <?php endif; ?>
    <div class="clear">&nbsp;</div>
  </div>
  
  <div class="poolTopInfo">
    <div class="poolTopInfo_bg">
      <img src="http://playtexbabypool.com/dev/_/img/dskt_topbar_bg.png"/>
    </div>
    <div class="poolTopInfo_fg">
      <div class="grid_3">
        <div class="pTI_image viewSinglePool poolInfoBox">
          <img class="profile_img <?= $poolPhotoOrientation; ?>" src="<?= $poolPhotoLink; ?>" />
        </div>
      </div>
      <div class="grid_6">
        <div class="pTI_text poolInfoBox">
          <?php if ($poolStatus == 'closed') : ?>
            <div class="condensed" style="font-size:60px;">Awaiting Arrival!</div>
            <div class="smalldoily alignmiddle showMobileBlock"><hr /></div>
            <div><?= $motherFirstName;?>'s due on <?= $dueDate;?></div>
          <?php elseif ($poolStatus == 'ranked') : ?>
            <div class="condensed" style="font-size:60px;"><?= $motherFirstName;?>'s Baby</div>
            <div><?= $babyName;?> was born on <?= $babyBirthdate;?></div>
            <div class="hideMobile">
              <div class="smalldoily alignmiddle showMobileBlock"><hr /></div>
              <br/>
              <div class="newBornInfo"><b>Gender:</b> <span style="text-transform:capitalize;"><?= $babyGender;?></span> | <b>Weight:</b> <?= $babyWeightLbs;?>lbs <?= $babyWeightOz;?>oz</div>
              <div class="newBornInfo"><b>Time:</b> <?= $babyBirthtime;?> | <b>Length:</b> <?= $babyLength;?>in</div>
            </div>
            <div class="showMobileBlock">
              <div class="genderdoily-<?= $babyGender;?> alignmiddle"><hr /></div>
              <div class="newBornInfo"><span style="text-transform:capitalize;"><?= $babyGender;?></span>, <?= $babyBirthtime;?>, <?= $babyWeightLbs;?>lbs <?= $babyWeightOz;?>oz, <?= $babyLength;?>in</div>
            </div>
          <?php else : ?>
            <div class="condensed" style="font-size:60px;"><?= ($poolEndDays == 1) ? $poolEndDays.' day' : $poolEndDays.' days'; ?> left!</div>
            <div class="smalldoily alignmiddle showMobileBlock"><hr /></div>
            <div><?= $motherFirstName;?>'s due on <?= $dueDate;?></div>
          <?php endif; ?>
        </div>
      </div>
      <div class="grid_3 hideMobile">
        <div class="pTI_ad poolInfoBox">
          <?= $adBlock;?>
        </div>
      </div>
    </div>
    <div class="clear">&nbsp;</div>
  </div>
  
  <div class="poolGuesses overlapUpper <?= (!empty($hasMadeGuess) || $poolStatus != 'running') ? 'overlapClear' : ''; ?> <?= ($poolStatus == 'ranked') ? 'overlayRanked' : ''; ?>">
  <div class="clear">&nbsp;</div>

  <?php if (empty($hasMadeGuess) && $poolStatus == 'running') : ?>
  <div class="hideMobile overlapObj" style="margin:0 auto !important; text-align:center !important; z-index:50;">
    <a class="btn-red-ovrd" data-inline="true" href="#popupCreateGuess" data-rel="popup" data-position-to="window" data-transition="pop" data-role="button" data-icon="arrow-r" data-iconpos="right" data-theme="c">Make a Guess</a>
  </div>
  <?php endif; ?>

  <?php if ($hasAccess === true) : ?>
  <a class="btn-red-ovrd pushBorder showMobileBlock ui-fullsize-ovrd" href="/dev/pool/<?= $poolID;?>/edit/" data-theme="c" data-role="button" data-transition="flip" data-icon="gear" data-iconpos="right">MANAGE POOL</a>
  <?php endif; ?>
  <?php if (empty($hasMadeGuess) && $poolStatus == 'running') : ?>
  <a class="btn-red-ovrd showMobileBlock ui-fullsize-ovrd" href="#popupCreateGuess" data-rel="popup" data-position-to="window" data-transition="pop" data-role="button" data-icon="arrow-r" data-iconpos="right" data-theme="c">Make a Guess</a>
  <?php endif; ?>
  <div data-role="collapsible-set">
  <?php if ($poolStatus == 'ranked') : ?>
    <div class="hideMobile desktop-not-collapsible" data-role="collapsible" data-inset="false"  data-theme="a" data-collapsed="<?= (!empty($poolGuesses)) ? 'false' : 'true'; ?>" data-collapsed-icon="plus" data-expanded-icon="minus" data-iconpos="right">
      <h2 class="poolList">View the Winners</h2>
      <div class="doily aligntop hideMobile"><hr /></div>
      <?php if (!empty($poolGuesses)): ?>
      <div class="viewWinners">
        <?php $i = 1; foreach ($poolGuesses as $pG): ?>
          <?php if ($i <= 3) { echo '<div class="grid_4 ranked_'.$i.'">'; } ?>
            <!-- <div class="winRank">Ranked <?= $rankUsers[$pG['userID']]; ?></div> -->
            <img class="ribbon" src="http://www.playtexbabypool.com/dev/_/img/ribbon<?= $i?>.png"/>
            <span class="winning_info">
              <span class="top4_line1 top4_line"><img class="winning_image" src="//graph.facebook.com/<?= $pG['userID'];?>/picture?type=small"/></span>
              <span class="top4_line2 top4_line"><span class="winFullName"><?= $pG['fullName'];?></span></span>
              <span class="top4_line3 top4_line"><span class="winLength"><?= $pG['length'];?>in,</span> <span class="winWeight"><?= $pG['weight_lbs'];?>lbs <?= $pG['weight_oz'];?>oz</span></span>
              <span class="top4_line4 top4_line"><span class="winDateTime"><?= $pG['date'].' '.$pG['time'];?></span></span>
              <span class="top4_line5 top4_line"><span class="winGender" style="text-transform:capitalize"><?= $pG['gender'];?></span></span>
            </span>
          <?php if ($i != 3) { echo '</div>'; } else { echo '<div class="clear">&nbsp;</div>'; } ?>
          <?php if ($i >= 4) { break; } ?>
        <?php $i++; ?>
        <?php endforeach; ?>
      </div>
      <?php else : echo '<div>There are no winners.</div>'; endif; ?>
      <div class="clear">&nbsp;</div>
    </div>
    <!-- Mobile View for Winners -->
    <div class="showMobileBlock viewMobileTheWinners desktop-not-collapsible" data-role="collapsible" data-inset="false"  data-theme="a" data-collapsed="<?= (!empty($poolGuesses)) ? 'false' : 'true'; ?>" data-collapsed-icon="plus" data-expanded-icon="minus" data-iconpos="right">
      <h2 class="poolList">View the Winners</h2>
      <?php if (!empty($poolGuesses)): ?>
      <div class="viewWinners">
        <table class="viewGuessesList vGL_table tablesorter viewGuessesList_<?= (!empty($showRankResults)) ? 'running':'ranked' ?>" style="text-align:left;" data-sortlist="[['6,1']]">
      		<tbody class="tbody">
          <?php $i = 1; foreach ($poolGuesses as $pG): ?>
            <tr class="showMobileTable <?= ($pG['userID'] == $userID) ? 'my_guess':'users_guess'; ?>">
              <td colspan="<?= (!empty($showRankResults)) ? '5' : '4'; ?>" class="mobileNameColumn">
                <span style="vertical-align:middle;">
                  <img class="mobile-guessersImg" src="//graph.facebook.com/<?= $pG['userID'];?>/picture?type=small"/><?= $pG['fullName'];?>
                </span>
                <span style="vertical-align:middle;float:right;">
                  <img style="vertical-align:middle;width:60px;" src="http://playtexbabypool.com/dev/_/img/mobilerank_<?= $i; ?>.png" />
                </span>
              </td><td class="hideAll">&nbsp;</td>
              <td class="hideAll">&nbsp;</td><td class="hideAll">&nbsp;</td>
              <td class="hideAll">&nbsp;</td><td class="hideAll">&nbsp;</td>
              <?php if (!empty($showRankResults)) { echo '<td class="hideAll">&nbsp;</td>';} ?>
            </tr>
            <tr class="<?= ($pG['userID'] == $userID) ? 'my_guess':'users_guess'; ?>">
              <td class="hideAll"><?= $i;?></td>
              <td class="hideMobile">
                <img class="guessersImg" src="//graph.facebook.com/<?= $pG['userID'];?>/picture?type=small"/>
                <?= $pG['fullName'];?>
              </td>
              <td><?= $pG['date'].' '.$pG['time'];?></td>
              <!-- <td style="text-transform:capitalize"><?= $pG['gender'];?></td> -->
              <td class="genderIcon"><img class="guess_gender guess_gender_<?= $pG['gender'];?>" src="http://www.playtexbabypool.com/dev/_/img/<?= $pG['gender'];?>_symbol.png" alt="<?= $pG['gender'];?>" /></td>
              <td><?= $pG['length'];?> In</td>
              <td><?= $pG['weight_lbs'];?> Lbs <?= $pG['weight_oz'];?> Oz</td>
            </tr>
          <?php if ($i >= 4) { break; } ?>
          <?php $i++;?>
          <?php endforeach; ?>
      		</tbody>
        </table>
      </div>
      <?php else : echo '<div>There are no winners.</div>'; endif; ?>
      <div class="clear">&nbsp;</div>
    </div>
    <?php endif; ?>
    
    <div class="viewMobileTheWinners desktop-not-collapsible" data-role="collapsible" data-inset="false" data-theme="a" data-collapsed="<?= (!empty($poolGuesses) && $poolStatus != 'ranked') ? 'false' : 'true'; ?>" data-collapsed-icon="plus" data-expanded-icon="minus" data-iconpos="right">
    <h2 class="poolList">View <?= (!empty($showRankResults)) ? 'the Leaderboard' : 'Other Guesses'; ?></h2>
    <div style="z-index:50;" class="doily aligntop hideMobile"><hr /></div>
    <!-- <span class="badge"><?= (!empty($poolGuesses)) ? count($poolGuesses) : '0'; ?> -->
    <?php if (!empty($poolGuesses)): ?>
    <table class="viewGuessesList vGL_table tablesorter viewGuessesList_<?= (!empty($showRankResults)) ? 'running':'ranked' ?>" style="text-align:left;" data-sortlist="[[<?= (!empty($showRankResults)) ? '6,1' : '1,0' ?>]]">
  		<thead class="thead">
        <tr>
          <th class="hideAll">ID</th>
          <th>Name</th>
          <th>Date & Time</th>
          <?php if ($scoreGender == 1) : ?><th>Gender</th><?php endif; ?>
          <th>Length</th>
          <th>Weight</th>
          <?php if (!empty($showRankResults)) : ?><th>Points</th><?php endif;?>
        </tr>
  		</thead>
  		<tbody class="tbody">
      <?php $i = 1; foreach ($poolGuesses as $pG): ?>
        <tr class="showMobileTable <?= ($pG['userID'] == $userID) ? 'my_guess':'users_guess'; ?>">
          <td colspan="<?= (!empty($showRankResults)) ? '4' : '4'; ?>" class="mobileNameColumn">
            <span style="vertical-align:middle;">
              <img class="mobile-guessersImg" src="//graph.facebook.com/<?= $pG['userID'];?>/picture?type=small"/><?= $pG['fullName'];?>
            </span>
            <?php if (!empty($showRankResults)) : ?>
            <span style="vertical-align:middle;text-align:center;float:right;width:60px;height:60px;padding-top:10px;">
              <?= $pointUsers[$pG['userID']]; ?>
              <div style="font-size:10px;">POINTS</div>
            </span>
            <?php endif; ?>
            
          </td><td class="hideAll">&nbsp;</td>
          <td class="hideAll">&nbsp;</td><td class="hideAll">&nbsp;</td>
          <td class="hideAll">&nbsp;</td><td class="hideAll">&nbsp;</td>
          <?php if (!empty($showRankResults)) { echo '<td class="hideAll">&nbsp;</td>';} ?>
        </tr>
        <tr class="<?= ($pG['userID'] == $userID) ? 'my_guess':'users_guess'; ?>">
          <td class="hideAll"><?= $i++;?></td>
          <td class="hideMobile">
            <img class="guessersImg" src="//graph.facebook.com/<?= $pG['userID'];?>/picture?type=small"/>
            <?= $pG['fullName'];?>
          </td>
          <td><?= $pG['date'].' '.$pG['time'];?></td>
          <!-- <td style="text-transform:capitalize"><?= $pG['gender'];?></td> -->
          <?php if ($scoreGender == 1) : ?>
          <td class="genderIcon"><img class="guess_gender guess_gender_<?= $pG['gender'];?>" src="http://www.playtexbabypool.com/dev/_/img/<?= $pG['gender'];?>_symbol.png" alt="<?= $pG['gender'];?>" /></td>
          <?php endif;?>
          <td><?= $pG['length'];?> In</td>
          <td><?= $pG['weight_lbs'];?> Lbs <?= $pG['weight_oz'];?> Oz</td>
          <?php if (!empty($showRankResults)) { echo '<td class="hideMobile">'.$pointUsers[$pG['userID']].'</td>';} ?>
        </tr>
        <?php endforeach; ?>
  		</tbody>
    </table>
    <?php else : echo '<div style="padding:20px; text-align:center;">There are no other guesses'.(($poolStatus != 'ranked' && $poolStatus != 'closed') ? ', be the first to <a href="#popupCreateGuess" data-rel="popup" data-position-to="window" data-transition="pop">Make a Guess</a>':'').'</div>'; endif; ?>
    </div>
  <?= ($poolStatus == 'ranked') ? '</div>' : '</div>'; ?>
    <div class="clear">&nbsp;</div>
  <a onclick="window.open('http://www.facebook.com/sharer/sharer.php?u=http://www.playtexbabypool.com/dev/pool/<?= $poolID;?>/', 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');"
     href="#" data-rel="popup" data-position-to="window" data-role="button" data-transition="pop" data-theme="c" data-icon="arrow-r" data-iconpos="right" class="btn-red-ovrd ui-fullsize-ovrd showMobileBlock">Share with Friends</a>
  </div>
  <div class="grid_3 showMobile">
    <div class="poolInfoBox">
      <?= $adMobile;?>
    </div>
  </div>
  <?php if (!empty($registryLink)) : ?>
  <div class="mobi_registryLink_wrap showMobile">
    <a class="mobi_registryLink" href="<?= $registryLink;?>" target="_blank">
      <span class="mobi_registryLink_img">
        <img src="http://www.playtexbabypool.com/dev/_/img/registry-gift-box.jpg" />
      </span>
      <span class="mobi_registryLink_txt">
        <span class="mobi_registry"><?= $motherFirstName;?>'s Registry</span>
        <span class="rL_txt">Click here to visit.</span>
      </span>
    </a>
  </div>
  <?php endif; ?>
</div>

<script type="text/javascript">
  $(document).on('pageshow', function(){ // $(function(){
  	$('.viewGuessesList').tablesorter();  
  	
    tableSortFix();
    $(window).resize(function() { tableSortFix(); });
    
    function tableSortFix() {
      var windowWidth = $('.ui-page').width(),
          currentState = $('.vGL_table').data('mobileSort');
      
      if (currentState != true) {
        if (windowWidth <= 600) { //Enable Mobile
          $('.vGL_table').removeClass('viewGuessesList');
          $('.vGL_table').data('mobileSort','true');
          $('.vGL_table').trigger('sortReset');
        }
        else if (windowWidth > 600) { //Disable Mobile
          var sorting = [[<?= (!empty($showRankResults)) ? '6,1' : '1,0' ?>]];
          $('.vGL_table').addClass('viewGuessesList');
          $('.vGL_table').data('mobileSort','false');
          $('.vGL_table').trigger("sorton",[sorting]);
        }
      }
      return false;
    }
  });
</script>




<?php
  //-- Popup -- Make a Guess --//
  if (empty($hasMadeGuess)  || !empty($poolStatus)) : if (empty($hasMadeGuess) || $poolStatus != 'closed' || $poolStatus != 'ranked') :
?>
<?php if ($doesLikePage !== true) : ?>
<script type="text/javascript">
$(document).on("pageinit", function() {
  $('#popupCreateGuess').on({
    popupafterclose: function() {
      setTimeout(function(){
        $('#popupLikeAction').popup('open')
      }, 100);
    }
  });
});
</script>
<?php endif; ?>
<div id="popupCreateGuess" data-role="popup" style="min-width:300px;" class="ui-corner-all" data-overlay-theme="a">
  <!-- <a href="#" data-rel="back" data-role="button" data-theme="c" data-icon="delete" data-iconpos="notext" class="ui-btn-right closeBtn">Close</a> -->
  <a href="#" data-rel="back" class="ui-btn-right closeBtn"></a>
	<div data-role="header" data-theme="a" class="ui-corner-top">
		<h1>Make a Guess</h1>
	</div>
	<div data-role="content" data-theme="a" class="ui-corner-bottom ui-content-padding">
	   <div style="text-align:center; padding-bottom:10px;border-bottom:1px #888 solid;">
	     Mother is due on <?= $dueDate; ?>
	   </div>
    <div class="allError" style="display:none; margin:0; color:#ff0000">
      <br/><span style="display:inline-block;padding:10px 5px">&nbsp;</span>
    </div>
    <form id="createGuess" class="form create guess" name="createGuess" method="post" data-ajax="false">
    <label for="date">Birth Date <span class="reqOrg">*</span>:</label>
    <input type="text" name="date" data-role="datebox" data-theme="b" class="required" data-options='{"zindex":"100100100", "mode":"calbox", "afterToday":true, "useFocus":true, "useNewStyle":true, "calHighToday":false, "themeDatePick":"b", "themeDayHigh":"c", "themeGridPlus":"c", "themeHeader":"c", "themeDate":"a"}'  />
    <label for="time">Birth Time <span class="reqOrg">*</span>:</label>
    <input type="text" name="time" data-role="datebox" data-theme="c" class="required" data-options='{"zindex":"100100101", "mode":"timeflipbox", "useFocus":true, "useNewStyle":true, "themeDatePick":"b", "themeDayHigh":"c", "themeHeader":"c", "themeDate":"a"}' > 
    <?php if ($scoreGender == 1) : ?>
    <fieldset id="gender" data-role="controlgroup" data-type="horizontal">
    	<legend>Baby's Gender <span class="reqOrg">*</span>:</legend>
         	<input type="radio" name="gender" id="gender-B" value="boy" class="required" />
         	<label class="genderBtn_b" for="gender-B" data-role="button" data-theme="a" data-iconshadow="true" data-icon="male"></label>
         	<input type="radio" name="gender" id="gender-G" value="girl" />
         	<label class="genderBtn_g" for="gender-G" data-role="button" data-theme="a" data-iconshadow="true" data-icon="female"></label>
    </fieldset>
    <?php endif; ?>
    <label for="length">Birth Length <span class="reqOrg">*</span>:</label> 
    <label class="lb-length" for="length">Inches</label> 
    <input type="range" name="length" id="length" class="required" value="18" min="13" max="23" data-theme="b" data-highlight="true" />
    <div id="weightBox">
      <div id="weighteachLbs" class="weighteach">
        <label for="weight_lbs" style="display:block">Birth Weight <span class="reqOrg">*</span>:</label> 
        <label class="lb-weight_lbs" for="weight_lbs">Lbs</label> 
        <input type="range" name="weight_lbs" id="weight_lbs" class="required" value="8" min="3" max="12" data-theme="b" data-highlight="true" />
      </div>
      <div id="weighteachOz" class="weighteach">
        <label class="lb-weight_oz" for="weight_oz">Oz</label> 
        <input type="range" name="weight_oz" id="weight_oz" class="required" value="7" min="0" max="15" data-theme="b" data-highlight="true" />
      </div>
      <div class="clear">&nbsp;</div>
    </div>
    <input type="hidden" name="poolID" value="<?= $poolID; ?>" />
    <input type="hidden" name="formType" value="PoolGuess" />
    <br/>
    <div class="submit_wrap">
      <?php if ($doesLikePage === true) : ?>
      <input type="submit" name="submit" value="Submit Guess" data-theme="c" class="btn-red-ovrd" />
      <?php else: ?>
      <a href="#popupLikeAction" data-rel="popup" data-position-to="window" data-role="button" data-icon="check" data-iconpos="right" data-inline="true" data-theme="c" class="btn-red-ovrd" data-transition="pop">Submit Guess</a>
      <?php endif; ?>
    </div>
    </form>
	</div>
</div>
<script type="text/javascript">
$(document).on('pageshow', function(){
	var validator = $("#createGuess").validate({
	  onfocusout: false,
		invalidHandler: function(e, validator) {
		  var errors = validator.numberOfInvalids();
			if (errors) {
				var message = errors == 1
					? 'Review the 1 highlighted field below.'
					: 'Review the ' + errors + ' highlighted fields below.';
				$(".allError span").html(message);
				$(".allError").show();
			} else {
				$(".allError").hide();
			}
		},
    highlight: function(element, errorClass, validClass) {
      $(element).addClass(errorClass).removeClass(validClass);
      if ($(element).is(":radio"))
        $("#" + $(element).attr('name')).addClass(errorClass);
      else if ($(element).is(":checkbox"))
        $(element).parent().addClass(errorClass);
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).removeClass(errorClass).addClass(validClass);       
      if ($(element).is(":radio"))
        $("#" + $(element).attr('name')).removeClass(errorClass);
      else if ($(element).is(":checkbox"))
        $(element).parent().removeClass(errorClass);
    },
		errorPlacement: function(error, element) {
			if ($(element).is(":radio")) {
			  error.insertAfter($("#" + $(element).attr("name")));
		  }
			else if ($(element).is(":checkbox")) {
			  error.insertAfter($(element).parent());
		  }
			else {
			  error.insertAfter($(element));
		  }
		},
	});
});
</script>
<?php endif; endif; ?>
<?php if ($doesLikePage !== true) : ?>
<div data-role="popup" id="popupLikeAction" class="ui-corner-all likePopupBox" data-overlay-theme="a">
  <!-- <a href="#" data-rel="back" data-role="button" data-theme="c" data-icon="delete" data-iconpos="notext" class="ui-btn-right btn-red-ovrd closeBtn">Close</a> -->
  <a href="#" data-rel="back" class="ui-btn-right closeBtn"></a>
	<div data-role="header" class="ui-corner-top" style="display:none;">
		<h1>Confirmation</h1>
	</div>
	<div data-role="content" class="ui-corner-bottom ui-content-padding">
	  <div class="fb_like_wrapper">
  	  <img class="fb_profile_img" src="http://www.playtexbabypool.com/dev/_/img/playtex_fb_profile.png" />
  	  <span class="fb_like_txt_wrap">
    	  <img class="fb_like_us" src="http://www.playtexbabypool.com/dev/_/img/msg_like_us.png" />
    	  <div class="fb_like_btn"></div>
  	  </span>
	  </div>
	</div>
</div>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery.fbjlike.1.4.js""></script>
<script type="text/javascript">
$(document).on('pageshow', function(){
  //$(document).ready(function () {
  $('.fb_like_btn').fbjlike({
  	onlike:function(response){
      $('.fb_like_btn').html('<span style="color:red;font-weight:bold;">Thank You. Loading...</span>');
      $('.fb_like_btn').css('text-align','center').show('fade');
      document.forms["createGuess"].submit();
  	},
  	appID: '256375344488507',
  	buttonWidth: 300,
  	hideafterlike: true,
  	send: true,
  	href: 'http://www.facebook.com/PlaytexBaby',
  	lang: 'en_US',
		googleanalytics: true,
		googleanalytics_obj: '_gaq'
  });  
  $("#popupCreatePool").bind({
     popupafteropen: function(event, ui) {
      try{
          FB.XFBML.parse();
      } catch(err){
        
      }
     }
  });
});
</script>
<?php endif; ?>