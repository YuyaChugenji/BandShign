// Google Mapを表示する関数
function initMap() {
    const geocoder = new google.maps.Geocoder();
    // ここでaddressのvalueに住所のテキストを指定する
    geocoder.geocode(
        {
            address:
                "{{ $livehouseuser->postcode }}{{ $livehouseuser->prefecture }}{{ $livehouseuser->city }}{{ $livehouseuser->block }}{{ $livehouseuser->building }}",
        },
        function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                const latlng = {
                    lat: results[0].geometry.location.lat(),
                    lng: results[0].geometry.location.lng(),
                };
                const opts = {
                    zoom: 15,
                    center: new google.maps.LatLng(latlng),
                };
                const map = new google.maps.Map(
                    document.getElementById("map"),
                    opts
                );
                new google.maps.Marker({
                    position: latlng,
                    map: map,
                });
            } else {
                console.error(
                    "Geocode was not successful for the following reason: " +
                        status
                );
            }
        }
    );
}
