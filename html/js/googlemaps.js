function initMap() {
    var uluru = {lat: 58.37821334, lng: 26.71465933};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 17,
        center: uluru
    });
    var marker = new google.maps.Marker({
        position: uluru,
        map: map
    });
    marker['customInfo'] = "Siin on meie töökoht!";
    google.maps.event.addListener(marker, 'click', function() {
        alert(this.customInfo);
    });
}