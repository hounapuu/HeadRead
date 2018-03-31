<!-- Connects language files to this file-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<?php include_once("i18n/i18n.php");
require_once __DIR__ . '/php-graph-sdk-5.4/src/Facebook/autoload.php';
require_once "database-handler.php";

if (!session_id()) { //Check if facebook session is up, if not then start a new one
    session_start();
}

use Facebook\FacebookRequestException;

?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title><?= $pageTitileLogIn ?></title>

    <link rel="stylesheet" type="text/css" href="styles/style.css"/>
    <script src="js/googlemaps.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body onload="initMap()">
<!--Language selection flags-->
<div class="languages-flags">
    <a href="index.php?language=est"><img src="img/est.png" alt="eesti keeles"/></a>
    <a href="index.php?language=en"><img src="img/eng.png" alt="in english"/></a>
    <div class="clear"></div>
</div>

<div id="navbar-placeholder"></div>
<script>
    $(function(){
        $("#navbar-placeholder").load("navigationbar.html");
    });
</script>

<!-- Page name-->
<h1><?= $testpage ?>
    <!--Tooltip-->
    <span class="tooltip"><img src="img/qm.png" alt="info"/>
    <span class="tooltiptext"><?= $tooltipText ?></span>
</span></h1>
<!-- Facebook log in-->
<p id="status">
    <!--TODO: cleanup !-->
    <?php
    // Initialize the Facebook PHP SDK v5.
    $fb = new Facebook\Facebook([
        'app_id' => '159317391454778',
        'app_secret' => '725df95714f605f633f67d52fe8994bf',
        'default_graph_version' => 'v2.10',
    ]);
    //helper is used to log user in
    $helper = $fb->getRedirectLoginHelper();

    try {
        $session = $_SESSION['fb_access_token'];
    } catch (FacebookRequestException $ex) {
        // When Facebook returns an error
        echo $ex;

    } catch (\Exception $ex) {
        // When validation fails or other local issues
        echo $ex;

    }

    //show if the user is logged in or not
    if ($session) {
    //Logged in
    ?>
    <?= $isLoggedin; ?><br/>
    <?php
    $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
    $user = $response->getGraphUser();
    ?>
    <?= $helloMessage . $user['name']; ?>. <br/>
    <?php
    $logout_url = "logout.php";
    $dtb = new Dtb();
    $conn = $dtb->getConnection();
    $andmed = $dtb->getUserData($user['id']);
    $users = $dtb->getUserCount();
    ?>
    <?= $userCount . $users; ?> <br/>

    <?= $loginTime . $andmed[0]; ?>. <br/>
    <?= $ipMessage . $andmed[1]; ?>. <br/>

<button id="logoutButton" class="float-left submit-button"><?= $logoutMessage ?></button>

<script type="text/javascript">
    document.getElementById("logoutButton").onclick = function () {
        location.href = "<?=$logout_url?>";
    };
</script>
<?php

} else {
    ?>
    <?= $isNotLoggedin; ?><br/>
<?php
$permissions = ['email', 'public_profile', 'user_birthday']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://46.101.78.158/fb-callback.php', $permissions);
?>

    <button id="loginButton" class="float-left submit-button"><?= $loginLink ?></button>

    <script type="text/javascript">
        document.getElementById("loginButton").onclick = function () {
            location.href = "<?=$loginUrl?>";
        };
    </script>
    <?php

}

?>
</p>
<!--Random testing line-->
<p id="testrida"><?= $randomLines ?></p>

<p id="map"></p>
<script defer="defer"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBBRZiaZJycfXIp3rHPUSQIaGeMOn9pv4&amp;callback=initMap"
        type="text/javascript">
</script>
</body>

</html>