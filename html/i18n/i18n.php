<?php
if (!empty($_GET['language'])) {
    $_COOKIE['language'] = $_GET['language'] === 'est' ? 'est' : 'en';
} else {
    $_COOKIE['language'] = 'en';
}
setcookie('language', $_COOKIE['language']);

if ($_COOKIE['language'] == "en") {
    include("en.php");
} else {
    include("est.php");
}
?>