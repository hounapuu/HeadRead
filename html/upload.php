<?php
function alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
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
            alert("Fail " . basename($_FILES["fileToUpload"]["name"]) . " laeti üles.");
        } else {
            alert("Faili üleslaadimine ebaõnnestus.");
        }
    }
}
?>