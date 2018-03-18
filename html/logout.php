<?php
if(!session_id()){
    session_start();
}
if(isset($_SESSION['fb_access_token'])){
    require_once __DIR__ . '/php-graph-sdk-5.4/src/Facebook/autoload.php';
    $fb = new Facebook\Facebook([
        'app_id'                => '159317391454778',
        'app_secret'            => '725df95714f605f633f67d52fe8994bf',
        'default_graph_version' => 'v2.10',
    ]);
    $url = 'https://www.facebook.com/logout.php?next=http://46.101.78.158/login.php/&access_token='.$_SESSION['fb_access_token'];
    session_destroy();
    header('Location: '.$url);
}

?>