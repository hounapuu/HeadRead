<!DOCTYPE html">

<?php
    include_once "pay.php";
?>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>Kontakt</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
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
        $(function() {
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
            <tr>
                <td colspan="2">
                    <button type="submit" class='centerMe' form="pangalink">
                        <div class='icon'>
                            <i class='fa fa-credit-card'></i>
                        </div>
                        <div class='text'>
                            <span>Anneta</span>
                        </div>
                    </button>
                </td>
            </tr>
    </form>
    <!-- Payment result -->
    
    <?php
        if($_GET["payment_action"]=="success") {
            echo "Annetus edukalt tehtud. Me täname Teid!";
        } elseif ($_GET["payment_action"]=="cancel") {
            echo "Makse jäi pooleli või ebaõnnestus. Proovige uuesti!";
        } else {
            echo "Te pole veel annetanud. Tehke seda praegu! (See näide töötab juhul, kui teie arvutis töötab pangalink.net rakendus)";
        }
    ?>

</body>
