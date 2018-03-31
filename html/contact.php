
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
    <!-- contact information -->
    <p>Palju muud kontaktinfot <br/></p>

    <!-- Payment-->
    <p>Et me saaksime oma tööd jätkata ja arendajatele kommi osta, jäta palun meile 5 euri :)</p>
    <form method="post" action="http://localhost:3480/banklink/swedbank" id="pangalink">
        <!-- include all values as hidden form fields -->
        <?php foreach($fields as $key => $val):?>
            <input type="hidden" name="<?php echo $key; ?>" value="<?php echo htmlspecialchars($val); ?>" />
        <?php endforeach; ?>
            <tr><td colspan="2">
                    <button type="submit" class='centerMe' form="pangalink">
                        <div class='icon'>
                            <i class='fa fa-credit-card'></i>
                        </div>
                        <div class='text'>
                            <span>Anneta</span>
                        </div>
                    </button>
                </td></tr>
    </form>
    <!-- Payment result -->
    <?php
    if($_GET["payment_action"]=="success"){
        echo "Annetus edukalt tehtud. Me täname Teid!";
    } elseif ($_GET["payment_action"]=="cancel"){
        echo "Makse jäi pooleli või ebaõnnestus. Proovige uuesti!";
    }else{
        echo "Te pole veel annetanud. Tehke seda praegu! (See näide töötab juhul, kui teie arvutis töötab pangalink.net rakendus)";
    }
    ?>

</body>
