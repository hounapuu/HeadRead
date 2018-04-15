<!DOCTYPE html>
<html lang="et">

<?php
    include_once "utils/pay.php";
?>

<head>
    <title>Paremad Read - Kontaktinfo</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="description" content="Paremad Read kontaktinfo">
    <meta name="keywords" content="kontaktid, kontaktinfo">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../styles/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        if (typeof jQuery === "undefined") {
            document.write(unescape("%3Cscript src='/js/jquery-3.3.1.min.js' type='text/javascript'%3E%3C/script%3E"));
        }
    </script>
</head>

<body itemscope itemtype="http://schema.org/ContactPage">>
    <!-- Navbar-->
    <div id="navbar-placeholder">
        <?php include("templates/navigationbar.html"); ?>
    </div>

    <!-- contact information -->
    <p itemprop="text">Palju muud kontaktinfot <br/></p>

    <!-- Payment-->
    <p>Et me saaksime oma tööd jätkata ja arendajatele kommi osta, jäta palun meile 5 euri :)</p>

    <form method="post" action="http://localhost:3480/banklink/swedbank" id="pangalink" itemscope itemtype="https://schema.org/DonateAction">
        <!-- include all values as hidden form fields -->
        <?php foreach($fields as $key => $val):?>
            <input type="hidden" name="<?php echo $key; ?>" value="<?php echo htmlspecialchars($val); ?>" />
        <?php endforeach; ?>
        <div id="donate">
            <button type="submit" form="pangalink">
                <em class="fa fa-credit-card"></em>
                <span>Anneta</span>
            </button>
        </div>
    </form>
    <!-- Payment result -->

    <?php
        if ($_GET["payment_action"]=="success") {
            echo "Annetus edukalt tehtud. Me täname Teid!";
        } elseif ($_GET["payment_action"]=="cancel") {
            echo "Makse jäi pooleli või ebaõnnestus. Proovige uuesti!";
        } else {
            echo "Annetage kohe! (See näide töötab juhul, kui teie arvutis töötab pangalink.net rakendus)";
        }
    ?>

</body>
