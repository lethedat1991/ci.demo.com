<?php echo $map['js']; ?>
<div class="ct_demo">
    <?php echo $map['html']; ?>
    <div id="directionsDiv"></div>
</div>

<script>
    var markers = [];
    function placeMarker(map, location) {
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
        markers.push(marker);
    }
    function setAllMap(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }
    function clearMarkers() {
        setAllMap(null);
    }
    function initialize() {
        var markers = [];
        var mapProp = {
            center:new google.maps.LatLng(20.991583, 105.848670),
            zoom:13,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };
        var map=new google.maps.Map(document.getElementById("map-canvas"), mapProp);
        google.maps.event.addListener(map, 'click', function( event ){
            clearMarkers();
            var latlng = event.latLng.lat() + "," + event.latLng.lng();
            placeMarker(map, event.latLng);
            $('#latlng').val(latlng);
        });
        var input =(document.getElementById('pac-input'));
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        var searchBox = new google.maps.places.SearchBox((input));
        google.maps.event.addListener(searchBox, 'places_changed', function() {
            var places = searchBox.getPlaces();
            if (places.length == 0) {
                return;
            }
            for (var i = 0, marker; marker = markers[i]; i++) {
                marker.setMap(null);
            }
            markers = [];
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0, place; place = places[i]; i++) {
                var image = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };
                var marker = new google.maps.Marker({
                    map: map,
                    icon: image,
                    title: place.name,
                    position: place.geometry.location
                });
                markers.push(marker);
                bounds.extend(place.geometry.location);
            }
            map.fitBounds(bounds);
        });
        google.maps.event.addListener(map, 'bounds_changed', function() {
            var bounds = map.getBounds();
            searchBox.setBounds(bounds);
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script><!-- VENDOR -->
<br/><br/>
<p style="text-align: center">Chào bạn :<strong style="color: red;"><?php echo $this->session->userdata('username'); ?></strong>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="live" href="<?php echo base_url('logout.html') ?>" style="color: black;">LOGOUT</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="logout" href="<?php echo base_url('home/addplace') ?>" style="color: black;">Add Place</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="logout" href="<?php echo base_url('admin/login/addplace') ?>" style="color: black;">Add Place Adm</a>
</p>
