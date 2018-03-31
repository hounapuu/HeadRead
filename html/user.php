
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
session_start();
if (!isset($_SESSION['fb_access_token'])) {
    header("Location: http://46.101.78.158");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>Kasutaja</title>

    <link rel="stylesheet" type="text/css" href="styles/style.css"/>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

</head>

<body>
<!-- Navbar-->
<div id="navbar-placeholder"></div>
<script>
    $(function(){
        $("#navbar-placeholder").load("navigationbar.html", function () {
            $("#navbarUser").addClass("navbarActive");
        });
    });
</script>

<p></br><br/><br/></p>

<?php
if(isset($_FILES['image'])){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

    $expensions= array("jpeg","jpg","png");

    if(in_array($file_ext,$expensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }

    if($file_size > 2097152){
        $errors[]='File size must be excately 2 MB';
    }

    if(empty($errors)==true){
        move_uploaded_file($file_tmp,"images/".$file_name);
        echo "Success";
    }else{
        print_r($errors);
    }
}
?>

<form action = "" method = "POST" enctype = "multipart/form-data">
    <input type = "file" name = "image" />
    <input type = "submit"/>

    <ul>
        <li>Sent file: <?php echo $_FILES['image']['name'];  ?>
        <li>File size: <?php echo $_FILES['image']['size'];  ?>
        <li>File type: <?php echo $_FILES['image']['type'] ?>
    </ul>

</form>

<!--
<form action="upload.php" method="post" enctype="multipart/form-data">
    Profiilipildi ülslaadimine
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Lae üles" name="submit">
</form>
-->
</body>
