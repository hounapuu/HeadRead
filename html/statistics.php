<!DOCTYPE html>

<?php
    include_once("i18n/i18n.php");
    require_once __DIR__ . '/php-graph-sdk-5.4/src/Facebook/autoload.php';
    require_once "database-handler.php";
    session_start();
    if (!isset($_SESSION['fb_access_token']) && !isset($_SESSION['smartValid'])) {
        header("Location: http://46.101.78.158/");
    }
?>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>Statistika</title>

    <link rel="stylesheet" type="text/css" href="styles/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        if (typeof jQuery == 'undefined') {
            document.write(unescape("%3Cscript src='/js/jquery-3.3.1.min.js' type='text/javascript'%3E%3C/script%3E"));
        }
    </script>
</head>

<body>
    <!-- Navbar-->
    <div id="navbar-placeholder"></div>
    <script type="text/javascript">
        $(function () {
            $("#navbar-placeholder").load("navigationbar.html", function () {
                $("#navbarStatistics").addClass("navbarActive");
            });
        });
    </script>

    <p>
        <?php
        // Initialize the Facebook PHP SDK v5.
        $fb = new Facebook\Facebook([
            'app_id' => '159317391454778',
            'app_secret' => '725df95714f605f633f67d52fe8994bf',
            'default_graph_version' => 'v2.10',
        ]);

            $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
            $user = $response->getGraphUser();

        $dtb = new Dtb();
        $conn = $dtb->getConnection();
        $andmed = $dtb->getUserData($user['id']);
        $users = $dtb->getUserCount();
        echo $userCount . $users; ?> <br/>

        <?= $loginTime . $andmed[0]; ?>. <br/>
        <?= $ipMessage . $andmed[1]; ?>. <br/>
    </p>
</body>
