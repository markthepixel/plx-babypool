<link rel="stylesheet" href="//www.playtexbabypool.com/dev/_/css/jquery.fbphotoselector.css" />
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/jquery.fbphotoselector.js"></script>
<script type="text/javascript" src="//www.playtexbabypool.com/dev/_/js/babypool.fbphotoselector.manage.js"></script>

<div class="content_wrap">
  <div class="notification_area">
    <h2 class="notification"><span><?= $statusMessage; ?></span></h2>
  </div>
  <?php if (!empty($statusMessage)) : ?>
  <script>$(".notification_area").show().delay(5400).slideUp(1200);</script>
  <?php endif; ?>

  <div class="poolTitleTop">
    <h1>
      Manage your Baby Pool
      <span class="edit_wrap hideMobile">
        <a href="/dev/pool/<?= $poolID; ?>/" data-theme="c" data-role="button" data-inline="true" data-mini="true" data-transition="flip" data-icon="gear" data-iconpos="right" class="btn-red-ovrd hideMobile">BACK TO POOL</a>
      </span>
    </h1>
    <!-- [Pool Status: <?= $poolStatus;?> ] -->
  </div>
  <div class="poolTopInfo">
    <div class="poolTopInfo_bg">
      <img src="http://playtexbabypool.com/dev/_/img/dskt_topbar_bg.png"/>
    </div>
    <div class="poolTopInfo_fg">
      <div class="grid_3">
        <div class="pTI_image managePool poolInfoBox">
          <img class="profile_img <?= $poolPhotoOrientation; ?>" data-photospoolid="<?= $poolID; ?>" src="<?= $poolPhotoLink; ?>" />
          <div class="clear">&nbsp;</div><a href="#" class="photoSelect btn-red-ovrd" data-role="button" data-theme="c" data-icon="plus" data-inline="true">Update Photo</a>
        </div>
      </div>
      <div class="grid_6">
        <div class="pTI_text poolInfoBox">
          <div class="condensed" style="font-size:60px;">Manage Pool</div>
          <div style="padding:0 20px;">
            <div>Use the forms below to make changes or</div>
            <div>Inform everyone of the baby's arrival!</div>
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
  
  <div class="hideMobile"><br/><br/></div>
  <a class="showMobileBlock btn-red-ovrd ui-fullsize-ovrd" href="/dev/pool/<?= $poolID; ?>/" data-role="button" data-theme="c" data-icon="back" data-transition="flip">Back to Baby Pool</a>
  <div data-role="collapsible-set">
    <div class="formWrap">
      <?php if ($poolStatus != 'ranked' && $poolStatus != 'closed') : ?>
      <div data-role="collapsible" data-inset="false"  data-theme="a" data-collapsed-icon="plus" data-expanded-icon="minus" data-iconpos="right" data-collapsed="true">
        <h2>Edit Pool Settings</h2>
        <form id="editPool" name="editPool" method="post" data-ajax="false" action="//www.playtexbabypool.com/dev/pool/<?= $poolID; ?>/">
        <label for="motherEmail">Mother's Email:</label> 
        <input type="text" name="motherEmail" class="email" value="<?= isset($motherEmail) ? $motherEmail : ''; ?>" />

        <label for="motherMobile">Mother's Mobile Number:</label><div class="descTxt">Enter your mobile number if you'd like to receive future offers from Playtex Baby via SMS. Your number will not be used for any other purposes.</div>
        <input type="text" class="" name="motherMobile" value="<?= (!empty($motherMobile)) ? $motherMobile : '';?>" />
        <!--
        <fieldset id="gender" data-role="controlgroup" data-type="horizontal">
        	<legend>Baby's Gender:</legend>
             	<input type="radio" name="gender" id="gender-U" class="required" value="suprise" <?= (empty($gender) || $gender == 'surprise') ? 'checked=checked' : ''; ?> />
             	<label for="gender-U">It's a Surprise!</label>
             	<input type="radio" name="gender" id="gender-B" value="boy" <?= (!empty($gender) && $gender == 'boy') ? 'checked=checked' : ''; ?> />
             	<label for="gender-B">Boy</label>
             	<input type="radio" name="gender" id="gender-G" value="girl" <?= (!empty($gender) && $gender == 'girl') ? 'checked=checked' : ''; ?> />
             	<label for="gender-G">Girl</label>
        </fieldset>
        <label for="dueDate">Due Date <span class="reqOrg">*</span>:</label> 
        <input type="text" name="dueDate" class="required" value="<?= isset($dueDate) ? $dueDate : ''; ?>" data-theme="b" data-role="datebox" data-options='{"mode":"calbox", "afterToday":true, "useFocus":true, "useNewStyle":true, "calHighToday":false, "themeDatePick":"b", "themeDayHigh":"c", "themeGridPlus":"c", "themeHeader":"c", "themeDate":"a"}'  />
        -->
        <input type="hidden" name="dueTime" value="00:00 AM">
        <label for="poolEnd">Pool End Date <span class="reqOrg">*</span>:</label> 
        <input type="text" name="poolEnd" class="required" value="<?= isset($poolEnd) ? $poolEnd : ''; ?>" data-theme="b" data-role="datebox" data-options='{"mode":"calbox", "afterToday":true, "useFocus":true, "useNewStyle":true, "calHighToday":false, "themeDatePick":"b", "themeDayHigh":"c", "themeGridPlus":"c", "themeHeader":"c", "themeDate":"a"}'  />
        <label for="registryLink">Registry Link:</label> <input type="text" name="registryLink" value="<?= isset($registryLink) ? $registryLink : ''; ?>" />
        <input type="hidden" name="poolID" value="<?= $poolID; ?>" />
        <input type="hidden" name="poolStatus" value="<?= isset($poolStatus) ? $poolStatus : ''; ?>" />
        <input type="hidden" name="formType" value="PoolEdit" />
        <br/>
        <div style="text-align:center; margin:0 auto;">
          <a href="/dev/pool/<?= $poolID; ?>/" data-role="button" data-inline="true" data-icon="back" data-transition="flip" class="redButton cancel" data-theme="c">Cancel</a>
          <input type="submit" name="submit" value="Save" data-inline="true" data-icon="check" class="redButton" data-theme="c" />
        </div>
        </form>
      </div>
      <?php endif; ?>

      <?php if ($poolStatus != 'ranked') : ?>  
      <div data-role="collapsible" data-inset="false" data-theme="a" data-collapsed-icon="plus" data-expanded-icon="minus" data-iconpos="right" data-collapsed="<?= ($poolStatus == 'ranked' || $poolStatus == 'closed') ? 'false':'true'; ?>">
        <h2>The Baby is Here!</h2>
        <form id="finishPool" name="finishPool" method="post" data-ajax="false" action="//www.playtexbabypool.com/dev/pool/<?= $poolID; ?>/">
        <label for="babyName">Baby's Name <span class="reqOrg">*</span>:</label> 
        <input type="text" name="babyName" class="required" value="" />
        <fieldset id="babyGender" data-role="controlgroup" data-type="horizontal">
        	<legend>Baby's Gender <span class="reqOrg">*</span>:</legend>
             	<input data-theme="a" type="radio" name="babyGender" id="gender-B" class="required" value="boy" />
             	<label class="genderBtn_b" for="gender-B" data-role="button" data-theme="a" data-iconshadow="true" data-icon="male"></label>
             	<input data-theme="a" type="radio" name="babyGender" id="gender-G" value="girl" />
             	<label class="genderBtn_g" for="gender-G" data-role="button" data-theme="a" data-iconshadow="true" data-icon="female"></label>
        </fieldset>
        <label for="babyBirthdate">Birth Date <span class="reqOrg">*</span>:</label>
        <input type="text" name="babyBirthdate" class="required" data-role="datebox" data-theme="b" data-options='{"zindex":"100100100", "mode":"calbox", "afterToday":true, "useFocus":true, "useNewStyle":true, "calHighToday":false, "themeDatePick":"b", "themeDayHigh":"c", "themeGridPlus":"c", "themeHeader":"c", "themeDate":"a"}'  />
        <label for="babyBirthtime">Birth Time <span class="reqOrg">*</span>:</label>
        <input type="text" name="babyBirthtime" class="required" data-role="datebox" data-theme="c" data-options='{"zindex":"100100101", "mode":"timeflipbox", "useFocus":true, "useNewStyle":true, "themeDatePick":"b", "themeDayHigh":"c", "themeHeader":"c", "themeDate":"a"}' > 
        <label for="babyLength">Birth Length <span class="reqOrg">*</span>:</label> 
        <label class="lb-length" for="babyLength">Inches</label> 
        <input type="range" name="babyLength" id="length" class="required" value="25" min="1" max="50" data-theme="b" data-highlight="true" />
        <div id="weightBox">
          <div id="weighteachLbs" class="weighteach">
            <label for="babyWeightLbs" style="display:block">Birth Weight <span class="reqOrg">*</span>:</label> 
            <label class="lb-weight_lbs" for="babyWeightLbs">Lbs</label> 
            <input type="range" name="babyWeightLbs" class="required weight_lbs" value="13" min="0" max="25" data-theme="b" data-highlight="true" />
          </div>
          <div id="weighteachOz" class="weighteach">
            <label class="lb-weight_oz" for="babyWeightOz">Oz</label> 
            <input type="range" name="babyWeightOz" class="required weight_oz" value="7" min="0" max="15" data-theme="b" data-highlight="true" />
          </div>
          <div class="clear">&nbsp;</div>
        </div>
        <input type="hidden" name="poolID" value="<?= $poolID; ?>" />
        <input type="hidden" name="formType" value="<?= ($poolStatus == 'ranked') ? 'PoolBorn':'PoolBorn'; ?>" /><br/>
        <br/>
        <div style="text-align:center; margin:0 auto;">
          <a href="/dev/pool/<?= $poolID; ?>/" data-role="button" data-inline="true" data-icon="back" data-transition="flip" class="cancel redButton" data-theme="c">Cancel</a>
          <input type="submit" name="submit" value="Save & Share with friends" data-inline="true" data-icon="arrow-r" data-iconpos="right" class="redButton" data-theme="c" />
        </div>
        </form>
      </div>
      <?php endif; ?>
    
      <div data-role="collapsible" data-inset="false" data-theme="a" data-collapsed-icon="plus" data-expanded-icon="minus" data-iconpos="right" data-collapsed="true">
        <h2>Cancel Baby Pool</h2>
        <form id="cancelPool" name="cancelPool" method="post" data-ajax="false" action="//www.playtexbabypool.com/dev/pool/<?= $poolID; ?>/">
        <input type="hidden" name="poolID" value="<?= $poolID; ?>" />
        <input type="hidden" name="formType" value="PoolCancel" />
        <b>WARNING</b>: This action will cancel and PERMANENTLY delete your Baby Pool.<br/>
        <br/>
        <div style="text-align:center; margin:0 auto;">
          <a href="/dev/pool/<?= $poolID; ?>/" data-role="button" data-inline="true" data-icon="back" data-transition="flip" class="cancel redButton red-btn-ovrd" data-theme="c">No, don't cancel my baby pool</a>
          <input style="text-align:center;margin:0 auto;" type="submit" name="submit" value="Yes, cancel my baby pool" data-inline="true" data-icon="delete" class="redButton" data-theme="c" />
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

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


<script type="text/javascript">
$(document).on('pageshow', function(){
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
	var validator = $("#editPool").validate({
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

	var validator = $("#finishPool").validate({
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