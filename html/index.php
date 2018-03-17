<?php include("i18n/i18n.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns="" xmlns="" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title><?= $pageTitileLogIn ?></title>

    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script src="js/facebook_login.js" type="text/javascript"></script>
    <script src="js/testscript.js" type="text/javascript"></script>
</head>

<body>
<div class="languages-flags">
<a href="index.php?language=est"><img src="img/est.png" ></a>
<a href="index.php?language=en"><img src="img/eng.png" ></a>
    <div class="clear"></div>
</div>

<h1><?= $testpage ?></h1>
<p id="status">
    <fb:login-button
            scope="public_profile,email"
            onlogin="checkLoginState();">
    </fb:login-button>
</p>
<p id="testrida"><?= $randomLines ?></p>
</body>

</html>