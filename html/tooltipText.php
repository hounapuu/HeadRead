<?php
    $request = simplexml_load_string($_GET["request"]);
    if ($request == "tooltip") {
        echo "<tooltip>Vabandame! Me endiselt töötame oma lehe parendamise suunas. Rohkema informatsiooni vaatamiseks proovide uuesti järgmisel etapil.</tooltip>";
    }
?>
