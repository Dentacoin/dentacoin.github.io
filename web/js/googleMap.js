    // This example displays a marker at the center of Australia.
    // When the user clicks the marker, an info window opens.

    // Initializes the Map.
    function initMap() {
      var swissDP = {lat: 43.23082107851708, lng: 28.00166130065918};
      var fThreeT = {lat: 51.5355026, lng: -0.006374199999982011};
      let dentech = {lat: 18.462917, lng: 73.912061};
      let contident = {lat: 47.5131012, lng: 19.048879499999998};
      let lifDental = {lat: 42.9889753, lng: -78.69631529999998};
      let flinders = {lat: -37.8178116, lng: 144.96514609999997};
      let iteeth = {lat: 25.0329636, lng: 121.56542680000007};
      let qad = {lat: 51.7589538, lng: -0.47198979999996027}
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 2,
        center: {lat: 18.23082107851708, lng: 33.00166130065918}
      });

      // Initializing the markers
      var image = {
        url: '../web/img/dcnpointer.png',
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

      // Content for the info windows.
      var contentStringSwissDentaprime = '<div id="content">'+
                            '<div id="bodyContent">'+
                              '<div class="shell">'+
                                '<div class="range">'+
                                  '<div class="col-sm-12"><a href="https://www.dentaprime.com/dental-clinic" target="_blank"><img src="../web/img/dentists/dp-logo.png" alt="" style="width: 200px;"></a></div>'+
                                '</div>'+
                              '</div>'+
                            '</div>'+
                          '</div>';
      let contentStringDentaprimeFThreeT = '<div id="content">'+
                            '<div id="bodyContent">'+
                              '<div class="shell">'+
                                '<div class="range">'+
                                  '<div class="col-sm-12"><a href="https://www.dentaprime.co.uk/" target="_blank"><img src="../web/img/dentists/f3t-logo.png" alt="" style="width: 200px;"></a></div>'+
                                '</div>'+
                              '</div>'+
                            '</div>'+
                          '</div>';
      let contentStringDentech = '<div id="content">'+
                            '<div id="bodyContent">'+
                              '<div class="shell">'+
                                '<div class="range">'+
                                  '<div class="col-sm-12"><a href="http://www.dentechdentalcare.com/" target="_blank"><img src="../web/img/dentists/dentch-logo.png" alt="" style="width: 200px;"></a></div>'+
                                '</div>'+
                              '</div>'+
                            '</div>'+
                          '</div>';
      let contentStringContident = '<div id="content">'+
                            '<div id="bodyContent">'+
                              '<div class="shell">'+
                                '<div class="range">'+
                                  '<div class="col-sm-12"><a href="http://www.contident.com/" target="_blank"><img src="../web/img/dentists/contident.png" alt="" style="width: 200px;"></a></div>'+
                                '</div>'+
                              '</div>'+
                            '</div>'+
                          '</div>';
      let contentStringLifDental = '<div id="content">'+
                            '<div id="bodyContent">'+
                              '<div class="shell">'+
                                '<div class="range">'+
                                  '<div class="col-sm-12"><a href="http://www.lifdental.com/"" target="_blank"><img src="../web/img/dentists/lifdental.png" alt="" style="width: 200px;"></a></div>'+
                                '</div>'+
                              '</div>'+
                            '</div>'+
                          '</div>';
      let contentStringFlinders = '<div id="content">'+
                            '<div id="bodyContent">'+
                              '<div class="shell">'+
                                '<div class="range">'+
                                  '<div class="col-sm-12"><a href="http://www.dentalonflinders.com.au/" target="_blank"><img src="../web/img/dentists/dental-on-flinders.png" alt="" style="width: 200px;"></a></div>'+
                                '</div>'+
                              '</div>'+
                            '</div>'+
                          '</div>';
      let contentStringITeeth = '<div id="content">'+
                            '<div id="bodyContent">'+
                              '<div class="shell">'+
                                '<div class="range">'+
                                  '<div class="col-sm-12"><a href="https://www.facebook.com/mr.iteeth" target="_blank"><img src="../web/img/dentists/mr-iteeth.png" alt="" style="width: 200px;"></a></div>'+
                                '</div>'+
                              '</div>'+
                            '</div>'+
                          '</div>';
      let contentStringQAD = '<div id="content">'+
                            '<div id="bodyContent">'+
                              '<div class="shell">'+
                                '<div class="range">'+
                                  '<div class="col-sm-12"><a href="http://www.qadental.co.uk/" target="_blank"><img src="../web/img/dentists/qad.png" alt="" style="width: 200px;"></a></div>'+
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

      // Initializing marker properties and info windows.
      var markerOne = new google.maps.Marker({
        position: swissDP,
        map: map,
        icon: image,
        shape: shape,
        title: 'Swiss Dentaprime'
      });
      markerOne.addListener('click', function() {
        infowindowSwissDentaprime.open(map, markerOne);
      });
      var markerTwo = new google.maps.Marker({
        position: fThreeT,
        map: map,
        icon: image,
        shape: shape,
        title: 'Dentaprime F3T'
      });
      markerTwo.addListener('click', function(){
        infowindowDentaprimeFThreeT.open(map, markerTwo);
      });
      var markerThree = new google.maps.Marker({
        position: dentech,
        map: map,
        icon: image,
        shape: shape,
        title: 'Dentech'
      });
      markerThree.addListener('click', function(){
        infowindowDentech.open(map, markerThree);
      });
      var markerFour = new google.maps.Marker({
        position: contident,
        map: map,
        icon: image,
        shape: shape,
        title: 'Contident'
      });
      markerFour.addListener('click', function(){
        infowindowContident.open(map, markerFour);
      });
      var markerFive = new google.maps.Marker({
        position: lifDental,
        map: map,
        icon: image,
        shape: shape,
        title: 'LifDental'
      });
      markerFive.addListener('click', function(){
        infowindowLifDental.open(map, markerFive);
      });
      var markerSix = new google.maps.Marker({
        position: flinders,
        map: map,
        icon: image,
        shape: shape,
        title: 'Dental on Flinders'
      });
      markerSix.addListener('click', function(){
        infowindowFlinders.open(map, markerSix);
      });
      var markerSeven = new google.maps.Marker({
        position: iteeth,
        map: map,
        icon: image,
        shape: shape,
        title: 'Mr. iTeeth'
      });
      markerSeven.addListener('click', function(){
        infowindowITeeth.open(map, markerSeven);
      });
      var markerEight = new google.maps.Marker({
        position: qad,
        map: map,
        icon: image,
        shape: shape,
        title: 'Quality Afordable Dentistry'
      });
      markerEight.addListener('click', function(){
        infowindowQAD.open(map, markerEight);
      });

    //   // Drop testing.
    //   var neighborhoods = [
    //     {swissDP},
    //     {fThreeT},
    //     {dentech},
    //     {contident},
    //     {lifDental},
    //     {flinders},
    //     {iteeth},
    //     {qad},
    //   ];

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
    }