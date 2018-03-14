<?php
if(!session_id()){
    session_start();
}
require_once __DIR__ . '/php-graph-sdk-5.4/src/Facebook/autoload.php';
use Facebook\FacebookJavaScriptLoginHelper;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookSession;
use Facebook\FacebookRequestException;
use Facebook\GraphObject;
use Facebook\GraphUser;

// Initialize the Facebook PHP SDK v5.
$fb = new Facebook\Facebook([
    'app_id'                => '159317391454778',
    'app_secret'            => '725df95714f605f633f67d52fe8994bf',
    'default_graph_version' => 'v2.10',
]);

$helper = $fb -> getRedirectLoginHelper();

try {
    $session = $_SESSION['fb_access_token'];
} catch(FacebookRequestException $ex) {
    // When Facebook returns an error
    echo "tere";

} catch(\Exception $ex) {
    // When validation fails or other local issues
    echo "tere";

}

//show if the user is logged in or not
if ($session) {
    //Logged in
    echo ("User is logged in <br>") ;
    $response = $fb->get('/me?fields=id,name', $_SESSION['fb_access_token']);
    $user = $response -> getGraphUser();
    echo "Tere, " . $user['name'] . "<br>";
    $logout_url = "logout.php";
    echo  "<a href=" . $logout_url . ">Log out </a>";




} else {
    echo ("User is not logged in <br>");
    $permissions = ['email', 'public_profile', 'user_birthday']; // Optional permissions
    $loginUrl = $helper->getLoginUrl('http://46.101.78.158/fb-callback.php', $permissions);
    echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}



?>