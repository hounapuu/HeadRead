$(function () {
    $("#navbar-placeholder").load("navigationbar.html", function () {
        $("#navbarHome").addClass("navbarActive");
    });
});
var firstLoad = true;

function mouseOver() {

    if (firstLoad) {
        firstLoad = false;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                xmlDoc = $.parseXML(this.responseText);
                $xml = $(xmlDoc);
                document.getElementById("tooltip").innerHTML =
                    $xml.find("tooltip").text();
            }
        };
        xhttp.open("GET", "tooltipText.php?request=<request>tooltip</request>", true);
        xhttp.send();
    }
}