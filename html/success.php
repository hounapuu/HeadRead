<!-- Connects language files to this file-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<?php include("i18n/i18n.php"); ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="styles/style.css"/>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title><?= $LogInSuccessTitle?></title>
</head>

<!--Language selection flags-->
<body>
<div class="languages-flags">
    <a href="success.php?language=est"><img src="img/est.png" alt="eesti keeles"/></a>
    <a href="success.php?language=en"><img src="img/eng.png" alt="in english"/></a>
    <div class="clear"></div>
</div>

<!--Log in text-->
<p style="text-align: left;"><?= $LogInSuccess ?>
    <!--Tooltip-->
    <span class="tooltip"><img src="img/qm.png" alt="info"/>
    <span class="tooltiptext"><?=$tooltipText?></span>
</span>
</p>

</body>
</html>