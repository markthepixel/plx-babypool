<?php if (empty($hidePhotoSelect)) : ?>
<link rel="stylesheet" href="//www.playtexbabypool.com/dev/_/css/jquery.fbphotoselector.css" />
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery.fbphotoselector.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/babypool.fbphotoselector.js"></script>
<?php endif; ?>

<div class="content_wrap">
  <?php if (!empty($statusMessage)) : ?>
  <div class="notification_area">
    <h2 class="notification"><span><?= $statusMessage; ?></span></h2>
    <script>$(".notification_area").show().delay(5400).slideUp(1200);</script>
  </div>
  <?php endif; ?>
  
  <div class="poolTitleTop">
    <h1 class="headingHead">Create Pool</h1>
  </div>
  <div class="poolTopInfo">
    <div class="poolTopInfo_bg">
      <img src="http://playtexbabypool.com/dev/_/img/dskt_topbar_bg.png"/>
    </div>
    <div class="poolTopInfo_fg">
      <div class="grid_3">
        <div class="pTI_image createPool poolInfoBox">
          <img class="profile_img landscape" src="//www.playtexbabypool.com/dev/_/img/stock-pregnant-woman.jpg" />
          <?= (empty($hidePhotoSelect)) ? '<div class="clear">&nbsp;</div><a href="#" class="photoSelect btn-red-ovrd" data-role="button" data-theme="c" data-icon="plus" data-inline="true">Select Photo</a>' : ''; ?>
        </div>
      </div>
      <div class="grid_6">
        <div class="pTI_text poolInfoBox">
          <div class="condensed" style="font-size:60px;">Create a New Pool!</div>
          <div style="padding:0 20px;">
            <?php if (empty($hideGetStartedStep)) : ?>
            Select a photo for the Baby Pool.<br/>
            <?php endif; ?>
            Fill out the information below.
          </div>
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
  
  <div class="poolCreate overlapUpper">
    <div class="desktop-not-collapsible" data-role="collapsible" data-inset="false" data-theme="a" data-collapsed="false" data-collapsed-icon="plus" data-expanded-icon="minus" data-iconpos="right">
      <h2>LET'S GET STARTED!</h2>
      <div class="doily aligntop hideMobile"><hr /></div>
      <div class="formWrap">
      
      <?php
        //Set the correct fields to required
        $reqAll = 'required';
        if ($createType == 'PoolCreateOrganizer') {
          $reqMom = 'not-required';
          $reqOrg = 'required';
          echo '<style>.reqOrg{display:inline;}.reqMom{display:none;}</style>';
        }
        else {
          $reqMom = 'required';
          $reqOrg = 'not-required';
          echo '<style>.reqMom{display:inline;}.reqOrg{display:none;}</style>';
        }
      ?>
      <form id="createPool" class="createPool" name="createPool" method="post" data-ajax="false">
        <?php if (empty($hidePhotoSelect)) : ?>
      	<input type="hidden" id="fbimageurl" name="poolPhotoLink" value="https://graph.facebook.com/<?= $userID;?>/picture?width=220&height=220" /> 
        <input type="hidden" id="fbimageorientation" name="poolPhotoOrientation" value="landscape" /> 
        <?php endif; ?>
    
        <?php if (empty($hideMothersName)) : ?>
        <label for="motherName">Mother's Name <span class="reqOrg">*</span>:</label><div class="descTxt">Start typing the Mother's name as it appears in Facebook and select her from the list!</div>
        <input type="text" id="fbname" name="motherName" class="<?=$reqOrg;?>" />
        <input type="hidden" id="fbid" name="motherID" />
        <?php endif; ?>
    
        <?php if (!empty($motherEmail)) { $email = $motherEmail; } ?>
        <label for="motherEmail">Mother's Email:</label><div class="descTxt">Please enter email address.</div>
        <input type="email" class="email" name="motherEmail" value="<?= (!empty($email)) ? $email : '';?>" />
    
        <?php if (!empty($hideMothersName)) : ?>
        <label for="motherMobile">Mother's Mobile Number:</label><div class="descTxt">Enter your mobile number if you'd like to receive future offers from Playtex Baby via SMS. Your number will not be used for any other purposes.</div>
        <input type="text" class="" name="motherMobile" value="<?= (!empty($motherMobile)) ? $motherMobile : '';?>" />
        <?php endif; ?>
        
        <fieldset id="gender" data-role="controlgroup" data-type="horizontal">
        	<legend>Baby's Gender:<span class="reqMom">*</span>
          	<div class="descTxt">If you know the baby's gender select it here, otherwise select "It's a Surprise!"</div>
        	</legend>
         	<input type="radio" name="gender" id="gender-U" value="surprise" class="<?=$reqMom;?>"  <?= (!empty($gender) && $gender == 'surprise') ? 'checked="checked"' : '';?> />
         	<label class="surprise" for="gender-U">It's a Surprise!</label>
         	<input type="radio" name="gender" id="gender-B" value="boy" <?= (!empty($gender) && $gender == 'boy') ? 'checked="checked"' : '';?> />
         	<label class="genderBtn_b" for="gender-B" data-role="button" data-theme="a" data-iconshadow="true" data-icon="male"></label>
         	<input type="radio" name="gender" id="gender-G" value="girl" <?= (!empty($gender) && $gender == 'girl') ? 'checked="checked"' : '';?> />
         	<label class="genderBtn_g" for="gender-G" data-role="button" data-theme="a" data-iconshadow="true" data-icon="female"></label>
        </fieldset>
        
        <label for="dueDate">Due Date:<span class="reqMom">*</span></label><div class="descTxt">Select the due date that the baby is expected!</div>
        <input type="text" name="dueDate" id="dueDate" class="<?=$reqMom;?>" value="<?= (!empty($dueDate)) ? $dueDate : '';?>" data-role="datebox" data-theme="b" data-options='{"mode":"calbox", "afterToday":true, "useFocus":true, "useNewStyle":true, "calHighToday":false, "themeDatePick":"b", "themeDayHigh":"c", "themeGridPlus":"c", "themeHeader":"c", "themeDate":"a"}'  />
    
        <label for="poolEnd">Pool Close Date:<span class="reqMom">*</span></label><div class="descTxt">We have recommended 3 weeks before due date, below.</div>
        <input type="text" name="poolEnd" id="poolEnd" class="<?=$reqMom;?>" value="<?= (!empty($poolEnd)) ? $poolEnd : '';?>" data-role="datebox" data-theme="b" data-options='{"mode":"calbox", "afterToday":true, "notToday":true, "useFocus":true, "useNewStyle":true, "calHighToday":false, "themeDatePick":"b", "themeGridPlus":"c", "themeDayHigh":"c", "themeHeader":"c", "themeDate":"a"}' />
    
        <label for="registryLink">Registry Link:</label><div class="descTxt">Simply copy and paste the URL address of Mother's favorite registry.</div>
        <input type="text" name="registryLink" value="<?= (!empty($registryLink)) ? $registryLink : 'http://';?>" />
        
        <?php if (empty($hideSpecialOffers)) : ?>
        <label><input type="checkbox" name="special_offers" /> YES! Please sign me up for special offers from Playtex.</label>
        <?php endif; ?>
        <label><input type="checkbox" name="privacy_policy" class="<?=$reqAll;?>" /> <span class="reqAll">*</span>I agree to the <a href="http://www.playtexbaby.com/privacy.aspx">Privacy Policy</a>.</label>
    
        <?php if (!empty($poolID)) { echo '<input type="hidden" name="poolID" value="'.$poolID.'" />'; } ?>
        <input type="hidden" name="userID" value="<?= $userID; ?>" />
        <input type="hidden" name="formType" value="<?= $createType; ?>" />
        
        <div class="submit_wrap">
          <a href="/dev/" data-role="button" data-inline="true" data-icon="back" data-theme="c" class="btn-red-ovrd">Cancel</a>
          <?php if ($doesLikePage === true) : ?>
          <input type="submit" name="submit" data-inline="true" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="btn-red-ovrd" value="Create Pool" />
          <?php else: ?>
          <a href="#popupLikeAction" data-rel="popup" data-position-to="window" data-role="button" data-icon="arrow-r" data-iconpos="right" data-inline="true" data-theme="c" class="btn-red-ovrd" data-transition="pop">Create Pool</a>
          <?php endif; ?>
        </div>
      </form>
    
      <?php if ($doesLikePage !== true) : ?>
      <div data-role="popup" id="popupLikeAction" class="ui-corner-all likePopupBox" data-overlay-theme="a">
        <a href="#" data-rel="back" class="ui-btn-right closeBtn"></a>
        <!-- <a href="#" data-rel="back" data-role="button" data-theme="c" data-icon="delete" data-iconpos="notext" class="ui-btn-right btn-red-ovrd closeBtn">Close</a> -->
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
      <script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery.fbjlike.1.4.js"></script>
      <script type="text/javascript">
      $(document).on('pageshow', function(){
        $('.fb_like_btn').fbjlike({
        	appID: '256375344488507',
        	buttonWidth: 300,
        	hideafterlike: true,
        	send: true,
        	href: 'http://www.facebook.com/PlaytexBaby',
      		layout: 'normal',	//box_count|button_count|standard
      		action: 'like',		//recommend|like
        	lang: 'en_US',
      		googleanalytics: true,
      		googleanalytics_obj: '_gaq',
        	onlike: function(response){
            $('.fb_like_btn').html('<span style="color:red;font-weight:bold;text-align:center;">Loading <img src="http://playtexbabypool.com/dev/_/images/loader.gif" /></span>').show('fade');
            document.forms["createPool"].submit();
        	},
      		onunlike: function(){return true;}
        });  
        $("#popupLikeAction").bind({
           popupafteropen: function(event, ui) {
             try{
               FB.XFBML.parse();
               FB.Event.subscribe('edge.create',
                 function(response) {
                   $('.fb_like_btn').html('<span style="color:red;font-weight:bold;text-align:center;">Loading <img src="http://playtexbabypool.com/dev/_/images/loader.gif" /></span>').show('fade');
                   document.forms["createPool"].submit();
                 }
               );
             } catch(err){}        
           }
        });
      });
      </script>
      <?php endif; ?>
      
      </div>
    </div>
  </div>
</div>

<?php if (empty($hidePhotoSelect)) : ?>
<div id="CSPhotoSelector">
	<div class="CSPhotoSelector_dialog">
		<a href="#" id="CSPhotoSelector_buttonClose">x</a>
		<div class="CSPhotoSelector_form">
			<div class="CSPhotoSelector_header">
				<p>Choose from Photos</p>
			</div>
			<div class="CSPhotoSelector_content CSAlbumSelector_wrapper">
				<p>Browse your albums until you find a picture you want to use</p>
				<div class="CSPhotoSelector_searchContainer CSPhotoSelector_clearfix">
					<div class="CSPhotoSelector_selectedCountContainer">Select an album</div>
				</div>
				<div class="CSPhotoSelector_photosContainer CSAlbum_container"></div>
			</div>
			<div class="CSPhotoSelector_content CSPhotoSelector_wrapper">
				<p>Select a new photo</p>
				<div class="CSPhotoSelector_searchContainer CSPhotoSelector_clearfix">
					<a href="#" id="CSPhotoSelector_backToAlbums">Back to albums</a>
				</div>
				<div class="CSPhotoSelector_photosContainer CSPhoto_container"></div>
			</div>
			<div id="CSPhotoSelector_loader"></div>
			<div class="CSPhotoSelector_footer CSPhotoSelector_clearfix">
				<a href="#" id="CSPhotoSelector_pagePrev" class="CSPhotoSelector_disabled">Previous</a>
				<a href="#" id="CSPhotoSelector_pageNext">Next</a>
				<div class="CSPhotoSelector_pageNumberContainer">
					Page <span id="CSPhotoSelector_pageNumber">1</span> / <span id="CSPhotoSelector_pageNumberTotal">1</span>
				</div>
				<a href="#" id="CSPhotoSelector_buttonOK">OK</a>
				<a href="#" id="CSPhotoSelector_buttonCancel">Cancel</a>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>




<?php

              //======================================= JS+CSS START ======== NEED TO MOVE ==================================//

?>
<script type="text/javascript">
$(document).on('pageshow', function(){

  //Enable URL in Checkbox
  $('.ui-btn-inner a').click(function(event) {
    window.open($(this).attr('href'), $(this).attr('target'));
    event.preventDefault();   
  });
  
  //Autofill Future Date
  function dooffset() {
    var startdate = $('#dueDate').datebox('getTheDate'),
        offsetsec = 1814400, //3 Weeks in Seconds
        enddate = new Date(startdate.getFullYear(), startdate.getMonth(), startdate.getDate(), 0, 0, 0, 0);
    enddate.setSeconds(enddate.getSeconds() - offsetsec); //add for "after" date, subtract for "before" date

    var t2ay = new Date,
        today = new Date(t2ay.getFullYear(), t2ay.getMonth(), t2ay.getDate(), 0, 0, 0, 0),
        now = parseInt(today.getTime() / 1000),
        end = parseInt(enddate.getTime() / 1000);
    if (now >= end) { var enddate = new Date(t2ay.getFullYear(), t2ay.getMonth(), (t2ay.getDate() + 1), 0, 0, 0, 0); }
    
    $('#poolEnd').datebox('setTheDate', enddate);
    $('#poolEnd').trigger('datebox', {'method':'doset'});
  }
  $('#dueDate').live('change', function() {
    dooffset();
    $('#poolEnd').animate({ color: "#F00" }, 200).delay(1800).animate({ color: "#333" }, 1200);
  });

  //Form Validation (keyup & submit)
  jQuery.validator.addMethod("complete_url", function(val, elem) {
    //don't do anything
    if (val.length == 0) { return true; }
    if (val == 'http://') { return true; }
    //if user has not entered http:// or https:// assume they mean http://
    //if(!/^(https?|ftp):\/\//i.test(val)) { val = 'http://'+val; $(elem).val(val); }
    if(!/^(https?|ftp):\/\//i.test(val)) {
      val = 'http://'+val; // set both the value
      $(elem).val(val); // also update the form element
    }
    else {
      val = val.replace(/(http\:\/\/)+/,'http://');
      $(elem).val(val); // also update the form element
    }
    return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(val);
  });
  jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
      phone_number = phone_number.replace(/\s+/g, ""); 
  	return this.optional(element) || phone_number.length > 9 &&
  		phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
  }, "Please specify a valid US Phone Number");
	var validator = $("#createPool").validate({
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
		messages: {
		  registryLink: "Please enter a valid fully-qualified URL.",
		},
    rules: {
      registryLink: "complete_url",
      motherMobile: "phoneUS"
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

  <?php if (empty($hideMothersName)) : ?>
  //Dropdown for Friend Picker
  var fbFriendsList = <?= json_encode($listAllFriends); ?>;
  var source = fbFriendsList.data;
  $("#fbname").autocomplete({
      minLength: 2,
      autoFocus: false,
      autoSelect: true,
      source: function (request, response) {
        var term = $.ui.autocomplete.escapeRegex(request.term)
            , startsWithMatcher = new RegExp("^" + term, "i")
            , startsWith = $.grep(source, function(value) {
                return startsWithMatcher.test(value.name || value.value || value);
            })
            , containsMatcher = new RegExp(term, "i")
            , contains = $.grep(source, function (value) {
                return $.inArray(value, startsWith) < 0 && 
                    containsMatcher.test(value.name || value.value || value);
            });
        response(startsWith.concat(contains));
      },
		  focus: function( event, ui ) {
			  $( "#fbname" ).val( ui.item.name );
			  return false;
		  },
		  change: function( event, ui ) {
        if (!$('#fbname').val()) {
          $("#fbid").val('');
        }
        else {
          var userID = '',
              count = 0,
              val = $('#fbname').val();
              id = $('#fbid').val();
          $.each(source, function(i) {
          	if (source[i].name === val) {
          	  userID = source[i].id;
            	count += 1;
          	}
          });
          if (count == 1) {
            if (id != userID) {
              $("#fbid").val(userID);
            }
          }
          else {
            $("#fbid").val('');
            $('#fbname').val('');
            //.animate({ color: "#F00" }, 600).delay(1200).animate({ color: "#fff" }, 2400);
          }
        }
			  return false;
		  },
		  select: function( event, ui ) {
				$( "#fbname" ).val( ui.item.name );
				$( "#fbid" ).val( ui.item.id );			
				return false;
		  }
  });
  /*
  .data( "autocomplete" )._renderItem = function( ul, item ) {
    return $("<li>")
    .data("item.autocomplete", item)
    .append("<a>" + item.name + "</a>")
    .appendTo(ul);
  };
  */
  var obj = $("#fbname").data('autocomplete');
  obj && (obj._renderItem = function( ul, item ){
    return $("<li>")
    .data("item.autocomplete", item)
    .append("<a>" + item.name + "</a>")
    .appendTo(ul);
  });
  <?php endif; ?>

});
</script>

<!--
-->