<?php
    $requestXML = simplexml_load_string($GET["request"]);
    if ($requestXML["request"] == "tooltip") {
        echo "<tooltip>Vabandame! Me endiselt töötame oma lehe parendamise suunas. Rohkema informatsiooni vaatamiseks proovide uuesti järgmisel etapil.</tooltip>";
    }
?>
