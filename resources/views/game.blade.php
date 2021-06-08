<x-app-layout>
    <script src="{{ asset('js/dashboard/dashboard.js') }}" defer></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @isset($currentGame)
                {{ __('Game #' . $currentGame->id) }}
            @endisset
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="pano"></div>
                    <script>
                        function generateRandomPoint() {
                            initMap();
                            var sv = new google.maps.StreetViewService();
                            sv.getPanoramaByLocation(
                                new google.maps.LatLng(Math.random() * 180 - 90, Math.random() * 360 - 180), 500, processSVData
                            );
                        }

                        function processSVData(data, status) {
                            if (status == google.maps.StreetViewStatus.OK) {
                                console.log("EE " + data.location.latLng.toUrlValue(6));
                                console.log(data);

                                const panorama = new google.maps.StreetViewPanorama(
                                    document.getElementById("pano"), {
                                        position: data.location.latLng,
                                        pov: {
                                            heading: 34,
                                            pitch: 10,
                                        },
                                        disableDefaultUI: true,
                                    }
                                );

                            } else generateRandomPoint();
                        }
                    </script>
                    <div id="map_container"></div>
                    <script>
                        var map;

                        function initMap() {
                            var berkeley = {
                                lat: {{ $currentGame->latitude }},
                                lng: {{ $currentGame->longitude }}
                            };
                            var sv = new google.maps.StreetViewService();
                            // Set up the map.
                            map = new google.maps.Map(document.getElementById('map_container'), {
                                center: berkeley,
                                zoom: 16,
                                streetViewControl: false
                            });
                            // // Look for a nearby Street View panorama when the map is clicked.
                            // // getPanoramaByLocation will return the nearest pano when the
                            // // given radius is 50 meters or less.
                            // map.addListener('click', function(event) {
                            //     sv.getPanorama({
                            //     location: event.latLng,
                            //     radius: 500000
                            //     }, processSVData);
                            // });
                        }

                        // function processSVData(data, status) {
                        //     if (status === google.maps.StreetViewStatus.OK) {
                        //         var marker = new google.maps.Marker({
                        //             position: data.location.latLng,
                        //             map: map,
                        //             title: data.location.description
                        //         });
                        //         panorama.setPano(data.location.pano);
                        //         panorama.setPov({
                        //             heading: 270,
                        //             pitch: 0
                        //         });
                        //         panorama.setVisible(true);
                        //         marker.addListener('click', function() {
                        //             var markerPanoID = data.location.pano;
                        //             // Set the Pano to use the passed panoID.
                        //             panorama.setPano(markerPanoID);
                        //             panorama.setPov({
                        //                 heading: 270,
                        //                 pitch: 0
                        //             });
                        //             panorama.setVisible(true);
                        //         });
                        //     } else {
                        //         console.error('Street View data not found for this location.');
                        //     }
                        // }
                    </script>

{{--                     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZ2TiiS0J0PgPJO7qeQMV68vULm3fEbgE&callback=generateRandomPoint&libraries=&v=weekly" async></script> --}}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
