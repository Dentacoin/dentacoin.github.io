    // Map styles.
    var styles = [
      {
        elementType: 'geometry',
        stylers: [{color: '#f5f5f5'}]
      },
      {
        elementType: 'labels.icon',
        stylers: [{visibility: 'off'}]
      },
      {
        elementType: 'labels.text.fill',
        stylers: [{color: '#616161'}]
      },
      {
        elementType: 'labels.text.stroke',
        stylers: [{color: '#f5f5f5'}]
      },
      {
        featureType: 'administrative.land_parcel',
        elementType: 'labels.text.fill',
        stylers: [{color: '#bdbdbd'}]
      },
      {
        featureType: 'poi',
        elementType: 'geometry',
        stylers: [{color: '#eeeeee'}]
      },
      {
        featureType: 'poi',
        elementType: 'labels.text.fill',
        stylers: [{color: '#757575'}]
      },
      {
        featureType: 'poi.park',
        elementType: 'geometry',
        stylers: [{color: '#e5e5e5'}]
      },
      {
        featureType: 'poi.park',
        elementType: 'labels.text.fill',
        stylers: [{color: '#9e9e9e'}]
      },
      {
        featureType: 'road',
        elementType: 'geometry',
        stylers: [{color: '#ffffff'}]
      },
      {
        featureType: 'road.arterial',
        elementType: 'labels.text.fill',
        stylers: [{color: '#757575'}]
      },
      {
        featureType: 'road.highway',
        elementType: 'geometry',
        stylers: [{color: '#dadada'}]
      },
      {
        featureType: 'road.highway',
        elementType: 'labels.text.fill',
        stylers: [{color: '#616161'}]
      },
      {
        featureType: 'road.local',
        elementType: 'labels.text.fill',
        stylers: [{color: '#9e9e9e'}]
      },
      {
        featureType: 'transit.line',
        elementType: 'geometry',
        stylers: [{color: '#e5e5e5'}]
      },
      {
        featureType: 'transit.station',
        elementType: 'geometry',
        stylers: [{color: '#eeeeee'}]
      },
      {
        featureType: 'water',
        elementType: 'geometry',
        stylers: [{color: '#c9c9c9'}]
      },
      {
        featureType: 'water',
        elementType: 'labels.text.fill',
        stylers: [{color: '#9e9e9e'}]
      }
    ];

    // Initializing the Map.
    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 2,
        center: {lat: 17.23082107851708, lng: 15.00166130065918},
        styles: styles,
        gestureHandling: 'cooperative'
      });

      // Create the search box and link it to the UI element.
      var input = document.getElementById('pac-input');
      var searchBox = new google.maps.places.SearchBox(input);
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      // Bias the SearchBox results towards current map's viewport.
      map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
      });

      var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });

      // Initializing the markers
      var image = {
        url: 'https://dentacoin.com/web/img/dcnpointer.png',
        // This marker is 35 pixels wide by 53 pixels high.
        size: new google.maps.Size(35, 53),
        // The origin for this image is (0, 0).
        origin: new google.maps.Point(0, 0),
        // The anchor for this image is the base of the flagpole at (19, 51).
        anchor: new google.maps.Point(19, 51)
      };
      // Shapes define the clickable region of the icon. The type defines an HTML
      // <area> element 'poly' which traces out a polygon as a series of X,Y points.
      // The final coordinate closes the poly by connecting to the first coordinate.
      var shape = {
        coords: [1, 1, 1, 53, 51, 53, 51, 1],
        type: 'poly'
      };

      // Map styles.
      

      // Content for the info windows.
      var contentStringSwissDentaprime = '<div id="content">'+
                                          '<div id="bodyContent">'+
                                            '<div class="shell">'+
                                              '<div class="range">'+
                                                '<div class="col-sm-12">'+
                                                  '<a href="https://www.dentaprime.com/dental-clinic" target="_blank">'+
                                                    '<img src="https://dentacoin.com/web/img/dentists/dp-logo.png" alt="" style="width: 200px;">'+
                                                  '</a>'+
                                                '</div>'+
                                              '</div>'+
                                            '</div>'+
                                          '</div>'+
                                        '</div>';
      let contentStringDentaprimeFThreeT = '<div id="content">'+
                                            '<div id="bodyContent">'+
                                              '<div class="shell">'+
                                                '<div class="range">'+
                                                  '<div class="col-sm-12">'+
                                                    '<a href="https://www.dentaprime.co.uk/" target="_blank">'+
                                                      '<img src="https://dentacoin.com/web/img/dentists/f3t-logo.png" alt="" style="width: 200px;">'+
                                                    '</a>'+
                                                  '</div>'+
                                                '</div>'+
                                              '</div>'+
                                            '</div>'+
                                          '</div>';
      let contentStringDentech = '<div id="content">'+
                                  '<div id="bodyContent">'+
                                    '<div class="shell">'+
                                      '<div class="range">'+
                                        '<div class="col-sm-12">'+
                                          '<a href="http://www.dentechdentalcare.com/" target="_blank">'+
                                            '<img src="https://dentacoin.com/web/img/dentists/dentch-logo.png" alt="" style="width: 200px;">'+
                                          '</a>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>';
      let contentStringContident = '<div id="content">'+
                                    '<div id="bodyContent">'+
                                      '<div class="shell">'+
                                        '<div class="range">'+
                                          '<div class="col-sm-12">'+
                                            '<a href="http://www.contident.com/" target="_blank">'+
                                              '<img src="https://dentacoin.com/web/img/dentists/contident.png" alt="" style="width: 200px;">'+
                                            '</a>'+
                                          '</div>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>';
      let contentStringLifDental = '<div id="content">'+
                                    '<div id="bodyContent">'+
                                      '<div class="shell">'+
                                        '<div class="range">'+
                                          '<div class="col-sm-12">'+
                                            '<a href="http://www.lifdental.com/"" target="_blank">'+
                                              '<img src="https://dentacoin.com/web/img/dentists/lifdental.png" alt="" style="width: 200px;">'+
                                            '</a>'+
                                          '</div>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>';
      let contentStringFlinders = '<div id="content">'+
                                    '<div id="bodyContent">'+
                                      '<div class="shell">'+
                                        '<div class="range">'+
                                          '<div class="col-sm-12">'+
                                            '<a href="http://www.dentalonflinders.com.au/" target="_blank">'+
                                              '<img src="https://dentacoin.com/web/img/dentists/dental-on-flinders.png" alt="" style="width: 200px;">'+
                                            '</a>'+
                                          '</div>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>';
      let contentStringITeeth = '<div id="content">'+
                                  '<div id="bodyContent">'+
                                    '<div class="shell">'+
                                      '<div class="range">'+
                                        '<div class="col-sm-12">'+
                                          '<a href="https://www.facebook.com/mr.iteeth" target="_blank">'+
                                            '<img src="https://dentacoin.com/web/img/dentists/mr-iteeth.png" alt="" style="width: 200px;">'+
                                          '</a>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>';
      let contentStringQAD = '<div id="content">'+
                              '<div id="bodyContent">'+
                                '<div class="shell">'+
                                  '<div class="range">'+
                                    '<div class="col-sm-12">'+
                                      '<a href="http://www.qadental.co.uk/" target="_blank">'+
                                        '<img src="https://dentacoin.com/web/img/dentists/qad.png" alt="" style="width: 200px;">'+
                                      '</a>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>'+
                              '</div>'+
                            '</div>';
      let contentStringAura = '<div id="content">'+
                                '<div id="bodyContent">'+
                                  '<div class="shell">'+
                                    '<div class="range">'+
                                      '<div class="col-sm-12">'+
                                        '<a href="http://aurafamilydentistry.com/" target="_blank">'+
                                          '<img src="https://dentacoin.com/web/img/dentists/aura.png" alt="" style="width: 200px;">'+
                                        '</a>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>'+
                              '</div>';
      let contentStringDailyCare = '<div id="content">'+
                                    '<div id="bodyContent">'+
                                      '<div class="shell">'+
                                        '<div class="range">'+
                                          '<div class="col-sm-12">'+
                                            '<a href="http://dailycaredental.webs.com/" target="_blank">'+
                                              '<img src="https://dentacoin.com/web/img/dentists/daily-dental.png" alt="" style="width: 200px;">'+
                                            '</a>'+
                                          '</div>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>';
      let contentStringDentistsThree = '<div id="content">'+
                                        '<div id="bodyContent">'+
                                          '<div class="shell">'+
                                            '<div class="range">'+
                                              '<div class="col-sm-12">'+
                                                '<a href="http://dentist3.com/" target="_blank">'+
                                                  '<img src="https://dentacoin.com/web/img/dentists/dentist3.png" alt="" style="width: 200px;">'+
                                                '</a>'+
                                              '</div>'+
                                            '</div>'+
                                          '</div>'+
                                        '</div>'+
                                      '</div>';
      let contentStringStudioTOIA = '<div id="content">'+
                                      '<div id="bodyContent">'+
                                        '<div class="shell">'+
                                          '<div class="range">'+
                                            '<div class="col-sm-12">'+
                                              '<a href="http://www.studiotoia.com/en/" target="_blank">'+
                                                '<img src="https://dentacoin.com/web/img/dentists/studio-toia.png" alt="" style="width: 200px;">'+
                                              '</a>'+
                                            '</div>'+
                                          '</div>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>';
      let contentStringArkling = '<div id="content">'+
                                  '<div id="bodyContent">'+
                                    '<div class="shell">'+
                                      '<div class="range">'+
                                        '<div class="col-sm-12">'+
                                          '<a href="https://www.arklign.com/products/how-we-fabricate/" target="_blank">'+
                                            '<img src="https://dentacoin.com/web/img/dentists/arkling.png" alt="" style="width: 200px;">'+
                                          '</a>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>';
      let contentStringGroupHealth = '<div id="content">'+
                                  '<div id="bodyContent">'+
                                    '<div class="shell">'+
                                      '<div class="range">'+
                                        '<div class="col-sm-12" style="background: black;">'+
                                          '<a href="http://www.grouphealthdental.com/" target="_blank">'+
                                            '<img src="https://dentacoin.com/web/img/dentists/grouphealth.png" alt="" style="width: 200px;">'+
                                          '</a>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>';
      let contentStringParkSouth = '<div id="content">'+
                                  '<div id="bodyContent">'+
                                    '<div class="shell">'+
                                      '<div class="range">'+
                                        '<div class="col-sm-12">'+
                                          '<a href="http://www.parksouthdentistry.com" target="_blank">'+
                                            '<img src="https://dentacoin.com/web/img/dentists/parksouth.png" alt="" style="width: 200px;">'+
                                          '</a>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>';
      let contentStringGramercy = '<div id="content">'+
                                    '<div id="bodyContent">'+
                                      '<div class="shell">'+
                                        '<div class="range">'+
                                          '<div class="col-sm-12" style="background: black;">'+
                                            '<a href="https://www.gramercydentalcenter.com/" target="_blank">'+
                                              '<img src="https://dentacoin.com/web/img/dentists/gramercydental.png" alt="" style="width: 200px;">'+
                                            '</a>'+
                                          '</div>'+
                                        '</div>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>';

    // Creating the info windows.
    var infowindowSwissDentaprime = new google.maps.InfoWindow({
      content: contentStringSwissDentaprime
    });
    let infowindowDentaprimeFThreeT = new google.maps.InfoWindow({
      content: contentStringDentaprimeFThreeT
    });
    let infowindowDentech = new google.maps.InfoWindow({
      content: contentStringDentech
    });
    let infowindowContident = new google.maps.InfoWindow({
      content: contentStringContident
    });
    let infowindowLifDental = new google.maps.InfoWindow({
      content: contentStringLifDental
    });
    let infowindowFlinders = new google.maps.InfoWindow({
      content: contentStringFlinders
    });
    let infowindowITeeth = new google.maps.InfoWindow({
      content: contentStringITeeth
    });
    let infowindowQAD = new google.maps.InfoWindow({
      content: contentStringQAD
    });
    let infowindowAura = new google.maps.InfoWindow({
      content: contentStringAura
    });
    let infowindowDailyCare = new google.maps.InfoWindow({
      content: contentStringDailyCare
    });
    let infowindowDentistsThree = new google.maps.InfoWindow({
      content: contentStringDentistsThree
    });
    let infowindowStudioToia = new google.maps.InfoWindow({
      content: contentStringStudioTOIA
    });
    let infowindowArkling = new google.maps.InfoWindow({
      content: contentStringArkling
    })
    let infowindowGroupHealth = new google.maps.InfoWindow({
      content: contentStringGroupHealth
    })
    let infowindowParkSouth = new google.maps.InfoWindow({
      content: contentStringParkSouth
    })
    let infowindowGramercy = new google.maps.InfoWindow({
      content: contentStringGramercy
    })

    // Creates an object of locations for markers.
    var locations = [
        {lat: 43.23082107851708, lng: 28.00166130065918},
        {lat: 51.5355026, lng: -0.006374199999982011},
        {lat: 18.462917, lng: 73.912061},
        {lat: 47.5131012, lng: 19.048879499999998},
        {lat: 42.9889753, lng: -78.69631529999998},
        {lat: 42.991272, lng: -78.759595},
        {lat: 42.977661, lng: -78.816705},
        {lat: -37.8178116, lng: 144.96514609999997},
        {lat: 25.0329636, lng: 121.56542680000007},
        {lat: 51.7589538, lng: -0.47198979999996027},
        {lat: 34.2784764, lng: -118.73593010000002},
        {lat: -18.1346392, lng: 178.42604089999998},
        {lat: 3.246762, lng: 101.47423200000003},
        {lat: 45.6224576, lng: 8.849127400000043},
        {lat: 37.3998888, lng: -121.88700289999997},
        {lat: 40.755734, lng: -73.988958},
        {lat: 40.764943, lng: -73.975114},
        {lat: 40.737008, lng: -73.986978}
      ];

    // Create an object of titles for markers.
    var titles = [
        {title: "Swiss Dentaprime"},
        {title: "Dentaprime F3T"},
        {title: "Dentech"},
        {title: "Contident"},
        {title: "LifDental"},
        {title: "LifDental"},
        {title: "LifDental"},
        {title: "Dental on Flinders"},
        {title: "Mr. iTeeth"},
        {title: "Quality Afordable Dentistry"},
        {title: "Aura Family Dentistry"},
        {title: "Daily Care Dental"},
        {title: "Dentist3"},
        {title: "TOIA Dental Clinic"},
        {title: "Arkling"},
        {title: "GroupHealthDental"},
        {title: "Park South Dentistry"},
        {title: "Gramercy Dental Center"}
      ];

    // Adds markers to the map.
    // Note: The code uses the JavaScript Array.prototype.map() method to
    // create an array of markers based on a given "locations" array.
    // The map() method here has nothing to do with the Google Maps API.
    var markers = locations.map(function(location, i) {
        return new google.maps.Marker({
          position: location,
        //   title: titles[i].toString(),
          icon: image,
          shape: shape
        });
      });

    // Initializing info windows.
    var markerCluster = new MarkerClusterer(map, markers,
        {imagePath: 'https://dentacoin.com/web/img/m'});
        markers[0].addListener('click', function() {
            infowindowSwissDentaprime.open(map, markers[0]);
          });
          markers[1].addListener('click', function(){
            infowindowDentaprimeFThreeT.open(map, markers[1]);
          });
          markers[2].addListener('click', function(){
            infowindowDentech.open(map, markers[2]);
          });
          markers[3].addListener('click', function(){
            infowindowContident.open(map, markers[3]);
          });
          markers[4].addListener('click', function(){
            infowindowLifDental.open(map, markers[4]);
          });
          markers[5].addListener('click', function(){
            infowindowLifDental.open(map, markers[5]);
          });
          markers[6].addListener('click', function(){
            infowindowLifDental.open(map, markers[6]);
          });
          markers[7].addListener('click', function(){
            infowindowFlinders.open(map, markers[7]);
          });
          markers[8].addListener('click', function(){
            infowindowITeeth.open(map, markers[8]);
          });
          markers[9].addListener('click', function(){
            infowindowQAD.open(map, markers[9]);
          });
          markers[10].addListener('click', function(){
            infowindowAura.open(map, markers[10]);
          });
          markers[11].addListener('click', function(){
            infowindowDailyCare.open(map, markers[11]);
          });
          markers[12].addListener('click', function(){
            infowindowDentistsThree.open(map, markers[12]);
          });
          markers[13].addListener('click', function(){
            infowindowStudioToia.open(map, markers[13]);
          });
          markers[14].addListener('click', function(){
            infowindowArkling.open(map, markers[14]);
          });
          markers[15].addListener('click', function(){
            infowindowGroupHealth.open(map, markers[15]);
          });
          markers[16].addListener('click', function(){
            infowindowParkSouth.open(map, markers[16]);
          });
          markers[17].addListener('click', function(){
            infowindowGramercy.open(map, markers[17]);
          });
      
    }

    //   // Drop testing.
      

    //   var markers = [];

    //   function drop() {
    //     clearMarkers();
    //     for (var i = 0; i < neighborhoods.length; i++) {
    //       addMarkerWithTimeout(neighborhoods[i], i * 200);
    //     }
    //   }
  
    //   function addMarkerWithTimeout(position, timeout) {
    //     window.setTimeout(function() {
    //       markers.push(new google.maps.Marker({
    //         position: position,
    //         map: map,
    //         animation: google.maps.Animation.DROP
    //       }));
    //     }, timeout);
    //   }
  
    //   function clearMarkers() {
    //     for (var i = 0; i < markers.length; i++) {
    //       markers[i].setMap(null);
    //     }
    //     markers = [];
    //   }