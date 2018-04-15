<?php
if(!session_id()){
    session_start();
}
require_once __DIR__ . "/php-graph-sdk-5.4/src/Facebook/autoload.php";
require  __DIR__ . "/database-handler.php";

$fb = new Facebook\Facebook([
    "app_id" => "159317391454778",
    "app_secret" => "725df95714f605f633f67d52fe8994bf",
    "default_graph_version" => "v2.10",
]);

$helper = $fb->getRedirectLoginHelper();
$_SESSION["FBRLH_state"]=$_GET["state"];

try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo "Facebook SDK returned an error: " . $e->getMessage();
    exit;
}

if (! isset($accessToken)) {
    if ($helper->getError()) {
        header("HTTP/1.0 401 Unauthorized");
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
        header("HTTP/1.0 400 Bad Request");
        echo "Bad request";
    }
    exit;
}

// Logged in


echo "<h3>Access Token</h3>";
var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
echo "<h3>Metadata</h3>";
var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
try {
    $tokenMetadata->validateAppId($config["app_id"]);
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    echo $e;
}
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId("123");
try {
    $tokenMetadata->validateExpiration();
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    echo $e;
}

if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
        exit;
    }

    echo "<h3>Long-lived</h3>";
    var_dump($accessToken->getValue());
}

$_SESSION["fb_access_token"] = (string) $accessToken;

// Logged in

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
$dtb = new Dtb();
$conn = $dtb->getConnection();
$_SESSION["dtb"] = $dtb;
if (mysqli_ping($conn)) {
    echo ("Connection is establihed! <br>");
    $response = $fb->get("/me?fields=id,name,email", $_SESSION["fb_access_token"]);
    $user = $response->getGraphUser();
    $ipaddr =  $_SERVER["REMOTE_ADDR"];
    if (!($dtb->isUser($user["id"], $ipaddr))) {
        $dtb->insertUser($user["id"], $user["name"], $user["email"], $ipaddr);
        //faili kirjutamine
        $file="loggedInUsers.txt";
        $data=$user['name']."\n";
        fwrite($file,$data);
        fclose($file);

        // first login, send signup email
        if (filter_var($user["email"], FILTER_VALIDATE_EMAIL)) {
            $to = $user["email"];
            $subject = "Paremad Read - uus kasutaja";
            $body = "Tere tulemast Paremad Read kasutajate sekka!";
            $headers = "From: paremad@ninata.ga";
            if (!mail($to, $subject, $body, $headers)) {
                error_log(print_r("Message delivery failed to " . $to, TRUE), 3, "/var/tmp/sendmail_errors.log");
            }
        }
        
            
    }



} else {
    printf(mysqli_error($conn));
}
header("Location: http://46.101.78.158/");
?>