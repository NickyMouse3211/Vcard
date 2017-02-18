
<?php
// require Facebook PHP SDK
// see: https://developers.facebook.com/docs/php/gettingstarted/
// define('FACEBOOK_SDK_V4_SRC_DIR','/Facebook/');
require_once'Facebook/Autoload.php';
// initialize Facebook class using your own Facebook App credentials
// see: https://developers.facebook.com/docs/php/gettingstarted/#install


$fb = new Facebook\Facebook([
  'app_id' => '1533478166969359',
  'app_secret' => '4c35807324a7a9f7722aa1ce636035cb',
  'default_graph_version' => 'v2.2',
  ]);





// $config = array();
// $config['appId'] = '1533478166969359';
// $config['secret'] = '4c35807324a7a9f7722aa1ce636035cb';
// $config['fileUpload'] = false; // optional
 
// $fb = new Facebook\Facebook($config);
 
// define your POST parameters (replace with your own values)
// $params = array(
//   "access_token" => "1533478166969359|r5nC2EHOKLZrjsCrOj8daBAiAac", // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
//   "message" => "Here is a blog post about auto posting on Facebook using PHP #php #facebook",
//   "link" => "http://www.pontikis.net/blog/auto_post_on_facebook_with_php",
//   "picture" => "http://i.imgur.com/lHkOsiH.png",
//   "name" => "How to Auto Post on Facebook with PHP",
//   "caption" => "www.pontikis.net",
//   "description" => "Automatically post on Facebook with PHP using Facebook PHP SDK. How to create a Facebook app. Obtain and extend Facebook access tokens. Cron automation."
// );
 
// // post to Facebook
// // see: https://developers.facebook.com/docs/reference/php/facebook-api/
// try {
//   $ret = $fb->api('/100010683332041/feed', 'POST', $params);
//   echo 'Successfully posted to Facebook';
// } catch(Exception $e) {
//   echo $e->getMessage();
// }

$linkData = [
  'link' => 'http://fierce.hol.es',
  'message' => 'User provided message',
  ];

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->post('/100010683332041/feed', $linkData, '1533478166969359|r5nC2EHOKLZrjsCrOj8daBAiAac');
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

// $graphNode = $response->getGraphNode();

// echo 'Posted with id: ' . $graphNode['id'];
?>