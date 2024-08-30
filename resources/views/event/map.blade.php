<script
src="https://maps.googleapis.com/maps/api/js?key={{env('MAP_KEY')}}&loading=async&callback=initMap">
</script>
<!-- <script src="{{asset('js/map.js')}}"></script> -->
<script>
    function initMap() {
        // The location of Uluru
        var uluru = {lat: {{$lat}}, lng: {{$lng}}};
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 11, center: uluru});
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({position: uluru, map: map});
    }
</script>
<style>
       /* Set the size of the div element that contains the map */
       #map {
    /* height: 250px;  The height is 400 pixels */
    /* width: 100%;  The width is the width of the web page */
    position: fixed !important;
    height: 100% !important;
    width: 100% !important;
    overflow: visible !important;

}
    </style>


<!-- <div> -->
    <!-- Map container -->
    <!-- <div id="map" style="height: 250px; width: 100%;"></div> -->
<!-- <div>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('MAP_KEY')}}&callback=initMap" async></script>

    <script>
        function initMap() {
            // The location of Uluru
            var uluru = { lat: @json($lat), lng: @json($lng) };

            // The map, centered at Uluru
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 11,
                center: uluru,
            });

            // Create an AdvancedMarkerElement
            const markerElement = new google.maps.marker.AdvancedMarkerElement({
                map: map,
                position: uluru,
                title: "Uluru", // Optional title
                content: document.createElement('div'), // Custom HTML content
            });

            // Custom styling and content for the marker
            markerElement.content.innerHTML = '<div style="background: red; padding: 8px; border-radius: 4px;">My Custom Marker</div>';
        }
    </script>
</div> -->
