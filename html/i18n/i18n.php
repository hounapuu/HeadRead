<!--Language cookie logic-->
<?php
/*Creates a cookie dependingon language choose, deafult is estonian*/
if (!empty($_GET['language'])) {
    $_COOKIE['language'] = $_GET['language'] === 'est' ? 'est' : 'en';
} else {
    $_COOKIE['language'] = 'est';
}
setcookie('language', $_COOKIE['language']);

/*Selects file to use by selected language cookie*/
if ($_COOKIE['language'] == "en") {
    include("en.php");
} else {
    include("est.php");
}
?>