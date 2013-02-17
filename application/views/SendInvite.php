<div class="content_wrap">
  
  <h1>Let's Invite Mother</h1>
  <div class="desktop-not-collapsible" data-role="collapsible" data-inset="false" data-theme="a" data-collapsed="false" data-collapsed-icon="plus" data-expanded-icon="minus" data-iconpos="right">
    <h2>Invite the Mother</h2>
    <div class="sendInvite_wrap">
      <div style="font-weight:bold;">The pool has been successfully created!</div>
      <div>You must inform the Mother for approval.</div>
      <br/>
      <div class="sendInviteBtn_wrap">
        <a href="#" onclick="sendFbMsg(); return false;" data-role="button" data-icon="check" data-iconpos="left" data-inline="true" data-theme="c" class="sendInviteBtn btn-red-ovrd">Send Mother Message</a>
      </div>
      <div class="sendMeHomeBtn_wrap">
        <h3 style="padding:10px 0;color:#f00;">Message Successfully Sent!</h3>
        <a href="/dev/" data-role="button" data-inline="true" data-icon="home" data-theme="c" class="btn-red-ovrd">Home</a>
      </div>
    </div>
  
  </div>
  
  <script> 
  function sendFbMsg() {
    var userID    = '<?= $motherID; ?>';
    var firstName = '<?= $firstName; ?>';
    var poolID    = '<?= $poolID; ?>';
    FB.ui({
      method: 'send',
      name: firstName + ' created a Baby Pool for you!',
      to: userID,
      description: 'I\'ve created you a baby pool for you to approve!',
      link: 'http://www.playtexbabypool.com/dev/create/organizer/'+ poolID + '/',
    },
    function(response) {
      if (response && response.success == true) {
        $(".sendInviteBtn_wrap").hide();
        $(".sendMeHomeBtn_wrap").show();
      }
    });
  }
  </script>

</div>