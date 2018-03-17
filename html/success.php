<?php include("i18n/i18n.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns="" xmlns="" xml:lang="en" lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css"/>

    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title><?= $LogInSuccessTitle?></title>
</head>
<body>
<body>
<div class="languages-flags">
    <a href="success.php?language=est"><img src="img/est.png" ></a>
    <a href="success.php?language=en"><img src="img/eng.png" ></a>
    <div class="clear"></div>
</div>


<p><?= $LogInSuccess ?></p>
<div class="tooltip"><img src="img/qm.png">
    <span class="tooltiptext"><?=$tooltipText?></span>
</div>


</body>
</html>