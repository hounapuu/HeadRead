<!DOCTYPE html>

<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    session_start();
    if (!isset($_SESSION['fb_access_token'])) {
        header("Location: http://headread.ninata.ga");
    }
    include_once 'upload.php';
    require_once __DIR__ . '/php-graph-sdk-5.4/src/Facebook/autoload.php';
    require_once "database-handler.php";
?>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>Kasutaja</title>

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
    $(function(){
        $("#navbar-placeholder").load("navigationbar.html", function () {
            $("#navbarUser").addClass("navbarActive");
        });
    });
</script>

<p><br/><br/></p>

<form action="user.php" method="post" enctype="multipart/form-data">
    Vali fail:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Lae üles" name="submit">
    <input type="submit" value="Kustuta" name="delete">


</form>
<?php
    $dtb = new Dtb();
    $fb = new Facebook\Facebook([
        'app_id' => '159317391454778',
        'app_secret' => '725df95714f605f633f67d52fe8994bf',
        'default_graph_version' => 'v2.10',
    ]);

    $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
    $user = $response->getGraphUser();
    $rows = $dtb->getImages($user['id']);
    if (count($rows) > 0) {
        foreach ($rows as $row) {
            echo     "<img src='".$row[0]."''/>";;
        }
    }
?>
</body>
