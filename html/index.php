<!DOCTYPE html>
<html lang="et">

    <!-- Connects language files to this file-->
    <?php
        include_once("i18n/i18n.php");
        require_once __DIR__ . "/php-graph-sdk-5.4/src/Facebook/autoload.php";
        require_once "database-handler.php";

        if (!session_id()) { //Check if facebook session is up, if not then start a new one
            session_start();
        }

        use Facebook\FacebookRequestException;
    ?>


    <head>
        <title>Paremad Read - Avaleht</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <meta name="description" content="Paremad Read raamatuotsing">
        <meta name="keywords" content="Raamatud, E-raamatud, Kasutatud raamatud, Raamatute müük">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="styles/style.css"/>
        <script src="js/googlemaps.js" type="text/javascript"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            if (typeof jQuery == "undefined") {
                document.write(unescape("%3Cscript src='/js/jquery-3.3.1.min.js' type='text/javascript'%3E%3C/script%3E"));
            }
        </script>
    </head>

    <body onload="initMap()" itemscope itemtype="http://schema.org/WebPage">


    <!-- Navbar-->
        <div id="navbar-placeholder">
            <?php include("navigationbar.html"); ?> 
        </div>
        <script type="text/javascript" src="js/indexJS.js"></script>

        <!--Language selection flags-->
        <div class="languages-flags">
            <a href="index.php?language=est" rel="nofollow" itemprop="url"><img src="img/est.png" itemprop="image" alt="eesti keeles"/></a>
            <a href="index.php?language=en" rel="nofollow" itemprop="url"><img src="img/eng.png" itemprop="image" alt="in english"/></a>
            <div class="clear"></div>
        </div>

        <!-- Page name-->
        <h1><?= $testpage ?>
            <!--Tooltip-->
            <span class="tooltip" onmouseover="mouseOver()" onfocus="mouseOver()"><img src="img/qm.png" itemprop="image" alt="info"/>
                <span class="tooltiptext" id="tooltip">
                </span>
            </span>
        </h1>

        <!-- Facebook log in-->
        <p id="status">
        <!--TODO: cleanup !-->
        <?php
            // Initialize the Facebook PHP SDK v5.
            $fb = new Facebook\Facebook([
                "app_id" => "159317391454778",
                "app_secret" => "725df95714f605f633f67d52fe8994bf",
                "default_graph_version" => "v2.10",
            ]);
            //helper is used to log user in
            $helper = $fb->getRedirectLoginHelper();

            try {
                $session = $_SESSION["fb_access_token"];
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
                    $response = $fb->get("/me?fields=id,name,email", $_SESSION["fb_access_token"]);
                    $user = $response->getGraphUser();
                ?>
                <?= $helloMessage . $user["name"]; ?>. <br/>
                <?php
                    $logout_url = "logout.php";
                    $dtb = new Dtb();
                    $conn = $dtb->getConnection();
                    $andmed = $dtb->getUserData($user["id"]);
                    $users = $dtb->getUserCount();
                ?>
                <?= $userCount . $users; ?> <br/>

                <?= $loginTime . $andmed[0]; ?>. <br/>
                <?= $ipMessage . $andmed[1]; ?>. <br/>

                <button id="logoutButton" class="float-left submit-button" rel="nofollow" itemprop="url"><?= $logoutMessage ?></button>

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
                    $permissions = ["email", "public_profile", "user_birthday"]; // Optional permissions
                    $loginUrl = $helper->getLoginUrl("http://46.101.78.158/fb-callback.php", $permissions);
                ?>

                <button id="loginButton" class="float-left submit-button" rel="nofollow" itemprop="url"><?= $loginLink ?></button>
                <br>
                <form method="post" action="/smartid.php">
                    <div>
                        <label for="idNumber">Isikukood</label>
                        <input type="text" id="idNumber" placeholder="Sisesta isikukood" name="idNumber">
                    </div>
                    <div>
                        <label for="idSubmit">Kinnita</label>
                        <button type="submit" id="idSubmit">Kinnita</button>
                    </div>
                </form>

                <script type="text/javascript">
                    document.getElementById("loginButton").onclick = function () {
                        location.href = "<?=$loginUrl?>";
                    };
                </script>
                <?php

            }

        ?>

        <!-- Our location -->
        <div itemscope itemtype="http://schema.org/LocalBusiness">
            <span itemprop="name">Paremad Read asukoht</span>
            <p id="map" itemprop="hasMap"></p>
            <script defer="defer"
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBBRZiaZJycfXIp3rHPUSQIaGeMOn9pv4&amp;callback=initMap"
                    type="text/javascript">
            </script>
        </div>
    </body>

</html>
