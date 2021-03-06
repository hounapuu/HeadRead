<!DOCTYPE html>
<html lang="et">

<?php
    include_once("i18n/i18n.php");
    require_once __DIR__ . "/php-graph-sdk-5.4/src/Facebook/autoload.php";
    require_once "database-handler.php";
    session_start();
    if (!isset($_SESSION["fb_access_token"]) && !isset($_SESSION["smartValid"])) {
        header("Location: http://46.101.78.158/");
    }
?>

<head>
    <title>Paremad Read - Statistika</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="description" content="Paremad Read kasutajate statistika">
    <meta name="keywords" content="Kasutajate statistika, kasutajad">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        if (typeof jQuery == "undefined") {
            document.write(unescape("%3Cscript src='/js/jquery-3.3.1.min.js' type='text/javascript'%3E%3C/script%3E"));
        }
    </script>
    <script type="text/javascript" src="js/LoggedInUserclient.js"></script>
</head>

<body itemscope itemtype="http://schema.org/WebPage">
    <!-- Navbar-->
    <div id="navbar-placeholder">
        <?php include("navigationbar.html"); ?> 
    </div>
    

    <p itemprop="mainContentOfPage">
        <?php
        // Initialize the Facebook PHP SDK v5.
        $fb = new Facebook\Facebook([
            "app_id" => "159317391454778",
            "app_secret" => "725df95714f605f633f67d52fe8994bf",
            "default_graph_version" => "v2.10",
        ]);

            $response = $fb->get("/me?fields=id,name,email", $_SESSION["fb_access_token"]);
            $user = $response->getGraphUser();

        $dtb = new Dtb();
        $conn = $dtb->getConnection();
        $andmed = $dtb->getUserData($user["id"]);
        $users = $dtb->getUserCount();
        echo $userCount . $users; ?> <br/>

        <?= $loginTime . $andmed[0]; ?>. <br/>
        <?= $ipMessage . $andmed[1]; ?>. <br/>
    </p>
<br/>
    <!-- datapush -->
    <h2>Viimased Facebookiga sisselogijad:</h2>
    <pre id="loggedInUsers"></pre>



</body>
