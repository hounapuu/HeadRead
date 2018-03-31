
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
include_once "pay.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>Kontakt</title>

    <link rel="stylesheet" type="text/css" href="styles/style.css"/>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
    <!-- Navbar-->
    <div id="navbar-placeholder"></div>
    <script>
        $(function(){
            $("#navbar-placeholder").load("navigationbar.html", function () {
                $("#navbarContact").addClass("navbarActive");
            });
        });
    </script>
    <p>Palju muud kontaktinfot <br/></p>

    <form method="post" action="http://localhost:3480/banklink/swedbank">
        <!-- include all values as hidden form fields -->
        <?php foreach($fields as $key => $val):?>
            <input type="hidden" name="<?php echo $key; ?>" value="<?php echo htmlspecialchars($val); ?>" />
        <?php endforeach; ?>
            <tr><td colspan="2"><input type="submit" value="Edasi panga lehele" /></td></tr>
    </form>

    get:
    <?php
    print_r($_GET);
    ?>
    <br/>
    post:
    <?php
    print_r($_POST);
    ?>

</body>
