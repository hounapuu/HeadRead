<?php
require_once __DIR__ . '/php-graph-sdk-5.4/src/Facebook/autoload.php';
require_once "database-handler.php";

function alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";
}




// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $fb = new Facebook\Facebook([
        'app_id' => '159317391454778',
        'app_secret' => '725df95714f605f633f67d52fe8994bf',
        'default_graph_version' => 'v2.10',
    ]);

    $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
    $user = $response->getGraphUser();


    $target_dir = "uploads/";
    $target_file = $target_dir . $user['id'] . "/" . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if (strpos($_FILES["fileToUpload"]["name"], '.php') !== false){
        alert("php faili ei saa üles laadida");
        $uploadOk = 0;
    }
    if ($check !== false) {
        alert("Fail on pilt - " . $check["mime"] . ".");
        $uploadOk = 1;
    } else {
        alert("Fail ei ole pilt.");
        $uploadOk = 0;
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        alert("Fail juba eksisteerib.");
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        alert("Fail on liiga suur (max 500kB).");
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        alert("Fail peab olema jpg, jpeg, png või gif formaadis.");
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        alert("Faili üleslaadimine ebaõnnestus.");
        // if everything is ok, try to upload file
    } else {
        echo $_FILES["fileToUpload"]["tmp_name"];
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $dtb = new Dtb();
            $dtb->insertImage($user['id'], $target_file);
            alert("Fail " . basename($_FILES["fileToUpload"]["name"]) . " laeti üles.");
        } else {
            alert("Faili üleslaadimine ebaõnnestus.");
        }
    }
}
if (isset($_POST["delete"])) {
    $fb = new Facebook\Facebook([
        'app_id' => '159317391454778',
        'app_secret' => '725df95714f605f633f67d52fe8994bf',
        'default_graph_version' => 'v2.10',
    ]);

    $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
    $user = $response->getGraphUser();
    $dtb = new Dtb();
    $rows = $dtb->getImages($user['id']);
    if (count($rows) > 0) {
        foreach ($rows as $row) {
            $dtb->removeImage($user['id'], $row[0]);
        }
    } else {
        alert("Pole midagi kustutada.");
    }
}



?>