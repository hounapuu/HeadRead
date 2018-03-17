function lisaTeksti(keel) {

    var element = document.getElementById("testrida");
    var text = keel=== "est"?"Lisatud rida":"Added line";

    element.innerHTML = element.innerHTML + "<br>" + text;
};

