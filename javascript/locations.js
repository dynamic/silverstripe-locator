// init maps
load();

var map;
var map2;
var geocoder;

function load() {
	if (GBrowserIsCompatible()) {
    	geocoder = new GClientGeocoder();
	}
}

// page load - show all locations on map
function showAllLocations() {

	document.getElementById('largeMap').style.display = 'block';
	
	map2 = new GMap2(document.getElementById('largeMap'));
	map2.addControl(new GSmallMapControl());
	map2.addControl(new GMapTypeControl());

	var searchUrl = window.location.pathname + 'MapXML/?all=1';
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
			var country = markers[i].getAttribute('country');
			var website = markers[i].getAttribute('website');
			var phone = markers[i].getAttribute('phone');
			var point = new GLatLng(parseFloat(markers[i].getAttribute('lat')),
				parseFloat(markers[i].getAttribute('lng')));
				
			var formatted = '';
			if (address) formatted += address + '<br>';
			if (address2) formatted += address2 + '<br>';
			if (city) formatted += city + ', ';
			if (state) formatted += state + ' ';
			if (zip) formatted += zip;
			if (country) formatted += '<br>' + country;
			
			var long = '';
			if (address) long += address + ', ';
			if (address2) long += address2 + ', ';
			if (city) long += city + ', ';
			if (state) long += state + ' ';
			if (zip) long += zip;
			if (country) long += ' ' + country;
			
			var marker = createMarker(point, name, formatted, long, website, phone, false, false);
			map2.addOverlay(marker);
			bounds2.extend(point);
		}

		map2.setCenter(bounds2.getCenter(), map2.getBoundsZoomLevel(bounds2));

	});

}

// search based on address - address field or geolocator
function searchLocations(start) {
	
	// hide/show elements
	document.getElementById('largeMap').style.display = 'none';
	document.getElementById('map').style.display = 'block';
	document.getElementById('sidebar').style.display = 'block';
	
	// set map options
	map = new GMap2(document.getElementById('map'));
	map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
	
	// check that address was entered
	var address = document.getElementById('addressInput').value;
	if (start) address = start;
	if (!address) {
		alert('Please enter an address');
		return false;
	}
	
	geocoder.getLatLng(address, function(latlng) {
		if (!latlng) {
			alert(address + ' not found');
		} else {
			//alert(latlng);
			searchLocationsNear(latlng,address);
		}
	});
	
}

function searchLocationsNear(center,address) {

	userAddress = address;

 	var radius = document.getElementById('radiusSelect').value;
	var searchUrl = window.location.pathname + 'MapXML/?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&address=' + address;
	//alert(searchUrl);
	
	GDownloadUrl(searchUrl, function(data) {
   		var xml = GXml.parse(data);
   		var markers = xml.documentElement.getElementsByTagName('marker');
   		map.clearOverlays();

   		var sidebar = document.getElementById('sidebar');
   		sidebar.innerHTML = '';
   		if (markers.length == 0) {
     		sidebar.innerHTML = '<div class="typography"><p>Sorry! There are no locations in this area. Please try again with a larger search radius.</p></div>';
     		map.setCenter(new GLatLng(40, -100), 4);
     		return;
   		}
   		
   		// marker for current location of user   		
		var userMarker = createMarker(center, 'You', userAddress, false, false, false, true);
		map.addOverlay(userMarker);
		var userSidebarEntry = createSidebarEntry(userMarker, 'You', userAddress, false, false, false, false);
		sidebar.appendChild(userSidebarEntry);
		

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
			                     
			var formatted = '';
			if (address) formatted += address + '<br>';
			if (address2) formatted += address2 + '<br>';
			if (city) formatted += city + ', ';
			if (state) formatted += state + ' ';
			if (zip) formatted += zip;
			if (country) formatted += '<br>' + country;
			
			var long = '';
			if (address) long += address + ', ';
			if (address2) long += address2 + ', ';
			if (city) long += city + ', ';
			if (state) long += state + ' ';
			if (zip) long += zip;
			if (country) long += ' ' + country;
			
			// map markers
			var marker = createMarker(point, name, formatted, long, website, phone, false, true);
			map.addOverlay(marker);
			
			// populate sidebar
			var sidebarEntry = createSidebarEntry(marker, name, formatted, long, website, phone, distance);
			sidebar.appendChild(sidebarEntry);
			bounds.extend(point);
   		}
   		
   		// expand map to include user location
   		bounds.extend(center);
   		
   		//alert(markers.length);
   		if (markers.length < 2) {
   			map.setCenter(bounds.getCenter(), 14);
   		} else {
   			map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
   		}
 	});
}

function getDirections(toAddress, name) {
	
	// hide/show elements
	document.getElementById('largeMap').style.display = 'none';
	document.getElementById('map').style.display = 'block';
	document.getElementById('sidebar').style.display = 'block';
	
	var map;
	var directionsPanel;
	var directions;
	var fromAddress = document.getElementById('addressInput').value;
	
	var sidebar = document.getElementById('sidebar');
	sidebar.innerHTML = '<a href="#" onclick="searchLocations();return false">x close</a>';
 
 	// create new directions map
	map = new GMap2(document.getElementById('map'));
	map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
	
	// create directions sidebar
	directionsPanel = document.getElementById("sidebar");
	directions = new GDirections(map, directionsPanel);
	directions.load("from: "+fromAddress+" to: "+toAddress);
	 
}

function createMarker(point, name, address, long, website, phone, color, directions) {
	
	if (color) {
		var greenIcon = new GIcon(G_DEFAULT_ICON);
		greenIcon.image = "locations/images/dd-start.png";
		var markerOptions = { icon:greenIcon };
	} else {
		var markerOptions = null;
	}
	
	var marker = new GMarker(point, markerOptions);
	
	// set html for map marker
	var html = '';
	if (name) html += '<h4>' + name + '</h4>';
	if (address) html += address;
	if (directions) html += '<br><a href="#"  onclick="getDirections(\''+long+'\', \'' + name + '\');return false">Driving Directions</a>';
	
	// mouse events
	GEvent.addListener(marker, 'click', function() {
		marker.openInfoWindowHtml(html);
	});
	
	return marker;
}

function createSidebarEntry(marker, name, address, longAddress, website, phone, distance) {
	
	var div = document.createElement('div');
	
	// set html for each result
	var html = '<div class="locationItem">';
	if (name) html += '<h4>' + name + '</h4>';
	if (address) html += address;
	if (website) html += '<br><a href="' + website + '" target="_blank">' + website + '</a>';
	if (phone) html += '<br>' + phone;
	if (distance) html += '<br>' + distance.toFixed(1) + ' mi | <a href="#"  onclick="getDirections(\''+longAddress+'\', \'' + name + '\');return false">Driving Directions</a></div>';
	
	// insert html into sidebar
	div.innerHTML = html;
	div.style.cursor = 'pointer';
	div.style.marginBottom = '5px'; 
	
	// mouse events
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
    
// auto find location
function findMe() {

	// Check to see if this browser supports geolocation.
	if (navigator.geolocation) {
		
		navigator.geolocation.getCurrentPosition(
			function( position ){
			 
				// Check to see if there is already a location.
				// There is a bug in FireFox where this gets
				// invoked more than once with a cahced result.
				if (location){
					return;
				}
				 
				// Log that this is the initial position.
				console.log( "Initial Position Found" );
				
				//alert(position.coords.latitude);
				
				var latlng = position.coords.latitude + ',' + position.coords.longitude;
				
				var location = geocoder.getLocations(latlng, showAddress);
				
				//
				 
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
		
	} else {
		alert("Your browser does not support location services");
	}
}
	
function showAddress(response) {

	if (!response || response.Status.code != 200) {
	
		alert("Status Code:" + response.Status.code);
		
	} else {
		
		place = response.Placemark[0];

		document.getElementById('addressInput').value = place.address;
		
		var coordinates = '(' + place.Point.coordinates[1] + ', ' + place.Point.coordinates[0] + ')';
		
		searchLocations(place.address);
	
	}
}