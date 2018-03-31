
// navigation bar
function showNavigation() { 
    $("#navbar-placeholder").load("navigationbar.html", function () {
        $("#navbarHome").addClass("navbarActive");
    });    
}

// load local jquery if cdn fails
function jqueryLoadLocal() {
    if (typeof jQuery == 'undefined') {
        document.write(unescape("%3Cscript src='/js/jquery-3.3.1.min.js' type='text/javascript'%3E%3C/script%3E"));
    }
}