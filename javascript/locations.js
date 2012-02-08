//<![CDATA[

	// init
	load();
	
    var map;
    var map2;
    var geocoder;

    function load() {
      if (GBrowserIsCompatible()) {
        geocoder = new GClientGeocoder();
      }
    }
    
    function showAllLocations() {
	
		document.getElementById('largeMap').style.display = 'block';
		
		map2 = new GMap2(document.getElementById('largeMap'));
		map2.addControl(new GSmallMapControl());
		map2.addControl(new GMapTypeControl());

		var searchUrl = 'LocationController/MapXML/?all=1';
		GDownloadUrl(searchUrl, function(data) {
			var xml = GXml.parse(data);
			var markers = xml.documentElement.getElementsByTagName('marker');
			map2.clearOverlays();
			
			var bounds2 = new GLatLngBounds();
			for (var i = 0; i < markers.length; i++) {
			 var name = markers[i].getAttribute('name');
			 var address = markers[i].getAttribute('address');
			 var address2 = markers[i].getAttribute('address2');
			 var city = markers[i].getAttribute('city');
			 var state = markers[i].getAttribute('state');
			 var zip = markers[i].getAttribute('zipcode');
			 var website = markers[i].getAttribute('website');
			 var phone = markers[i].getAttribute('phone');
			 //var id = parseFloat(markers[i].getAttribute('id'));
			 var point = new GLatLng(parseFloat(markers[i].getAttribute('lat')),
			                         parseFloat(markers[i].getAttribute('lng')));
			 
			 var marker = createMarker(point, name, address, address2, city, state, zip, website, phone);
			 map2.addOverlay(marker);
			 //var sidebarEntry = createSidebarEntry(marker, name, address, address2, city, state, zip, website, phone, distance);
			 //sidebar.appendChild(sidebarEntry);
			 bounds2.extend(point);
			}
			//alert(markers.length);
			if (markers.length < 2) {
				map2.setCenter(bounds2.getCenter(), 11);
			} else {
				map2.setCenter(bounds2.getCenter(), map2.getBoundsZoomLevel(bounds2));
			}
		});

	}

   function searchLocations() {
     document.getElementById('largeMap').style.display = 'none';
   	 document.getElementById('map').style.display = 'block';
   	 document.getElementById('sidebar').style.display = 'block';
   	 
   	 map = new GMap2(document.getElementById('map'));
   	 map.addControl(new GSmallMapControl());
     map.addControl(new GMapTypeControl());
     //map.setCenter(new GLatLng(40, -100), 4);
     var address = document.getElementById('addressInput').value;
     if (!address) {
     	alert('Please enter an address');
     	return false;
     }
     
     geocoder.getLatLng(address, function(latlng) {
       if (!latlng) {
         alert(address + ' not found');
       } else {
         searchLocationsNear(latlng,address);
         //searchLocationsNear(address);
       }
     });
   }

   function searchLocationsNear(center,address) {
   	//alert(address);
     var radius = document.getElementById('radiusSelect').value;
     //var searchUrl = 'phpsqlsearch_genxml.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
     var searchUrl = 'LocationController/MapXML/?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&address=' + address;
     //alert(searchUrl);
     //var searchUrl = 'dealer-locator/MapXML/'+center;

     GDownloadUrl(searchUrl, function(data) {
       var xml = GXml.parse(data);
       var markers = xml.documentElement.getElementsByTagName('marker');
       map.clearOverlays();

       var sidebar = document.getElementById('sidebar');
       sidebar.innerHTML = '';
       if (markers.length == 0) {
         sidebar.innerHTML = '<div class="typography"><p>Sorry! There are no dealers in this area. Please select a larger search radius.</p><p>If you would like more information on our products, please give us a call at 800.832.8914 or <a href="/contact-us/">email us</a>.</div>';
         map.setCenter(new GLatLng(40, -100), 4);
         return;
       }

       var bounds = new GLatLngBounds();
       for (var i = 0; i < markers.length; i++) {
         var name = markers[i].getAttribute('name');
         var address = markers[i].getAttribute('address');
         var address2 = markers[i].getAttribute('address2');
         var city = markers[i].getAttribute('city');
         var state = markers[i].getAttribute('state');
         var zip = markers[i].getAttribute('zipcode');
         var country = markers[i].getAttribute('country');
         var website = markers[i].getAttribute('website');
         var phone = markers[i].getAttribute('phone');
         var distance = parseFloat(markers[i].getAttribute('distance'));
         var point = new GLatLng(parseFloat(markers[i].getAttribute('lat')),
                                 parseFloat(markers[i].getAttribute('lng')));
         
         var marker = createMarker(point, name, address, address2, city, state, zip, country, website, phone);
         map.addOverlay(marker);
         var sidebarEntry = createSidebarEntry(marker, name, address, address2, city, state, zip, country, website, phone, distance);
         sidebar.appendChild(sidebarEntry);
         bounds.extend(point);
       }
       //alert(markers.length);
       if (markers.length < 2) {
       	map.setCenter(bounds.getCenter(), 14);
       } else {
       	map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
       }
     });
   }
   
   function getDirections(toAddress, name) {
		var map;
		var directionsPanel;
		var directions;
		
		var fromAddress = document.getElementById('addressInput').value;
		var sidebar = document.getElementById('sidebar');
   	 	sidebar.innerHTML = '<a href="#" onclick="searchLocations();return false"><< back to results</a><h3>' + name + '</h3>';
     
		map = new GMap2(document.getElementById('map'));
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());
		directionsPanel = document.getElementById("sidebar");
		directions = new GDirections(map, directionsPanel);
		directions.load("from: "+fromAddress+" to: "+toAddress);
   	 
   	 	//sidebar.innerHTML .= '<p><a href="#" onclick="searchLocations();return false">Back to results</a></p>';
   	 
   }

    function createMarker(point, name, address, address2, city, state, zip, country, website, phone) {
      var marker = new GMarker(point);
      var longAddress = address + ', ';
      if (address2) longAddress += address2 + ', ';
      longAddress += city + ', ' + state + ' ' + zip + ' ' + country + ' (' + name + ')';
      var html = '<h4>' + name + '</h4>' + address + '<br>';
      if (address2) html += address2 + '<br>';
      html += city + ', ' + state + ' ' + zip;
      if (country) html += '<br>' + country;
      if (website) html += '<br><a href="' + website + '" target="_blank">' + website + '</a>';
      if (phone) html += '<br>' + phone;
      html += '<br><a href="#"  onclick="getDirections(\''+longAddress+'\', \'' + name + '\');return false">Driving Directions</a>';
      GEvent.addListener(marker, 'click', function() {
        marker.openInfoWindowHtml(html);
      });
      return marker;
    }

    function createSidebarEntry(marker, name, address, address2, city, state, zip, country, website, phone, distance) {
      var div = document.createElement('div');
      var longAddress = address + ', ';
      if (address2) longAddress += address2 + ', ';
      longAddress += city + ', ' + state + ' ' + zip + ' ' + country + ' (' + name + ')';
      var html = '<div class="DealerItem"><h4>' + name + '</h4>' + address;
      if (address2) html += '<br>' + address2;
      html += '<br>' + city + ', ' + state + ' ' + zip;
      if (country) html += '<br>' + country + '<br>';
      if (website) html += '<a href="' + website + '" target="_blank">' + website + '</a><br>';
      if (phone) html += phone + '<br>';
      html += distance.toFixed(1) + ' mi | <a href="#"  onclick="getDirections(\''+longAddress+'\', \'' + name + '\');return false">Driving Directions</a></div>';
      div.innerHTML = html;
      div.style.cursor = 'pointer';
      div.style.marginBottom = '5px'; 
      GEvent.addDomListener(div, 'click', function() {
        GEvent.trigger(marker, 'click');
      });
      GEvent.addDomListener(div, 'mouseover', function() {
        div.style.backgroundColor = '#eee';
      });
      GEvent.addDomListener(div, 'mouseout', function() {
        div.style.backgroundColor = '#fff';
      });
      return div;
    }
    //]]>
    
    // auto find location
    function findMe() {
    
    	// Check to see if this browser supports geolocation.
		if (navigator.geolocation) {
			
			navigator.geolocation.getCurrentPosition(
				function( position ){
				 
					// Check to see if there is already a location.
					// There is a bug in FireFox where this gets
					// invoked more than once with a cahced result.
					/*if (locationMarker){
						return;
					}*/
					 
					// Log that this is the initial position.
					console.log( "Initial Position Found" );
					
					//alert(position.coords.latitude);
					
					var lat = position.coords.latitude;
					var long = position.coords.longitude;
					var latlong = lat+','+long;
					
					 
					// Add a marker to the map using the position.
					/*locationMarker = addMarker(
						position.coords.latitude,
						position.coords.longitude,
						"Initial Position"
					);*/
					
					//alert(latlong);
					
					var location = geocoder.getLocations(latlong, showAddress);
			
					
					 
				},
				function( error ){
					console.log( "Something went wrong: ", error );
				},
				{
					timeout: (5 * 1000),
					maximumAge: (1000 * 60 * 15),
					enableHighAccuracy: true
				}
			);
			
			
			
		}
	}
	
	function showAddress(response) {

	  if (!response || response.Status.code != 200) {
	    alert("Status Code:" + response.Status.code);
	  } else {
	    place = response.Placemark[0];
	    
	    //alert(place.address);
	    
	    document.getElementById('addressInput').value = place.address;
	    
	    /*point = new GLatLng(place.Point.coordinates[1],place.Point.coordinates[0]);
	    marker = new GMarker(point);
	    map.addOverlay(marker);
	    marker.openInfoWindowHtml(
	        '<b>orig latlng:</b>' + response.name + '<br/>' + 
	        '<b>latlng:</b>' + place.Point.coordinates[1] + "," + place.Point.coordinates[0] + '<br>' +
	        '<b>Status Code:</b>' + response.Status.code + '<br>' +
	        '<b>Status Request:</b>' + response.Status.request + '<br>' +
	        '<b>Address:</b>' + place.address + '<br>' +
	        '<b>Accuracy:</b>' + place.AddressDetails.Accuracy + '<br>' +
	        '<b>Country code:</b> ' + place.AddressDetails.Country.CountryNameCode);
	  */}
	}
    
