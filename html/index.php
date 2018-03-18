<!-- Connects language files to this file-->
<?php include_once("i18n/i18n.php");
require_once __DIR__ . '/php-graph-sdk-5.4/src/Facebook/autoload.php';
require_once "database-handler.php";

if (!session_id()) { //Check if facebook session is up, if not then start a new one
    session_start();
}

use Facebook\FacebookRequestException;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns="" xmlns="" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title><?= $pageTitileLogIn ?></title>

    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script src="js/testscript.js" type="text/javascript"></script>
</head>

<body>
<!--Language selection flags-->
<div class="languages-flags">
    <a href="index.php?language=est"><img src="img/est.png"></a>
    <a href="index.php?language=en"><img src="img/eng.png"></a>
    <div class="clear"></div>
</div>

<!-- Page name-->
<h1><?= $testpage ?></h1>
<!-- Facebook log in-->
<p id="status" >
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
        <?=$isLoggedin;?><br>
        <?php
        $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
        $user = $response->getGraphUser();
        ?>
        <?= $helloMessage  . $user['name']; ?>. <br>
        <?php
        $logout_url = "logout.php";
        $dtb = new Dtb();
        $conn = $dtb->getConnection();
        $andmed = $dtb->getUserData($user['id']);
        ?>
        <?= $loginTime  . $andmed[0]; ?>. <br>
        <?= $ipMessage  . $andmed[1]; ?>. <br>
        <a href=<?=$logout_url?>><?=$logoutMessage?></a>
        <?php

    } else {
        ?>
        <?=$isNotLoggedin;?><br>
        <?php
        $permissions = ['email', 'public_profile', 'user_birthday']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('http://46.101.78.158/fb-callback.php', $permissions);
        ?>
        <a href=<?=$loginUrl?>><?=$loginLink?></a>
        <?php

    }

    ?>

</>
<!--Random testing line-->
<p id="testrida" ><?= $randomLines ?></p>
</body>

</html>