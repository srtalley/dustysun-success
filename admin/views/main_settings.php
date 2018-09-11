<!--Facebook-->
<!--https://developers.facebook.com/docs/plugins/share-button#-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=241973699583991&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<!--Twitter-->
<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>

<!--Google-->
<!--https://developers.google.com/+/web/share/-->
<script src="https://apis.google.com/js/platform.js" async defer></script>
<div class="ds-wp-settings-flex-columns">
  <div class="ds-wp-settings-two-thirds ds-wp-settings-space-between">
    <div>
        <h3 class="ds-wp-settings-first-title">SUCCESS is a theme that will help you define your business!</h3>

        <h4>How to Use</h4>
        <p>
          <ol>
            <li>Make sure you've already installed the required <a href="/wp-admin/themes.php?page=tgmpa-install-plugins&plugin_status=install">One Click Demo Import</a> plugin.</li>
            <li>Once that's installed, <a href="/wp-admin/themes.php?page=pt-one-click-demo-import">run the importer</a> if you haven't already.</li>
            <li>Change any of the built in layouts or check out the SUCCESS options under the <a href="/wp-admin/customize.php?return=%2Fwp-admin%2Fadmin.php%3Fpage%3Ddustysun-cafechill">Theme Customizer</a>.</li>
          </ol>
        </p>
      </div>
  
  </div>
  <div class="ds-wp-settings-one-third ds-wp-settings-logo-display">
      <img src="<?php echo get_stylesheet_directory_uri() . '/admin/views/success.jpg';?>">
  </div>
  <div class="ds-wp-settings-full-width ds-wp-settings-api-share-box">
  <!-- Begin MailChimp Signup Form -->
  <link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">
  <style type="text/css">
    #mc_embed_signup{width:100%;}
    #mc_embed_signup form { padding: 0;}
    #mc_embed_signup .button {background-color: #87608d;}
    #mc_embed_signup .button:hover {background-color: #6f3d65;}
    /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
       We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
  </style>
  <div id="mc_embed_signup">
  <form action="https://dustysun.us13.list-manage.com/subscribe/post?u=f9e097f181dd4927894fb3b6c&amp;id=aae905235f" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
      <div id="mc_embed_signup_scroll">
    <label for="mce-EMAIL">Sign up for updates on this theme &amp; more!</label>
    <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
      <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
      <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_f9e097f181dd4927894fb3b6c_aae905235f" tabindex="-1" value=""></div>
      <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
      </div>
  </form>
  </div>

  <!--End mc_embed_signup-->

  <div><h4>Love this theme? Please share with your friends! :)</h4></div>

  <div class="ds-wp-settings-vertical-align">
    <!-- Your share button code -->
    <div class="fb-share-button" data-href="https://dustysun.com/success-theme/" data-layout="button" data-size="large"></div>

    <a class="twitter-share-button"
      href="https://twitter.com/intent/tweet?text=Check%20Out%20SUCCESS&url=https://dustysun.com/success-theme/"
      data-size="large"></a>

    <!-- Place this tag where you want the share button to render. -->
    <div class="g-plus" data-action="share" data-height="24" data-href="https://dustysun.com/success-theme/"></div>
  </div>
  </div>
</div> <!-- ds-wp-settings-flex-columns -->
