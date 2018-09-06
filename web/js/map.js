var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function calcRoute(dep, arr) {
    var start = dep;
    var end = arr;

    var request = {
        origin: start,
        destination: end,
        provideRouteAlternatives: true,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function (result, status, distance) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);
        }
    });
}

function initializeRecap(lat_dep, lng_dep, lat_arr, lng_arr) {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var chicago = new google.maps.LatLng(lat_dep, lng_dep);
    var mapOptions = {
        zoom: 5,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: chicago
    }
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    directionsDisplay.setMap(map);

    var dep = new google.maps.LatLng(lat_dep, lng_dep);
    var arr = new google.maps.LatLng(lat_arr, lng_arr);
    calcRoute(dep, arr);
    getDistance(dep, arr);
}

function getDistance(dep, arr) {
    var origin = dep;
    var destination = arr;

    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [origin],
        destinations: [destination],
        travelMode: google.maps.TravelMode.DRIVING,
        avoidHighways: false,
        avoidTolls: false
    }, callback);

    function callback(response, status) {
        var res = response.rows[0].elements[0].distance.value;
        $("#distance").append(res / 1000);
        return res;
    }

}