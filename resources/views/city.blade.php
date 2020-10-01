@extends('layouts.app')
@section('map')
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

@endsection

@section('content')

<div id="map">
</div>



<div class="container">

    @foreach($nearCities as $nearCity)
        <div class="p-2 bg-info d-inline-block mt-lg-1">  {{$nearCity->name}}</div>
    @endforeach

</div>




<script type="text/javascript">

    var locations = @json($nearCitiesForJS)


    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: new google.maps.LatLng({{$city->latitude}}, {{$city->longitude}}),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }
</script>
@endsection
