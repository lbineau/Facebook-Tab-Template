<?php
require 'inc/const.php';
require 'inc/facebook/facebook.php';

$facebook = new Facebook(array(
  'appId'  => FB_APP_ID,
  'secret' => FB_APP_SECRET,
));

// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
  }
}
// Login or logout url will be needed depending on current user state.

if ($user) {
  $params = array(
    'scope' => PERMS,
    'redirect_uri' => FB_APP_URL
  );
  $logoutUrl = $facebook->getLogoutUrl($params);
} else {
  $params = array( 'next' => FB_APP_URL );
  $loginUrl = $facebook->getLoginUrl($params);
}

// This call will always work since we are fetching public data.
$publicProfile = $facebook->api('/mnstr.agence');

?><!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content=">">
  <meta property="og:image" content="">
  <meta property="og:description" content="">

  <title>Tab boilerplate</title>
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" href="css/style.css">

  <script src="js/libs/modernizr-2.5.3.min.js"></script>
</head>

<body onload="resize();">
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

  <div id="wrapper">
    <header>
      <h1>Tab boilerplate</h1>
    </header>
    <div role="main">
      <?php if ($user): // if the user is logged and have permissions ?>
        <a href="<?php echo $logoutUrl; ?>">Logout</a>
        
        <h3>You</h3>
        <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

        <h3>Your User Object (/me)</h3>
        <pre><?php print_r($user_profile); ?></pre>
      <?php else: // else fallback ?>
        <strong><em>You are not Connected.</em></strong>
        <div>
          Login using OAuth 2.0 handled by the PHP SDK:
          <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
        </div>
      <?php endif ?>

      <?php // displayed in every cases ?>
      <h3>PHP Session</h3>
      <pre><?php print_r($_SESSION); ?></pre>

      <h3>Public profile of <?php echo $publicProfile['name']; ?></h3>
      <img src="<?php echo $publicProfile['picture']; ?>">
      <?php echo $publicProfile['name']; ?>
    </div>
    <footer>

    </footer>
  </div>

  <div id="fb-root"></div>
  <script src="https://connect.facebook.net/en_US/all.js"></script>
  <script>
  var appId = '<?php echo $facebook->getAppID() ?>', // see in the const.php file
      appURL = '<?php echo FB_APP_URL ?>';

  FB.init({
    appId : appId, // App ID
    status : true, // check login status
    cookie : true, // enable cookies to allow the server to access the session
    xfbml : true  // parse XFBML
  });

  
  /**
   * Facebook Events
   */
  FB.Event.subscribe('auth.login', function(response) {
    window.location.reload();
  });
  
  FB.Event.subscribe('auth.logout', function(response) {
    window.location.reload();
  });

  // redirect to app/tab URL if user views outside Facebook
  // useful for enabling open graph data
  var isInIframe = (window.location != window.parent.location) ? true : false;

  if ( !isInIframe && location.host.indexOf('localhost') == -1 ) {
    location.href = appURL; // redirect not logged people on the facebook tab url
  }else{
    <?php if (FORCE_PERMS && !$user): // if the user have no permissions ?>
        top.location.href = "<?php echo $loginUrl ?>"; // redirect users with no permissions
    <?php endif; ?>    
  }


  // setup tab autogrowth
  function resize() {
    FB.Canvas.setAutoGrow();
  }
  </script>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.2.min.js"><\/script>')</script>

  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>

  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID. -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
</body>
</html>