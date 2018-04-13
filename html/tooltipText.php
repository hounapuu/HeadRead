<?php
    $request = simplexml_load_string($GET["request"]);
    print_r($request);
    if ($request == "tooltip") {
        echo "<tooltip>Vabandame! Me endiselt töötame oma lehe parendamise suunas. Rohkema informatsiooni vaatamiseks proovide uuesti järgmisel etapil.</tooltip>";
    }
?>
